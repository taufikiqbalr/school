<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gurus
 *
 * @author L745
 */
class gurus extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('guru_model');
        $this->load->model('guru_ijazah_model');
        $this->load->model('guru_wali_model');
        $this->load->model('guru_mata_pelajaran_model');
        $this->load->model('guru_kelas_matpel_model');
        // used in script to determine menu
        $this->load->vars('menu', 'gurus');
    }
    
    public function upload() {
        $this->is_privilege('NEW_GURU');
        $date = new DateTime();
        $file_name = $this->flexi_auth->get_user_id() + "" . +$date->getTimestamp();

        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = '5000';
        // change file name
        $config['file_name'] = $file_name;
        
        // load library
        $this->load->library('upload', $config);
        $this->load->library('excel_reader');

        if (!$this->upload->do_upload("guru")) {
            $this->session->set_flashdata('message', '<div class="alert">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data guru gagal di upload, format yg diterima adalah XLS atau XLSX dengan max 5MB</div>');
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
            if($this->guru_model->import($data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data guru berhasil di-import</div>');
            }else{
                $this->session->set_flashdata('message', '<div class="alert">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data guru gagal di-import, ada data yang salah</div>');
            }
            // remove file
            unlink($file['upload_data']['full_path']);
        }
        redirect('gurus');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_GURU');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->guru_model->column_names()) ? trim($this->input->get('column', TRUE)) : "nip";
        else
            $data['column'] = "nip";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('gurus?');
        $config['total_rows'] = $this->guru_model->get_total($data['cond']);
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

        // fetch guru
        $data['gurus'] = $this->guru_model->
                fetch_gurus($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Guru";
        $data['breadc'] = array('menu' => "index_guru");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('gurus', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_GURU');
        $data['content_title'] = "Lihat Guru";
        $data['breadc'] = array('menu' => "show_guru", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['guru'] = $this->guru_model->get_guru($id);
        if (empty($data['guru']))
            show_404();
        
        //for entities
        $data['guru_ijazahs'] = $this->guru_ijazah_model->get_guru_ijazahs($id);
        $data['guru_walis'] = $this->guru_wali_model->get_guru_walis($id);
        $data['guru_mata_pelajarans'] = $this->guru_mata_pelajaran_model->get_guru_mata_pelajarans($id);
        $data['guru_kelas_matpels'] = $this->guru_kelas_matpel_model->get_guru_kelas_matpels($id);
        
        $this->load_view('gurus', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_GURU');
        $data['content_title'] = "Buat Data Guru";
        $data['breadc'] = array('menu' => "new_guru");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // set texted field from create method
        $data['nip'] = isset($this->session->userdata('field')['nip']) ? $this->session->userdata('field')['nip'] : '';
        $data['nuptk'] = isset($this->session->userdata('field')['nuptk']) ? $this->session->userdata('field')['nuptk'] : '';
        $data['nrg'] = isset($this->session->userdata('field')['nrg']) ? $this->session->userdata('field')['nrg'] : '';
        $data['nsg'] = isset($this->session->userdata('field')['nsg']) ? $this->session->userdata('field')['nsg'] : '';
        $data['nama'] = isset($this->session->userdata('field')['nama']) ? $this->session->userdata('field')['nama'] : '';
        $data['email'] = isset($this->session->userdata('field')['email']) ? $this->session->userdata('field')['email'] : '';
        $data['tempat_lahir'] = isset($this->session->userdata('field')['tempat_lahir']) ? $this->session->userdata('field')['tempat_lahir'] : '';
        $data['tanggal_lahir'] = isset($this->session->userdata('field')['tanggal_lahir']) ? $this->session->userdata('field')['tanggal_lahir'] : '';
        $data['alamat'] = isset($this->session->userdata('field')['alamat']) ? $this->session->userdata('field')['alamat'] : '';
         $data['rt'] = isset($this->session->userdata('field')['rt']) ? $this->session->userdata('field')['rt'] : '';
        $data['rw'] = isset($this->session->userdata('field')['rw']) ? $this->session->userdata('field')['rw'] : '';
        $data['desa'] = isset($this->session->userdata('field')['desa']) ? $this->session->userdata('field')['desa'] : '';
        $data['kec'] = isset($this->session->userdata('field')['kec']) ? $this->session->userdata('field')['kec'] : '';
        $data['kota'] = isset($this->session->userdata('field')['kota']) ? $this->session->userdata('field')['kota'] : '';
        $data['kodepos'] = isset($this->session->userdata('field')['kodepos']) ? $this->session->userdata('field')['kodepos'] : '';
        $data['status'] = isset($this->session->userdata('field')['status']) ? $this->session->userdata('field')['status'] : '';
        $data['tanggal_pengangkatan'] = isset($this->session->userdata('field')['tanggal_pengangkatan']) ? $this->session->userdata('field')['tanggal_pengangkatan'] : '';
        $data['no_telepon'] = isset($this->session->userdata('field')['no_telepon']) ? $this->session->userdata('field')['no_telepon'] : '';
        $data['no_handphone'] = isset($this->session->userdata('field')['no_handphone']) ? $this->session->userdata('field')['no_handphone'] : '';
        $data['jenis_kelamin'] = isset($this->session->userdata('field')['jenis_kelamin']) ? $this->session->userdata('field')['jenis_kelamin'] : '';
        $data['agama'] = isset($this->session->userdata('field')['agama']) ? $this->session->userdata('field')['agama'] : '';
               
        $this->load_view('gurus', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_GURU');
        $data['content_title'] = "Ubah Data Guru";
        $data['breadc'] = array('menu' => "edit_guru", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['guru'] = $this->guru_model->get_guru($id);
        if (empty($data['guru']))
            show_404();
        
        //for entities
        $data['guru_ijazahs'] = $this->guru_ijazah_model->get_guru_ijazahs($id);
        $data['guru_walis'] = $this->guru_wali_model->get_guru_walis($id);
        $data['guru_mata_pelajarans'] = $this->guru_mata_pelajaran_model->get_guru_mata_pelajarans($id);
        $data['guru_kelas_matpels'] = $this->guru_kelas_matpel_model->get_guru_kelas_matpels($id);
        
        // set texted field from create method
        $data['guru']['nip'] = isset($this->session->userdata('field')['nip']) ? $this->session->userdata('field')['nip'] : $data['guru']['nip'];
        $data['guru']['nuptk'] = isset($this->session->userdata('field')['nuptk']) ? $this->session->userdata('field')['nuptk'] : $data['guru']['nuptk'];
        $data['guru']['nrg'] = isset($this->session->userdata('field')['nrg']) ? $this->session->userdata('field')['nrg'] : $data['guru']['nrg'];
        $data['guru']['nsg'] = isset($this->session->userdata('field')['nsg']) ? $this->session->userdata('field')['nsg'] : $data['guru']['nsg'];
        $data['guru']['nama'] = isset($this->session->userdata('field')['nama']) ? $this->session->userdata('field')['nama'] : $data['guru']['nama'];
        $data['guru']['email'] = isset($this->session->userdata('field')['email']) ? $this->session->userdata('field')['email'] : $data['guru']['email'];
        $data['guru']['tempat_lahir'] = isset($this->session->userdata('field')['tempat_lahir']) ? $this->session->userdata('field')['tempat_lahir'] : $data['guru']['tempat_lahir'];
        $data['guru']['tanggal_lahir'] = isset($this->session->userdata('field')['tanggal_lahir']) ? $this->session->userdata('field')['tanggal_lahir'] : $data['guru']['tanggal_lahir'];
        $data['guru']['alamat'] = isset($this->session->userdata('field')['alamat']) ? $this->session->userdata('field')['alamat'] : $data['guru']['alamat'];
        $data['guru']['rt'] = isset($this->session->userdata('field')['rt']) ? $this->session->userdata('field')['rt'] : $data['guru']['rt'];
        $data['guru']['rw'] = isset($this->session->userdata('field')['rw']) ? $this->session->userdata('field')['rw'] : $data['guru']['rw'];
        $data['guru']['desa'] = isset($this->session->userdata('field')['desa']) ? $this->session->userdata('field')['desa'] : $data['guru']['desa'];
        $data['guru']['kec'] = isset($this->session->userdata('field')['kec']) ? $this->session->userdata('field')['kec'] : $data['guru']['kec'];
        $data['guru']['kota'] = isset($this->session->userdata('field')['kota']) ? $this->session->userdata('field')['kota'] : $data['guru']['kota'];
        $data['guru']['kodepos'] = isset($this->session->userdata('field')['kodepos']) ? $this->session->userdata('field')['kodepos'] : $data['guru']['kodepos'];
        $data['guru']['status'] = isset($this->session->userdata('field')['status']) ? $this->session->userdata('field')['status'] : $data['guru']['status'];
        $data['guru']['tanggal_pengangkatan'] = isset($this->session->userdata('field')['tanggal_pengangkatan']) ? $this->session->userdata('field')['tanggal_pengangkatan'] : $data['guru']['tanggal_pengangkatan'];
        $data['guru']['no_telepon'] = isset($this->session->userdata('field')['no_telepon']) ? $this->session->userdata('field')['no_telepon'] : $data['guru']['no_telepon'];
        $data['guru']['no_handphone'] = isset($this->session->userdata('field')['no_handphone']) ? $this->session->userdata('field')['no_handphone'] : $data['guru']['no_handphone'];
        $data['guru']['jenis_kelamin'] = isset($this->session->userdata('field')['jenis_kelamin']) ? $this->session->userdata('field')['jenis_kelamin'] : $data['guru']['jenis_kelamin'];
        $data['guru']['agama'] = isset($this->session->userdata('field')['agama']) ? $this->session->userdata('field')['agama'] : $data['guru']['agama'];
        $this->load_view('gurus', 'edit', $data);
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new guru
    public function create() {
        $this->is_privilege('NEW_GURU');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nip', 'label' => 'NIP',
                'rules' => 'trim|required|callback_nip_check'),
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'),
            array('field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'trim|required'),
            array('field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'trim|required'),
            array('field' => 'email', 'label' => 'E-Mail', 'rules' => 'trim|valid_email'),
            array('field' => 'status', 'label' => 'Status', 'rules' => 'trim|required'),
            array('field' => 'kodepos', 'label' => 'Kode Pos', 'rules' => 'trim|numeric'),
            array('field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get guru from input.
        $nip = trim($this->input->post('nip', TRUE));
        $nuptk = trim($this->input->post('nuptk', TRUE));
        $nrg = trim($this->input->post('nrg', TRUE));
        $nsg = trim($this->input->post('nsg', TRUE));
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $email = trim($this->input->post('email', TRUE));
        $tempat_lahir = strtoupper(trim($this->input->post('tempat_lahir', TRUE)));
        $tanggal_lahir = trim($this->input->post('tanggal_lahir', TRUE));
        $alamat = strtoupper(trim($this->input->post('alamat', TRUE)));
        $rt = trim($this->input->post('rt', TRUE));
        $rw = trim($this->input->post('rw', TRUE));
        $desa = strtoupper(trim($this->input->post('desa', TRUE)));
        $kec = strtoupper(trim($this->input->post('kec', TRUE)));
        $kota = trim($this->input->post('kota', TRUE));
        $kodepos = trim($this->input->post('kodepos', TRUE));
        $status = strtoupper(trim($this->input->post('status', TRUE)));
        $tanggal_pengangkatan = $this->input->post('tanggal_pengangkatan', TRUE) ? trim($this->input->post('tanggal_pengangkatan', TRUE)) : NULL;
        $no_telepon = trim($this->input->post('no_telepon', TRUE));
        $no_handphone = trim($this->input->post('no_handphone', TRUE));
        $jenis_kelamin = trim($this->input->post('jenis_kelamin', TRUE));
        $agama = strtoupper(trim($this->input->post('agama', TRUE)));

        if ($this->form_validation->run()) {
            $data = array(
                'nip' => $nip,
                'nuptk' => $nuptk,
                'nrg' => $nrg,
                'nsg' => $nsg,
                'nama' => $nama,
                'email' => $email,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'rt' => $rt,
                'rw' => $rw,
                'desa' => $desa,
                'kec' => $kec,
                'kota' => $kota,
                'kodepos' => $kodepos,
                'status' => $status,
                'tanggal_pengangkatan' => $tanggal_pengangkatan,
                'no_telepon' => $no_telepon,
                'no_handphone' => $no_handphone,
                'agama' => $agama,
                'jenis_kelamin' => $jenis_kelamin
            );

            if ($this->guru_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data guru berhasil ditambah</div>');
                redirect('gurus');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nip', form_error('nip'));
        $this->session->set_flashdata('nama', form_error('nama'));
        $this->session->set_flashdata('email', form_error('email'));
        $this->session->set_flashdata('tanggal_lahir', form_error('tanggal_lahir'));
        $this->session->set_flashdata('tempat_lahir', form_error('tempat_lahir'));
        $this->session->set_flashdata('status', form_error('status'));
        $this->session->set_flashdata('jenis_kelamin', form_error('jenis_kelamin'));
        $this->session->set_flashdata('kodepos', form_error('kodepos'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'nip' => $nip, 'nuptk' => $nuptk, 'tanggal_lahir' => $tanggal_lahir,
            'nrg' => $nrg, 'nsg' => $nsg, 'alamat' => $alamat,
            'nama' => $nama, 'email' => $email, 'status' => $status,
            '$tempat_lahir' => $tempat_lahir, 'tanggal_pengangkatan' => $tanggal_pengangkatan,
            'no_telepon' => $no_telepon, 'no_handphone' => $no_handphone,
            'jenis_kelamin' => $jenis_kelamin, 'agama' => $agama,
            'rt' => $rt, 'rw' => $rw, 'desa' => $desa,
            'kec' => $kec, 'kota' => $kota, 'kodepos' => $kodepos
                ));
        
        redirect('gurus/new');
    }

    // for update guru
    public function update($id) {
        $this->is_privilege('EDIT_GURU');
        $this->load->library('form_validation');
        
        // Get guru from input.
        $nip = trim($this->input->post('nip', TRUE));
        $nuptk = trim($this->input->post('nuptk', TRUE));
        $nrg = trim($this->input->post('nrg', TRUE));
        $nsg = trim($this->input->post('nsg', TRUE));
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $email = trim($this->input->post('email', TRUE));
        $tempat_lahir = strtoupper(trim($this->input->post('tempat_lahir', TRUE)));
        $tanggal_lahir = trim($this->input->post('tanggal_lahir', TRUE));
        $alamat = strtoupper(trim($this->input->post('alamat', TRUE)));
        $rt = trim($this->input->post('rt', TRUE));
        $rw = trim($this->input->post('rw', TRUE));
        $desa = strtoupper(trim($this->input->post('desa', TRUE)));
        $kec = strtoupper(trim($this->input->post('kec', TRUE)));
        $kota = trim($this->input->post('kota', TRUE));
        $kodepos = trim($this->input->post('kodepos', TRUE));
        $status = strtoupper(trim($this->input->post('status', TRUE)));
        $tanggal_pengangkatan = $this->input->post('tanggal_pengangkatan', TRUE) ? trim($this->input->post('tanggal_pengangkatan', TRUE)) : NULL;
        $no_telepon = trim($this->input->post('no_telepon', TRUE));
        $no_handphone = trim($this->input->post('no_handphone', TRUE));
        $jenis_kelamin = trim($this->input->post('jenis_kelamin', TRUE));
        $agama = strtoupper(trim($this->input->post('agama', TRUE)));

        $validation_rules = array(
            array('field' => 'nip', 'label' => 'NIP',
                'rules' => 'trim|required|callback_nip_check_update['.$id.']'),
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'),
            array('field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'trim|required'),
            array('field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'trim|required'),
            array('field' => 'email', 'label' => 'E-Mail', 'rules' => 'trim|valid_email'),
            array('field' => 'status', 'label' => 'Status', 'rules' => 'trim|required'),
            array('field' => 'kodepos', 'label' => 'Kode Pos', 'rules' => 'trim|numeric'),
            array('field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'nip' => $nip,
                'nuptk' => $nuptk,
                'nrg' => $nrg,
                'nsg' => $nsg,
                'nama' => $nama,
                'email' => $email,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'alamat' => $alamat,
                'rt' => $rt,
                'rw' => $rw,
                'desa' => $desa,
                'kec' => $kec,
                'kota' => $kota,
                'kodepos' => $kodepos,
                'status' => $status,
                'tanggal_pengangkatan' => $tanggal_pengangkatan,
                'no_telepon' => $no_telepon,
                'no_handphone' => $no_handphone,
                'agama' => $agama,
                'jenis_kelamin' => $jenis_kelamin
            );

            if ($this->guru_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data guru berhasil diubah</div>');
                redirect('gurus/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nip', form_error('nip'));
        $this->session->set_flashdata('nama', form_error('nama'));
        $this->session->set_flashdata('email', form_error('email'));
        $this->session->set_flashdata('tanggal_lahir', form_error('tanggal_lahir'));
        $this->session->set_flashdata('tempat_lahir', form_error('tempat_lahir'));
        $this->session->set_flashdata('status', form_error('status'));
        $this->session->set_flashdata('jenis_kelamin', form_error('jenis_kelamin'));
        $this->session->set_flashdata('kodepos', form_error('kodepos'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'nip' => $nip, 'nuptk' => $nuptk, 'tanggal_lahir' => $tanggal_lahir,
            'nrg' => $nrg, 'nsg' => $nsg, 'alamat' => $alamat,
            'nama' => $nama, 'email' => $email, 'status' => $status,
            '$tempat_lahir' => $tempat_lahir, 'tanggal_pengangkatan' => $tanggal_pengangkatan,
            'no_telepon' => $no_telepon, 'no_handphone' => $no_handphone,
            'jenis_kelamin' => $jenis_kelamin, 'agama' => $agama,
            'rt' => $rt, 'rw' => $rw, 'desa' => $desa,
            'kec' => $kec, 'kota' => $kota, 'kodepos' => $kodepos
                ));
        
        redirect('gurus/' . $id . '/edit');
    }

    // for delete guru with ID
    public function delete($id) {
        $this->is_privilege('DELETE_GURU');
        if ($this->guru_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data guru berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data guru gagal dihapus</div>');
        }
        redirect('gurus');
    }

    // for delete guru with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_GURU');
        $affected_row = $this->input->post('ids', TRUE) ? $this->guru_model->deletes($this->input->post('ids', TRUE)) : 0;
        if($affected_row){
            $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data guru berhasil dihapus</div>');
        }else{
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data guru gagal dihapus</div>');
        }
        
        redirect('gurus');
    }

    // validation for check unique nip
    public function nip_check($str) {
        $query = $this->guru_model->unique_check(trim($str));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('nip_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique nip in update
    public function nip_check_update($str, $id) {
        $query = $this->guru_model->unique_check(trim($str));
        if ($query->num_rows() > 0) {
            $guru = $query->row_array();
            if (trim($id) === trim($guru['id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('nip_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}

?>
