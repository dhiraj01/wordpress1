<?php

class RM_Paypal_Service implements RM_Gateway_Service
{
    private $paypal;
    private $options;
    private $paypal_email;
    private $currency;
    private $paypal_page_style;

    function __construct() {
        $this->options= new RM_Options();

        $sandbox =  $this->options->get_value_of('paypal_test_mode');
        $this->paypal_email = $this->options->get_value_of('paypal_email');
        $this->currency = $this->options->get_value_of('currency');
        $this->paypal_page_style = $this->options->get_value_of('paypal_page_style');

        $this->paypal = new paypal_class();

        if ($sandbox == 'yes')
            $this->paypal->toggle_sandbox(true);
        else
            $this->paypal->toggle_sandbox(false);

        $this->paypal->admin_mail = get_option('admin_email');
    }

    function getPaypal() {
        return $this->paypal;
    }

    function getOptions() {
        return $this->options;
    }

    function setPaypal($paypal) {
        $this->paypal = $paypal;
    }

    function setOptions($options) {
        $this->options = $options;
    }

    public function callback($payment_status,$rm_pproc_id)
    {
        switch ($payment_status)
            {
                case 'success':
                    if ($rm_pproc_id)
                    {
                        $log_id = $rm_pproc_id;
                        $log = RM_DBManager::get_row('PAYPAL_LOGS', $log_id);
                        if ($log)
                        {
                            if ($log->log)
                            {
                                $paypal_log = maybe_unserialize($log->log);
                                $payment_status = $paypal_log['payment_status'];

                                if ($payment_status == 'Completed')
                                {
                                    echo '<div id="rmform">';
                                    echo "<div class='rminfotextfront'>" . RM_UI_Strings::get("MSG_PAYMENT_SUCCESS") . "</br>";
                                    echo '</div></div>';
                                    return 'success';
                                } else if ($payment_status == 'Denied' || $payment_status == 'Failed' || $payment_status == 'Refunded' || $payment_status == 'Reversed' || $payment_status == 'Voided')
                                {
                                    echo '<div id="rmform">';
                                    echo "<div class='rminfotextfront'>" . RM_UI_Strings::get("MSG_PAYMENT_FAILED") . "</br>";
                                    echo '</div></div>';
                                    return 'failed';
                                } else if ($payment_status == 'In-Progress' || $payment_status == 'Pending' || $payment_status == 'Processed')
                                {
                                    echo '<div id="rmform">';
                                    echo "<div class='rminfotextfront'>" . RM_UI_Strings::get("MSG_PAYMENT_PENDING") . "</br>";
                                    echo '</div></div>';
                                    return 'pending';
                                } else if ($payment_status == 'Canceled_Reversal')
                                {
                                    return 'canceled_reversal';
                                }
                            }
                        }
                    }
                    return false;

                case 'cancel':
                    echo '<div id="rmform">';
                    echo "<div class='rminfotextfront'>" . RM_UI_Strings::get("MSG_PAYMENT_CANCEL") . "</br>";
                    echo '</div></div>';
                    return;

                case 'ipn':
                    $trasaction_id = $_POST["txn_id"];
                    $payment_status = $_POST["payment_status"];
                    $cstm = $_POST["custom"];
                    $abcd = explode("|", $cstm);
                    $user_id = (int) ($abcd[1]);
                    $acbd = explode("|", $cstm);
                    $log_entry_id = (int) ($acbd[0]); //$_POST["custom"];
                    $log_array = maybe_serialize($_POST);

                    $curr_date = RM_Utilities::get_current_time(); // date_i18n(get_option('date_format'));

                    RM_DBManager::update_row('PAYPAL_LOGS', $log_entry_id, array(
                        'status' => $payment_status,
                        'txn_id' => $trasaction_id,
                        'posted_date' => $curr_date,
                        'log' => $log_array), array('%s', '%s', '%s', '%s'));

                    if ($this->paypal->validate_ipn())
                    {
                        //IPN is valid, check payment status and process logic
                        if ($payment_status == 'Completed')
                        {
                            if ($user_id)
                            {
                                $gopt = new RM_Options;
                                if ($gopt->get_value_of('user_auto_approval') == "yes")
                                {
                                    $user_service = new RM_User_Services();
                                    $user_service->activate_user_by_id($user_id);
                                }
                            }
                            return 'success';
                        }
                        else if ($payment_status == 'Denied' || $payment_status == 'Failed' || $payment_status == 'Refunded' || $payment_status == 'Reversed' || $payment_status == 'Voided')
                        {
                            return 'failed';
                        } else if ($payment_status == 'In-Progress' || $payment_status == 'Pending' || $payment_status == 'Processed')
                        {
                            return 'pending';
                        } else if ($payment_status == 'Canceled_Reversal')
                        {
                            return 'canceled_reversal';
                        }

                        return 'unknown';
                    }

                    return 'invalid_ipn';
            }
    }

