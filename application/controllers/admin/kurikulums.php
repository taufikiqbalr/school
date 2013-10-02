<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kurikulums
 *
 * @author L745
 */
class kurikulums extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('kurikulum_model');
        // used in script to determine menu
        $this->load->vars('menu', 'kurikulums');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_KURIKULUM');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->kurikulum_model->column_names()) ? trim($this->input->get('column', TRUE)) : "nama";
        else
            $data['column'] = "nama";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('kurikulums?');
        $config['total_rows'] = $this->kurikulum_model->get_total($data['cond']);
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

        // fetch kurikulum
        $data['kurikulums'] = $this->kurikulum_model->
                fetch_kurikulums($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Kurikulum";
        $data['breadc'] = array('menu' => "index_kurikulum");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('kurikulums', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_KURIKULUM');
        $data['content_title'] = "Lihat Kurikulum";
        $data['breadc'] = array('menu' => "show_kurikulum", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['kurikulum'] = $this->kurikulum_model->get_kurikulum($id);
        if (empty($data['kurikulum']))
            show_404();
        $this->load_view('kurikulums', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_KURIKULUM');
        $data['content_title'] = "Buat Data Kurikulum";
        $data['breadc'] = array('menu' => "new_kurikulum");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // set texted field from create method
        $data['nama'] = isset($this->session->userdata('field')['nama']) ? 
                $this->session->userdata('field')['nama'] : '';
               
        $this->load_view('kurikulums', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_KURIKULUM');
        $data['content_title'] = "Ubah Data Kurikulum";
        $data['breadc'] = array('menu' => "edit_kurikulum", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['kurikulum'] = $this->kurikulum_model->get_kurikulum($id);
        if (empty($data['kurikulum']))
            show_404();
        
        // set texted field from update method
        $data['kurikulum']['nama'] = isset($this->session->userdata('field')['nama']) ? 
                $this->session->userdata('field')['nama'] : $data['kurikulum']['nama'];
        
        $this->load_view('kurikulums', 'edit', $data);
        
        // unset session field data when error from method update
        $this->session->unset_userdata('field');
    }

    // for create new kurikulum
    public function create() {
        $this->is_privilege('NEW_KURIKULUM');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama',
                'rules' => 'trim|required|callback_nama_check')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get kurikulum from input.
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));

        if ($this->form_validation->run()) {
            $data = array(
                'nama' => $nama
            );

            if ($this->kurikulum_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data kurikulum berhasil ditambah</div>');
                redirect('kurikulums');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nama', form_error('nama'));
        
        // capture texted field
        $this->session->set_userdata('field', array('nama' => $nama));

        redirect('kurikulums/new');
    }

    // for update kurikulum
    public function update($id) {
        $this->is_privilege('EDIT_KURIKULUM');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama',
                'rules' => 'trim|required|callback_nama_check_update['.$id.']')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get kurikulum from input.
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));

        if ($this->form_validation->run()) {
            $data = array(
                'nama' => $nama
            );

            if ($this->kurikulum_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data kurikulum berhasil diubah</div>');
                redirect('kurikulums/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nama', form_error('nama'));
        
        // capture texted field
        $this->session->set_userdata('field', array('nama' => $nama));
        
        redirect('kurikulums/' . $id . '/edit');
    }

    // for delete kurikulum with ID
    public function delete($id) {
        $this->is_privilege('DELETE_KURIKULUM');
        if ($this->kurikulum_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kurikulum berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kurikulum gagal dihapus</div>');
        }
        redirect('kurikulums');
    }

    // for delete kurikulum with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_KURIKULUM');
        $affected_row = $this->input->post('ids', TRUE) ? $this->kurikulum_model->deletes($this->input->post('ids', TRUE)) : 0;
        if($affected_row){
            $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' Data kurikulum berhasil dihapus</div>');
        }else{
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kurikulum gagal dihapus</div>');
        }
        
        redirect('kurikulums');
    }

    // validation for check unique tingkat
    public function nama_check($str) {
        $query = $this->db->get_where('kurikulums', array('nama' => trim($str)));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('nama_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique tingkat in update
    public function nama_check_update($str, $id) {
        $query = $this->db->get_where('kurikulums', array('nama' => trim($str)));
        if ($query->num_rows() > 0) {
            $kurikulum = $query->row_array();
            if (trim($id) === trim($kurikulum['id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('nama_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}

?>
