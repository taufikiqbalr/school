<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswa_nilais
 *
 * @author L745
 */
class siswa_nilais extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('siswa_nilai_model');
        $this->load->model('guru_kelas_matpel_model');
        $this->load->model('siswa_model');
        // used in script to determine menu
        $this->load->vars('menu', 'siswa_nilais');
    }
    
    // for index view
    public function index() {
    	$siswa_nilais = $this->siswa_nilai_model->get_siswa_nilai();
    	$this->output->set_content_type('application/json')
    	->set_output(json_encode($siswa_nilais));
    }
    
    // for show view
    public function show($id) {
    	$siswa_nilai =  $this->siswa_nilai_model->get_siswa_nilai($id);
    	if (empty($siswa_nilai))
    		show_404();
    
    	$this->output->set_content_type('application/json')
    	->set_output(json_encode($siswa_nilai));
    }

}

?>
