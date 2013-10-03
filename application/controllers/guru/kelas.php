<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kelas
 *
 * @author L745
 */
class kelas extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('kelas_model');
        $this->load->model('kelas_bagian_model');
        $this->load->model('jurusan_model');
        // used in script to determine menu
        $this->load->vars('menu', 'kelas');
    }
    
    public function upload() {
        $this->is_privilege('NEW_KELAS');
        $date = new DateTime();
        $file_name = $this->flexi_auth->get_user_id() + "" . +$date->getTimestamp();

        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'xls';
        $config['max_size'] = '5000';
        // change file name
        $config['file_name'] = $file_name;

        // load library
        $this->load->library('upload', $config);
        $this->load->library('excel_reader');

        if (!$this->upload->do_upload("kelas")) {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data kelas gagal di upload, format yg diterima adalah XLS dengan max 5MB</div>');
        } else {
            $file = array('upload_data' => $this->upload->data());
            //Set output Encoding .
            $this->excel_reader->setOutputEncoding('CP1251');
            // load file path
//            $file = $this->load->get_var('doc_path') . '/upload/template absensi.xls';
            // load file
            $this->excel_reader->read($file['upload_data']['full_path']);
            error_reporting(E_ALL ^ E_NOTICE);
            // Sheet 1
            $data = $this->excel_reader->sheets[0];
            // import data to db
            if ($this->kelas_model->import($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data kelas berhasil di-import</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data kelas gagal di-import, ada data yang salah</div>');
            }
            // remove file
            unlink($file['upload_data']['full_path']);
        }
        redirect('kelas');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_KELAS');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->kelas_model->column_names()) ? trim($this->input->get('column', TRUE)) : "tingkat";
        else
            $data['column'] = "tingkat";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('kelas?');
        $config['total_rows'] = $this->kelas_model->get_total($data['cond']);
        $config['per_page'] = '15';
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

        // fetch kelas
        $data['kelas'] = $this->kelas_model->
                fetch_kelas($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Kelas";
        $data['breadc'] = array('menu' => "index_kelas");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        ;

        $this->load_view('kelas', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_KELAS');
        $data['content_title'] = "Lihat Kelas";
        $data['breadc'] = array('menu' => "show_kelas", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['kela'] = $this->kelas_model->get_kelas($id);
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians($id);
        if (empty($data['kela']))
            show_404();
        $this->load_view('kelas', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_KELAS');
        $data['content_title'] = "Buat Kelas";
        $data['breadc'] = array('menu' => "new_kelas");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        
        //for select dropdown
        $data['jurusans'] = $this->jurusan_model->get_jurusan();
        
        // set texted field from create method
        $data['tingkat'] = isset($this->session->userdata('field')['tingkat']) ? $this->session->userdata('field')['tingkat'] : '';
        $data['jurusan_id'] = isset($this->session->userdata('field')['jurusan_id']) ? $this->session->userdata('field')['jurusan_id'] : '';

        $this->load_view('kelas', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_KELAS');
        $data['content_title'] = "Ubah Kelas";
        $data['breadc'] = array('menu' => "edit_kelas", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['kela'] = $this->kelas_model->get_kelas($id);
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians($id);
        //for select dropdown
        $data['jurusans'] = $this->jurusan_model->get_jurusan();
        if (empty($data['kela']))
            show_404();
        // set texted field from create method
        $data['kela']['tingkat'] = isset($this->session->userdata('field')['tingkat']) ? $this->session->userdata('field')['tingkat'] : $data['kela']['tingkat'];
        $data['kela']['jurusan_id'] = isset($this->session->userdata('field')['jurusan_id']) ? $this->session->userdata('field')['jurusan_id'] : $data['kela']['jurusan_id'];
        
        $this->load_view('kelas', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new kelas
    public function create() {
        $this->is_privilege('NEW_KELAS');
        $this->load->library('form_validation');
        
        // Get kelas from input.
        $tingkat = trim($this->input->post('tingkat', TRUE));
        $jurusan_id = $this->input->post('jurusan_id', TRUE) ? trim($this->input->post('jurusan_id', TRUE)) : NULL;

        $validation_rules = array(
            array('field' => 'tingkat', 'label' => 'Tingkat',
                'rules' => 'trim|required|callback_tingkat_check[' . $jurusan_id . ']')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'tingkat' => $tingkat,
                'jurusan_id' => $jurusan_id
            );

            if ($this->kelas_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data kelas berhasil ditambah</div>');
                redirect('kelas');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('tingkat', form_error('tingkat'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'tingkat' => $tingkat, 'jurusan_id' => $jurusan_id
                ));

        redirect('kelas/new');
    }

    // for update kelas
    public function update($id) {
        $this->is_privilege('EDIT_KELAS');
        $this->load->library('form_validation');
        
        // Get kelas from input.
        $tingkat = trim($this->input->post('tingkat', TRUE));
        $jurusan_id = $this->input->post('jurusan_id', TRUE) ? trim($this->input->post('jurusan_id', TRUE)) : NULL;
        $ids = array('jurusan_id' => $jurusan_id, 'id' => $id);

        $validation_rules = array(
            array('field' => 'tingkat', 'label' => 'Tingkat',
                'rules' => 'trim|required|callback_tingkat_check_update['.implode(',',$ids).']')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'tingkat' => $tingkat,
                'jurusan_id' => $jurusan_id
            );

            if ($this->kelas_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data kelas berhasil diubah</div>');
                redirect('kelas/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('tingkat', form_error('tingkat'));
        
        // capture texted field
        $this->session->set_userdata('field', array(
            'tingkat' => $tingkat, 'jurusan_id' => $jurusan_id
                ));
        
        redirect('kelas/' . $id . '/edit');
    }

    // for delete kelas with ID
    public function delete($id) {
        $this->is_privilege('DELETE_KELAS');
        if ($this->kelas_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kelas berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kelas gagal dihapus</div>');
        }
        redirect('kelas');
    }

    // for delete kelas with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_KELAS');
        $affected_row = $this->input->post('ids', TRUE) ? $this->kelas_model->deletes($this->input->post('ids', TRUE)) : 0;
        if($affected_row){
            $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data kelas berhasil dihapus</div>');
        }else{
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kelas gagal dihapus</div>');
        }
        
        redirect('kelas');
    }
    
    // validation for check unique tingkat
    public function tingkat_check($str, $jurusan_id) {
        $query = $this->kelas_model->tingkat_unique($str, $jurusan_id);
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('tingkat_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    // validation for check unique tingkat in update
    public function tingkat_check_update($tingkat, $ids) {
        $ids = explode(',', $ids);
        $query = $this->kelas_model->tingkat_unique($tingkat, $ids[0]);
        if ($query->num_rows() > 0) {
            $kela = $query->row_array();
            if (trim($ids[1]) === trim($kela['id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('tingkat_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    

}

?>
