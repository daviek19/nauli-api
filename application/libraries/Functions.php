<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Functions
 *
 * @author David
 */
class Functions {

    public function get_serial_no($table_name, $auto_field, $prefix, $padding = 4) {
        $select_query = "CALL GenerateSerialNumber('{$table_name}','{$auto_field}','{$prefix}','{$padding}');";
        $query = $this->workshop_db->query($select_query);
        return $query->row()->serial_no;
    }

}
