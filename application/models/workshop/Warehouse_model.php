<?php

class Warehouse_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_warehouses($company_id = '0')
    {

        log_message("debug", "*********** fetching get_all_warehouses ***********");

        $select_query =
            "SELECT * FROM `warehouse` JOIN `parameter_description` ON
             warehouse.wh_loc = parameter_description.description_id WHERE warehouse.company_id IN (?,?)
					ORDER BY warehouse.date_created DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found warehouses..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting warehouses.');

            return false;
        }
    }

    public function get_single_warehouse($company_id = '0', $wh_id)
    {
        log_message("debug", "*********** fetching get_single_warehouse ***********");

        if (!empty($wh_id)) {

            $select_query =
                "SELECT * FROM `warehouse` JOIN `parameter_description` ON
                 warehouse.wh_loc = parameter_description.description_id
					WHERE warehouse.wh_id = {$wh_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found warehouse..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting warehouse.');

                return false;
            }
        } else {
            //The wh_id was empty
            return FALSE;
        }
    }

    public function create_warehouse($data)
    {
        log_message("debug", "create_warehouse...data " . json_encode($data));

        if ($this->workshop_db->insert('warehouse', $data)) {

            log_message("debug", "warehouse create query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('warehouse', array('wh_id' => $id));

            log_message("debug", " group created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function warehouse_exists($wh_name, $company_id)
    {

        $this->workshop_db->where('wh_name', $wh_name);

        $this->workshop_db->where('wh_name', $company_id);

        $query = $this->workshop_db->get('warehouse');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_warehouse($data)
    {

        log_message("debug", "Getting ready to update_warehouse... " . json_encode($data));

        if (empty($data['wh_id'])) {

            log_message("debug", " warehouse id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('wh_id', $data['wh_id']);

        if ($this->workshop_db->update('warehouse', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_warehouse " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('warehouse', array('wh_id' => $data['wh_id']));

        log_message("debug", " update_warehouse query " . $this->workshop_db->last_query());

        log_message("debug", " warehouse Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function warehouse_id_exists($wh_id)
    {
        $this->workshop_db->where('wh_id', $wh_id);

        $query = $this->workshop_db->get('warehouse');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

}