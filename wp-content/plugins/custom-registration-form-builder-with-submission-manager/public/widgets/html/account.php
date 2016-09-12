<div class="dbfl" id="rm-user-greeting">
    <strong id="rm-greeting-text"></strong><?php echo $data->user->first_name; ?>
</div>
<div class="rm-user-panel-user-image dbfl">
    <?php echo get_avatar($data->user->ID); ?>
</div>
<div class="rm-user-panel-user-details rm-white-box rm-rounded-corners dbfl">
    <div class="rm-panel-row dbfl">
        <div class="rm-panel-field difl"><?php echo RM_UI_Strings::get('FIELD_TYPE_FNAME'); ?></div>
        <div class="rm-panel-value difl"><?php echo $data->user->first_name; ?></div>
    </div>
    <div class="rm-panel-row dbfl">
        <div class="rm-panel-field difl"><?php echo RM_UI_Strings::get('FIELD_TYPE_LNAME'); ?></div>
        <div class="rm-panel-value difl"><?php echo $data->user->last_name; ?></div>
    </div>
    <div class="rm-panel-row dbfl">
        <div class="rm-panel-field difl"><?php echo RM_UI_Strings::get('LABEL_BIO'); ?></div>
        <div class="rm-panel-value difl"><?php echo $data->user->description; ?></div>
    </div>
    <?php
    if (is_array($data->custom_fields) || is_object($data->custom_fields)) {
        foreach ($data->custom_fields as $field_id => $sub) {
            $key = $sub->label;
            $meta = $sub->value;
            if(!isset($sub->type)){
                                $sub->type = '';
                            }
            $meta = RM_Utilities::strip_slash_array(maybe_unserialize($meta));
            ?>
            <div class="rm-panel-row dbfl">

                <div class="rm-panel-field difl"><?php echo $key; ?></div>
                <div class="rm-panel-value difl">
                    <?php
                    if (is_array($meta) || is_object($meta)) {
                                        if (isset($meta['rm_field_type']) && $meta['rm_field_type'] == 'File') {
                                            unset($meta['rm_field_type']);

                                            foreach ($meta as $sub) {

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
                                        } elseif (isset($meta['rm_field_type']) && $meta['rm_field_type'] == 'Address') {
                                            $sub = $meta['original'] . '<br/>';
                                            if (count($meta) === 8) {
                                                $sub .= '<b>Street Address</b> : ' . $meta['st_number'] . ', ' . $meta['st_route'] . '<br/>';
                                                $sub .= '<b>City</b> : ' . $meta['city'] . '<br/>';
                                                $sub .= '<b>State</b> : ' . $meta['state'] . '<br/>';
                                                $sub .= '<b>Zip code</b> : ' . $meta['zip'] . '<br/>';
                                                $sub .= '<b>Country</b> : ' . $meta['country'];
                                            }
                                                echo $sub;
                                        } elseif ($sub->type == 'Time') {                                  
                                    echo $meta['time'].", Timezone: ".$meta['timezone'];
                                } else {
                                            $sub = implode(', ', $meta);
                                            echo $sub;
                                        }
                                    } else {
                                        if($sub->type=='Rating')
                                        {
                                           echo '<div class="rateit" id="rateit5" data-rateit-min="0" data-rateit-max="5" data-rateit-value="'.$meta.'" data-rateit-ispreset="true" data-rateit-readonly="true"></div>';
                                 
                                        }
                                        else
                                        echo $meta;
                                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }
    ?>

</div>

