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
        
$form = new Form("options_thirdparty");
    $form->configure(array(
        "prevent" => array("bootstrap","jQuery"),
        "action" => ""
    ));
  
            $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get('GLOBAL_SETTINGS_EXTERNAL_INTEGRATIONS') . '</div>'));
$form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_LOGIN_FACEBOOK_OPTION'), "enable_facebook", array("yes" => ''),array("id" => "id_rm_enable_fb_cb", "class" => "id_rm_enable_fb_cb" , "value" =>  $data['enable_facebook'],  "onclick" => "hide_show(this)", "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_THIRDPARTY_FB_ENABLE'))));

       
       if ($data['enable_facebook'] == 'yes')
            $form->addElement(new Element_HTML('<div class="childfieldsrow" id="id_rm_enable_fb_cb_childfieldsrow">'));
        else
            $form->addElement(new Element_HTML('<div class="childfieldsrow" id="id_rm_enable_fb_cb_childfieldsrow" style="display:none">'));

    
    $form->addElement(new Element_Textbox(RM_UI_Strings::get('LABEL_FACEBOOK_APP_ID'), "facebook_app_id", array("value" => $data['facebook_app_id'], "id"=>"id_rm_fb_appid_tb", "longDesc"=>RM_UI_Strings::get('HELP_OPTIONS_THIRDPARTY_FB_APPID'))));
    $form->addElement(new Element_Textbox(RM_UI_Strings::get('LABEL_FACEBOOK_SECRET'), "facebook_app_secret", array("value" => $data['facebook_app_secret'],"id"=>"id_rm_fb_appsecret_tb", "longDesc"=>RM_UI_Strings::get('HELP_OPTIONS_THIRDPARTY_FB_SECRET'))));
  
    $form->addElement(new Element_HTML("</div>"));
    
     $form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_MAILCHIMP_INTEGRATION'), "enable_mailchimp", array("yes" => ''),array("id" => "id_rm_enable_mc_cb", "class" => "id_rm_enable_mc_cb" , "value" =>  $data['enable_mailchimp'],  "onclick" => "hide_show(this)", "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_THIRDPARTY_MC_ENABLE'))));

       if ($data['enable_mailchimp'] == 'yes')
            $form->addElement(new Element_HTML('<div class="childfieldsrow" id="id_rm_enable_mc_cb_childfieldsrow">'));
        else
            $form->addElement(new Element_HTML('<div class="childfieldsrow" id="id_rm_enable_mc_cb_childfieldsrow" style="display:none">'));
       
        $form->addElement(new Element_Textbox(RM_UI_Strings::get('LABEL_MAILCHIMP_API'), "mailchimp_key", array("value" => $data['mailchimp_key'], "id" => "id_rm_mc_key_tb", "longDesc" => RM_UI_Strings::get('HELP_OPTIONS_THIRDPARTY_MC_API'))));
        $form->addElement(new Element_HTML("</div>"));
    $form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_CONSTANT_CONTACT_OPTION_INTEGRATION'), "enable_ccontact", array("yes" => ''),array("id" => "", "class" => "" , "value" =>  "","disabled"=>"disabled","readonly"=>"readonly", "longDesc" => RM_UI_Strings::get('MSG_BUY_PRO_BOTH_INLINE'))));
     $form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_AWEBER_OPTION_INTEGRATION'), "enable_aweber", array("yes" => ''),array("id" => "", "class" => "" , "value" =>  "","disabled"=>"disabled","readonly"=>"readonly", "longDesc" => RM_UI_Strings::get('MSG_BUY_PRO_BOTH_INLINE'))));
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