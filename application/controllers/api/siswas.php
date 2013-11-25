<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswas
 *
 * @author L745
 */
class siswas extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('siswa_model');
        $this->load->model('siswa_kelas_model');
        // used in script to determine menu
        $this->load->vars('menu', 'siswas');
    }

    // for index view
    public function index() {
    	$siswas = $this->siswa_model->get_siswa();
    	$this->output->set_content_type('application/json')
    	->set_output(json_encode($siswas));
    }

    // for show view
    public function show($id) {
    	$siswa = $this->siswa_model->get_siswa($id);
    	if (empty($siswa))
    		show_404();
    
    	//for entities
    	$data['siswa_kelas'] = $this->siswa_kelas_model->get_kelas($id);
    
    	$this->output->set_content_type('application/json')
    	->set_output(json_encode($siswa));
    }    
    

}

?>
