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
        $form = new Form("add-note");

        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => ""
        ));

        if ($data->model->get_note_id())
        {
            $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get("TITLE_EDIT_NOTE_PAGE") . '</div>'));
            $form->addElement(new Element_Hidden("note_id", $data->model->get_note_id()));
        } else
            $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get("TITLE_NEW_NOTE_PAGE") . '</div>'));

        $form->addElement(new Element_Hidden("submission_id", $data->submission_id));

        $form->addElement(new Element_Textarea("<b>" . RM_UI_Strings::get('LABEL_NOTE_TEXT') . ":</b>", "notes", array("class" => "rm-static-field rm_field_value", "value" => $data->model->get_notes())));
        $form->addElement(new Element_Color("<b>" . RM_UI_Strings::get('LABEL_NOTE_COLOR') . ":</b>", "bg_color", array("class" => "jscolor", "value" => $data->model->get_note_options()->bg_color)));
        $form->addElement(new Element_Checkbox("<b>" . RM_UI_Strings::get('LABEL_VISIBLE_FRONT') . ":</b>", "status", array(1 => ""), array("class" => "rm-static-field rm_input_type", "value" => $data->model->get_status())));

        $form->addElement(new Element_HTMLL('&#8592; &nbsp; Cancel', '?page=rm_submission_view&rm_submission_id=' . $data->submission_id, array('class' => 'cancel')));
        $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_SAVE'), "submit", array("id" => "rm_submit_btn", "class" => "rm_btn", "name" => "submit")));

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
</div>
