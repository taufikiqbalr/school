<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of staffs
 *
 * @author L745
 */
class staffs extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('staff_model');
        $this->load->model('staff_ijazah_model');
        // used in script to determine menu
        $this->load->vars('menu', 'staffs');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_STAFF');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->staff_model->column_names()) ? trim($this->input->get('column', TRUE)) : "nik";
        else
            $data['column'] = "nik";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('staffs?');
        $config['total_rows'] = $this->staff_model->get_total($data['cond']);
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

        // fetch staff
        $data['staffs'] = $this->staff_model->
                fetch_staffs($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Staff";
        $data['breadc'] = array('menu' => "index_staff");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('staffs', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_STAFF');
        $data['content_title'] = "Lihat Staff";
        $data['breadc'] = array('menu' => "show_staff", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['staff'] = $this->staff_model->get_staff($id);
        if (empty($data['staff']))
            show_404();

        //for entities
        $data['staff_ijazahs'] = $this->staff_ijazah_model->get_staff_ijazahs($id);

        $this->load_view('staffs', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_STAFF');
        $data['content_title'] = "Buat Data Staff";
        $data['breadc'] = array('menu' => "new_staff");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // set texted field from create method
        $data['nik'] = isset($this->session->userdata('field')['nik']) ? 
                $this->session->userdata('field')['nik'] : '';
        $data['nama'] = isset($this->session->userdata('field')['nama']) ? 
                $this->session->userdata('field')['nama'] : '';
        $data['email'] = isset($this->session->userdata('field')['email']) ? 
                $this->session->userdata('field')['email'] : '';
        $data['tempat_lahir'] = isset($this->session->userdata('field')['tempat_lahir']) ?
                $this->session->userdata('field')['tempat_lahir'] : '';
        $data['tanggal_lahir'] = isset($this->session->userdata('field')['tanggal_lahir']) ? 
                $this->session->userdata('field')['tanggal_lahir'] : '';
        $data['alamat'] = isset($this->session->userdata('field')['alamat']) ?
                $this->session->userdata('field')['alamat'] : '';
        $data['status'] = isset($this->session->userdata('field')['status']) ?
                $this->session->userdata('field')['status'] : '';
        $data['no_telepon'] = isset($this->session->userdata('field')['no_telepon']) ?
                $this->session->userdata('field')['no_telepon'] : '';
        $data['no_handphone'] = isset($this->session->userdata('field')['no_handphone']) ?
                $this->session->userdata('field')['no_handphone'] : '';
        $data['jenis_kelamin'] = isset($this->session->userdata('field')['jenis_kelamin']) ?
                $this->session->userdata('field')['jenis_kelamin'] : '';
        $data['agama'] = isset($this->session->userdata('field')['agama']) ?
                $this->session->userdata('field')['agama'] : '';

        $this->load_view('staffs', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_STAFF');
        $data['content_title'] = "Ubah Data Staff";
        $data['breadc'] = array('menu' => "edit_staff", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['staff'] = $this->staff_model->get_staff($id);
        if (empty($data['staff']))
            show_404();

        //for entities
        $data['staff_ijazahs'] = $this->staff_ijazah_model->get_staff_ijazahs($id);

        // set texted field from create method
        $data['staff']['nik'] = isset($this->session->userdata('field')['nik']) ? 
                $this->session->userdata('field')['nik'] : $data['staff']['nik'];
        $data['staff']['nama'] = isset($this->session->userdata('field')['nama']) ? 
                $this->session->userdata('field')['nama'] : $data['staff']['nama'];
        $data['staff']['email'] = isset($this->session->userdata('field')['email']) ? 
                $this->session->userdata('field')['email'] : $data['staff']['email'];
        $data['staff']['tempat_lahir'] = isset($this->session->userdata('field')['tempat_lahir']) ?
                $this->session->userdata('field')['tempat_lahir'] : $data['staff']['tempat_lahir'];
        $data['staff']['tanggal_lahir'] = isset($this->session->userdata('field')['tanggal_lahir']) ?
                $this->session->userdata('field')['tanggal_lahir'] : $data['staff']['tanggal_lahir'];
        $data['staff']['alamat'] = isset($this->session->userdata('field')['alamat']) ?
                $this->session->userdata('field')['alamat'] : $data['staff']['alamat'];
        $data['staff']['status'] = isset($this->session->userdata('field')['status']) ?
                $this->session->userdata('field')['status'] : $data['staff']['status'];
        $data['staff']['no_telepon'] = isset($this->session->userdata('field')['no_telepon']) ?
                $this->session->userdata('field')['no_telepon'] : $data['staff']['no_telepon'];
        $data['staff']['no_handphone'] = isset($this->session->userdata('field')['no_handphone']) ?
                $this->session->userdata('field')['no_handphone'] : $data['staff']['no_handphone'];
        $data['staff']['jenis_kelamin'] = isset($this->session->userdata('field')['jenis_kelamin']) ?
                $this->session->userdata('field')['jenis_kelamin'] : $data['staff']['jenis_kelamin'];
        $data['staff']['agama'] = isset($this->session->userdata('field')['agama']) ?
                $this->session->userdata('field')['agama'] : $data['staff']['agama'];
        $this->load_view('staffs', 'edit', $data);
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new staff
    public function create() {
        $this->is_privilege('NEW_STAFF');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nik', 'label' => 'NIK',
                'rules' => 'trim|required|callback_nik_check'),
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'),
            array('field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'trim|required'),
            array('field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'trim|required'),
            array('field' => 'email', 'label' => 'E-Mail', 'rules' => 'trim|valid_email'),
            array('field' => 'status', 'label' => 'Status', 'rules' => 'trim|required'),
            array('field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get staff from input.
        $nik = trim($this->input->post('nik', TRUE));
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $email = trim($this->input->post('email', TRUE));
        $tempat_lahir = strtoupper(trim($this->input->post('tempat_lahir', TRUE)));
        $tanggal_lahir = trim($this->input->post('tanggal_lahir', TRUE));
        $alamat = strtoupper(trim($this->input->post('alamat', TRUE)));
        $status = strtoupper(trim($this->input->post('status', TRUE)));
        $no_telepon = trim($this->input->post('no_telepon', TRUE));
        $no_handphone = trim($this->input->post('no_handphone', TRUE));
        $jenis_kelamin = trim($this->input->post('jenis_kelamin', TRUE));
        $agama = strtoupper(trim($this->input->post('agama', TRUE)));

        if ($this->form_validation->run()) {
            $data = array(
                'nik' => $nik,
                'nama' => $nama,
                'email' => $email,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'status' => $status,
                'no_telepon' => $no_telepon,
                'no_handphone' => $no_handphone,
                'agama' => $agama,
                'jenis_kelamin' => $jenis_kelamin
            );

            if ($this->staff_model->create($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data staff berhasil ditambah</div>');
                redirect('staffs');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nik', form_error('nik'));
        $this->session->set_flashdata('nama', form_error('nama'));
        $this->session->set_flashdata('email', form_error('email'));
        $this->session->set_flashdata('tanggal_lahir', form_error('tanggal_lahir'));
        $this->session->set_flashdata('tempat_lahir', form_error('tempat_lahir'));
        $this->session->set_flashdata('status', form_error('status'));
        $this->session->set_flashdata('jenis_kelamin', form_error('jenis_kelamin'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'nik' => $nik, 'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat, 'nama' => $nama, 'email' => $email,
            '$tempat_lahir' => $tempat_lahir, 'status' => $status,
            'no_telepon' => $no_telepon, 'no_handphone' => $no_handphone,
            'jenis_kelamin' => $jenis_kelamin, 'agama' => $agama
        ));

        redirect('staffs/new');
    }

    // for update staff
    public function update($id) {
        $this->is_privilege('EDIT_STAFF');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nik', 'label' => 'NIK',
                'rules' => 'trim|required|callback_nik_check_update[' . $id . ']'),
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'),
            array('field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'trim|required'),
            array('field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'trim|required'),
            array('field' => 'email', 'label' => 'E-Mail', 'rules' => 'trim|valid_email'),
            array('field' => 'status', 'label' => 'Status', 'rules' => 'trim|required'),
            array('field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get staff from input.
        $nik = trim($this->input->post('nik', TRUE));
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $email = trim($this->input->post('email', TRUE));
        $tempat_lahir = strtoupper(trim($this->input->post('tempat_lahir', TRUE)));
        $tanggal_lahir = trim($this->input->post('tanggal_lahir', TRUE));
        $alamat = strtoupper(trim($this->input->post('alamat', TRUE)));
        $status = strtoupper(trim($this->input->post('status', TRUE)));
        $no_telepon = trim($this->input->post('no_telepon', TRUE));
        $no_handphone = trim($this->input->post('no_handphone', TRUE));
        $jenis_kelamin = trim($this->input->post('jenis_kelamin', TRUE));
        $agama = strtoupper(trim($this->input->post('agama', TRUE)));

        if ($this->form_validation->run()) {
            $data = array(
                'nik' => $nik,
                'nama' => $nama,
                'email' => $email,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'status' => $status,
                'no_telepon' => $no_telepon,
                'no_handphone' => $no_handphone,
                'agama' => $agama,
                'jenis_kelamin' => $jenis_kelamin
            );

            if ($this->staff_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data staff berhasil diubah</div>');
                redirect('staffs/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nik', form_error('nik'));
        $this->session->set_flashdata('nama', form_error('nama'));
        $this->session->set_flashdata('email', form_error('email'));
        $this->session->set_flashdata('tanggal_lahir', form_error('tanggal_lahir'));
        $this->session->set_flashdata('tempat_lahir', form_error('tempat_lahir'));
        $this->session->set_flashdata('status', form_error('status'));
        $this->session->set_flashdata('jenis_kelamin', form_error('jenis_kelamin'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'nik' => $nik, 'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat, 'nama' => $nama, 'email' => $email,
            '$tempat_lahir' => $tempat_lahir, 'status' => $status,
            'no_telepon' => $no_telepon, 'no_handphone' => $no_handphone,
            'jenis_kelamin' => $jenis_kelamin, 'agama' => $agama
        ));

        redirect('staffs/' . $id . '/edit');
    }

    // for delete staff with ID
    public function delete($id) {
        $this->is_privilege('DELETE_STAFF');
        if ($this->staff_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data staff berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data staff gagal dihapus</div>');
        }
        redirect('staffs');
    }

    // for delete staff with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_STAFF');
        $affected_row = $this->input->post('ids', TRUE) ? $this->staff_model->deletes($this->input->post('ids', TRUE)) : 0;
        if ($affected_row) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                    ' data staff berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data staff gagal dihapus</div>');
        }

        redirect('staffs');
    }

    // validation for check unique nik
    public function nik_check($str) {
        $query = $this->db->get_where('staffs', array('nik' => trim($str)));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('nik_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique nik in update
    public function nik_check_update($str, $id) {
        $query = $this->db->get_where('staffs', array('nik' => trim($str)));
        if ($query->num_rows() > 0) {
            $staff = $query->row_array();
            if (trim($id) === trim($staff['id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('nik_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}

?>
