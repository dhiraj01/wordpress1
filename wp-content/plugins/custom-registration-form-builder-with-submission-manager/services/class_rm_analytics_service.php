<?php

/**
 *
 *
 * @author CMSHelplive
 */
class RM_Analytics_Service extends RM_Services
{

  public function get_all($model_identifier = null, $offset = 0, $limit = 15, $column = '*', $sort_by = '', $descending = false)
  {
  	return parent::get_all($model_identifier, $offset, $limit, $column, $sort_by, $descending);
  }

  public function get_form_stats($form_id, $offset=0, $limit=99999)
  {
  	return RM_DBManager::get('STATS', array('form_id' => $form_id), array('%d'), 'results', $offset, $limit, '*', 'visited_on', true);
  }

  public function get_average_filling_time($form_id)
  {
    $avg = RM_DBManager::get_average_value('STATS','time_taken', array('form_id' => $form_id));

    //Round up to 2 digits after decimal point.
    return round($avg,2);
  }

  public function reset($form_id)
  {
    //RM_DBManager::delete_and_reset_table('STATS');
    RM_DBManager::delete_rows('STATS', array('form_id'=>$form_id), array('%d'));
  }

  public function get_field_stats($form_id)
  {
    $fields = RM_DBManager::get_fields_filtered_by_types($form_id, array('Select','Checkbox','Radio','Country'));
    $stat_arr = array();

    if(is_array($fields) || is_object($fields))
    foreach($fields as $field)
    {
      $res = array();
      $tmp_obj = new stdClass;

      $vals = maybe_unserialize($field->field_value);

      $tmp_obj->label = $field->field_label;
      $tmp_obj->total_sub = 0;

      switch ($field->field_type)
      {
         case 'Checkbox':
            
             $temp = RM_DBManager::get('SUBMISSION_FIELDS', array('field_id' => $field->field_id), array('%d'),'col',0, 999999, "value");
             
            if(!$temp)
              break;
            
            foreach($vals as $val)
             {
              $res[$val] = 0;
             }

             $other_option_submission = 0;

             foreach($temp as $single_sub)
             {
                if($single_sub == NULL)
                    continue;
                $single_sub = maybe_unserialize($single_sub);               
                
                foreach ($single_sub as $f_v) 
                {
                  if(isset($res[$f_v]))
                    $res[$f_v]+=1;
                  else
                    $other_option_submission++;              
                }     
                            
             }

             $res['Other'] = $other_option_submission;
             
             //IMPORTANT: Checkbox is a multiple value type submission,
             //hence we can't just add up the submissions of individual option to get the total submissions.
             $tmp_obj->total_sub = RM_DBManager::count('SUBMISSION_FIELDS', array('field_id' => $field->field_id));             
           break;

        case 'Country':
            $temp = RM_DBManager::count_multiple('SUBMISSION_FIELDS', "value", array('field_id' => $field->field_id));
            
            if(!$temp)
              break;

            foreach($temp as $single_sub)
            {
               $res[$single_sub->value] = (int)$single_sub->count;
               $tmp_obj->total_sub += (int)$single_sub->count;
            }
            
            //Compensate for the cases when Country field was not submitted (blank values).
            if(isset($res['']))
            {
              $tmp_obj->total_sub -= $res[''];
              //We dont need this in stat, unset it.
              unset($res['']);
            }

           break;

        case 'Radio':
        case 'Select':
            if($field->field_type == 'Select')
              $vals = explode(',',$field->field_value);

            $temp = RM_DBManager::count_multiple('SUBMISSION_FIELDS', "value", array('field_id' => $field->field_id));
            
            if(!$temp)
              break;

            foreach($temp as $single_sub)
            {
              if(in_array($single_sub->value, $vals))
              {
                 $res[$single_sub->value] = (int)$single_sub->count;
                 $tmp_obj->total_sub += (int)$single_sub->count;
              }
            }
           break;

       } 
       $tmp_obj->sub_stat = $res;
       $stat_arr[] = $tmp_obj;
    }
    return $stat_arr;
  }

  public function get_browser_usage($form_id)
  {
      $browsers['Chrome'] =            (object)array("visits"=>0,"submissions"=>0);
      $browsers['Safari'] =            (object)array("visits"=>0,"submissions"=>0);
      $browsers['Internet Explorer'] = (object)array("visits"=>0,"submissions"=>0);
      $browsers['Opera'] =             (object)array("visits"=>0,"submissions"=>0);
      $browsers['Android'] =           (object)array("visits"=>0,"submissions"=>0);
      $browsers['iPhone'] =            (object)array("visits"=>0,"submissions"=>0);
      $browsers['Firefox'] =           (object)array("visits"=>0,"submissions"=>0);
      $browsers['BlackBerry'] =        (object)array("visits"=>0,"submissions"=>0);
      $browsers['Other'] =             (object)array("visits"=>0,"submissions"=>0);


      $temp = RM_DBManager::count_multiple('STATS', "browser_name", array('form_id' => $form_id), array('browser_name' => 'Chrome,Safari,Opera,Internet Explorer,Firefox,iPhone,Android,BlackBerry'));
      $known_browser_visits = array();
      $total_known_browser_visits = 0;

      foreach ($temp as $stat)
      {
        $known_browser_visits[$stat->browser_name] = (int)$stat->count;
        $browsers[$stat->browser_name]->visits = (int)$stat->count;
        $total_known_browser_visits += $known_browser_visits[$stat->browser_name];
      }
      $browsers['Other']->visits = (int) $total_known_browser_visits;

      $temp = RM_DBManager::count_multiple('STATS', "browser_name", array('form_id' => $form_id, 'submitted_on' => 'not null', 'submitted_on' => '!banned'), array('browser_name' => 'Chrome,Safari,Opera,Internet Explorer,Firefox,iPhone,Android,BlackBerry'));
      $known_browser_submissions = array();
      $total_known_browser_submissions = 0;
//echo "<pre>",var_dump($browsers),"</pre>";

      foreach ($temp as $stat)
      {
        $known_browser_submissions[$stat->browser_name] = (int)$stat->count;
        $browsers[$stat->browser_name]->submissions = (int)$stat->count;
        $total_known_browser_submissions += $known_browser_submissions[$stat->browser_name];
      }
      $browsers['Other']->submissions = (int) $total_known_browser_submissions;
  //    echo "<pre>",var_dump($browsers),"</pre>";

      $usage = new stdClass;

      $usage->browser_submission = $known_browser_submissions;
      $usage->total_known_browser_submission = $total_known_browser_submissions;
      $usage->browser_usage = $known_browser_visits;
      $usage->total_known_browser_usage = $total_known_browser_visits;
      $usage->browsers = $browsers;

      return $usage;
  }


}