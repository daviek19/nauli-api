<?php

class Items_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_items($company_id = '0')
    {
        $select_query =
            "SELECT `items`.`company_id`,
       `items`.`item_id`,
       `items`.`item_no`,
       `items`.`item_name`,
       `items`.`wh_id`,
       `warehouse`.`wh_name`,
       `items`.`description_id`,
       `group_master`.`group_name`,
       `classification`.`description_name`,
       `items`.`group_id`,
       `items`.`item_unit_id`,
       `parameter_description`.`description_name` AS unit_name,
       `items`.`cost`,
       `items`.`reorder_qty`,
       `items`.`min_qty`,
       `items`.`active`,
       `items`.`subgroup_id`,
       `sub_groups`.`subgroup_name`,
       `items`.`date_created`
FROM   `workshop`.`items`
       INNER JOIN `workshop`.`warehouse`
               ON ( `items`.`wh_id` = `warehouse`.`wh_id` )
       INNER JOIN `workshop`.`parameter_description` AS `classification`
               ON ( `items`.`description_id` = `classification`.`description_id`
                  )
       INNER JOIN `workshop`.`parameter_description`
               ON ( `items`.`item_unit_id` =
                    `parameter_description`.`description_id` )
       INNER JOIN `workshop`.`group_master`
               ON ( `items`.`group_id` = `group_master`.`group_id` )
       LEFT JOIN `workshop`.`sub_groups`
              ON ( `items`.`subgroup_id` = `sub_groups`.`subgroup_id` )
WHERE  `items`.`company_id` IN (?,?)
ORDER  BY `items`.`date_created` DESC; ";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found warehouses..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting items.');

            return false;
        }
    }

    public function get_single_item($company_id = '0', $item_id)
    {
        if (!empty($item_id)) {

            $select_query =
                "SELECT `items`.`company_id`,
       `items`.`item_id`,
       `items`.`item_no`,
       `items`.`item_name`,
       `items`.`wh_id`,
       `warehouse`.`wh_name`,
       `items`.`description_id`,
       `classification`.`description_name`,
       `items`.`group_id`,
       `group_master`.`group_name`,
       `items`.`item_unit_id`,
       `parameter_description`.`description_name` AS unit_name,
       `items`.`cost`,
       `items`.`reorder_qty`,
       `items`.`min_qty`,
       `items`.`active`,
       `items`.`subgroup_id`,
       `sub_groups`.`subgroup_name`,
       `items`.`date_created`
FROM   `workshop`.`items`
       INNER JOIN `workshop`.`warehouse`
               ON ( `items`.`wh_id` = `warehouse`.`wh_id` )
       INNER JOIN `workshop`.`parameter_description` AS `classification`
               ON ( `items`.`description_id` = `classification`.`description_id`
                  )
       INNER JOIN `workshop`.`parameter_description`
               ON ( `items`.`item_unit_id` =
                    `parameter_description`.`description_id` )
       INNER JOIN `workshop`.`group_master`
               ON ( `items`.`group_id` = `group_master`.`group_id` )
       LEFT JOIN `workshop`.`sub_groups`
              ON ( `items`.`subgroup_id` = `sub_groups`.`subgroup_id` )
WHERE  `items`.`item_id` = {$item_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", "fetch item query..." . $this->db->last_query());

                log_message("debug", "found item..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting item.');

                return false;
            }
        } else {
            return FALSE;
        }
    }

    public function create_item($data)
    {
        if ($this->workshop_db->insert('items', $data)) {

            log_message("debug", "items create query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('items', array('item_id' => $id));

            log_message("debug", " group created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function item_exists($item_name, $company_id)
    {

        $this->workshop_db->where('item_name', $item_name);

        $this->workshop_db->where('company_id', $company_id);

        $query = $this->workshop_db->get('items');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_item($data)
    {

        log_message("debug", "Getting ready to update_item... " . json_encode($data));

        if (empty($data['item_id'])) {

            log_message("debug", " item id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('item_id', $data['item_id']);

        if ($this->workshop_db->update('items', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_item " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('items', array('item_id' => $data['item_id']));

        log_message("debug", " update_item query " . $this->workshop_db->last_query());

        log_message("debug", " item Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function item_id_exists($item_id)
    {
        $this->workshop_db->where('item_id', $item_id);

        $query = $this->workshop_db->get('items');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

}