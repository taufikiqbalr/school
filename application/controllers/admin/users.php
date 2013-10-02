<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author L745
 */
class users extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('user_group_model');
        // used in script to determine menu
        $this->load->vars('menu', 'users');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_USER');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->user_model->column_names()) ? trim($this->input->get('column', TRUE)) : "uacc_username";
        else
            $data['column'] = "uacc_username";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('users?');
        $config['total_rows'] = $this->user_model->get_total($data['cond']);
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

        // fetch user
        $data['users'] = $this->user_model->
                fetch_users($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data User";
        $data['breadc'] = array('menu' => "index_user");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('users', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_user('SHOW_USER',$id);
        $data['content_title'] = "Lihat User";
        $data['breadc'] = array('menu' => "show_user", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['user'] = $this->user_model->get_user($id);
        if (empty($data['user']))
            show_404();
        $this->load_view('users', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_USER');
        $data['content_title'] = "Buat Data User";
        $data['breadc'] = array('menu' => "new_user");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // for select view
        $data['user_groups'] = $this->user_group_model->get_user_group();

        // set texted field from create method
        $data['uacc_username'] = isset($this->session->userdata('field')['uacc_username']) ?
                $this->session->userdata('field')['uacc_username'] : '';
        $data['uacc_email'] = isset($this->session->userdata('field')['uacc_email']) ?
                $this->session->userdata('field')['uacc_email'] : '';
        $data['uacc_group_fk'] = isset($this->session->userdata('field')['uacc_group_fk']) ?
                $this->session->userdata('field')['uacc_group_fk'] : '';

        $this->load_view('users', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_user('EDIT_USER',$id);
        $data['content_title'] = "Ubah Data User";
        $data['breadc'] = array('menu' => "edit_user", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['user'] = $this->user_model->get_user($id);
        if (empty($data['user']))
            show_404();

        // for select view
        $data['user_groups'] = $this->user_group_model->get_user_group();

        // set texted field from update method
        $data['user']['uacc_username'] = isset($this->session->userdata('field')['uacc_username']) ?
                $this->session->userdata('field')['uacc_username'] : $data['user']['uacc_username'];
        $data['user']['uacc_email'] = isset($this->session->userdata('field')['uacc_email']) ?
                $this->session->userdata('field')['uacc_email'] : $data['user']['uacc_email'];
        $data['user']['uacc_group_fk'] = isset($this->session->userdata('field')['uacc_group_fk']) ?
                $this->session->userdata('field')['uacc_group_fk'] : $data['user']['uacc_group_fk'];

        $this->load_view('users', 'edit', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new user
    public function create() {
        $this->is_privilege('NEW_USER');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'uacc_username', 'label' => 'Username',
                'rules' => 'trim|required|callback_username_check'),
            array('field' => 'uacc_email', 'label' => 'Email',
                'rules' => 'trim|valid_email'),
            array('field' => 'uacc_group_fk', 'label' => 'Grup User',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get user from input.
        $uacc_username = strtoupper(trim($this->input->post('uacc_username', TRUE)));
        $uacc_email = trim($this->input->post('uacc_email', TRUE));
        $uacc_group_fk = trim($this->input->post('uacc_group_fk', TRUE));

        if ($this->form_validation->run()) {
            $data = array(
                'uacc_username' => $uacc_username,
                'uacc_email' => $uacc_email,
                'uacc_group_fk' => $uacc_group_fk
            );

            if ($this->user_model->create($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data user berhasil ditambah</div>');
                redirect('users');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('uacc_username', form_error('uacc_username'));
        $this->session->set_flashdata('uacc_email', form_error('uacc_email'));
        $this->session->set_flashdata('uacc_group_fk', form_error('uacc_group_fk'));

        // capture texted field
        $this->session->set_userdata('field', array('uacc_username' => $uacc_username));
        $this->session->set_userdata('field', array('uacc_email' => $uacc_email));
        $this->session->set_userdata('field', array('uacc_group_fk' => $uacc_group_fk));

        redirect('users/new');
    }

    // for update user
    public function update($id) {
        $this->is_user('EDIT_USER',$id);
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'uacc_username', 'label' => 'Username',
                'rules' => 'trim|required|callback_username_check_update[' . $id . ']'),
            array('field' => 'uacc_email', 'label' => 'Email',
                'rules' => 'trim|valid_email'),
            array('field' => 'uacc_group_fk', 'label' => 'Grup User',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get user from input.
        $uacc_username = strtoupper(trim($this->input->post('uacc_username', TRUE)));
        $uacc_email = trim($this->input->post('uacc_email', TRUE));
        $uacc_group_fk = trim($this->input->post('uacc_group_fk', TRUE));

        if ($this->form_validation->run()) {
            $data = array(
                'uacc_username' => $uacc_username,
                'uacc_email' => $uacc_email,
                'uacc_group_fk' => $uacc_group_fk
            );

            if ($this->user_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data user berhasil diubah</div>');
                redirect('users/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('uacc_username', form_error('uacc_username'));
        $this->session->set_flashdata('uacc_email', form_error('uacc_email'));
        $this->session->set_flashdata('uacc_group_fk', form_error('uacc_group_fk'));

        // capture texted field
        $this->session->set_userdata('field', array('uacc_username' => $uacc_username));
        $this->session->set_userdata('field', array('uacc_email' => $uacc_email));
        $this->session->set_userdata('field', array('uacc_group_fk' => $uacc_group_fk));

        redirect('users/' . $id . '/edit');
    }
    
    // for edit password view
    public function edit_password($id) {
        $this->is_user('EDIT_USER',$id);
        
        $data['content_title'] = "Ubah Password User";
        $data['breadc'] = array('menu' => "edit_password_user", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['user'] = $this->user_model->get_user($id);
        if (empty($data['user']))
            show_404();
        $this->load_view('users', 'edit_password', $data);
    }

    /**
     * change_password
     * Updates a users password.
     */
    public function update_password($id) {
        $this->is_user('EDIT_USER',$id);

        $this->load->library('form_validation');

        // Set validation rules.
        // The custom rule 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'current_password', 'label' => 'Current Password',
                'rules' => 'required'),
            array('field' => 'new_password', 'label' => 'New Password',
                'rules' => 'required|validate_password|matches[confirm_new_password]'),
            array('field' => 'confirm_new_password', 'label' => 'Confirm Password',
                'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Run the validation.
        if ($this->form_validation->run()) {
            // Get password data from input.
//            $identity = $this->flexi_auth->get_user_identity();
            $user = $this->user_model->get_user($id);
            $identity = $user['uacc_username'];
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');

            // Note: Changing a password will delete all 'Remember me' database sessions for the user, except their current session.
            $response = $this->flexi_auth->change_password($identity, $current_password, $new_password);
            
            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    $this->flexi_auth->get_messages() .
                    '</div>');

            // Redirect user.
            // Note: As an added layer of security, you may wish to email the user that their password has been updated.
            ($response) ? redirect('home') : redirect('users/' . $id . '/editpassword');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
            $this->session->set_flashdata('message', $this->data['message']);
            $this->session->set_flashdata('current_password', form_error('current_password'));
            $this->session->set_flashdata('new_password', form_error('new_password'));
            $this->session->set_flashdata('confirm_new_password', form_error('confirm_new_password'));

            redirect('users/' . $id . '/editpassword');
        }
    }

    // for delete user with ID
    public function delete($id) {
        $this->is_privilege('DELETE_USER');
        if ($this->user_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data user berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data user gagal dihapus</div>');
        }
        redirect('users');
    }

    // for delete user with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_USER');
        $affected_row = $this->input->post('ids', TRUE) ? $this->user_model->deletes($this->input->post('ids', TRUE)) : 0;
        if ($affected_row) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                    ' Data user berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data user gagal dihapus</div>');
        }

        redirect('users');
    }

    // validation for check unique username
    public function username_check($str) {
        $query = $this->db->get_where('user_accounts', array('uacc_username' => trim($str)));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('username_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique username in update
    public function username_check_update($str, $id) {
        $query = $this->db->get_where('user_accounts', array('uacc_username' => trim($str)));
        if ($query->num_rows() > 0) {
            $user = $query->row_array();
            if (trim($id) === trim($user['uacc_id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('username_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}

?>
