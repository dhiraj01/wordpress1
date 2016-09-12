<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="rmagic">
    <?php
    ?>
    <!-----Operations bar Start-->

    <div class="operationsbar">
        <div class="rmtitle"><?php echo RM_UI_Strings::get('TEXT_FROM').': '. $data->submission->get_user_email(); ?></div>
        <div class="icons">
            <a href="?page=rm_options_manage"><img alt="" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/global-settings.png'; ?>"></a>

        </div>
        <div class="nav">
            <ul>
                <li><a href="?page=rm_submission_manage&rm_form_id=<?php echo $data->submission->get_form_id(); ?>"><?php echo RM_UI_Strings::get("LABEL_BACK"); ?></a></li>
                <li><a class="rm_deactivated" href="javascript:void(0)"><?php echo RM_UI_Strings::get("LABEL_ADD_NOTE"); ?></a></li>
                <li><a class="rm_deactivated" href="javascript:void(0)"><?php echo RM_UI_Strings::get("LABEL_PRINT"); ?></a></li>
                <li><a href="?page=rm_submission_view&rm_submission_id=<?php echo $data->submission->get_submission_id(); ?>&rm_action=delete"><?php echo RM_UI_Strings::get("LABEL_DELETE"); ?></a></li>
            </ul>
        </div>

    </div>
    <!--****Operations bar Ends**-->

    <!--**Content area Starts**-->
    <div class="rm-submission">        

        <form method="post" action="" name="rm_view_submission" id="rm_view_submission_page_form">
            <input type="hidden" name="rm_slug" value="" id="rm_slug_input_field">

            <?php
            if ($data->form_is_unique_token)
            {
                ?>
                <div class="rm-submission-field-row">
                    <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_UNIQUE_TOKEN_SHORT'); ?> :</div>
                    <div class="rm-submission-value"><?php echo $data->submission->get_unique_token(); ?></div>
                </div>
                <?php
            }
            ?>

            <div class="rm-submission-field-row">
                <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_ENTRY_ID'); ?></div>
                <div class="rm-submission-value"><?php echo $data->submission->get_submission_id(); ?></div>
            </div>

            <div class="rm-submission-field-row">
                <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_ENTRY_TYPE'); ?></div>
                <div class="rm-submission-value"><?php echo $data->form_type; ?></div>
            </div>
            <?php
            if ($data->form_type_status == "1" && !empty($data->user))
            {
                $user_roles_dd = RM_Utilities::user_role_dropdown();
                ?>
                <div class="rm-submission-field-row">
                    <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_USER_NAME'); ?></div>
                    <div class="rm-submission-value"><?php echo $data->user->display_name; ?></div>
                </div>

                <div class="rm-submission-field-row">
                    <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_USER_ROLES'); ?></div>
                    <?php if(count($data->user->roles) === 1): ?>
                    <div class="rm-submission-value"><?php echo $user_roles_dd[(implode(',', $data->user->roles))]; ?></div>
                    <?php else: ?>
                    <div class="rm-submission-value"><?php echo RM_UI_Strings::get('MSG_USER_DELETED'); ?></div>                    
                    <?php endif; ?>
                </div>

                <?php
            }
            ?>
            <?php
            $submission_data = $data->submission->get_data();
         
            if (is_array($submission_data) || $submission_data)
                foreach ($submission_data as $field_id => $sub):

                    $sub_key = $sub->label;
                    $sub_data = $sub->value;
                    if(!isset($sub->type)){
                                $sub->type = '';
                            }
                    ?>

                    <!--submission row block-->

                    <div class="rm-submission-field-row">
                        <div class="rm-submission-label"><?php echo $sub_key; ?></div>
                        <div class="rm-submission-value">
                            <?php
                            //if submitted data is array print it in more than one row.
                            
                            if (is_array($sub_data)) {

                                //If submitted data is a file.

                                if (isset($sub_data['rm_field_type']) && $sub_data['rm_field_type'] == 'File') {
                                    unset($sub_data['rm_field_type']);

                                    foreach ($sub_data as $sub) {

                                        $att_path = get_attached_file($sub);
                                        $att_url = wp_get_attachment_url($sub);
                                        ?>
                                        <div class="rm-submission-attachment">
                                            <?php echo wp_get_attachment_link($sub, 'thumbnail', false, true, false); ?>
                                            <div class="rm-submission-attachment-field"><?php echo basename($att_path); ?></div>
                                            <div class="rm-submission-attachment-field"><a href="<?php echo $att_url; ?>"><?php echo RM_UI_Strings::get('LABEL_DOWNLOAD'); ?></a></div>
                                        </div>

                                        <?php
                                    }
                                } elseif (isset($sub_data['rm_field_type']) && $sub_data['rm_field_type'] == 'Address') {
                                    $sub = $sub_data['original'] . '<br/>';
                                    if (count($sub_data) === 8) {
                                        $sub .= '<b>Street Address</b> : ' . $sub_data['st_number'] . ', ' . $sub_data['st_route'] . '<br/>';
                                        $sub .= '<b>City</b> : ' . $sub_data['city'] . '<br/>';
                                        $sub .= '<b>State</b> : ' . $sub_data['state'] . '<br/>';
                                        $sub .= '<b>Zip code</b> : ' . $sub_data['zip'] . '<br/>';
                                        $sub .= '<b>Country</b> : ' . $sub_data['country'];
                                    }
                                    echo $sub;
                                }  elseif ($sub->type == 'Time') {                                  
                                    echo $sub_data['time'].", Timezone: ".$sub_data['timezone'];
                                } 
                                //If submitted data is a Star Rating.
                                
                                
                                
                                else {
                                    $sub = implode(', ', $sub_data);
                                    echo $sub;
                                }
                            } else {
                                
                                if($sub->type == 'Rating')
                                {
                                    echo '<div class="rateit" id="rateit5" data-rateit-min="0" data-rateit-max="5" data-rateit-value="'.$sub->value.'" data-rateit-ispreset="true" data-rateit-readonly="true"></div>';
                                }
                                else
                                {
                                echo $sub_data;
                                }
                            }
                            ?>
                        </div>
                    </div>  <!-- End of one submission block-->
                    <?php
                endforeach;
            if ($data->payment)
            {
                if ($data->payment->log):
                    ?>
                    <div class="rm-submission-field-row">
                        <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_PAYER_NAME'); ?></div>
                        <div class="rm-submission-value"><?php if (isset($data->payment->log['first_name'])) echo $data->payment->log['first_name'];
            if (isset($data->payment->log['last_name'])) echo ' ' . $data->payment->log['last_name']; ?></div>
                    </div>
                    <div class="rm-submission-field-row">
                        <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_PAYER_EMAIL'); ?></div>
                        <div class="rm-submission-value"><?php if (isset($data->payment->log['payer_email'])) echo $data->payment->log['payer_email']; ?></div>
                    </div>
                    <?php
                endif;
                ?>
                <div class="rm-submission-field-row">
                    <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_INVOICE'); ?></div>
                    <div class="rm-submission-value"><?php if (isset($data->payment->invoice)) echo $data->payment->invoice; ?></div>
                </div>
                <div class="rm-submission-field-row">
                    <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_TAXATION_ID'); ?></div>
                    <div class="rm-submission-value"><?php if (isset($data->payment->txn_id)) echo $data->payment->txn_id; ?></div>
                </div>
                <div class="rm-submission-field-row">
                    <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_STATUS_PAYMENT'); ?></div>
                    <div class="rm-submission-value"><?php if (isset($data->payment->status)) echo $data->payment->status; ?></div>
                </div>
                <div class="rm-submission-field-row">
                    <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_PAID_AMOUNT'); ?></div>
                    <div class="rm-submission-value"><?php if (isset($data->payment->total_amount)) echo $data->payment->total_amount; ?></div>
                </div>
                <div class="rm-submission-field-row">
                    <div class="rm-submission-label"><?php echo RM_UI_Strings::get('LABEL_DATE_OF_PAYMENT'); ?></div>
                    <div class="rm-submission-value"><?php if (isset($data->payment->posted_date)) echo RM_Utilities::localize_time($data->payment->posted_date, get_option('date_format')); ?></div>
                </div>
                <?php
            }
            ?>


        </form>
    </div>
    <?php
    if ($data->notes && (is_object($data->notes) || is_array($data->notes)))
    {
        foreach ($data->notes as $note)
        {
            ?>
            <div class="rm-submission-note" style="border-left: 4px solid #<?php echo maybe_unserialize($note->note_options)->bg_color; ?>">
                <div class="rm-submission-note-text"><?php echo $note->notes; ?></div>
                <div class="rm-submission-note-attribute">

                    <?php
                    echo RM_UI_Strings::get('LABEL_CREATED_BY') . " <b>" . $note->author . "</b> <em>" . RM_Utilities::localize_time($note->publication_date) . "</em>";
                    if ($note->editor)
                        echo " (" . RM_UI_Strings::get('LABEL_EDITED_BY') . " <b>" . $note->editor . "</b> <em>" . RM_Utilities::localize_time($note->last_edit_date) . "</em>";
                    ?>
                </div>

                <div class="rm-submission-note-attribute"><a href="?page=rm_note_add&rm_submission_id=<?php echo $data->submission->get_submission_id(); ?>&rm_note_id=<?php echo $note->note_id; ?>"><?php echo RM_UI_Strings::get('LABEL_EDIT'); ?></a>
                    <a href="javascript:void(0)" onclick="document.getElementById('rmnotesectionform<?php echo $note->note_id; ?>').submit()"><?php echo RM_UI_Strings::get('LABEL_DELETE'); ?></a>
                </div>
                <form method="post" id="rmnotesectionform<?php echo $note->note_id; ?>">
                    <input type="hidden" name="rm_slug" value="rm_note_delete">
                    <input type="hidden" name="rm_note_id" value="<?php echo $note->note_id; ?>">
                </form>
            </div>
            <?php
        }
    }
    ?>
    
<div class="rm-upgrade-note-gold">
        <div class="rm-banner-title">Unlock Note and Print options, by upgrading<img src="<?php echo RM_IMG_URL.'logo.png'?>"> </div>
        <div class="rm-banner-subtitle">Choose from two powerful extension bundles</div>
        <div class="rm-banner-box"><a href="http://registrationmagic.com/?download_id=317&edd_action=add_to_cart" target="blank"><img src="<?php echo RM_IMG_URL.'silver-logo.png'?>"></a>

        </div>
        <div class="rm-banner-box"><a href="http://registrationmagic.com/?download_id=19544&edd_action=add_to_cart" target="blank"><img src="<?php echo RM_IMG_URL.'gold-logo.png'?>"></a>

        </div>
    </div>
</div>
