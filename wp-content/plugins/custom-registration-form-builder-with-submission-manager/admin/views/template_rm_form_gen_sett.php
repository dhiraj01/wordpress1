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
        $form = new Form("form_sett_general");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => ""
        ));
        
        if (isset($data->model->form_id)) {
            $form->addElement(new Element_HTML('<div class="rmheader">' . $data->model->form_name . '</div>'));
            $form->addElement(new Element_HTML('<div class="rmsettingtitle">' . RM_UI_Strings::get('LABEL_F_GEN_SETT') . '</div>'));
            $form->addElement(new Element_Hidden("form_id", $data->model->form_id));
        } else {
            $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get("TITLE_NEW_FORM_PAGE") . '</div>'));
        }

        $form->addElement(new Element_Textbox("<b>" . RM_UI_Strings::get('LABEL_TITLE') . ":</b>", "form_name", array("id" => "rm_form_name", "required" => "1", "value" => $data->model->form_name, "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_TITLE'))));
        $form->addElement(new Element_Textarea("<b>" . RM_UI_Strings::get('LABEL_DESC') . ":</b>", "form_description", array("id" => "rm_form_description", "value" => $data->model->form_options->form_description, "longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_DESC'))));
        
        if($data->model->form_type === null)
           $data->model->form_type = RM_REG_FORM;
        $form_type_selection_array = array(RM_REG_FORM => "<span class='rm_form_type_label'>".RM_UI_Strings::get('LABEL_REG_FORM').'</span><div class="rm_formtype_help"><div>'.RM_UI_Strings::get('HELP_SELECT_FORM_TYPE_REG').'</div></div>',
            RM_CONTACT_FORM => "<span class='rm_form_type_label'>".RM_UI_Strings::get('LABEL_NON_REG_FORM').'</span><div class="rm_formtype_help"><div>'.RM_UI_Strings::get('HELP_SELECT_FORM_TYPE_NON_REG').'</div></div>');
        $form->addElement(new Element_Radio("<b>" . RM_UI_Strings::get('LABEL_SELECT_FORM_TYPE') . "</b>:", "form_type", $form_type_selection_array, array("class" => "rm_user_create", "value" => $data->model->form_type)));

        $form->addElement(new Element_TinyMCEWP("<b>" . RM_UI_Strings::get('LABEL_CONTENT_ABOVE') . ":</b>", $data->model->form_options->form_custom_text, "form_custom_text", array('editor_class' => 'rm_TinyMCE', 'editor_height' => '100px'), array("longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_CONTENT_ABOVE_FORM'))));
          if(isset($data->model->form_id))
        $form->addElement(new Element_Radio("<b>" . RM_UI_Strings::get('LABEL_SHOW_PROG_BAR') . ":</b>", "display_progress_bar", array('yes'=>RM_UI_Strings::get('LABEL_YES'),'no'=>RM_UI_Strings::get('LABEL_NO'),'default'=>RM_UI_Strings::get('LABEL_DEFAULT')), array("id"=>"id_form_actrl_date_type","class"=>"rm_deactivated","readonly"=>"readonly","disabled"=>"disabled", "longDesc" => RM_UI_Strings::get('MSG_BUY_PRO_BOTH_INLINE'))));
       
        if(!isset($data->model->form_id))
        $form->addElement(new Element_HTMLL('&#8592; &nbsp; Cancel', 'javascript:void(0)', array('class' => 'cancel', 'onClick' => 'window.history.back();')));
        else
            $form->addElement (new Element_HTMLL ('&#8592; &nbsp; Cancel', '?page=rm_form_sett_manage&rm_form_id='.$data->model->form_id, array('class' => 'cancel')));
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
