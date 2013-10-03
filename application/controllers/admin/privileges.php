<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of privileges
 *
 * @author L745
 */
class privileges extends MY_application_controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('privilege_model');
        // used in script to determine menu
        $this->load->vars('menu', 'privileges');
    }
    
    // for index view
    public function index() {
        $this->is_privilege('INDEX_HAK_AKSES');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->privilege_model->column_names()) ? trim($this->input->get('column', TRUE)) : "upriv_name";
        else
            $data['column'] = "upriv_name";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('privileges?');
        $config['total_rows'] = $this->privilege_model->get_total($data['cond']);
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

        // fetch privileges
        $data['privileges'] = $this->privilege_model->
                fetch_privileges($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Hak Akses";
        $data['breadc'] = array('menu' => "index_privilege");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        ;

        $this->load_view('privileges', 'index', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_HAK_AKSES');
        $data['content_title'] = "Buat Hak Akses";
        $data['breadc'] = array('menu' => "new_privilege");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // set texted field from create method
        $data['priv_name'] = isset($this->session->userdata('field')['priv_name']) ? 
                $this->session->userdata('field')['priv_name'] : '';
        $data['priv_desc'] = isset($this->session->userdata('field')['priv_desc']) ? 
                $this->session->userdata('field')['priv_desc'] : '';

        $this->load_view('privileges', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_HAK_AKSES');
        $data['content_title'] = "Lihat Hak Akses";
        $data['breadc'] = array('menu' => "show_privilege", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['privilege'] = $this->privilege_model->get_privilege($id);
        if (empty($data['privilege'])) show_404();
        $this->load_view('privileges', 'show', $data);
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_HAK_AKSES');
        $data['content_title'] = "Ubah Hak Akses";
        $data['breadc'] = array('menu' => "edit_privilege", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['privilege'] = $this->privilege_model->get_privilege($id);
        if (empty($data['privilege'])) show_404();
        
        // set texted field from update method
        $data['privilege']['priv_name'] = isset($this->session->userdata('field')['priv_name']) ? 
                $this->session->userdata('field')['priv_name'] : $data['privilege']['priv_name'];
        $data['privilege']['priv_desc'] = isset($this->session->userdata('field')['priv_desc']) ? 
                $this->session->userdata('field')['priv_desc'] : $data['privilege']['priv_desc'];
        
        $this->load_view('privileges', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new  privilege
    public function create() {
        $this->is_privilege('NEW_HAK_AKSES');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'priv_name', 'label' => 'Nama Hak Akses',
                'rules' => 'trim|required|callback_priv_name_check')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get  privilege data from input.
        $priv_name = strtoupper(trim($this->input->post('priv_name')));
        $priv_desc = strtoupper(trim($this->input->post('priv_desc')));

        if ($this->form_validation->run()) {
            if ($this->privilege_model->insert($priv_name, $priv_desc)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data hak akses berhasil ditambah</div>');
                redirect('privileges');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors(
                '<div class="alert alert-error"><a class="close" data-dismiss="alert" '.
                'href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('priv_name', form_error('priv_name'));

        // capture texted field
        $this->session->set_data('field', 
                array('priv_name' => $priv_name,
                    'priv_desc' => $priv_desc));

        redirect('privileges/new');
    }

    // for update  privilege
    public function update($id) {
        $this->is_privilege('EDIT_HAK_AKSES');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'priv_name', 'label' => 'Nama Hak Akses',
                'rules' => 'trim|required|callback_priv_name_check_update[' . $id . ']')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get  privilege data from input.
        $priv_name = strtoupper(trim($this->input->post('priv_name')));
        $priv_desc = strtoupper(trim($this->input->post('priv_desc')));

        if ($this->form_validation->run()) {
            $data = array(
                $this->flexi_auth->db_column('user_privileges', 'name') => $priv_name,
                $this->flexi_auth->db_column('user_privileges', 'description') => $priv_desc
            );

            if ($this->privilege_model->update($id, $data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success"><a class="close" '.
                        'data-dismiss="alert" href="#">&times;</a>'.
                        'Data hak akses berhasil diubah</div>');
                redirect('privileges/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('priv_name', form_error('priv_name'));
        
        // capture texted field
        $this->session->set_data('field', 
                array('priv_name' => $priv_name,
                    'priv_desc' => $priv_desc));
        redirect('privileges/' . $id . '/edit');
    }

    // for delete kelas with ID
    public function delete($id) {
        $this->is_privilege('DELETE_HAK_AKSES');
        if ($this->privilege_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data hak akses berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data hak akses gagal dihapus</div>');
        }
        redirect('privileges');
    }

    // for delete kelas with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_HAK_AKSES');
        $affected_row = $this->input->post('ids', TRUE) ? $this->privilege_model->deletes($this->input->post('ids', TRUE)) : 0;
        $this->session->set_flashdata('message', 
                '<div class="alert alert-info"><a class="close" '.
                'data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data hak akses berhasil dihapus</div>');
        redirect('privileges');
    }

    // validation for check unique privilege name
    public function priv_name_check($str) {
        $query = $this->db->get_where('user_privileges', array('upriv_name' => trim($str)));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('priv_name_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique priv_name in update
    public function priv_name_check_update($str, $id) {
        $query = $this->db->get_where('user_privileges', array('upriv_name' => trim($str)));
        if ($query->num_rows() > 0) {
            $upriv = $query->row_array();
            if (trim($id) === trim($upriv['upriv_id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('priv_name_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }
    
    
}

?>
