<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of application_controller
 *
 * @author L745
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_application_controller extends MY_load_controller {

    function __construct() {
        parent::__construct();

        // check login
        if ($this->flexi_auth->is_logged_in()) {
            $this->load->model('user_model');
            $this->load->model('user_group_model');
            $this->load->model('guru_model');
            $this->load->model('staff_model');
            $this->load->model('siswa_model');
            $this->load->model('privilege_model');
            // set session for user profiles and user privileges
            $user_id = $this->flexi_auth->get_user_id();
            $user_group_id = $this->flexi_auth->get_user_group_id();
            $user_data = array();
            if (empty($user_id))
                redirect('login');
            // check if session already exist or not
            if (!$this->session->userdata('user_data')) {
//                $user = $this->user_model->get_user($user_id);
//                $user_group = $this->user_group_model->get_user_group($user_group_id);
                switch ($user_group_id) {
                    // grup guru
                    case 2:
                        $user_data = $this->guru_model->get_user_id($user_id);
                        break;
                    // grup staff
                    case 3:
                        $user_data = $this->staff_model->get_user_id($user_id);
                        break;
                    // grup admin
                    case 4:
                        $user_data = $this->staff_model->get_user_id($user_id);
                        break;
                    // grup siswa
                    case 5:
                        $user_data = $this->siswa_model->get_user_id($user_id);
                        break;
                }
                $privileges = $this->privilege_model->get_user_privileges($user_id);
                $this->session->set_userdata('user_data', $user_data);
                $this->session->set_userdata('privileges', $privileges);
            }
        } else {
            redirect('login');
        }
    }

    // load the specific view
    public function load_view($p_view, $p_menu, $data) {
        $this->load->view('shared/head', $data);
        $this->load->view('shared/scripts', $data);
        $this->load->view('shared/header', $data);
//        $this->load->view('shared/user_menu', $data);
        $this->load->view('shared/menu', $data);
        $this->load->view('shared/breadcrumb', $data);
        $this->load->view('shared/content_title', $data);
        // load per menu
        if (!empty($p_menu))
            $this->load->view($p_view . '/' . $p_menu, $data);
        else
            $this->load->view($p_view, $data);

        $this->load->view('shared/footer', $data);
    }

    // check if user is privileged
    public function is_privilege($privilege) {
        if (!$this->flexi_auth->is_admin() &&
                !in_array($privilege, $this->session->userdata('privileges')))
            show_404();
    }
    
    public function check_privilege($privilege) {
        if (!$this->flexi_auth->is_admin() &&
                !in_array($privilege, $this->session->userdata('privileges')))
            return FALSE;
        else
            return TRUE;
    }

    // check if user can only edit their own data
    public function is_user($privilege, $user_id) {
        if (!$this->flexi_auth->is_admin() &&
                !in_array($privilege, $this->session->userdata('privileges')) &&
                $this->flexi_auth->get_user_id() != $user_id)
            show_404();
    }
    
    // check if user is guru
    public function is_guru($privilege){
        if (!$this->flexi_auth->is_admin() &&
                !in_array($privilege, $this->session->userdata('privileges')) &&
                $this->flexi_auth->get_user_group_id() != "2")
            show_404();
    }
    
    // check if user is/was guru wali
    public function is_guru_wali($privilege){
        if (!$this->flexi_auth->is_admin() &&
                !in_array($privilege, $this->session->userdata('privileges'))){
            if($this->flexi_auth->get_user_group_id() != "2"){
                $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
                if(count($guru)>0){
                    if($this->guru_model->count_guru_wali($guru['id'])<1)
                        show_404();
                }else
                    show_404();
            }else
                show_404();
        }
    }

    public function get_userdata() {
        return $this->session->userdata('user_data');
    }

}

?>
