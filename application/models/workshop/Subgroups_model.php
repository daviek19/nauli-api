<?php

class Subgroups_model extends CI_Model
{
	private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }
	
	 public function get_all_subgroups($company_id = '0')
    {

        log_message("debug", "*********** fetching get_all_subgroups ***********");

        $select_query = "SELECT * FROM `sub_groups` JOIN `group_master` on sub_groups.group_id = group_master.group_id 
						 WHERE sub_groups.company_id IN (?,?)
						 ORDER BY sub_groups.group_id, sub_groups.date_created DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found subgroups..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting subgroups.');

            return false;
        }
    }

	  public function get_single_subgroup($company_id = '0', $subgroup_id)
    {
        log_message("debug", "*********** fetching get_single_subgroup ***********");

        if (!empty($subgroup_id)) {

            $select_query = 
						"SELECT * FROM `sub_groups` JOIN `group_master` on sub_groups.group_id = group_master.group_id 
						 WHERE sub_groups.subgroup_id = {$subgroup_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found subgroup..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting subgroup.');

                return FALSE;
            }
        } else {
            //The department_id was empty
            return FALSE;
        }
    }
	
	
		public function create_subgroup($data)
		{
			log_message("debug", "create_subgroup...data " . json_encode($data));

			if ($this->workshop_db->insert('sub_groups', $data)) {

				log_message("debug", "sub_group create query " . $this->workshop_db->last_query());

				$id = $this->workshop_db->insert_id();

				$new_record = $this->workshop_db->get_where('sub_groups', array('subgroup_id' => $id));

				log_message("debug", " group created " . json_encode($new_record->row()));

				return $new_record->row();
			} else {
				return FALSE;
			}
		}
		
		public function subgroup_exists($subgroup_name, $company_id,$group_id){
			
	    $this->workshop_db->where('subgroup_name', $subgroup_name);

        $this->workshop_db->where('company_id', $company_id);
		
		$this->workshop_db->where('group_id', $group_id);

        $query = $this->workshop_db->get('sub_groups');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
		}
		
 public function update_subgroup($data)
    {

        log_message("debug", "Getting ready to update_subgroup... " . json_encode($data));

        if (empty($data['subgroup_id'])) {

            log_message("debug", " subgroup id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('subgroup_id', $data['subgroup_id']);

        if ($this->workshop_db->update('sub_groups', $data) == FALSE) {

            return FALSE;
        }

        //All went well
        $new_record = $this->workshop_db->get_where('sub_groups', array('subgroup_id' => $data['subgroup_id']));

        log_message("debug", " update_subgroup query " . $this->workshop_db->last_query());

        log_message("debug", " subgroup Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }
   public function subgroup_id_exists($subgroup_id)
    {
        $this->workshop_db->where('subgroup_id', $subgroup_id);

        $query = $this->workshop_db->get('sub_groups');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
     }

}