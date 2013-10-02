<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_load_controller
 *
 * @author L745
 */
class MY_load_controller extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->auth = new stdClass;
        $this->load->library('flexi_auth');
        $this->load->library('flexi_auth_lite', FALSE, 'flexi_auth');
        
        // Variables
        $this->load->vars('base_url', base_url());
        $this->load->vars('includes_dir', base_url() . '/includes/');
        $this->load->vars('web_title', 'Sekolah');
        $this->load->vars('doc_path', $_SERVER['DOCUMENT_ROOT'].'/school/');
    }

}

?>
