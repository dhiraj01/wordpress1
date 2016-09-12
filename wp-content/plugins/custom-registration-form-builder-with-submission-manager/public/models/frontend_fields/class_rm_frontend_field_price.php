<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RM_Frontend_Field_Price extends RM_Frontend_Field_Base
{

    protected $currency_pos;
    protected $curr_symbol;
    protected $pp_field_id;

    public function __construct($id, $label, $options, $field_value, $currency_pos, $currency_symbol, $page_no = 1, $is_primary = false, $extra_opts = null)
    {
        parent::__construct($id, 'Price', $label, $options, $page_no, $is_primary, $extra_opts);
        $this->pp_field_id = $field_value;
        $field_name = $this->field_type . "_" . $this->field_id . "_" . $this->pp_field_id;
        $this->set_field_name($field_name);
        $this->currency_pos = $currency_pos;
        $this->curr_symbol = $currency_symbol;
    }

    public function get_pfbc_field()
    {
        if ($this->pfbc_field)
            return $this->pfbc_field;
        else
        {
            $pfbc_field_array = array();
            $paypal_field = new RM_PayPal_Fields();
            $res = $paypal_field->load_from_db($this->pp_field_id);

            if (!$res)
                return null;

            $label = $this->get_formatted_label();
            $name = $this->field_name;
            $pfbc_field_array[] = new Element_Hidden('rm_payment_form', 'pp');

            $properties = array();

            if (isset($this->field_options['required']))
                $properties['required'] = '1';
            if (isset($this->field_options['style']))
                $properties['style'] = $this->field_options['style'];  
            
            if (isset($this->field_options['longDesc']))
                $properties['longDesc'] = $this->field_options['longDesc'];
            
            if (isset($this->field_options['style']))
                $properties['style'] = $this->field_options['style']; 
            
            if (isset($this->field_options['labelStyle']))
                $properties['labelStyle'] = $this->field_options['labelStyle'];
            
            $element = null;
            switch ($paypal_field->get_type())
            {
                case "fixed":
                    if ($this->currency_pos == 'before')
                        $properties['value'] = $paypal_field->get_name() . " (" . $this->curr_symbol . " " . $paypal_field->get_value() . ")";
                    else
                        $properties['value'] = $paypal_field->get_name() . " (" . $paypal_field->get_value() . " " . $this->curr_symbol . ")";
                    $properties['readonly'] = 1;
                    $properties['class'] = $paypal_field->get_class();
                    if ($paypal_field->get_extra_options() != 'yes')
                        $element = new Element_Hidden($name, $label);
                    else
                        $element = new Element_Textbox($label, $name, $properties);
                    break;
                
            }

            $pfbc_field_array[] = $element;

            $this->pfbc_field = $pfbc_field_array;

            return $this->pfbc_field;
        }
    }

    public function get_prepared_data($request)
    {
        $paypal_field = new RM_PayPal_Fields();
        $res = $paypal_field->load_from_db($this->pp_field_id);

        if (!$res)
            return null;

        switch ($paypal_field->get_type())
        {
            case "fixed":
                return parent::get_prepared_data($request);
        }
        
    }
    
    //Returns details of the price fields submitted by user in an stdClass object containing following fields..
    // billing ==> it contains an array of individual objects holding product name and price in 'label' and 'price' fields.
    // total ==> total amount for that particular field as submitted by user. (It is NOT the total amount for all the price fields in a form).
    
     public function get_pricing_detail($request)
    {
        $paypal_field = new RM_PayPal_Fields();
        $res = $paypal_field->load_from_db($this->pp_field_id);

        if (!$res)
            return null;
        
        $total_price = 0.0;
        $billing = array();
        
        switch ($paypal_field->get_type())
        {
            case "fixed":
                $total_price = floatval($paypal_field->get_value());
                $billing[] = (object)array('label'=>$paypal_field->get_name(), 'price'=>$total_price);
                break;
        }
        
         $value = (object)array('billing'=>$billing, 'total_price'=>$total_price);
         return $value;
    }

}
