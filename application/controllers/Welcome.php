<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        $this->load->helper('url');
        $this->load->view('welcome_message'); //rest_server
    }

    public function test() {
        print "<p>this is the test zone</p>";
        $this->load->model('people_model');

        $result = $this->people_model->get_person(10);
        if (empty($result)) {
            print "empty";
        }

        $this->output->enable_profiler(TRUE);
   
    }

}
