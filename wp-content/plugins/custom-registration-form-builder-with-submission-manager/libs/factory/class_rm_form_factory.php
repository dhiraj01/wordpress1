<?php

/* 
 * Creates an object of a form after loading from databse.
 */

class RM_Form_Factory
{
    private $form_id;
    private $backend_form;
    private $backend_field;
    private $frontend_form;
    private $service;
    
    public function __construct()
    {
        $this->form_id = null;
        $this->backend_form = null;
        $this->backend_field = null;
        $this->frontend_form = null;
        $this->service = new RM_Front_Form_Service;
    }
    
    public function create_form($form_id)
    {
        //Load form from database
        $this->backend_form = new RM_Forms;
        $this->backend_form->load_from_db($form_id);
        
        //Update form diary
        global $rm_form_diary;
        if(isset($rm_form_diary[$form_id]))
            $rm_form_diary[$form_id]++;
        else
            $rm_form_diary[$form_id] = 1;
        
        
        $primary_field_req_names = array();
        //Load corresponding fields from db
        $fields = array();
        $db_fields = $this->service->get_all_form_fields($form_id);
        if($db_fields)
        {
            foreach($db_fields as $db_field)
            {
                $field_options = maybe_unserialize($db_field->field_options);
                $form_options = $this->backend_form->get_form_options();
                
                if(isset($form_options->style_textfield)){
                    $field_options->style_textfield = $form_options->style_textfield;
                }
                if(isset($form_options->style_label)){
                    $field_options->style_label = $form_options->style_label;
                }
                
                $opts = $this->service->set_properties($field_options);
                $db_field->field_value = maybe_unserialize($db_field->field_value);
                $field_name = $db_field->field_type."_".$db_field->field_id;
               
                $db_field->field_label = $db_field->field_label; 
                
                if(isset($field_options->icon))
                    $x_opts = (object)array('icon' => $field_options->icon);
                else
                    $x_opts = null;
                
                switch($db_field->field_type)
                {
                    case 'Price':
                        $gopts = new RM_Options;
                        $currency_pos = $gopts->get_value_of('currency_symbol_position');
                        $currency_symbol = $gopts->get_currency_symbol();
                        $fields[$field_name] = new RM_Frontend_Field_Price($db_field->field_id, $db_field->field_label, $opts, $db_field->field_value, $currency_pos, $currency_symbol, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    
                    case 'File':
                        $fields[$field_name] = new RM_Frontend_Field_File($db_field->field_id, $db_field->field_label, $opts, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    
                    case 'Select':
                        $fields[$field_name] = new RM_Frontend_Field_Select($db_field->field_id, $db_field->field_label, $opts, $db_field->field_value, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    
                    case 'Multi-Dropdown':
                        break;
                    case 'Phone':
                        break;
                    case 'Mobile':
                        break;
                    case 'Nickname':
                        $fields[$field_name] = new RM_Frontend_Field_Base($db_field->field_id,'Nickname', $db_field->field_label, $opts, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    case 'Image':
                        break;
                    case 'Facebook':
                        
                        break;
                    case 'Website':
                        $opts['Pattern'] = "((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)";
                        //$opts['Title'] =  RM_UI_Strings::get("WEBSITE_ERROR");
                        $fields[$field_name] = new RM_Frontend_Field_Base($db_field->field_id,'Website', $db_field->field_label, $opts, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    case 'Twitter':
                        break;
                    case 'Google':
                        break;
                    case 'Instagram':
                        break;
                    case 'Linked':
                        break;
                    case 'SoundCloud':
                        break;
                    case 'Youtube':
                        break;
                    case 'VKontacte':
                        break;
                    case 'Skype':
                        break;
                    case 'Bdate':
                        break;
                    case 'SecEmail':
                        break;
                    case 'Gender':
                        break;
                    case 'Language':
                        break;
                    case 'Terms':
                        $opts['cb_label'] = isset($field_options->tnc_cb_label)?$field_options->tnc_cb_label:null; 
                    case 'Radio':
                    case 'Checkbox':
                        $classname = "RM_Frontend_Field_".$db_field->field_type;
                        $fields[$field_name] = new $classname($db_field->field_id, $db_field->field_label, $opts, $db_field->field_value, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    case 'Shortcode':
                        $classname = "RM_Frontend_Field_Visible_Only";
                        $db_field->field_value = do_shortcode($db_field->field_value );
                        $fields[$field_name] = new $classname($db_field->field_id,'HTMLCustomized',$field_name, $db_field->field_label, $opts, $db_field->field_value, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    case 'Divider':
                        $classname = "RM_Frontend_Field_Visible_Only";
                        $fields[$field_name] = new $classname($db_field->field_id,'HTMLCustomized',$field_name, $db_field->field_label, $opts,' <hr class="rm_divider" width="100%" size="8" align="center">', $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    case 'Spacing':
                        $classname = "RM_Frontend_Field_Visible_Only";
                        $fields[$field_name] = new $classname($db_field->field_id,'HTMLCustomized',$field_name, $db_field->field_label, $opts,'<div class="rm_spacing"></div>', $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    case 'HTMLH':
                    case 'HTMLP':
                        $classname = "RM_Frontend_Field_Visible_Only";
                        $fields[$field_name] = new $classname($db_field->field_id, $db_field->field_type, $db_field->field_label, $opts, $db_field->field_value, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    case 'Time':
                        break;
                    case 'Rating':
                        break;
                    case 'Email':
                        // in this case pre-populate the primary email field with logged-in user's email.
                        if($db_field->is_field_primary)
                        {
                            $primary_field_req_names['user_email'] =  $db_field->field_type."_".$db_field->field_id;
                            
                            if(is_user_logged_in())
                            {
                                $current_user = wp_get_current_user();                            
                                $opts['value'] = $current_user->user_email;
                            }
                        }
                        $fields[$field_name] = new RM_Frontend_Field_Base($db_field->field_id, $db_field->field_type, $db_field->field_label, $opts, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                    
                    case 'Address':
                    case 'Map':
                        break;
                                        
                    default:
                        $fields[$field_name] = new RM_Frontend_Field_Base($db_field->field_id, $db_field->field_type, $db_field->field_label, $opts, $db_field->page_no, $db_field->is_field_primary, $x_opts);
                        break;
                }                
                
            }            
          }  
            
            switch($this->backend_form->get_form_type())
            {
                case RM_REG_FORM:                    
                    $this->frontend_form = new RM_Frontend_Form_Reg($this->backend_form);
                    $primary_field_req_names['username'] = 'username';
                    $primary_field_req_names['password'] = 'password';
                    $this->frontend_form->set_primary_field_index($primary_field_req_names);
                    break;
                
                //Contact form is default case to keep compatibility with previous code
                default:
                    //$this->frontend_form = new RM_Frontend_Form_Multipage($this->backend_form);                    
                    $this->frontend_form = new RM_Frontend_Form_Contact($this->backend_form);
                    $this->frontend_form->set_primary_field_index($primary_field_req_names);
                    break;
            }              
            
            $this->frontend_form->add_fields_array($fields);      
            $this->frontend_form->set_form_number($rm_form_diary[$form_id]);
        
        //Set up FE form object
        
        //Return  new FE form
        return $this->frontend_form;
    }
}
