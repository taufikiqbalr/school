<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_groups
 *
 * @author L745
 */
class user_groups extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_group_model');
        // used in script to determine menu
        $this->load->vars('menu', 'user_groups');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_GRUP_USER');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->user_group_model->column_names()) ? trim($this->input->get('column', TRUE)) : "ugrp_name";
        else
            $data['column'] = "ugrp_name";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('usergroups?');
        $config['total_rows'] = $this->user_group_model->get_total($data['cond']);
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

        // fetch user_groups
        $data['user_groups'] = $this->user_group_model->
                fetch_user_groups($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Grup User";
        $data['breadc'] = array('menu' => "index_user_group");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        ;

        $this->load_view('user_groups', 'index', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_GRUP_USER');
        $data['content_title'] = "Buat User Group";
        $data['breadc'] = array('menu' => "new_user_group");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // set texted field from create method
        $data['group_name'] = isset($this->session->userdata('field')['group_name']) ?
                $this->session->userdata('field')['group_name'] : '';
        $data['group_desc'] = isset($this->session->userdata('field')['group_desc']) ?
                $this->session->userdata('field')['group_desc'] : '';
        $data['group_admin'] = isset($this->session->userdata('field')['group_admin']) ?
                $this->session->userdata('field')['group_admin'] : '';

        $this->load_view('user_groups', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_GRUP_USER');
        $data['content_title'] = "Lihat Grup User";
        $data['breadc'] = array('menu' => "show_user_group", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['user_group'] = $this->user_group_model->get_user_group($id);
        if (empty($data['user_group'])) show_404();
        $this->load_view('user_groups', 'show', $data);
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_GRUP_USER');
        $data['content_title'] = "Ubah Grup User";
        $data['breadc'] = array('menu' => "edit_user_group", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['user_group'] = $this->user_group_model->get_user_group($id);
        if (empty($data['user_group']))
            show_404();
        
        // set texted field from create method
        $data['user_group']['group_name'] = isset($this->session->userdata('field')['group_name']) ? 
                $this->session->userdata('field')['group_name'] : $data['user_group']['group_name'];
        $data['user_group']['group_desc'] = isset($this->session->userdata('field')['group_desc']) ? 
                $this->session->userdata('field')['group_desc'] : $data['user_group']['group_desc'];
        $data['user_group']['group_admin'] = isset($this->session->userdata('field')['group_admin']) ? 
                $this->session->userdata('field')['group_admin'] : $data['user_group']['group_admin'];
        
        $this->load_view('user_groups', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new user group
    public function create() {
        $this->is_privilege('NEW_GRUP_USER');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'group_name', 'label' => 'Nama Grup',
                'rules' => 'trim|required|callback_group_name_check'),
            array('field' => 'group_admin', 'label' => 'Admin Status', 'rules' => 'integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get user group data from input.
        $group_name = strtoupper(trim($this->input->post('group_name')));
        $group_desc = strtoupper(trim($this->input->post('group_desc')));
        $group_admin = ($this->input->post('group_admin')) ? 1 : 0;

        if ($this->form_validation->run()) {
            if ($this->user_group_model->insert($group_name, $group_desc, $group_admin)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data grup user berhasil ditambah</div>');
                redirect('usergroups');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('group_name', form_error('group_name'));
        $this->session->set_flashdata('group_desc', form_error('group_desc'));

        // capture texted field
        $this->session->set_userdata('field', 
                array('group_name' => $group_name,
                    'group_desc' => $group_desc,
                    'group_admin' => $group_admin));

        redirect('usergroups/new');
    }

    // for update user group
    public function update($id) {
        $this->is_privilege('EDIT_GRUP_USER');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'group_name', 'label' => 'Nama Grup',
                'rules' => 'trim|required|callback_user_group_check_update[' . $id . ']'),
            array('field' => 'group_admin', 'label' => 'Admin Status', 'rules' => 'integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get user group data from input.
        $group_name = strtoupper(trim($this->input->post('group_name')));
        $group_desc = strtoupper(trim($this->input->post('group_desc')));
        $group_admin = ($this->input->post('group_admin')) ? 1 : 0;

        if ($this->form_validation->run()) {
            $data = array(
                $this->flexi_auth->db_column('user_groups', 'name') => $group_name,
                $this->flexi_auth->db_column('user_groups', 'description') => $group_desc,
                $this->flexi_auth->db_column('user_groups', 'admin') => $group_admin
            );

            if ($this->user_group_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data grup user berhasil diubah</div>');
                redirect('usergroups/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('group_name', form_error('group_name'));
        $this->session->set_flashdata('group_desc', form_error('group_desc'));
        
        // capture texted field
        $this->session->set_userdata('field', 
                array('group_name' => $group_name,
                    'group_desc' => $group_desc,
                    'group_admin' => $group_admin));
        
        redirect('usergroups/' . $id . '/edit');
    }

    // for delete kelas with ID
    public function delete($id) {
        $this->is_privilege('DELETE_GRUP_USER');
        if ($this->user_group_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info"><a class="close" '.
                    'data-dismiss="alert" href="#">&times;</a>'.
                    'Data grup user berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data grup user gagal dihapus</div>');
        }
        redirect('usergroups');
    }

    // for delete kelas with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_GRUP_USER');
        $affected_row = $this->input->post('ids', TRUE) ? $this->user_group_model->deletes($this->input->post('ids', TRUE)) : 0;
        if($affected_row){
            $this->session->set_flashdata('message', 
                '<div class="alert alert-info"><a class="close" '.
                'data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data grup user berhasil dihapus</div>');
        }else{
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data grup user gagal dihapus</div>');
        }
        
        redirect('usergroups');
    }

    // validation for check unique group_name
    public function group_name_check($str) {
        $query = $this->db->get_where('user_groups', array('ugrp_name' => trim($str)));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('group_name_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique group_name in update
    public function group_name_check_update($str, $id) {
        $query = $this->db->get_where('user_groups', array('ugrp_name' => trim($str)));
        if ($query->num_rows() > 0) {
            $ugrp = $query->row_array();
            if (trim($id) === trim($ugrp['ugrp_id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('group_name_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}

?>
