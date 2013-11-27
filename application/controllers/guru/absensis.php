<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of absensis
 *
 * @author L745
 */
class absensis extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('absensi_model');
        $this->load->model('kelas_bagian_model');
        $this->load->model('tahun_ajaran_model');
        $this->load->model('kelas_bagian_model');
        $this->load->model('siswa_model');
        $this->load->model('guru_wali_model');
        // is_matpel = 1
        $this->load->model('guru_model');
        $this->load->model('mata_pelajaran_model');
        // used in script to determine menu
        $this->load->vars('menu', 'absensis');
    }
    
    public function download(){
    	$this->load->library('excel');
    	$sheet = new PHPExcel();
    	$sheet->getProperties()->setTitle('Data Absensi')->setDescription('Data Absensi');
    	$sheet->setActiveSheetIndex(0);
    	
    	// get day
    	$day = "";$date=12;$month=12;$year=2012;
    	if($this->input->post('tanggal', TRUE)){
    		list($date, $month, $year) = explode('-', $this->input->post('tanggal', TRUE));
			$eng_day = strftime( "%A", strtotime($month."/".$date."/".$year));
			$day = convert_day($eng_day);
    	}
    	
    	// get guru wali
    	$guru = $this->guru_wali_model->get_guru_wali_kelas($this->tahun_ajaran_model->get_id($year),$this->input->post('kelas_bagian_id', TRUE));
    	$nama_guru = "";
    	if(!empty($guru))
    		$nama_guru = $guru['nama'];
    	
    	// get kelas
    	$kelas = get_full_kelas($this->input->post('kelas_bagian_id', TRUE),TRUE);
    	
    	// col, row, value
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Hari, Tanggal');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $day.", ".$this->input->post('tanggal', TRUE));
    	
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 2, 'Jam');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 2, $this->input->post('jam_awal', TRUE)." - ".$this->input->post('jam_akhir', TRUE));
    	
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'Mata Pelajaran');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 3, $this->input->post('mata_pelajaran', TRUE));
    	
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 4, 'Guru');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 4, $this->input->post('guru', TRUE));
    	
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 5, 'Kelas');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 5, $kelas);
    	
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 6, 'Guru Wali');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 6, $nama_guru);
    	
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, 8, 'NIS');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, 8, 'Nama');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(2, 8, 'Kehadiran');
    	$sheet->getActiveSheet()->setCellValueByColumnAndRow(3, 8, 'Keterangan');
    	
    	// fetch siswa where kelas_bagian_id, tahun_ajaran_id
    	$siswas = $this->siswa_model->get_siswas_with_kelas($this->input->post('kelas_bagian_id', TRUE), $this->tahun_ajaran_model->get_id($year));
    	$row = 9;
    	foreach ($siswas as $siswa) {
    		$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $siswa['nis']);
    		$sheet->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $siswa['nama']);
    		$row++;
    	}
    	
    	$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel5');
    	header('Content-Type: application/vnd.ms-excel');
    	
    	// Data Absensi Kelas - Tanggal
    	header('Content-Disposition: attachment;filename="Data Absensi_'.$kelas.'_'.strftime( "%d%b%Y", strtotime($month."/".$date."/".$year)).'.xls"');
    	
    	header('Cache-Control: max-age=0');
    	$sheet_writer->save('php://output');
    }

    public function upload() {
        $this->is_guru_wali('NEW_ABSENSI');
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

        if (!$this->upload->do_upload("absensi")) {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data absensi gagal di upload, format yg diterima adalah XLS dengan max 5MB</div>');
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
            if ($this->absensi_model->import($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data absensi berhasil di-import</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data absensi gagal di-import, ada data yang salah</div>');
            }
            // remove file
            unlink($file['upload_data']['full_path']);
        }
        redirect('absensis');
    }

    // for index view
    public function index() {
        $this->is_guru_wali('INDEX_ABSENSI');
        // pagination
        $this->load->library('pagination');
        $this->load->library('excel_reader');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->absensi_model->column_names()) ? trim($this->input->get('column', TRUE)) : "bulan";
        else
            $data['column'] = "bulan";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // for select
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians();
        $data['tahun_ajarans'] = $this->tahun_ajaran_model->get_tahun_ajaran();
        $data['siswas'] = $this->siswa_model->get_siswa();
        // is_matpel = 1
        $data['mata_pelajarans'] = $this->mata_pelajaran_model->get_mata_pelajaran();
        $data['gurus'] = $this->guru_model->get_guru();

        $data['tanggal'] = $this->input->get('tanggal', TRUE) ? trim($this->input->get('tanggal', TRUE)) : "";
        $data['bulan'] = $this->input->get('bulan', TRUE) ? trim($this->input->get('bulan', TRUE)) : "";
        $data['tahun_ajaran_id'] = $this->input->get('tahun_ajaran_id', TRUE) ? trim($this->input->get('tahun_ajaran_id', TRUE)) : "";
        $data['kelas_bagian_id'] = $this->input->get('kelas_bagian_id', TRUE) ? trim($this->input->get('kelas_bagian_id', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('absensis?');
        $config['total_rows'] = $this->absensi_model->get_total($data['cond']);
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

        // fetch absensi
        $data['absensis'] = $this->absensi_model->
                fetch_absensis($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data Absensi";
        $data['breadc'] = array('menu' => "index_absensi");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('absensis', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_guru_wali('SHOW_ABSENSI');
        $data['content_title'] = "Lihat Absensi";
        $data['breadc'] = array('menu' => "show_absensi", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['absensi'] = $this->absensi_model->get_absensi($id);
        if (empty($data['absensi']))
            show_404();
        $this->load_view('absensis', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_guru_wali('NEW_ABSENSI');
        $data['content_title'] = "Buat Data Absensi";
        $data['breadc'] = array('menu' => "new_absensi");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // for select
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians();
        $data['tahun_ajarans'] = $this->tahun_ajaran_model->get_tahun_ajaran();
        $data['siswas'] = $this->siswa_model->get_siswa();
        // is_matpel = 1
        $data['mata_pelajarans'] = $this->mata_pelajaran_model->get_mata_pelajaran();
        $data['gurus'] = $this->guru_model->get_guru();

        // set texted field from create method
        $data['siswa_id'] = isset($this->session->userdata('field')['siswa_id']) ?
                $this->session->userdata('field')['siswa_id'] : '';
        $data['tanggal'] = isset($this->session->userdata('field')['tanggal']) ?
                $this->session->userdata('field')['tanggal'] : '';
        $data['kelas_bagian_id'] = isset($this->session->userdata('field')['kelas_bagian_id']) ?
                $this->session->userdata('field')['kelas_bagian_id'] : '';
        $data['tahun_ajaran_id'] = isset($this->session->userdata('field')['tahun_ajaran_id']) ?
                $this->session->userdata('field')['tahun_ajaran_id'] : '';
        $data['absensi'] = isset($this->session->userdata('field')['absensi']) ?
                $this->session->userdata('field')['absensi'] : '';
        $data['keterangan'] = isset($this->session->userdata('field')['keterangan']) ?
                $this->session->userdata('field')['keterangan'] : '';
        $data['bulan'] = isset($this->session->userdata('field')['bulan']) ?
                $this->session->userdata('field')['bulan'] : '';
        // is_matpel = 1
        $data['mata_pelajaran_id'] = isset($this->session->userdata('field')['mata_pelajaran_id']) ?
                $this->session->userdata('field')['mata_pelajaran_id'] : '';
        $data['guru_id'] = isset($this->session->userdata('field')['guru_id']) ?
                $this->session->userdata('field')['guru_id'] : '';

        $this->load_view('absensis', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_guru_wali('EDIT_ABSENSI');
        $data['content_title'] = "Ubah Data Absensi";
        $data['breadc'] = array('menu' => "edit_absensi", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['absensi'] = $this->absensi_model->get_absensi($id);

        // for select
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians();
        $data['tahun_ajarans'] = $this->tahun_ajaran_model->get_tahun_ajaran();
        $data['siswas'] = $this->siswa_model->get_siswa();
        // is_matpel = 1
        $data['mata_pelajarans'] = $this->mata_pelajaran_model->get_mata_pelajaran();
        $data['gurus'] = $this->guru_model->get_guru();

        if (empty($data['absensi']))
            show_404();

        // set texted field from create method
        $data['absensi']['siswa_id'] = isset($this->session->userdata('field')['siswa_id']) ?
                $this->session->userdata('field')['siswa_id'] : $data['absensi']['siswa_id'];
        $data['absensi']['tanggal'] = isset($this->session->userdata('field')['tanggal']) ?
                $this->session->userdata('field')['tanggal'] : $data['absensi']['tanggal'];
        $data['absensi']['kelas_bagian_id'] = isset($this->session->userdata('field')['kelas_bagian_id']) ?
                $this->session->userdata('field')['kelas_bagian_id'] : $data['absensi']['kelas_bagian_id'];
        $data['absensi']['tahun_ajaran_id'] = isset($this->session->userdata('field')['tahun_ajaran_id']) ?
                $this->session->userdata('field')['tahun_ajaran_id'] : $data['absensi']['tahun_ajaran_id'];
        $data['absensi']['absensi'] = isset($this->session->userdata('field')['absensi']) ?
                $this->session->userdata('field')['absensi'] : $data['absensi']['absensi'];
        $data['absensi']['keterangan'] = isset($this->session->userdata('field')['keterangan']) ?
                $this->session->userdata('field')['keterangan'] : $data['absensi']['keterangan'];
        $data['absensi']['bulan'] = isset($this->session->userdata('field')['bulan']) ?
                $this->session->userdata('field')['bulan'] : $data['absensi']['bulan'];
        // is_matpel = 1
        $data['absensi']['mata_pelajaran_id'] = isset($this->session->userdata('field')['mata_pelajaran_id']) ?
                $this->session->userdata('field')['mata_pelajaran_id'] : $data['absensi']['mata_pelajaran_id'];
        $data['absensi']['guru_id'] = isset($this->session->userdata('field')['guru_id']) ?
                $this->session->userdata('field')['guru_id'] : $data['absensi']['guru_id'];

        $this->load_view('absensis', 'edit', $data);

        // unset session field data when error from method update
        $this->session->unset_userdata('field');
    }

    // for create new absensi
    public function create() {
        $this->is_guru_wali('NEW_ABSENSI');
        $this->load->library('form_validation');

        // Get absensi from input.
        $siswa_id = trim($this->input->post('siswa_id', TRUE));
        $tanggal = trim($this->input->post('tanggal', TRUE));
        $kelas_bagian_id = trim($this->input->post('kelas_bagian_id', TRUE));
        $tahun_ajaran_id = trim($this->input->post('tahun_ajaran_id', TRUE));
        $absensi = trim($this->input->post('absensi', TRUE));
        $keterangan = trim($this->input->post('keterangan', TRUE));
        $bulan = trim($this->input->post('bulan', TRUE));
        // is_matpel = 1
        $mata_pelajaran_id = trim($this->input->post('mata_pelajaran_id', TRUE));
        $guru_id = trim($this->input->post('guru_id', TRUE));
        // option absensi using mata pelajaran
        $is_matpel = 1;
        // get user_id
        $user_id = $this->flexi_auth->get_user_id();

        $ids = array('tanggal' => $tanggal,
            'kelas_bagian_id' => $kelas_bagian_id,
            'tahun_ajaran_id' => $tahun_ajaran_id,
            'bulan' => $bulan,
            'guru_id' => $guru_id,
            'mata_pelajaran_id' => $mata_pelajaran_id
        );

        $validation_rules = array(
            array('field' => 'siswa_id', 'label' => 'Siswa',
                'rules' => 'trim|required|integer|callback_unique_check[' . implode(',', $ids) . ']'),
            array('field' => 'tanggal', 'label' => 'Tanggal',
                'rules' => 'trim|required|integer'),
            array('field' => 'kelas_bagian_id', 'label' => 'Kelas',
                'rules' => 'trim|required|integer'),
            array('field' => 'tahun_ajaran_id', 'label' => 'Tahun',
                'rules' => 'trim|required|integer'),
            array('field' => 'absensi', 'label' => 'Absensi',
                'rules' => 'trim|required|integer'),
            array('field' => 'bulan', 'label' => 'Bulan',
                'rules' => 'trim|required|integer'),
            // is_matpel = 1
            array('field' => 'mata_pelajaran_id', 'label' => 'Mata Pelajaran',
                'rules' => 'trim|required|integer'),
            array('field' => 'guru_id', 'label' => 'Guru',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'siswa_id' => $siswa_id,
                'tanggal' => $tanggal,
                'kelas_bagian_id' => $kelas_bagian_id,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'absensi' => $absensi,
                'keterangan' => $keterangan,
                'bulan' => $bulan,
                'user_id' => $user_id,
                'is_matpel' => $is_matpel,
                // is_matpel = 1
                'mata_pelajaran_id' => $mata_pelajaran_id,
                'guru_id' => $guru_id
            );

            if ($this->absensi_model->create($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data absensi berhasil ditambah</div>');
                redirect('absensis');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('siswa_id', form_error('siswa_id'));
        $this->session->set_flashdata('tanggal', form_error('tanggal'));
        $this->session->set_flashdata('kelas_bagian_id', form_error('kelas_bagian_id'));
        $this->session->set_flashdata('tahun_ajaran_id', form_error('tahun_ajaran_id'));
        $this->session->set_flashdata('absensi', form_error('absensi'));
        $this->session->set_flashdata('bulan', form_error('bulan'));
        // is_matpel = 1
        $this->session->set_flashdata('mata_pelajaran_id', form_error('mata_pelajaran_id'));
        $this->session->set_flashdata('guru_id', form_error('guru_id'));

        // capture texted field
        $this->session->set_userdata('field', array('siswa_id' => $siswa_id));
        $this->session->set_userdata('field', array('kelas_bagian_id' => $kelas_bagian_id));
        $this->session->set_userdata('field', array('tahun_ajaran_id' => $tahun_ajaran_id));
        $this->session->set_userdata('field', array('absensi' => $absensi));
        $this->session->set_userdata('field', array('keterangan' => $keterangan));
        $this->session->set_userdata('field', array('bulan' => $bulan));
        $this->session->set_userdata('field', array('tanggal' => $tanggal));
        // is_matpel = 1
        $this->session->set_userdata('field', array('mata_pelajaran_id' => $mata_pelajaran_id));
        $this->session->set_userdata('field', array('guru_id' => $guru_id));

        redirect('absensis/new');
    }

    // for update absensi
    public function update($id) {
        $this->is_guru_wali('EDIT_ABSENSI');
        $this->load->library('form_validation');

        // Get absensi from input.
        $siswa_id = trim($this->input->post('siswa_id', TRUE));
        $tanggal = trim($this->input->post('tanggal', TRUE));
        $kelas_bagian_id = trim($this->input->post('kelas_bagian_id', TRUE));
        $tahun_ajaran_id = trim($this->input->post('tahun_ajaran_id', TRUE));
        $absensi = trim($this->input->post('absensi', TRUE));
        $keterangan = trim($this->input->post('keterangan', TRUE));
        $bulan = trim($this->input->post('bulan', TRUE));
        // is_matpel = 1
        $mata_pelajaran_id = trim($this->input->post('mata_pelajaran_id', TRUE));
        $guru_id = trim($this->input->post('guru_id', TRUE));
        // option absensi using mata pelajaran
        $is_matpel = 1;
        // get user_id
        $user_id = $this->flexi_auth->get_user_id();

        $ids = array('tanggal' => $tanggal,
            'kelas_bagian_id' => $kelas_bagian_id,
            'tahun_ajaran_id' => $tahun_ajaran_id,
            'bulan' => $bulan,
            'guru_id' => $guru_id,
            'mata_pelajaran_id' => $mata_pelajaran_id,
            'id' => $id
        );

        $validation_rules = array(
            array('field' => 'siswa_id', 'label' => 'Siswa',
                'rules' => 'trim|required|integer|callback_unique_check_update[' . implode(',', $ids) . ']'),
            array('field' => 'tanggal', 'label' => 'Tanggal',
                'rules' => 'trim|required|integer'),
            array('field' => 'kelas_bagian_id', 'label' => 'Kelas',
                'rules' => 'trim|required|integer'),
            array('field' => 'tahun_ajaran_id', 'label' => 'Tahun',
                'rules' => 'trim|required|integer'),
            array('field' => 'absensi', 'label' => 'Absensi',
                'rules' => 'trim|required|integer'),
            array('field' => 'bulan', 'label' => 'Bulan',
                'rules' => 'trim|required|integer'),
            // is_matpel = 1
            array('field' => 'mata_pelajaran_id', 'label' => 'Mata Pelajaran',
                'rules' => 'trim|required|integer'),
            array('field' => 'guru_id', 'label' => 'Guru',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'siswa_id' => $siswa_id,
                'tanggal' => $tanggal,
                'kelas_bagian_id' => $kelas_bagian_id,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'absensi' => $absensi,
                'keterangan' => $keterangan,
                'bulan' => $bulan,
                'user_id' => $user_id,
                'is_matpel' => $is_matpel,
                // is_matpel = 1
                'mata_pelajaran_id' => $mata_pelajaran_id,
                'guru_id' => $guru_id
            );

            if ($this->absensi_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data absensi berhasil diubah</div>');
                redirect('absensis/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('siswa_id', form_error('siswa_id'));
        $this->session->set_flashdata('tanggal', form_error('tanggal'));
        $this->session->set_flashdata('kelas_bagian_id', form_error('kelas_bagian_id'));
        $this->session->set_flashdata('tahun_ajaran_id', form_error('tahun_ajaran_id'));
        $this->session->set_flashdata('absensi', form_error('absensi'));
        $this->session->set_flashdata('bulan', form_error('bulan'));
        // is_matpel = 1
        $this->session->set_flashdata('mata_pelajaran_id', form_error('mata_pelajaran_id'));
        $this->session->set_flashdata('guru_id', form_error('guru_id'));

        // capture texted field
        $this->session->set_userdata('field', array('siswa_id' => $siswa_id));
        $this->session->set_userdata('field', array('kelas_bagian_id' => $kelas_bagian_id));
        $this->session->set_userdata('field', array('tahun_ajaran_id' => $tahun_ajaran_id));
        $this->session->set_userdata('field', array('absensi' => $absensi));
        $this->session->set_userdata('field', array('keterangan' => $keterangan));
        $this->session->set_userdata('field', array('bulan' => $bulan));
        $this->session->set_userdata('field', array('tanggal' => $tanggal));
        // is_matpel = 1
        $this->session->set_userdata('field', array('mata_pelajaran_id' => $mata_pelajaran_id));
        $this->session->set_userdata('field', array('guru_id' => $guru_id));

        redirect('absensis/' . $id . '/edit');
    }

    // for delete absensi with ID
    public function delete($id) {
        $this->is_guru_wali('DELETE_ABSENSI');
        if ($this->absensi_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data absensi berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data absensi gagal dihapus</div>');
        }
        redirect('absensis');
    }

    // for delete absensi with multiple ID
    public function deletes() {
        $this->is_guru_wali('DELETE_ABSENSI');
        $affected_row = $this->input->post('ids', TRUE) ? $this->absensi_model->deletes($this->input->post('ids', TRUE)) : 0;
        $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' Data absensi berhasil dihapus</div>');
        redirect('absensis');
    }

    // validation for check unique group selection
    public function unique_check($siswa_id, $ids) {
        $ids = explode(',', $ids);
        $query = $this->absensi_model->unique_check($siswa_id, $ids[0], $ids[1], $ids[2], $ids[3], $ids[4], $ids[5]);
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('unique_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique group selection in update
    public function unique_check_update($siswa_id, $ids) {
        $ids = explode(',', $ids);
        $query = $this->absensi_model->unique_check($siswa_id, $ids[0], $ids[1], $ids[2], $ids[3], $ids[4], $ids[5]);
        if ($query->num_rows() > 0) {
            $absensi = $query->row_array();
            if (trim($ids[6]) === trim($absensi['id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('unique_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

}

?>
