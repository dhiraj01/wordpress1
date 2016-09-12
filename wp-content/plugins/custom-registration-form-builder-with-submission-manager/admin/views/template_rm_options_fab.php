<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$image_dir = plugin_dir_url(dirname(dirname(__FILE__))) . "images";
$media_btn_label = RM_UI_Strings::get('LABEL_FAB_ICON');
$media_btn_help_text = RM_UI_Strings::get('TEXT_FAB_ICON_HELP');
$media_btn_val = RM_UI_Strings::get('LABEL_FAB_ICON_BTN');
$remove_btn_val = RM_UI_Strings::get('LABEL_FAB_ICON_BTN_REM');
$fab_icon = $data['fab_icon'];
$icon_src = '';
if($fab_icon){
    if($src= wp_get_attachment_image_url($fab_icon)){
        $icon_src = $src;
    }
}
$media_btn_html = <<<btn_html
        <div class="rmrow">
            <div class="rmfield" for="options_fab-element-1">
                <label>$media_btn_label</label>
            </div>
            <div class="rminput rm_wpmedia_input_cont">
                <div id="rm_fab_icon"><img alt="" src="$icon_src"></div>
                <input type="hidden" name="fab_icon" value="$fab_icon" id="rm_fab_icon_val">
                <input type="button" class="rm_wpmedia_btn button" id="rm_media_btn_fab_icon" value="$media_btn_val">
                <input type="button" class="rm_btn button" id="rm_btn_remove_fab_icon" value="$remove_btn_val" onclick="rm_remove_fab_icon()">
            </div>
                <div class="rmnote">
                    <div class="rmprenote"></div>
                        <div class="rmnotecontent">$media_btn_help_text</div>
                </div>
            </div>
btn_html;

?>


<div class="rmagic">

    <!--Dialogue Box Starts-->
    <div class="rmcontent">


        <?php
        $pages = get_pages();
        $wp_pages = RM_Utilities::wp_pages_dropdown();

        $form = new Form("options_fab");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => "",
            "enctype" => "multipart/form-data"
        ));

        $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get('GLOBAL_SETTINGS_FAB') . '</div>'));
        $form->addElement(new Element_Checkbox(RM_UI_Strings::get('LABEL_SHOW_FLOATING_ICON'), "display_floating_action_btn", array("yes" => ''), $data['display_floating_action_btn'] == 'yes' ? array("value" => "yes", "longDesc" => RM_UI_Strings::get('HELP_SHOW_FLOATING_ICON')) : array("longDesc" => RM_UI_Strings::get('HELP_SHOW_FLOATING_ICON'))));
        $form->addElement(new Element_HTML($media_btn_html));
        $form->addElement(new Element_HTML('<div class="rmnotice">'.RM_UI_Strings::get('NOTE_MAGIC_PANEL_STYLING').'</div>'));
        $form->addElement(new Element_HTMLL('&#8592; &nbsp; Cancel', '?page=rm_options_manage', array('class' => 'cancel')));
        $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_SAVE')));
        $form->render();
        ?> 

    </div>
</div>
<?php wp_enqueue_media(); ?> 
<script type="text/javascript">
    jQuery(document).ready(function(){
       jQuery('#rm_floating_btn_type_rd-0').click(function(){
           jQuery('#floating_btn_txt_tb').slideUp();
       });
       jQuery('#rm_floating_btn_type_rd-1, #rm_floating_btn_type_rd-2').click(function(){
                      jQuery('#floating_btn_txt_tb').slideDown();
       });
       
       if (jQuery('.rm_wpmedia_btn').length > 0) {
        if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
        jQuery('.rm_wpmedia_input_cont').on('click', '.rm_wpmedia_btn', function(e) {
            e.preventDefault();
            var button = jQuery(this);
            var id = button.prev();
            wp.media.editor.send.attachment = function(props, attachment) {
                id.val(attachment.id);
                jQuery("#rm_fab_icon img").prop('src',attachment.url);
            };
            wp.media.editor.open();
            return false;
        });
        
    }
};
    });
    
    function rm_remove_fab_icon(){
        jQuery("#rm_fab_icon img").prop('src','');
        jQuery("#rm_fab_icon_val").val('');
    }
</script>

<?php   
        