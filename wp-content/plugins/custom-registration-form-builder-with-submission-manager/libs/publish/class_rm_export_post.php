<?php

require_once plugin_dir_path(__FILE__) . 'interface_rm_exporter.php';

/**
 * Description of class_rm_export_post
 *
 * @author CMSHelplive
 */
class RM_Export_POST implements RM_Exporter
{

    private $xurl;
    private $data_prepared;

    public function __construct($url)
    {
        $this->xurl = new RM_Xurl($url);
        $this->data_prepared = array();
    }

    public function prepare_data($data_raw)
    {
        foreach ($data_raw as $data_row)
        {
            if (is_array($data_row->value))
            {
                if (isset($data_row->value['rm_field_type']) && $data_row->value['rm_field_type'] == 'File')
                {
                    unset($data_row->value['rm_field_type']);
                    if (count($data_row->value) == 0)
                        $data_row->value = null;
                    else
                    {
                        $file = array();
                        foreach ($data_row->value as $a)
                            $file[] = wp_get_attachment_url($a);

                        $data_row->value = implode(',', $file);
                    }
                } else
                    $data_row->value = implode(',', $data_row->value);
            }
            $this->data_prepared[$data_row->label] = $data_row->value;
        }
    }

    public function send_data()
    {
        return $this->xurl->post($this->data_prepared);
    }

}