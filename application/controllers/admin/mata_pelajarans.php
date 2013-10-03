<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mata_pelajarans
 *
 * @author L745
 */
class mata_pelajarans extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mata_pelajaran_model');
        // used in script to determine menu
        $this->load->vars('menu', 'mata_pelajarans');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_MATA_PELAJARAN');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->mata_pelajaran_model->column_names()) ? trim($this->input->get('column', TRUE)) : "kode";
        else
            $data['column'] = "kode";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('matapelajarans?');
        $config['total_rows'] = $this->mata_pelajaran_model->get_total($data['cond']);
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

        // fetch mata_pelajaran
        $data['mata_pelajarans'] = $this->mata_pelajaran_model->
                fetch_mata_pelajarans($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Mata Pelajaran";
        $data['breadc'] = array('menu' => "index_mata_pelajaran");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('mata_pelajarans', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_MATA_PELAJARAN');
        $data['content_title'] = "Lihat Mata Pelajaran";
        $data['breadc'] = array('menu' => "show_mata_pelajaran", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['mata_pelajaran'] = $this->mata_pelajaran_model->get_mata_pelajaran($id);
        if (empty($data['mata_pelajaran']))
            show_404();
        $this->load_view('mata_pelajarans', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_MATA_PELAJARAN');
        $data['content_title'] = "Buat Data Mata Pelajaran";
        $data['breadc'] = array('menu' => "new_mata_pelajaran");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // set texted field from create method
        $data['nama'] = isset($this->session->userdata('field')['nama']) ? 
                $this->session->userdata('field')['nama'] : '';
        $data['kode'] = isset($this->session->userdata('field')['kode']) ? 
                $this->session->userdata('field')['kode'] : '';
        $data['jumlah_jam'] = isset($this->session->userdata('field')['jumlah_jam']) ? 
                $this->session->userdata('field')['jumlah_jam'] : '';
               
        $this->load_view('mata_pelajarans', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_MATA_PELAJARAN');
        $data['content_title'] = "Ubah Data Mata Pelajaran";
        $data['breadc'] = array('menu' => "edit_mata_pelajaran", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['mata_pelajaran'] = $this->mata_pelajaran_model->get_mata_pelajaran($id);
        if (empty($data['mata_pelajaran']))
            show_404();
        
        // set texted field from update method
        $data['mata_pelajaran']['nama'] = isset($this->session->userdata('field')['nama']) ? 
                $this->session->userdata('field')['nama'] : $data['mata_pelajaran']['nama'];
        $data['mata_pelajaran']['kode'] = isset($this->session->userdata('field')['kode']) ? 
                $this->session->userdata('field')['kode'] : $data['mata_pelajaran']['kode'];
        $data['mata_pelajaran']['jumlah_jam'] = isset($this->session->userdata('field')['jumlah_jam']) ?
                $this->session->userdata('field')['jumlah_jam'] : $data['mata_pelajaran']['jumlah_jam'];
        
        $this->load_view('mata_pelajarans', 'edit', $data);
        
        // unset session field data when error from method update
        $this->session->unset_userdata('field');
    }

    // for create new mata_pelajaran
    public function create() {
        $this->is_privilege('NEW_MATA_PELAJARAN');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'),
            array('field' => 'kode', 'label' => 'Kode',
                'rules' => 'trim|required|callback_kode_check'),
            array('field' => 'jumlah_jam', 'label' => 'Jumlah Jam',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get mata_pelajaran from input.
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $kode = strtoupper(trim($this->input->post('kode', TRUE)));
        $jumlah_jam = trim($this->input->post('jumlah_jam', TRUE));

        if ($this->form_validation->run()) {
            $data = array(
                'nama' => $nama, 'kode' => $kode, 'jumlah_jam' => $jumlah_jam
            );

            if ($this->mata_pelajaran_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data mata pelajaran berhasil ditambah</div>');
                redirect('matapelajarans');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nama', form_error('nama'));
        $this->session->set_flashdata('kode', form_error('kode'));
        $this->session->set_flashdata('jumlah_jam', form_error('jumlah_jam'));
        
        // capture texted field
        $this->session->set_userdata('field', array(
            'nama' => $nama, 'kode' => $kode,
            'jumlah_jam' => $jumlah_jam
                ));

        redirect('matapelajarans/new');
    }

    // for update mata_pelajaran
    public function update($id) {
        $this->is_privilege('EDIT_MATA_PELAJARAN');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'),
            array('field' => 'kode', 'label' => 'Kode',
                'rules' => 'trim|required|callback_kode_check_update['.$id.']'),
            array('field' => 'jumlah_jam', 'label' => 'Jumlah Jam',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get mata_pelajaran from input.
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $kode = strtoupper(trim($this->input->post('kode', TRUE)));
        $jumlah_jam = trim($this->input->post('jumlah_jam', TRUE));

        if ($this->form_validation->run()) {
            $data = array(
                'nama' => $nama, 'kode' => $kode, 'jumlah_jam' => $jumlah_jam
            );

            if ($this->mata_pelajaran_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data mata_pelajaran berhasil diubah</div>');
                redirect('mata_pelajarans/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nama', form_error('nama'));
        $this->session->set_flashdata('kode', form_error('kode'));
        $this->session->set_flashdata('jumlah_jam', form_error('jumlah_jam'));
        
        // capture texted field
        $this->session->set_userdata('field', array(
            'nama' => $nama, 'kode' => $kode,
            'jumlah_jam' => $jumlah_jam
                ));
        
        redirect('matapelajarans/' . $id . '/edit');
    }

    // for delete mata_pelajaran with ID
    public function delete($id) {
        $this->is_privilege('DELETE_MATA_PELAJARAN');
        if ($this->mata_pelajaran_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data mata_pelajaran berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data mata_pelajaran gagal dihapus</div>');
        }
        redirect('matapelajarans');
    }

    // for delete mata_pelajaran with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_MATA_PELAJARAN');
        $affected_row = $this->input->post('ids', TRUE) ? $this->mata_pelajaran_model->deletes($this->input->post('ids', TRUE)) : 0;
        if($affected_row){
            $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' Data mata_pelajaran berhasil dihapus</div>');
        }
        else{
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data mata_pelajaran gagal dihapus</div>');
        }
        redirect('matapelajarans');
    }

    // validation for check unique kode
    public function kode_check($str) {
        $query = $this->db->get_where('mata_pelajarans', array('kode' => trim($str)));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('kode_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique kode in update
    public function kode_check_update($str, $id) {
        $query = $this->db->get_where('mata_pelajarans', array('kode' => trim($str)));
        if ($query->num_rows() > 0) {
            $mata_pelajaran = $query->row_array();
            if (trim($id) === trim($mata_pelajaran['id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('kode_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}

?>
