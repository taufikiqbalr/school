<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_privileges
 *
 * @author L745
 */
class user_privileges extends MY_application_controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('user_privilege_model');
        $this->load->model('privilege_model');
        $this->load->model('user_model');
        // used in script to determine menu
        $this->load->vars('menu', 'user_privileges');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_HAK_AKSES_USER');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->user_privilege_model->column_names()) ? trim($this->input->get('column', TRUE)) : "username";
        else
            $data['column'] = "username";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('userprivileges?');
        $config['total_rows'] = $this->user_privilege_model->get_total($data['cond']);
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

        // fetch user_privileges
        $data['user_privileges'] = $this->user_privilege_model->
                fetch_user_privileges($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Hak Akses User";
        $data['breadc'] = array('menu' => "index_user_privilege");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        ;

        $this->load_view('user_privileges', 'index', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_HAK_AKSES_USER');
        $data['content_title'] = "Buat Hak Akses User";
        $data['breadc'] = array('menu' => "new_user_privilege");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // for select option
        $data['privileges'] = $this->privilege_model->get_privilege();
        $data['users'] = $this->user_model->get_user();

        // set texted field from create method
        $data['upriv_users_uacc_fk'] = isset($this->session->userdata('field')['upriv_users_uacc_fk']) ? 
                $this->session->userdata('field')['upriv_users_uacc_fk'] : '';
        $data['upriv_users_upriv_fk'] = isset($this->session->userdata('field')['upriv_users_upriv_fk']) ?
                $this->session->userdata('field')['upriv_users_upriv_fk'] : '';

        $this->load_view('user_privileges', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_HAK_AKSES_USER');
        $data['content_title'] = "Lihat Hak Akses User";
        $data['breadc'] = array('menu' => "show_user_privilege", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['user_privilege'] = $this->user_privilege_model->get_user_privilege($id);
        if (empty($data['user_privilege']))
            show_404();
        $this->load_view('user_privileges', 'show', $data);
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_HAK_AKSES_USER');
        $data['content_title'] = "Ubah Hak Akses User";
        $data['breadc'] = array('menu' => "edit_user_privilege", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['user_privilege'] = $this->user_privilege_model->get_user_privilege($id);
        
        // for select option
        $data['privileges'] = $this->privilege_model->get_privilege();
        $data['users'] = $this->user_model->get_user();
        
        if (empty($data['user_privilege']))
            show_404();
        // set texted field from create method
        $data['user_privilege']['upriv_users_uacc_fk'] = isset($this->session->userdata('field')['upriv_users_uacc_fk']) ? 
                $this->session->userdata('field')['upriv_users_uacc_fk'] : $data['user_privilege']['upriv_users_uacc_fk'];
        $data['user_privilege']['upriv_users_upriv_fk'] = isset($this->session->userdata('field')['upriv_users_upriv_fk']) ? 
                $this->session->userdata('field')['upriv_users_upriv_fk'] : $data['user_privilege']['upriv_users_upriv_fk'];
        
        $this->load_view('user_privileges', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new group privilege
    public function create() {
        $this->is_privilege('NEW_HAK_AKSES_USER');
        $this->load->library('form_validation');

        // Get group privilege data from input.
        $upriv_users_uacc_fk = $this->input->post('upriv_users_uacc_fk');
        $upriv_users_upriv_fk = $this->input->post('upriv_users_upriv_fk');

        $validation_rules = array(
            array('field' => 'upriv_users_uacc_fk', 'label' => 'Nama User', 'rules' => 'trim|required|integer|callback_user_check[' . $upriv_users_upriv_fk . ']'),
            array('field' => 'upriv_users_upriv_fk', 'label' => 'Nama Hak Akses', 'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            if ($this->user_privilege_model->insert($upriv_users_uacc_fk, $upriv_users_upriv_fk)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data hak akses user berhasil ditambah</div>');
                redirect('userprivileges');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('upriv_users_uacc_fk', form_error('upriv_users_uacc_fk'));
        $this->session->set_flashdata('upriv_users_upriv_fk', form_error('upriv_users_upriv_fk'));

        // capture texted field
        $this->session->set_userdata('field', array('upriv_users_uacc_fk' => $upriv_users_uacc_fk,'upriv_users_upriv_fk' => $upriv_users_upriv_fk));

        redirect('userprivileges/new');
    }

    // for update group privilege
    public function update($id) {
        $this->is_privilege('EDIT_HAK_AKSES_USER');
        $this->load->library('form_validation');
        
        // Get group privilege data from input.
        $upriv_users_uacc_fk = $this->input->post('upriv_users_uacc_fk');
        $upriv_users_upriv_fk = $this->input->post('upriv_users_upriv_fk');
        $ids = array('upriv_users_upriv_fk' => $upriv_users_upriv_fk, 'id' => $id);

        $validation_rules = array(
            array('field' => 'upriv_users_uacc_fk', 'label' => 'Nama User', 
                'rules' => 'trim|required|integer|callback_user_check_update['.implode(',',$ids).']'),
            array('field' => 'upriv_users_upriv_fk', 'label' => 'Nama Hak Akses', 
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'upriv_users_uacc_fk' => $upriv_users_uacc_fk,
                'upriv_users_upriv_fk' => $upriv_users_upriv_fk
            );

            if ($this->user_privilege_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data hak akses user berhasil diubah</div>');
                redirect('userprivileges/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('upriv_users_uacc_fk', form_error('upriv_users_uacc_fk'));
        $this->session->set_flashdata('upriv_users_upriv_fk', form_error('upriv_users_upriv_fk'));
        // capture texted field
        $this->session->set_userdata('field', array(
            'upriv_users_uacc_fk' => $upriv_users_uacc_fk,'upriv_users_upriv_fk' => $upriv_users_upriv_fk));
        redirect('userprivileges/' . $id . '/edit');
    }

    // for delete kelas with ID
    public function delete($id) {
        $this->is_privilege('DELETE_HAK_AKSES_USER');
        if ($this->user_privilege_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data hak akses user berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert"><a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data hak akses user gagal dihapus</div>');
        }
        redirect('userprivileges');
    }

    // for delete kelas with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_HAK_AKSES_USER');
        $affected_row = $this->input->post('ids', TRUE) ? $this->user_privilege_model->deletes($this->input->post('ids', TRUE)) : 0;
        $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data hak akses user berhasil dihapus</div>');
        redirect('userprivileges');
    }

    // validation for check unique user selection
    public function user_check($uacc_id, $upriv_id) {
        $query = $this->user_privilege_model->user_priv_unique($uacc_id, $upriv_id);
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('user_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique user selection in update
    public function user_check_update($uacc_id, $ids) {
        $ids = explode(',', $ids);
        $query = $this->user_privilege_model->user_priv_unique($uacc_id, $ids[0]);
        if ($query->num_rows() > 0) {
            $user_privilege = $query->row_array();
            if (trim($ids[1]) === trim($user_privilege['upriv_users_id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('user_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }
}

?>
