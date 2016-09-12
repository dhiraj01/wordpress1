<div id="rm_otp_login">

    <div class="dbfl rm-white-box rm-rounded-corners">
        <div id="rm_otp_enter_email">
            <div class="rm-login-panel-user-image dbfl">
                <img class="dbfl rm-placeholder-user-image" src="<?php echo RM_IMG_URL; ?>placeholder-pic.png">
            </div>
            <div class="dbfl rm-login-panel-fields">
                <input type="text" placeholder="<?php _e('Email:', ''); ?>" value="" id="rm_otp_econtact" name="<?php echo wp_generate_password(5, false, false); ?>"
                       onkeypress="return rm_call_otp(event, 'rm-floating-page-login')" maxlength="50" class="difl rm-rounded-corners rm-grey-box"/>

                <button class="difl rm-rounded-corners rm-accent-bg rm-button" id="rm-panel-login" onclick="rm_call_otp(event, 'rm-floating-page-login', 'submit')"><?php echo RM_UI_Strings::get('LABEL_NEXT'); ?></button>
            </div>
        </div>
        <div id="rm_otp_enter_password" style="display:none">
            <div class="rm-login-panel-user-image dbfl">
                <img class="dbfl rm-placeholder-user-image" src="<?php echo RM_IMG_URL; ?>user-icon-blue.jpg">
            </div>
            <div class="dbfl rm-login-panel-fields">

                <input type="text" value="" placeholder="<?php _e('OTP:', ''); ?>" maxlength="50" name="<?php echo wp_generate_password(5, false, false); ?>" id="rm_otp_kcontact" class="difl rm-rounded-corners rm-grey-box" onkeypress="return rm_call_otp(event, 'rm-floating-page-login')"/>

                <button class="difl rm-rounded-corners rm-accent-bg rm-button" id="rm-panel-login" onclick="rm_call_otp(event, 'rm-floating-page-login', 'submit')"><?php echo RM_UI_Strings::get('LABEL_LOGIN'); ?></button>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo wp_generate_password(8, false); ?>" name="security_key"/>
    <div class="rm_f_notifications">
        <span class="rm_f_error"></span>
        <span class="rm_f_success"></span> 
    </div>
</div>

