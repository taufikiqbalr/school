<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswas
 *
 * @author L745
 */
class siswas extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('siswa_model');
        $this->load->model('siswa_kelas_model');
        // used in script to determine menu
        $this->load->vars('menu', 'siswas');
    }
    
    public function upload() {
        $this->is_privilege('NEW_SISWA');
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

        if (!$this->upload->do_upload("siswa")) {
            $this->session->set_flashdata('message', '<div class="alert">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data siswa gagal di upload, format yg diterima adalah XLS dengan max 5MB</div>');
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
            if($this->siswa_model->import($data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data siswa berhasil di-import</div>');
            }else{
                $this->session->set_flashdata('message', '<div class="alert">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data siswa gagal di-import, ada data yang salah</div>');
            }
            // remove file
            unlink($file['upload_data']['full_path']);
        }
        redirect('siswas');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_SISWA');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->siswa_model->column_names()) ? trim($this->input->get('column', TRUE)) : "nis";
        else
            $data['column'] = "nis";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('siswas?');
        $config['total_rows'] = $this->siswa_model->get_total($data['cond']);
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

        // fetch siswa
        $data['siswas'] = $this->siswa_model->
                fetch_siswas($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Siswa";
        $data['breadc'] = array('menu' => "index_siswa");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('siswas', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_SISWA');
        $data['content_title'] = "Lihat Data Siswa";
        $data['breadc'] = array('menu' => "show_siswa", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['siswa'] = $this->siswa_model->get_siswa($id);
        if (empty($data['siswa']))
            show_404();
        //for entities
        $data['siswa_kelas'] = $this->siswa_kelas_model->get_kelas($id);
        $this->load_view('siswas', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_SISWA');
        $data['content_title'] = "Buat Data Siswa";
        $data['breadc'] = array('menu' => "new_siswa");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // set texted field from create method
        $data['nis'] = isset($this->session->userdata('field')['nis']) ? $this->session->userdata('field')['nis'] : '';
        $data['nama'] = isset($this->session->userdata('field')['nama']) ? $this->session->userdata('field')['nama'] : '';
        $data['email'] = isset($this->session->userdata('field')['email']) ? $this->session->userdata('field')['email'] : '';
        $data['nohp'] = isset($this->session->userdata('field')['nohp']) ? $this->session->userdata('field')['nohp'] : '';
        $data['notel'] = isset($this->session->userdata('field')['notel']) ? $this->session->userdata('field')['notel'] : '';
        $data['tmptlhr'] = isset($this->session->userdata('field')['tmptlhr']) ? $this->session->userdata('field')['tmptlhr'] : '';
        $data['tgllhr'] = isset($this->session->userdata('field')['tgllhr']) ? $this->session->userdata('field')['tgllhr'] : '';
        $data['jk'] = isset($this->session->userdata('field')['jk']) ? $this->session->userdata('field')['jk'] : '';
        $data['agama'] = isset($this->session->userdata('field')['agama']) ? $this->session->userdata('field')['agama'] : '';
        $data['almt'] = isset($this->session->userdata('field')['almt']) ? $this->session->userdata('field')['almt'] : '';
        $data['rt'] = isset($this->session->userdata('field')['rt']) ? $this->session->userdata('field')['rt'] : '';
        $data['rw'] = isset($this->session->userdata('field')['rw']) ? $this->session->userdata('field')['rw'] : '';
        $data['desa'] = isset($this->session->userdata('field')['desa']) ? $this->session->userdata('field')['desa'] : '';
        $data['kec'] = isset($this->session->userdata('field')['kec']) ? $this->session->userdata('field')['kec'] : '';
        $data['nmsekolah'] = isset($this->session->userdata('field')['nmsekolah']) ? $this->session->userdata('field')['nmsekolah'] : '';
        $data['almtsekolah'] = isset($this->session->userdata('field')['almtsekolah']) ? $this->session->userdata('field')['almtsekolah'] : '';
        $data['noijasah'] = isset($this->session->userdata('field')['noijasah']) ? $this->session->userdata('field')['noijasah'] : '';
        $data['nilaiijasah'] = isset($this->session->userdata('field')['nilaiijasah']) ? $this->session->userdata('field')['nilaiijasah'] : '';
        $data['nilaiskl'] = isset($this->session->userdata('field')['nilaiskl']) ? $this->session->userdata('field')['nilaiskl'] : '';
        $data['nmbpk'] = isset($this->session->userdata('field')['nmbpk']) ? $this->session->userdata('field')['nmbpk'] : '';
        $data['pkrjbpk'] = isset($this->session->userdata('field')['pkrjbpk']) ? $this->session->userdata('field')['pkrjbpk'] : '';
        $data['nmibu'] = isset($this->session->userdata('field')['nmibu']) ? $this->session->userdata('field')['nmibu'] : '';
        $data['pkrjibu'] = isset($this->session->userdata('field')['pkrjibu']) ? $this->session->userdata('field')['pkrjibu'] : '';
        $data['penghasilanortu'] = isset($this->session->userdata('field')['penghasilanortu']) ? $this->session->userdata('field')['penghasilanortu'] : '';
        $data['almtortu'] = isset($this->session->userdata('field')['almtortu']) ? $this->session->userdata('field')['almtortu'] : '';
        $data['rtortu'] = isset($this->session->userdata('field')['rtortu']) ? $this->session->userdata('field')['rtortu'] : '';
        $data['rwortu'] = isset($this->session->userdata('field')['rwortu']) ? $this->session->userdata('field')['rwortu'] : '';
        $data['desaortu'] = isset($this->session->userdata('field')['desaortu']) ? $this->session->userdata('field')['desaortu'] : '';
        $data['kecortu'] = isset($this->session->userdata('field')['kecortu']) ? $this->session->userdata('field')['kecortu'] : '';
        $data['kotaortu'] = isset($this->session->userdata('field')['kotaortu']) ? $this->session->userdata('field')['kotaortu'] : '';
        $data['kodepos'] = isset($this->session->userdata('field')['kodepos']) ? $this->session->userdata('field')['kodepos'] : '';
        $data['kodeposortu'] = isset($this->session->userdata('field')['kodeposortu']) ? $this->session->userdata('field')['kodeposortu'] : '';
        $data['tlportu'] = isset($this->session->userdata('field')['tlportu']) ? $this->session->userdata('field')['tlportu'] : '';
        $data['pendidikanbpk'] = isset($this->session->userdata('field')['pendidikanbpk']) ? $this->session->userdata('field')['pendidikanbpk'] : '';
        $data['pendidikanibu'] = isset($this->session->userdata('field')['pendidikanibu']) ? $this->session->userdata('field')['pendidikanibu'] : '';
        $data['tahun_masuk'] = isset($this->session->userdata('field')['tahun_masuk']) ? $this->session->userdata('field')['tahun_masuk'] : '';
               
        $this->load_view('siswas', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_SISWA');
        $data['content_title'] = "Ubah Data Siswa";
        $data['breadc'] = array('menu' => "edit_siswa", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['siswa'] = $this->siswa_model->get_siswa($id);
        if (empty($data['siswa']))
            show_404();
        //for entities
        $data['siswa_kelas'] = $this->siswa_kelas_model->get_kelas($id);
        // set texted field from update method
        $data['siswa']['nis'] = isset($this->session->userdata('field')['nis']) ? $this->session->userdata('field')['nis'] : $data['siswa']['nis'];
        $data['siswa']['nama'] = isset($this->session->userdata('field')['nama']) ? $this->session->userdata('field')['nama'] : $data['siswa']['nama'];
        $data['siswa']['email'] = isset($this->session->userdata('field')['email']) ? $this->session->userdata('field')['email'] : $data['siswa']['email'];
        $data['siswa']['nohp'] = isset($this->session->userdata('field')['nohp']) ? $this->session->userdata('field')['nohp'] : $data['siswa']['nohp'];
        $data['siswa']['notel'] = isset($this->session->userdata('field')['notel']) ? $this->session->userdata('field')['notel'] : $data['siswa']['notel'];
        $data['siswa']['tmptlhr'] = isset($this->session->userdata('field')['tmptlhr']) ? $this->session->userdata('field')['tmptlhr'] : $data['siswa']['tmptlhr'];
        $data['siswa']['tgllhr'] = isset($this->session->userdata('field')['tgllhr']) ? $this->session->userdata('field')['tgllhr'] : $data['siswa']['tgllhr'];
        $data['siswa']['jk'] = isset($this->session->userdata('field')['jk']) ? $this->session->userdata('field')['jk'] : $data['siswa']['jk'];
        $data['siswa']['agama'] = isset($this->session->userdata('field')['agama']) ? $this->session->userdata('field')['agama'] : $data['siswa']['agama'];
        $data['siswa']['almt'] = isset($this->session->userdata('field')['almt']) ? $this->session->userdata('field')['almt'] : $data['siswa']['almt'];
        $data['siswa']['rt'] = isset($this->session->userdata('field')['rt']) ? $this->session->userdata('field')['rt'] : $data['siswa']['rt'];
        $data['siswa']['rw'] = isset($this->session->userdata('field')['rw']) ? $this->session->userdata('field')['rw'] : $data['siswa']['rw'];
        $data['siswa']['desa'] = isset($this->session->userdata('field')['desa']) ? $this->session->userdata('field')['desa'] : $data['siswa']['desa'];
        $data['siswa']['kec'] = isset($this->session->userdata('field')['kec']) ? $this->session->userdata('field')['kec'] : $data['siswa']['kec'];
        $data['siswa']['nmsekolah'] = isset($this->session->userdata('field')['nmsekolah']) ? $this->session->userdata('field')['nmsekolah'] : $data['siswa']['nmsekolah'];
        $data['siswa']['almtsekolah'] = isset($this->session->userdata('field')['almtsekolah']) ? $this->session->userdata('field')['almtsekolah'] : $data['siswa']['almtsekolah'];
        $data['siswa']['noijasah'] = isset($this->session->userdata('field')['noijasah']) ? $this->session->userdata('field')['noijasah'] : $data['siswa']['noijasah'];
        $data['siswa']['nilaiijasah'] = isset($this->session->userdata('field')['nilaiijasah']) ? $this->session->userdata('field')['nilaiijasah'] : $data['siswa']['nilaiijasah'];
        $data['siswa']['nilaiskl'] = isset($this->session->userdata('field')['nilaiskl']) ? $this->session->userdata('field')['nilaiskl'] : $data['siswa']['nilaiskl'];
        $data['siswa']['nmbpk'] = isset($this->session->userdata('field')['nmbpk']) ? $this->session->userdata('field')['nmbpk'] : $data['siswa']['nmbpk'];
        $data['siswa']['pkrjbpk'] = isset($this->session->userdata('field')['pkrjbpk']) ? $this->session->userdata('field')['pkrjbpk'] : $data['siswa']['pkrjbpk'];
        $data['siswa']['nmibu'] = isset($this->session->userdata('field')['nmibu']) ? $this->session->userdata('field')['nmibu'] : $data['siswa']['nmibu'];
        $data['siswa']['pkrjibu'] = isset($this->session->userdata('field')['pkrjibu']) ? $this->session->userdata('field')['pkrjibu'] : $data['siswa']['pkrjibu'];
        $data['siswa']['penghasilanortu'] = isset($this->session->userdata('field')['penghasilanortu']) ? $this->session->userdata('field')['penghasilanortu'] : $data['siswa']['penghasilanortu'];
        $data['siswa']['almtortu'] = isset($this->session->userdata('field')['almtortu']) ? $this->session->userdata('field')['almtortu'] : $data['siswa']['almtortu'];
        $data['siswa']['rtortu'] = isset($this->session->userdata('field')['rtortu']) ? $this->session->userdata('field')['rtortu'] : $data['siswa']['rtortu'];
        $data['siswa']['rwortu'] = isset($this->session->userdata('field')['rwortu']) ? $this->session->userdata('field')['rwortu'] : $data['siswa']['rwortu'];
        $data['siswa']['desaortu'] = isset($this->session->userdata('field')['desaortu']) ? $this->session->userdata('field')['desaortu'] : $data['siswa']['desaortu'];
        $data['siswa']['kecortu'] = isset($this->session->userdata('field')['kecortu']) ? $this->session->userdata('field')['kecortu'] : $data['siswa']['kecortu'];
        $data['siswa']['kotaortu'] = isset($this->session->userdata('field')['kotaortu']) ? $this->session->userdata('field')['kotaortu'] : $data['siswa']['kotaortu'];
        $data['siswa']['kodepos'] = isset($this->session->userdata('field')['kodepos']) ? $this->session->userdata('field')['kodepos'] : $data['siswa']['kodepos'];
        $data['siswa']['kodeposortu'] = isset($this->session->userdata('field')['kodeposortu']) ? $this->session->userdata('field')['kodeposortu'] : $data['siswa']['kodeposortu'];
        $data['siswa']['tlportu'] = isset($this->session->userdata('field')['tlportu']) ? $this->session->userdata('field')['tlportu'] : $data['siswa']['tlportu'];
        $data['siswa']['pendidikanbpk'] = isset($this->session->userdata('field')['pendidikanbpk']) ? $this->session->userdata('field')['pendidikanbpk'] : $data['siswa']['pendidikanbpk'];
        $data['siswa']['pendidikanibu'] = isset($this->session->userdata('field')['pendidikanibu']) ? $this->session->userdata('field')['pendidikanibu'] : $data['siswa']['pendidikanibu'];
        $data['siswa']['tahun_masuk'] = isset($this->session->userdata('field')['tahun_masuk']) ? $this->session->userdata('field')['tahun_masuk'] : $data['siswa']['tahun_masuk'];
        
        $data['siswa']['tahun_keluar'] = isset($this->session->userdata('field')['tahun_masuk']) ? $this->session->userdata('field')['tahun_masuk'] : $data['siswa']['tahun_keluar'];
        
        $this->load_view('siswas', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new siswa
    public function create() {
        $this->is_privilege('NEW_SISWA');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nis', 'label' => 'NIS',
                'rules' => 'trim|required|callback_nis_check'),
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'),
            array('field' => 'tmptlhr', 'label' => 'Tempat Lahir', 'rules' => 'trim|required'),
            array('field' => 'tgllhr', 'label' => 'Tanggal Lahir', 'rules' => 'trim|required'),
            array('field' => 'email', 'label' => 'E-Mail', 'rules' => 'trim|valid_email'),
            array('field' => 'nohp', 'label' => 'No Handphone', 'rules' => 'trim|numeric'),
            array('field' => 'notel', 'label' => 'No Telepon', 'rules' => 'trim|numeric'),
            array('field' => 'kodepos', 'label' => 'Kode Pos', 'rules' => 'trim|numeric'),
            array('field' => 'kodeposortu', 'label' => 'Kode Pos Orangtua', 'rules' => 'trim|numeric'),
            array('field' => 'tlportu', 'label' => 'No Telepon Orangtua', 'rules' => 'trim|numeric'),
            array('field' => 'penghasilanortu', 'label' => 'Penghasilan Orangtua', 'rules' => 'trim|required|integer'),
            array('field' => 'jk', 'label' => 'Jenis Kelamin', 'rules' => 'trim|required|integer'),
            array('field' => 'agama', 'label' => 'Agama', 'rules' => 'trim|required'),
            array('field' => 'tahun_masuk', 'label' => 'Tahun Masuk', 'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get siswa from input.
        $nis = trim($this->input->post('nis', TRUE));
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $email = trim($this->input->post('email', TRUE));
        $tmptlhr = strtoupper(trim($this->input->post('tmptlhr', TRUE)));
        $tgllhr = trim($this->input->post('tgllhr', TRUE));
        $almt = strtoupper(trim($this->input->post('almt', TRUE)));
        $nohp = trim($this->input->post('nohp', TRUE));
        $notel = trim($this->input->post('notel', TRUE));
        $jk = trim($this->input->post('jk', TRUE));
        $agama = strtoupper(trim($this->input->post('agama', TRUE)));
        $rt = trim($this->input->post('rt', TRUE));
        $rw = trim($this->input->post('rw', TRUE));
        $desa = strtoupper(trim($this->input->post('desa', TRUE)));
        $kec = strtoupper(trim($this->input->post('kec', TRUE)));
        $nmsekolah = strtoupper(trim($this->input->post('nmsekolah', TRUE)));
        $almtsekolah = strtoupper(trim($this->input->post('almtsekolah', TRUE)));
        $noijasah = trim($this->input->post('noijasah', TRUE));
        $nilaiijasah = trim($this->input->post('nilaiijasah', TRUE));
        $nilaiskl = trim($this->input->post('nilaiskl', TRUE));
        $nmbpk = strtoupper(trim($this->input->post('nmbpk', TRUE)));
        $pkrjbpk = strtoupper(trim($this->input->post('pkrjbpk', TRUE)));
        $nmibu = strtoupper(trim($this->input->post('nmibu', TRUE)));
        $pkrjibu = strtoupper(trim($this->input->post('pkrjibu', TRUE)));
        $penghasilanortu = trim($this->input->post('penghasilanortu', TRUE));
        $almtortu = strtoupper(trim($this->input->post('almtortu', TRUE)));
        $rtortu = trim($this->input->post('rtortu', TRUE));
        $rwortu = trim($this->input->post('rwortu', TRUE));
        $desaortu = strtoupper(trim($this->input->post('desaortu', TRUE)));
        $kecortu = strtoupper(trim($this->input->post('kecortu', TRUE)));
        $kotaortu = strtoupper(trim($this->input->post('kotaortu', TRUE)));
        $kodeposortu = trim($this->input->post('kodeposortu', TRUE));
        $kodepos = trim($this->input->post('kodepos', TRUE));
        $tlportu = trim($this->input->post('tlportu', TRUE));
        $pendidikanbpk = strtoupper(trim($this->input->post('pendidikanbpk', TRUE)));
        $pendidikanibu = strtoupper(trim($this->input->post('pendidikanibu', TRUE)));
        $tahun_masuk = trim($this->input->post('tahun_masuk', TRUE));

        if ($this->form_validation->run()) {
            $data = array(
                'nis' => $nis,
                'nama' => $nama,
                'email' => $email,
                'tmptlhr' => $tmptlhr,
                'tgllhr' => $tgllhr,
                'almt' => $almt,
                'notel' => $notel,
                'nohp' => $nohp,
                'agama' => $agama,
                'rt' => $rt,
                'rw' => $rw,
                'desa' => $desa,
                'kec' => $kec,
                'nmsekolah' => $nmsekolah,
                'almtsekolah' => $almtsekolah,
                'noijasah' => $noijasah,
                'nilaiijasah' => $nilaiijasah,
                'nilaiskl' => $nilaiskl,
                'nmbpk' => $nmbpk,
                'pkrjbpk' => $pkrjbpk,
                'nmibu' => $nmibu,
                'pkrjibu' => $pkrjibu,
                'penghasilanortu' => $penghasilanortu,
                'almtortu' => $almtortu,
                'rtortu' => $rtortu,
                'rwortu' => $rwortu,
                'desaortu' => $desaortu,
                'kecortu' => $kecortu,
                'kotaortu' => $kotaortu,
                'kodeposortu' => $kodeposortu,
                'kodepos' => $kodepos,
                'tlportu' => $tlportu,
                'pendidikanbpk' => $pendidikanbpk,
                'pendidikanibu' => $pendidikanibu,
                'jk' => $jk,
                'tahun_masuk' => $tahun_masuk
            );

            if ($this->siswa_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data siswa berhasil ditambah</div>');
                redirect('siswas');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nis', form_error('nis'));
        $this->session->set_flashdata('nama', form_error('nama'));
        $this->session->set_flashdata('email', form_error('email'));
        $this->session->set_flashdata('tgllhr', form_error('tgllhr'));
        $this->session->set_flashdata('tmptlhr', form_error('tmptlhr'));
        $this->session->set_flashdata('agama', form_error('agama'));
        $this->session->set_flashdata('jk', form_error('jk'));
        $this->session->set_flashdata('nohp', form_error('nohp'));
        $this->session->set_flashdata('notel', form_error('notel'));
        $this->session->set_flashdata('kodepos', form_error('kodepos'));
        $this->session->set_flashdata('kodeposortu', form_error('kodeposortu'));
        $this->session->set_flashdata('penghasilanortu', form_error('penghasilanortu'));
        $this->session->set_flashdata('tlportu', form_error('tlportu'));
        $this->session->set_flashdata('tahun_masuk', form_error('tahun_masuk'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'nis' => $nis, 'nama' => $nama, 'email' => $email,
            'tmptlhr' => $tmptlhr, 'tgllhr' => $tgllhr,
            'agama' => $agama, '$jk' => $jk, 'notel' => $notel,
            'nohp' => $nohp, 'kodepos' => $kodepos, 
            'kodeposortu' => $kodeposortu, 'almt' => $almt,
            'rt' => $rt, 'rw' => $rw, 'kec' => $kec,
            'nmsekolah' => $nmsekolah, 'almtsekolah' => $almtsekolah,
            'noijasah' => $noijasah, 'nilaiijasah' => $nilaiijasah,
            'nilaiskl' => $nilaiskl, 'nmbpk' => $nmbpk, 
            'pkrjbpk' => $pkrjbpk, 'nmibu' => $nmibu, 'pkrjibu' => $pkrjibu,
            'penghasilanortu' => $penghasilanortu, 'almtortu' => $almtortu,
            'rtortu' => $rtortu, 'rwortu' => $rwortu,
            'kecortu' => $kecortu, '$kotaortu' => $kotaortu,
            'desaortu' => $desaortu, 'desa' => $desa,
            'tlportu' => $tlportu, 'pendidikanbpk' => $pendidikanbpk,
            'pendidikanibu' => $pendidikanibu,'tahun_masuk' => $tahun_masuk
                ));

        redirect('siswas/new');
    }

    // for update siswa
    public function update($id) {
        $this->is_privilege('EDIT_SISWA');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nis', 'label' => 'NIS',
                'rules' => 'trim|required|callback_nis_check_update['.$id.']'),
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'),
            array('field' => 'tmptlhr', 'label' => 'Tempat Lahir', 'rules' => 'trim|required'),
            array('field' => 'tgllhr', 'label' => 'Tanggal Lahir', 'rules' => 'trim|required'),
            array('field' => 'email', 'label' => 'E-Mail', 'rules' => 'trim|valid_email'),
            array('field' => 'nohp', 'label' => 'No Handphone', 'rules' => 'trim|numeric'),
            array('field' => 'notel', 'label' => 'No Telepon', 'rules' => 'trim|numeric'),
            array('field' => 'kodepos', 'label' => 'Kode Pos', 'rules' => 'trim|numeric'),
            array('field' => 'kodeposortu', 'label' => 'Kode Pos Orangtua', 'rules' => 'trim|numeric'),
            array('field' => 'tlportu', 'label' => 'No Telepon Orangtua', 'rules' => 'trim|numeric'),
            array('field' => 'penghasilanortu', 'label' => 'Penghasilan Orangtua', 'rules' => 'trim|required|numeric'),
            array('field' => 'jk', 'label' => 'Jenis Kelamin', 'rules' => 'trim|required|integer'),
            array('field' => 'agama', 'label' => 'Agama', 'rules' => 'trim|required'),
            array('field' => 'tahun_masuk', 'label' => 'Tahun Masuk', 'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get siswa from input.
        $nis = trim($this->input->post('nis', TRUE));
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $email = trim($this->input->post('email', TRUE));
        $tmptlhr = strtoupper(trim($this->input->post('tmptlhr', TRUE)));
        $tgllhr = trim($this->input->post('tgllhr', TRUE));
        $almt = strtoupper(trim($this->input->post('almt', TRUE)));
        $nohp = trim($this->input->post('nohp', TRUE));
        $notel = trim($this->input->post('notel', TRUE));
        $jk = trim($this->input->post('jk', TRUE));
        $agama = strtoupper(trim($this->input->post('agama', TRUE)));
        $rt = trim($this->input->post('rt', TRUE));
        $rw = trim($this->input->post('rw', TRUE));
        $desa = strtoupper(trim($this->input->post('desa', TRUE)));
        $kec = strtoupper(trim($this->input->post('kec', TRUE)));
        $nmsekolah = strtoupper(trim($this->input->post('nmsekolah', TRUE)));
        $almtsekolah = strtoupper(trim($this->input->post('almtsekolah', TRUE)));
        $noijasah = trim($this->input->post('noijasah', TRUE));
        $nilaiijasah = trim($this->input->post('nilaiijasah', TRUE));
        $nilaiskl = trim($this->input->post('nilaiskl', TRUE));
        $nmbpk = strtoupper(trim($this->input->post('nmbpk', TRUE)));
        $pkrjbpk = strtoupper(trim($this->input->post('pkrjbpk', TRUE)));
        $nmibu = strtoupper(trim($this->input->post('nmibu', TRUE)));
        $pkrjibu = strtoupper(trim($this->input->post('pkrjibu', TRUE)));
        $penghasilanortu = trim($this->input->post('penghasilanortu', TRUE));
        $almtortu = strtoupper(trim($this->input->post('almtortu', TRUE)));
        $rtortu = trim($this->input->post('rtortu', TRUE));
        $rwortu = trim($this->input->post('rwortu', TRUE));
        $desaortu = strtoupper(trim($this->input->post('desaortu', TRUE)));
        $kecortu = strtoupper(trim($this->input->post('kecortu', TRUE)));
        $kotaortu = strtoupper(trim($this->input->post('kotaortu', TRUE)));
        $kodeposortu = trim($this->input->post('kodeposortu', TRUE));
        $kodepos = trim($this->input->post('kodepos', TRUE));
        $tlportu = trim($this->input->post('tlportu', TRUE));
        $pendidikanbpk = strtoupper(trim($this->input->post('pendidikanbpk', TRUE)));
        $pendidikanibu = strtoupper(trim($this->input->post('pendidikanibu', TRUE)));
        $tahun_masuk = trim($this->input->post('tahun_masuk', TRUE));
        
        $tahun_keluar = trim($this->input->post('tahun_keluar', TRUE));

        if ($this->form_validation->run()) {
            $data = array(
                'nis' => $nis,
                'nama' => $nama,
                'email' => $email,
                'tmptlhr' => $tmptlhr,
                'tgllhr' => $tgllhr,
                'almt' => $almt,
                'notel' => $notel,
                'nohp' => $nohp,
                'agama' => $agama,
                'rt' => $rt,
                'rw' => $rw,
                'desa' => $desa,
                'kec' => $kec,
                'nmsekolah' => $nmsekolah,
                'almtsekolah' => $almtsekolah,
                'noijasah' => $noijasah,
                'nilaiijasah' => $nilaiijasah,
                'nilaiskl' => $nilaiskl,
                'nmbpk' => $nmbpk,
                'pkrjbpk' => $pkrjbpk,
                'nmibu' => $nmibu,
                'pkrjibu' => $pkrjibu,
                'penghasilanortu' => $penghasilanortu,
                'almtortu' => $almtortu,
                'rtortu' => $rtortu,
                'rwortu' => $rwortu,
                'desaortu' => $desaortu,
                'kecortu' => $kecortu,
                'kotaortu' => $kotaortu,
                'kodeposortu' => $kodeposortu,
                'kodepos' => $kodepos,
                'tlportu' => $tlportu,
                'pendidikanbpk' => $pendidikanbpk,
                'pendidikanibu' => $pendidikanibu,
                'jk' => $jk,
                'tahun_masuk' => $tahun_masuk,
                
                'tahun_keluar' => $tahun_keluar
            );

            if ($this->siswa_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data siswa berhasil diubah</div>');
                redirect('siswas/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('nis', form_error('nis'));
        $this->session->set_flashdata('nama', form_error('nama'));
        $this->session->set_flashdata('email', form_error('email'));
        $this->session->set_flashdata('tgllhr', form_error('tgllhr'));
        $this->session->set_flashdata('tmptlhr', form_error('tmptlhr'));
        $this->session->set_flashdata('agama', form_error('agama'));
        $this->session->set_flashdata('jk', form_error('jk'));
        $this->session->set_flashdata('nohp', form_error('nohp'));
        $this->session->set_flashdata('notel', form_error('notel'));
        $this->session->set_flashdata('kodepos', form_error('kodepos'));
        $this->session->set_flashdata('kodeposortu', form_error('kodeposortu'));
        $this->session->set_flashdata('penghasilanortu', form_error('penghasilanortu'));
        $this->session->set_flashdata('tlportu', form_error('tlportu'));
        $this->session->set_flashdata('tahun_masuk', form_error('tahun_masuk'));
        
        // capture texted field
        $this->session->set_userdata('field', array(
            'nis' => $nis, 'nama' => $nama, 'email' => $email,
            'tmptlhr' => $tmptlhr, 'tgllhr' => $tgllhr,
            'agama' => $agama, '$jk' => $jk, 'notel' => $notel,
            'nohp' => $nohp, 'kodepos' => $kodepos, 
            'kodeposortu' => $kodeposortu, 'almt' => $almt,
            'rt' => $rt, 'rw' => $rw, 'kec' => $kec,
            'nmsekolah' => $nmsekolah, 'almtsekolah' => $almtsekolah,
            'noijasah' => $noijasah, 'nilaiijasah' => $nilaiijasah,
            'nilaiskl' => $nilaiskl, 'nmbpk' => $nmbpk, 
            'pkrjbpk' => $pkrjbpk, 'nmibu' => $nmibu, 'pkrjibu' => $pkrjibu,
            'penghasilanortu' => $penghasilanortu, 'almtortu' => $almtortu,
            'rtortu' => $rtortu, 'rwortu' => $rwortu,
            'kecortu' => $kecortu, '$kotaortu' => $kotaortu,
            'desaortu' => $desaortu, 'desa' => $desa,
            'tlportu' => $tlportu, 'pendidikanbpk' => $pendidikanbpk,
            'pendidikanibu' => $pendidikanibu,'tahun_masuk' => $tahun_masuk,
            
            'tahun_keluar' => $tahun_keluar
                ));
        
        redirect('siswas/' . $id . '/edit');
    }

    // for delete siswa with ID
    public function delete($id) {
        $this->is_privilege('DELETE_SISWA');
        if ($this->siswa_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data siswa berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data siswa gagal dihapus</div>');
        }
        redirect('siswas');
    }

    // for delete siswa with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_SISWA');
        $affected_row = $this->input->post('ids', TRUE) ? $this->siswa_model->deletes($this->input->post('ids', TRUE)) : 0;
        if($affected_row){
            $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data siswa berhasil dihapus</div>');
        }else{
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data siswa gagal dihapus</div>');
        }
        
        redirect('siswas');
    }

    // validation for check unique tingkat
    public function nis_check($str) {
        $query = $this->siswa_model->unique_check(trim($str));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('nis_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique tingkat in update
    public function nis_check_update($str, $id) {
        $query = $this->siswa_model->unique_check(trim($str));
        if ($query->num_rows() > 0) {
            $siswa = $query->row_array();
            if (trim($id) === trim($siswa['id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('nis_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }
    
    

}

?>
