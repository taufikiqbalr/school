<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gurus
 *
 * @author L745
 */
class gurus extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('guru_model');
        $this->load->model('guru_ijazah_model');
        $this->load->model('guru_wali_model');
        $this->load->model('guru_mata_pelajaran_model');
        $this->load->model('guru_kelas_matpel_model');
        // used in script to determine menu
        $this->load->vars('menu', 'gurus');
    }

    // for index view
    public function index() {
        $gurus = $this->guru_model->get_guru();
        $this->output->set_content_type('application/json')
                 ->set_output(json_encode($gurus));
    }

    // for show view
    public function show($id) {
        $guru = $this->guru_model->get_guru($id);
        if (empty($guru))
            show_404();
        
        //for entities
        $data['guru_ijazahs'] = $this->guru_ijazah_model->get_guru_ijazahs($id);
        $data['guru_walis'] = $this->guru_wali_model->get_guru_walis($id);
        $data['guru_mata_pelajarans'] = $this->guru_mata_pelajaran_model->get_guru_mata_pelajarans($id);
        $data['guru_kelas_matpels'] = $this->guru_kelas_matpel_model->get_guru_kelas_matpels($id);
        
        $this->output->set_content_type('application/json')
                 ->set_output(json_encode($guru));
    }

}

?>
