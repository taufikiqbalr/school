<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswa_nilai_akhirs
 *
 * @author L745
 */
class siswa_nilai_akhirs extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('siswa_nilai_akhir_model');
        $this->load->model('siswa_nilai_model');
        // used in script to determine menu
        $this->load->vars('menu', 'siswa_nilai_akhirs');
    }

    // for index view
    public function index() {
        $this->is_guru('INDEX_NILAI_AKHIR_SISWA');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->siswa_nilai_akhir_model->column_names()) ? trim($this->input->get('column', TRUE)) : "kode";
        else
            $data['column'] = "kode";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('siswanilaiakhirs?');
        $config['total_rows'] = $this->siswa_nilai_akhir_model->get_total($data['cond']);
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

        // fetch siswa_nilai_akhir
        $data['siswa_nilai_akhirs'] = $this->siswa_nilai_akhir_model->
                fetch_siswa_nilai_akhirs($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Nilai Akhir Siswa";
        $data['breadc'] = array('menu' => "index_siswa_nilai_akhir");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('siswa_nilai_akhirs', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_guru('SHOW_NILAI_AKHIR_SISWA');
        $data['content_title'] = "Lihat Nilai Akhir Siswa";
        $data['breadc'] = array('menu' => "show_siswa_nilai_akhir", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['siswa_nilai_akhir'] = $this->siswa_nilai_akhir_model->get_siswa_nilai_akhir($id);
        if (empty($data['siswa_nilai_akhir']))
            show_404();
        $data['siswa_nilais'] = $this->siswa_nilai_model->get_siswa_nilais($data['siswa_nilai_akhir']['siswa_id']);
        $this->load_view('siswa_nilai_akhirs', 'show', $data);
    }

    // for edit view
    public function edit($id) {
        $this->is_guru('EDIT_NILAI_AKHIR_SISWA');
        $data['content_title'] = "Ubah Data Nilai Akhir Siswa";
        $data['breadc'] = array('menu' => "edit_siswa_nilai_akhir", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['siswa_nilai_akhir'] = $this->siswa_nilai_akhir_model->get_siswa_nilai_akhir($id);
        if (empty($data['siswa_nilai_akhir']))
            show_404();

        // set texted field from update method
        $data['siswa_nilai_akhir']['nilai_akhir'] = isset($this->session->userdata('field')['nilai_akhir']) ?
                $this->session->userdata('field')['nilai_akhir'] : $data['siswa_nilai_akhir']['nilai_akhir'];

        $this->load_view('siswa_nilai_akhirs', 'edit', $data);

        // unset session field data when error from method update
        $this->session->unset_userdata('field');
    }

    // for update siswa_nilai_akhir
    public function update($id) {
        $this->is_guru('EDIT_NILAI_AKHIR_SISWA');
        $this->load->library('form_validation');

        // Get siswa_nilai_akhir from input.
        $nilai_akhir = trim($this->input->post('nilai_akhir', TRUE));

        $validation_rules = array(
            array('field' => 'nilai_akhir', 'label' => 'Nilai Akhir',
                'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'nilai_akhir' => $nilai_akhir
            );

            if ($this->siswa_nilai_akhir_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data siswa_nilai_akhir berhasil diubah</div>');
                redirect('siswa_nilai_akhirs/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nilai_akhir', form_error('nilai_akhir'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'nilai_akhir' => $nilai_akhir
        ));

        redirect('siswanilaiakhirs/' . $id . '/edit');
    }

}

?>
