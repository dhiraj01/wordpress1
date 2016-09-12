<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="rmagic">

    <!--Dialogue Box Starts-->
    <div class="rmcontent">


        <?php
        $form = new Form("options_users");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => ""
        ));
        
        $options_sp = array("id" => "id_rm_send_pass_cb", "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_USER_SEND_PASS'));
        
        if($data['auto_generated_password'] === 'yes')
            $options_sp['disabled'] = true;
        
        if( $data['send_password'] === 'yes')
            $options_sp['value'] = 'yes';

        $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get('GLOBAL_SETTINGS_USER') . '</div>'));
        $form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_AUTO_PASSWORD'), "auto_generated_password", array("yes" => ''), $data['auto_generated_password'] === 'yes' ? array("id" => "id_rm_autogen_pass_cb", "value" => "yes", "onchange" => "checkbox_disable_elements(this, 'id_rm_send_pass_cb-0', 1)", "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_USER_AUTOGEN')) : array("id" => "id_rm_autogen_pass_cb", "onchange" => "checkbox_disable_elements(this, 'id_rm_send_pass_cb-0', 1)", "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_USER_AUTOGEN'))));

        $form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_SEND_PASS_EMAIL'), "send_password", array("yes" => ''), $options_sp));

        $form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_REGISTER_APPROVAL'), "buy_pro", array("yes" => ''), array("value" => "yes", 'disabled' => 1, "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_USER_AUTOAPPROVAL') . "<br><br>" . RM_UI_Strings::get('MSG_BUY_PRO_INLINE'))));

        $form->addElement(new Element_HTMLL('&#8592; &nbsp; Cancel', '?page=rm_options_manage', array('class' => 'cancel')));
        $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_SAVE')));

        $form->render();
        ?>
    </div>
    <div class="rm-upgrade-note-gold">
        <div class="rm-banner-title">Upgrade and expand the power of<img src="<?php echo RM_IMG_URL.'logo.png'?>"> </div>
        <div class="rm-banner-subtitle">Choose from two powerful extension bundles</div>
        <div class="rm-banner-box"><a href="http://registrationmagic.com/?download_id=317&edd_action=add_to_cart" target="blank"><img src="<?php echo RM_IMG_URL.'silver-logo.png'?>"></a>

        </div>
        <div class="rm-banner-box"><a href="http://registrationmagic.com/?download_id=19544&edd_action=add_to_cart" target="blank"><img src="<?php echo RM_IMG_URL.'gold-logo.png'?>"></a>

        </div>
    </div>
</div>

<?php   