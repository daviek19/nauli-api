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
} 