    public function cancel() {

    }

    public function charge($data,$pricing_details) {
        $form_id= $data->form_id;
        $this_script = get_permalink();
        
        if(false == $this_script){
            $this_script = admin_url('admin-ajax.php?action=registrationmagic_embedform&form_id='.$data->form_id);
        }
        $sign = strpos($this_script, '?') ? '&' : '?';

        $i = 1;
        foreach ($pricing_details->billing as $item)
        {
            $this->paypal->add_field('item_name_' . $i, $item->label);
            $i++;
        }

        $i = 1;
        $total_amount = 0.0;
        foreach ($pricing_details->billing as $item)
        {
            $this->paypal->add_field('amount_' . $i, $item->price);
            $total_amount += floatval($item->price);
            $i++;
        }

        $invoice = (string) date("His") . rand(1234, 9632);

        $this->paypal->add_field('business', $this->paypal_email); // Call the facilitator eaccount
        $this->paypal->add_field('cmd', '_cart'); // cmd should be _cart for cart checkout
        $this->paypal->add_field('upload', '1');
        $this->paypal->add_field('return', $this_script . $sign . 'rm_pproc=success&rm_pproc_id=0'); // return URL after the transaction got over
        $this->paypal->add_field('cancel_return', $this_script . $sign . 'rm_pproc=cancel&rm_pproc_id=0'); // cancel URL if the trasaction was cancelled during half of the transaction
        $this->paypal->add_field('notify_url', $this_script . $sign . 'rm_pproc=ipn&rm_pproc_id=0'); // Notify URL which received IPN (Instant Payment Notification)
        $this->paypal->add_field('currency_code', $this->currency);
        $this->paypal->add_field('invoice', $invoice);

        $this->paypal->add_field('page_style', $this->paypal_page_style);

        //Insert into PayPal log table

        $curr_date = RM_Utilities::get_current_time(); //date_i18n(get_option('date_format'));

        if ($total_amount <= 0.0)
        {
            $log_entry_id = RM_DBManager::insert_row('PAYPAL_LOGS', array('submission_id' => $data->submission_id,
                        'form_id' => $form_id,
                        'invoice' => $invoice,
                        'status' => 'Completed',
                        'total_amount' => $total_amount,
                        'currency' => $this->currency,
                        'posted_date' => $curr_date), array('%d', '%d', '%s', '%s', '%f', '%s', '%s'));

            return true;
        } else
        {
            $log_entry_id = RM_DBManager::insert_row('PAYPAL_LOGS', array('submission_id' => $data->submission_id,
                        'form_id' => $form_id,
                        'invoice' => $invoice,
                        'status' => 'Pending',
                        'total_amount' => $total_amount,
                        'currency' => $this->currency,
                        'posted_date' => $curr_date), array('%d', '%d', '%s', '%s', '%f', '%s', '%s'));
        }
        
        if(isset($data->user_id))
            $cstm_data = $log_entry_id."|".$data->user_id;
        else
            $cstm_data = $log_entry_id."|0";
        
        $this->paypal->add_field('custom', $cstm_data);
        $this->paypal->add_field('return', $this_script . $sign . 'rm_pproc=success&rm_pproc_id='.$log_entry_id); // return URL after the transaction got over
        $this->paypal->add_field('cancel_return', $this_script . $sign . 'rm_pproc=cancel&rm_pproc_id='.$log_entry_id); // cancel URL if the trasaction was cancelled during half of the transaction
        $this->paypal->add_field('notify_url', $this_script . $sign . 'rm_pproc=ipn&rm_pproc_id='.$log_entry_id); // Notify URL which received IPN (Instant Payment Notification)
                        
        $this->paypal->submit_paypal_post(); // POST it to paypal
        return 'do_not_redirect';  //We do not want form redirect to work in case paypal processing is going on.
    }

    public function refund() {
        
    }

    public function subscribe() {
        
    }

}

