<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_rm_form_settings_controller
 *
 * @author Cmshelplive
 */
class RM_Form_Settings_Controller {

    public $mv_handler;

    function __construct() {
        $this->mv_handler = new RM_Model_View_Handler();
    }

    function manage($model, $service, $request) {
        $data = new stdClass();
        if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id'])
            $data->get_query_params = '&rm_form_id=' . $request->req['rm_form_id'];
        else
            $data->get_query_params = '';
        $view = $this->mv_handler->setView('form_settings');
        $view->render($data);
    }

    function general($model, $service, $request, $params) {
        if ($this->mv_handler->validateForm("form_sett_general")) {
            $options = array();
            $options['form_type'] = $request->req['form_type'];
            $options['form_name'] = $request->req['form_name'];
            $options['form_description'] = $request->req['form_description'];
            $options['form_custom_text'] = $request->req['form_custom_text'];

            if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
                $model->load_from_db($request->req['rm_form_id']);
                $model->set($options);
                $model->update_into_db();
                RM_Utilities::redirect('?page=rm_form_sett_manage&rm_form_id='.$request->req['rm_form_id']);
                return;
            } else {
                $model->set($options);
                $form_id = $service->add_user_form();
                RM_Utilities::redirect('?page=rm_form_sett_manage&rm_form_id='.$form_id);
                return;
            }
        }
        $data = new stdClass();
        $view = $this->mv_handler->setView('form_gen_sett');
        if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id'])
            $model->load_from_db($request->req['rm_form_id']);
        $data->model = $model;
        $view->render($data);
    }

    function limits($model, $service, $request, $params) {

        if ($this->mv_handler->validateForm("form_sett_limits")) {
            $options['form_should_auto_expire'] = isset($request->req['form_should_auto_expire']) ? $request->req['form_should_auto_expire'] : null;
            $options['form_expired_by'] = isset($request->req['form_expired_by']) ? $request->req['form_expired_by'] : null;
            $options['form_submissions_limit'] = $request->req['form_submissions_limit'];
            $options['form_expiry_date'] = $request->req['form_expiry_date'];
            
            if(isset( $request->req['form_message_after_expiry']))
                $options['form_message_after_expiry'] = $request->req['form_message_after_expiry'];
            
            $options['enable_captcha'] = isset($request->req['enable_captcha']) ? $request->req['enable_captcha'] : null;
            //$options['allow_multiple_file_uploads'] =isset( $request->req['allow_multiple_file_uploads']) ? $request->req['allow_multiple_file_uploads'] : null;
            $options['sub_limit_antispam'] = isset( $request->req['sub_limit_antispam']) ? $request->req['sub_limit_antispam'] : null;
            $options['post_expiry_action'] = isset( $request->req['post_expiry_action']) ? $request->req['post_expiry_action'] : 'display_message';
            
            if(isset( $request->req['post_expiry_form_id']))
                $options['post_expiry_form_id'] = $request->req['post_expiry_form_id'];
            //var_dump($request->req);die;
            if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
                $model->load_from_db($request->req['rm_form_id']);
                $model->set($options);
                if ($model->validate_limits('form_sett_limits')) {
                    $model->update_into_db();
                RM_Utilities::redirect('?page=rm_form_sett_manage&rm_form_id='.$request->req['rm_form_id']);
                    return;
                } else
                    $visited = true;
            } else {
                echo '<div class="rmnotice">' . RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED') . '</div>';
                return;
            }
        }

        if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
            $data = new stdClass();
            if (!isset($visited))
                $model->load_from_db($request->req['rm_form_id']);
            $view = $this->mv_handler->setView('form_limits_sett');
            $data->model = $model;
            $data->form_dropdown = RM_Utilities::get_forms_dropdown($service);
        } else {
            $view = $this->mv_handler->setView('show_notice');
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
        }
        $view->render($data);
    }

    function post_sub($model, $service, $request, $params) {
        if ($this->mv_handler->validateForm("form_sett_post_sub")) {
            $options['form_success_message'] = $request->req['form_success_message'];
            
            $options['form_redirect'] = isset($request->req['form_redirect']) ? $request->req['form_redirect'] : 'none';
            $options['form_redirect_to_page'] = $request->req['form_redirect_to_page'];
            $options['form_redirect_to_url'] = $request->req['form_redirect_to_url'];
            

            if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
                $model->load_from_db($request->req['rm_form_id']);
                $model->set($options);
                if ($model->validate_post_sub('form_sett_post_sub')) {
                    $model->update_into_db();
                RM_Utilities::redirect('?page=rm_form_sett_manage&rm_form_id='.$request->req['rm_form_id']);
                    return;
                } else
                    $visited = true;
            } else {
                echo '<div class="rmnotice">' . RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED') . '</div>';
                return;
            }
        }
        if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
            $data = new stdClass();
            $view = $this->mv_handler->setView('form_post_sub_sett');
            if (!isset($visited))
                $model->load_from_db($request->req['rm_form_id']);
            $data->model = $model;
            $data->wp_pages = RM_Utilities::wp_pages_dropdown();
        }else {
            $view = $this->mv_handler->setView('show_notice');
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
        }
        $view->render($data);
    }

    function autoresponder($model, $service, $request, $params) {

        if ($this->mv_handler->validateForm("form_sett_autoresponder")) {

            $options['form_should_send_email'] = isset($request->req['form_should_send_email']) ? $request->req['form_should_send_email'] : null;
            $options['form_email_subject'] = $request->req['form_email_subject'];
            $options['form_email_content'] = $request->req['form_email_content'];

            if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
                $model->load_from_db($request->req['rm_form_id']);
                $model->set($options);
                if ($model->validate_autoresponder('form_sett_autoresponder')) {
                    $model->update_into_db();
                RM_Utilities::redirect('?page=rm_form_sett_manage&rm_form_id='.$request->req['rm_form_id']);
                    return;
                } else {
                    $visited = true;
                }
            } else {
                echo '<div class="rmnotice">' . RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED') . '</div>';
                return;
            }
        }

        if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
            if (!isset($visited))
                $model->load_from_db($request->req['rm_form_id']);
            $data = new stdClass();
            $data->model = $model;
            $view = $this->mv_handler->setView('form_autoresponder_sett');
        }else {
            $view = $this->mv_handler->setView('show_notice');
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
        }
        $view->render($data);
    }

    function accounts($model, $service, $request, $params) {

        if ($this->mv_handler->validateForm("form_sett_accounts")) {

            $options['form_type'] = isset($request->req['form_type']) ? RM_REG_FORM : RM_CONTACT_FORM;
            $options['default_form_user_role'] = 'subscriber';
            $options['form_user_role'] = isset($request->req['form_user_role']) ? $request->req['form_user_role'] : array();
            $options['form_should_user_pick'] = isset($request->req['form_should_user_pick']) ? $request->req['form_should_user_pick'] : null;
            $options['form_user_field_label'] = '';
            $options['auto_login'] = isset($request->req['auto_login']) ? 1 : null;
            
            if (isset($request->req['rm_form_id'])  && (int)$request->req['rm_form_id']) {
                $model->load_from_db($request->req['rm_form_id']);
                $model->set($options);
                if ($model->validate_accounts('form_sett_accounts')) {
                    $model->update_into_db();
                RM_Utilities::redirect('?page=rm_form_sett_manage&rm_form_id='.$request->req['rm_form_id']);
                    return;
                } else
                    $visited = true;
            } else {
                echo '<div class="rmnotice">' . RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED') . '</div>';
                return;
            }
        }

        if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
            $data = new stdClass();
            $data->roles = RM_Utilities::user_role_dropdown(true);
            if (!isset($visited))
                $model->load_from_db($request->req['rm_form_id']);
            $data->model = $model;
            $view = $this->mv_handler->setView('form_accounts_sett');
        }else {
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
            $view = $this->mv_handler->setView('show_notice');
        }
        $view->render($data);
    }

    function view($model, $service, $request, $params) {
        if (!$request instanceof RM_Request) {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            if(isset($request->form_id) && (int)$request->form_id){
                $model = new RM_Forms;
                $model->load_from_db($request->form_id);
                $model->set((array)$request);
                $model->update_into_db();
                echo 'saved';
            }else
                echo 'not saved';
            die;
        }
        if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
            $data = new stdClass();
            $view = $this->mv_handler->setView('form_view_sett');
            $model->load_from_db($request->req['rm_form_id']);
            $data->model = $model;
        } else {
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
            $view = $this->mv_handler->setView('show_notice');
        }
        $view->render($data);
    }

    function mailchimp($model, $service, $request, $params) {
        if ($this->mv_handler->validateForm("form_sett_mailchimp")) {
            $options = array();
            $options['mailchimp_list'] = $request->req['mailchimp_list'];
            $options['mailchimp_mapped_email'] = isset($request->req['email'])?$request->req['email']:null;
            $options['mailchimp_relations'] = $service->get_mailchimp_mapping($request->req);
            $options['form_is_opt_in_checkbox'] = isset($request->req['form_is_opt_in_checkbox']) ? $request->req['form_is_opt_in_checkbox'] : null;
            $options['form_opt_in_text'] = $request->req['form_opt_in_text'];
            if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
                $model->load_from_db($request->req['rm_form_id']);
                $model->set($options);
                $model->update_into_db();
                RM_Utilities::redirect('?page=rm_form_sett_manage&rm_form_id='.$request->req['rm_form_id']);
                return;
            } else {
                echo '<div class="rmnotice">' . RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED') . '</div>';
                return;
            }
        }

        if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
            $data = new stdClass();
            $data->form_id = $request->req['rm_form_id'];
            $model->load_from_db($request->req['rm_form_id']);
            $data->mc_form_list = $model->form_options->mailchimp_list;
            
            if($data->mc_form_list)
                $data->mc_fields = $service->mc_field_mapping($data->form_id, $model->form_options);
            else
                $data->mc_fields = null;
            $data->model = $model;
            $mclist = $service->get_list();
            $data->mailchimp_list[''] = RM_UI_Strings::get('SELECT_LIST');
            if($mclist && isset($mclist['lists']))
            {
                foreach ($mclist['lists'] as $mcl) {
                    $data->mailchimp_list[$mcl['id']] = $mcl['name'];
                }
            }
            $view = $this->mv_handler->setView('form_mc_sett');
        }else{
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
            $view = $this->mv_handler->setView('show_notice');
        }


        $view->render($data);
    }
    
    function access_control($model, $service, $request, $params) {
        if (isset($request->req['rm_form_id'])) {
            $model->load_from_db($request->req['rm_form_id']);
            $data = new stdClass();
            $data->model = $model;
            $data->form_id = $request->req['rm_form_id'];
            $data->all_roles = RM_Utilities::user_role_dropdown();
            $view = $this->mv_handler->setView('form_access_control_sett');
        } else {
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
           // $view = $this->mv_handler->setView('show_notice');
        }
        $view->render($data);
    }

 function ccontact($model, $service, $request, $params) {
     if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
          
            $model->load_from_db($request->req['rm_form_id']);
            $data = new stdClass();
            $data->form_name = $model->form_name;
            $data->form_id = $request->req['rm_form_id'];
            $view = $this->mv_handler->setView('form_sett_constant_contact');
        }else{
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
            $view = $this->mv_handler->setView('show_notice');
        }


        $view->render($data);
    }
    function aweber($model, $service, $request, $params) {
       
     if (isset($request->req['rm_form_id']) && (int)$request->req['rm_form_id']) {
          
          $model->load_from_db($request->req['rm_form_id']);
            $data = new stdClass();
            $data->form_name = $model->form_name;
            $data->form_id = $request->req['rm_form_id'];
            $view = $this->mv_handler->setView('form_sett_aw');
        }else{
            $data = RM_UI_Strings::get('MSG_FS_NOT_AUTHORIZED');
            $view = $this->mv_handler->setView('show_notice');
        }


        $view->render($data);
    }
}
