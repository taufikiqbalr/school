<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        
        // used in script to determine menu
        $this->load->vars('menu', 'welcome');
    }
    
    public function index() {
        $data['content_title'] = "Halaman Utama";
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        
        $data['user'] = $this->get_userdata();
        
        $this->load_view('home', '', $data);
    }

    public function home() {
        $this->load->view('welcome_message');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */