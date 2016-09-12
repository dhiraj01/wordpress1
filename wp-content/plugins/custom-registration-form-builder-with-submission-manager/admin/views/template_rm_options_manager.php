<?php
/*
 * To show all the available setting options
 */

$image_path = plugin_dir_url(dirname(dirname(__FILE__))) . 'images/';
global $rm_env_requirements;
?>

<?php if (!($rm_env_requirements & RM_REQ_EXT_CURL)){ ?>
 <div class="shortcode_notification ext_na_error_notice"><p class="rm-notice-para"><?php echo RM_UI_Strings::get('RM_ERROR_EXTENSION_CURL');?></p></div>
 <?php } ?>
 
<div class="rmagic">

    <!-----Settings Area Starts----->

    <div class="rm-global-settings">
        <div class="rm-settings-title">Global Settings</div>
        <div class="settings-icon-area">
            <a href="admin.php?page=rm_options_general">
                <div class="rm-settings-box">
                    <img class="rm-settings-icon" src="<?php echo $image_path; ?>general-settings.png">
                    <div class="rm-settings-description">

                    </div>
                    <div class="rm-settings-subtitle"><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_GENERAL'); ?></div>
                    <span><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_GENERAL_EXCERPT'); ?></span>
                </div></a>
            
            <a href="admin.php?page=rm_options_fab">
                <div class="rm-settings-box">
                    <img class="rm-settings-icon" src="<?php echo $image_path; ?>fab-options.png">
                    <div class="rm-settings-description">

                    </div>
                    <div class="rm-settings-subtitle"><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_FAB'); ?></div>
                    <span><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_FAB_EXCERPT'); ?></span>
                </div></a>

            <a href="admin.php?page=rm_options_security">
                <div class="rm-settings-box">
                    <img class="rm-settings-icon" src="<?php echo $image_path; ?>rm-security.png">
                    <div class="rm-settings-description">

                    </div>
                    <div class="rm-settings-subtitle"><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_SECURITY'); ?></div>
                    <span><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_SECURITY_EXCERPT'); ?></span>
                </div></a>

            <a href="admin.php?page=rm_options_user">
                <div class="rm-settings-box">
                    <img class="rm-settings-icon" src="<?php echo $image_path; ?>rm-user-accounts.png">
                    <div class="rm-settings-description">

                    </div>
                    <div class="rm-settings-subtitle"><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_USER'); ?></div>
                    <span><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_USER_EXCERPT'); ?></span>
                </div></a>

            <a href="admin.php?page=rm_options_autoresponder">
                <div class="rm-settings-box">
                    <img class="rm-settings-icon" src="<?php echo $image_path; ?>rm-email-notifications.png">
                    <div class="rm-settings-description">

                    </div>
                    <div class="rm-settings-subtitle"><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_EMAIL_NOTIFICATIONS'); ?></div>
                    <span><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_EMAIL_NOTIFICATIONS_EXCERPT'); ?></span>
                </div></a>

            <a href="admin.php?page=rm_options_thirdparty">
                <div class="rm-settings-box">
                    <img class="rm-settings-icon" src="<?php echo $image_path; ?>rm-third-party.png">
                    <div class="rm-settings-description">

                    </div>
                    <div class="rm-settings-subtitle"><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_EXTERNAL_INTEGRATIONS'); ?></div>
                    <span><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_EXTERNAL_INTEGRATIONS_EXCERPT'); ?></span>
                </div></a>

            <a href="admin.php?page=rm_options_payment">
                <div class="rm-settings-box">
                    <img class="rm-settings-icon" src="<?php echo $image_path; ?>rm-payments.png">
                    <div class="rm-settings-description">

                    </div>
                    <div class="rm-settings-subtitle"><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_PAYMENT'); ?></div>
                    <span><?php echo RM_UI_Strings::get('GLOBAL_SETTINGS_PAYMENT_EXCERPT'); ?></span>
                </div></a>

        </div>
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
