<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mata_pelajaran_persentases
 *
 * @author L745
 */
class mata_pelajaran_persentases extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mata_pelajaran_persentase_model');
        // used in script to determine menu
        $this->load->vars('menu', 'mata_pelajaran_persentases');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_PERSEN_MP');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->mata_pelajaran_persentase_model->column_names()) ? trim($this->input->get('column', TRUE)) : "kode";
        else
            $data['column'] = "kode";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('matapelajaranpersentases?');
        $config['total_rows'] = $this->mata_pelajaran_persentase_model->get_total($data['cond']);
        $config['per_page'] = '5';
        $this->pagination->initialize($config);

        // use when pagination use_page_number = true
        if ($this->input->get('per_page', TRUE)) {
            if (intval($this->input->get('per_page', TRUE)) > 0)
                $page = (intval($this->input->get('per_page', TRUE)) - 1) * $this->pagination->per_page;
            else
                $page = 0;
        }
        else
            $page = 0;

//        use when pagination use_page_number = false
//        $page = $this->input->get('per_page', TRUE) ? $this->input->get('per_page', TRUE) : 0;
        // create pagination html
        $data['links'] = $this->pagination->create_links();

        // set custom pagination text
        $data['total_rows'] = $this->pagination->total_rows;
        $data['num_pages'] = (ceil($this->pagination->total_rows / $this->pagination->per_page) > 0) ? ceil($this->pagination->total_rows / $this->pagination->per_page) : 1;
        $data['cur_page'] = ($this->pagination->cur_page > 0) ? $this->pagination->cur_page : 1;

        // fetch mata_pelajaran_persentase
        $data['mata_pelajaran_persentases'] = $this->mata_pelajaran_persentase_model->
                fetch_mata_pelajaran_persentases($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Bobot Nilai Mata Pelajaran";
        $data['breadc'] = array('menu' => "index_mata_pelajaran_persentase");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('mata_pelajaran_persentases', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_PERSEN_MP');
        $data['content_title'] = "Lihat Bobot Nilai Mata Pelajaran";
        $data['breadc'] = array('menu' => "show_mata_pelajaran_persentase", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['mata_pelajaran_persentase'] = $this->mata_pelajaran_persentase_model->get_mata_pelajaran_persentase($id);
        if (empty($data['mata_pelajaran_persentase']))
            show_404();
        $this->load_view('mata_pelajaran_persentases', 'show', $data);
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_PERSEN_MP');
        $data['content_title'] = "Ubah Data Bobot Nilai Mata Pelajaran";
        $data['breadc'] = array('menu' => "edit_mata_pelajaran_persentase", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['mata_pelajaran_persentase'] = $this->mata_pelajaran_persentase_model->get_mata_pelajaran_persentase($id);
        if (empty($data['mata_pelajaran_persentase']))
            show_404();
        
        // set texted field from update method
        $data['mata_pelajaran_persentase']['persentase'] = isset($this->session->userdata('field')['persentase']) ? $this->session->userdata('field')['persentase'] : $data['mata_pelajaran_persentase']['persentase'];
        
        $this->load_view('mata_pelajaran_persentases', 'edit', $data);
        
        // unset session field data when error from method update
        $this->session->unset_userdata('field');
    }

    // for update mata_pelajaran_persentase
    public function update($id) {
        $this->is_privilege('EDIT_PERSEN_MP');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'persentase', 'label' => 'Persentase',
                'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get mata_pelajaran_persentase from input.
        $jenis = strtoupper(trim($this->input->post('jenis', TRUE)));
        $persentase = trim($this->input->post('persentase', TRUE));

        if ($this->form_validation->run()) {
            $data = array(
                'persentase' => $persentase
            );

            if ($this->mata_pelajaran_persentase_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data bobot nilai berhasil diubah</div>');
                redirect('mata_pelajaran_persentases/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('persentase', form_error('persentase'));
        
        // capture texted field
        $this->session->set_userdata('field', array(
            'persentase' => $persentase
                ));
        
        redirect('matapelajaranpersentases/' . $id . '/edit');
    }

}

?>
