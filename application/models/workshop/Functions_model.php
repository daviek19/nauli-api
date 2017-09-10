<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017-09-07
 * Time: 6:18 PM
 */
class Functions_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_serial_no($table_name, $auto_field, $prefix, $padding = 4)
    {
        $select_query = "CALL GenerateSerialNumber('{$table_name}','{$auto_field}','{$prefix}','{$padding}');";
        $query = $this->workshop_db->query($select_query);
        return $query->row()->serial_no;
    }

    public function delete_row($table_name = '', $column_name = '', $data = array())
    {
        $identifier = implode(",", $data);

        log_message("debug", " the identity " . $identifier);


        $delete_query = "DELETE FROM `$table_name` WHERE `$column_name` IN($identifier)";

        $bool_result = $this->workshop_db->query($delete_query);

        log_message("debug", " update_parameter query " . $this->workshop_db->last_query());

        return $bool_result;
    }
} 