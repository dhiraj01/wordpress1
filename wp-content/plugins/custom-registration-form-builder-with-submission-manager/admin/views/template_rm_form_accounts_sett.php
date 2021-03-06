<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//var_dump($data);die;
?>

<div class="rmagic">

    <!--Dialogue Box Starts-->
    <div class="rmcontent">


        <?php
        $form = new Form("form_sett_accounts");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => ""
        ));

        if (isset($data->model->form_id)) {
            $form->addElement(new Element_HTML('<div class="rmheader">' . $data->model->form_name . '</div>'));
            $form->addElement(new Element_HTML('<div class="rmsettingtitle">' . RM_UI_Strings::get('LABEL_F_ACC_SETT') . '</div>'));
            $form->addElement(new Element_Hidden("form_id", $data->model->form_id));
        } else {
            $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get("TITLE_NEW_FORM_PAGE") . '</div>'));
        }
        
        $form->addElement(new Element_Checkbox("<b>" . RM_UI_Strings::get('LABEL_CREATE_WP_ACCOUNT') . "?</b>(" . RM_UI_Strings::get('LABEL_CREATE_WP_ACCOUNT_DESC') . "):", "form_type", array(1 => ""), array("id" => "rm_user_create", "class" => "rm_user_create", "onclick" => "hide_show(this);", "value" => $data->model->form_type, "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_CREATE_WP_USER'))));

        if ($data->model->form_type == 1)
            $form->addElement(new Element_HTML('<div class="childfieldsrow" id="rm_user_create_childfieldsrow">'));
        else
            $form->addElement(new Element_HTML('<div class="childfieldsrow" id="rm_user_create_childfieldsrow" style="display:none">'));


        $form->addElement(new Element_Select("<b>" . RM_UI_Strings::get('LABEL_DO_ASGN_WP_USER_ROLE') . ":</b>", "default_form_user_role", $data->roles, array("id" => "rm_user_role", "value" => 'subscriber',"disabled" => 1, "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_WP_USER_ROLE_AUTO') . "<br><br>" . RM_UI_Strings::get('MSG_BUY_PRO_INLINE'))));

        $form->addElement(new Element_Checkbox("<b>" . RM_UI_Strings::get('LABEL_LET_USER_PICK') . ":</b>", "get_pro", array(1 => ''), array("id" => "rm_form_should_user_pick", "disabled" => 1, "value" => 'no', "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_WP_USER_ROLE_PICK') . "<br><br>" . RM_UI_Strings::get('MSG_BUY_PRO_INLINE'))));


        
            $form->addElement(new Element_HTML('<div class="childfieldsrow" id="rm_form_should_user_pick_childfieldsrow">'));

        
        $form->addElement(new Element_Textbox("<b>" . RM_UI_Strings::get('LABEL_USER_ROLE_FIELD') . ":</b>", "get_pro", array("id" => "rm_role_label", "disabled" => 1, "value" => $data->model->form_options->form_user_field_label, "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_ROLE_SELECTION_LABEL'))));
        $form->addElement(new Element_Checkbox("<b>" . RM_UI_Strings::get('LABEL_ALLOW_WP_ROLE') . ":</b>", "get_pro_2", $data->roles, array("class" => "rm_allowed_roles", "disabled" => 1, "id" => "rm_", "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_ALLOWED_USER_ROLE') . "<br><br>" . RM_UI_Strings::get('MSG_BUY_PRO_INLINE'))));
        
        $form->addElement(new Element_HTML('</div>'));

        $form->addElement(new Element_Checkbox("<b>" . RM_UI_Strings::get('LABEL_AUTO_LOGIN') . "?</b>", "auto_login", array(1 => ""), array("value" => $data->model->form_options->auto_login, "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_AUTO_LOGIN'))));
        
        
        $form->addElement(new Element_HTML('</div>'));
        
        $form->addElement(new Element_HTMLL('&#8592; &nbsp; Cancel', '?page=rm_form_sett_manage&rm_form_id='.$data->model->form_id, array('class' => 'cancel')));
        $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_SAVE'), "submit", array("id" => "rm_submit_btn", "class" => "rm_btn", "name" => "submit", "onClick" => "jQuery.prevent_field_add(event,'This is a required field.')")));
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






        
