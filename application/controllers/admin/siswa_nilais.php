<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswa_nilais
 *
 * @author L745
 */
class siswa_nilais extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('siswa_nilai_model');
        $this->load->model('guru_kelas_matpel_model');
        $this->load->model('siswa_model');
        // used in script to determine menu
        $this->load->vars('menu', 'siswa_nilais');
    }

    // for index view
    public function index() {
        $this->is_guru('INDEX_NILAI_SISWA');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->siswa_nilai_model->column_names()) ? trim($this->input->get('column', TRUE)) : "nip";
        else
            $data['column'] = "nip";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('siswanilais?');
        $config['total_rows'] = $this->siswa_nilai_model->get_total($data['cond']);
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

        $is_wali = false;
        if (!$this->flexi_auth->is_admin() &&
                !in_array('INDEX_NILAI_SISWA', $this->session->userdata('privileges'))) {
            if ($this->flexi_auth->get_user_group_id() != "2") {
                $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
                if (count($guru) > 0) {
                    if ($this->guru_model->count_guru_wali($guru['id']) > 0)
                        $is_wali = true;
                }
            }
        }

        // guru kelas matpel ids
        $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
        $data['guru_kelas_matpel_ids'] = array();
        if (count($guru) > 0) {
            $data['guru_kelas_matpel_ids'] = $this->guru_model->get_guru_kelas_matpel_ids($guru['id']);
        }

        // condition to get data per guru matpel or not guru matpel
        if ($this->check_privilege('INDEX_NILAI_SISWA')) {
            // fetch siswa_nilai
            $data['siswa_nilais'] = $this->siswa_nilai_model->
                    fetch_siswa_nilais($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);
        } else if ($is_wali) {
            // fetch siswa_nilai
            $data['siswa_nilais'] = $this->siswa_nilai_model->
                    fetch_siswa_nilais_per_guru_wali($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);
        } else {
            // fetch siswa_nilai
            $data['siswa_nilais'] = $this->siswa_nilai_model->
                    fetch_siswa_nilais_per_guru_matpel($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);
        }

        $data['content_title'] = "Data Nilai Siswa";
        $data['breadc'] = array('menu' => "index_siswa_nilai");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // set custom pagination text
        $data['total_rows'] = $this->siswa_nilai_model->get_total();
        $data['num_pages'] = (ceil($data['total_rows'] / $this->pagination->per_page) > 0) ? ceil($data['total_rows'] / $this->pagination->per_page) : 1;
        $data['cur_page'] = ($this->pagination->cur_page > 0) ? $this->pagination->cur_page : 1;

        $this->load_view('siswa_nilais', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_guru('SHOW_NILAI_SISWA');
        $data['content_title'] = "Lihat Nilai Siswa";
        $data['breadc'] = array('menu' => "show_siswa_nilai", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['siswa_nilai'] = $this->siswa_nilai_model->get_siswa_nilai($id);
        if (empty($data['siswa_nilai']))
            show_404();
        $this->load_view('siswa_nilais', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_guru('NEW_NILAI_SISWA');
        $data['content_title'] = "Buat Data Nilai Siswa";
        $data['breadc'] = array('menu' => "new_siswa_nilai");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // condition to get data per guru matpel or not guru matpel
        if ($this->check_privilege('NEW_NILAI_SISWA')) {
            // for select
            $data['guru_kelas_matpels'] = $this->guru_kelas_matpel_model->get_guru_kelas_matpels();
            $data['siswas'] = $this->siswa_model->get_siswa();
        } else {
            $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
            if (count($guru) > 0) {
                // for select
                $data['siswas'] = "";
                $data['guru_kelas_matpels'] = $this->guru_kelas_matpel_model->get_guru_kelas_matpels($guru['id']);
                $index = 0;
                // get siswa yg kelas yg mata pelajarannya sama dengan mata pelajaran yg diajar guru
                foreach ($data['guru_kelas_matpels'] as $guru_kelas_matpel) {
                    $siswas = $this->siswa_model->get_siswas_with_kelas($guru_kelas_matpel['kelas_bagian_id'], $guru_kelas_matpel['tahun_ajaran_id']);
                    if ($index > 0) {
                        $data['siswas'] = array_merge($data['siswas'], $siswas);
                    } else {
                        $data['siswas'] = $siswas;
                    }
                    $index += 1;
                }
            } else {
                $data['guru_kelas_matpels'] = "";
                $data['siswas'] = "";
            }
        }

        // set texted field from create method
        $data['guru_kelas_matpel_id'] = isset($this->session->userdata('field')['guru_kelas_matpel_id']) ?
                $this->session->userdata('field')['guru_kelas_matpel_id'] : '';
        $data['siswa_id'] = isset($this->session->userdata('field')['siswa_id']) ?
                $this->session->userdata('field')['siswa_id'] : '';
        $data['jenis'] = isset($this->session->userdata('field')['jenis']) ?
                $this->session->userdata('field')['jenis'] : '';
        $data['nama'] = isset($this->session->userdata('field')['nama']) ?
                $this->session->userdata('field')['nama'] : '';
        $data['nilai'] = isset($this->session->userdata('field')['nilai']) ?
                $this->session->userdata('field')['nilai'] : '';

        $this->load_view('siswa_nilais', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_guru('EDIT_NILAI_SISWA');
        $data['content_title'] = "Ubah Data Nilai Siswa";
        $data['breadc'] = array('menu' => "edit_siswa_nilai", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['siswa_nilai'] = $this->siswa_nilai_model->get_siswa_nilai($id);

        // only admin, privileged users, and guru matpel who can use
        if (!$this->check_privilege('EDIT_NILAI_SISWA')) {
            $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
            if (count($guru) > 0) {
                $guru_kelas_matpel_ids = $this->guru_model->get_guru_kelas_matpel_ids($guru['id']);
                if (!in_array($data['siswa_nilai']['guru_kelas_matpel_id'], $guru_kelas_matpel_ids))
                    show_404();
            }else {
                show_404();
            }
        }

        if (empty($data['siswa_nilai']))
            show_404();

        // condition to get data per guru matpel or not guru matpel
        if ($this->check_privilege('EDIT_NILAI_SISWA')) {
            // for select
            $data['guru_kelas_matpels'] = $this->guru_kelas_matpel_model->get_guru_kelas_matpels();
            $data['siswas'] = $this->siswa_model->get_siswa();
        } else {
            $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
            if (count($guru) > 0) {
                // for select
                $data['siswas'] = "";
                $data['guru_kelas_matpels'] = $this->guru_kelas_matpel_model->get_guru_kelas_matpels($guru['id']);
                $index = 0;
                // get siswa yg kelas dan mata pelajarannya sama dengan kelas yg diajar guru
                foreach ($data['guru_kelas_matpels'] as $guru_kelas_matpel) {
                    $siswas = $this->siswa_model->get_siswas_with_kelas($guru_kelas_matpel['kelas_bagian_id'], $guru_kelas_matpel['tahun_ajaran_id']);
                    if ($index > 0) {
                        $data['siswas'] = array_merge($data['siswas'], $siswas);
                    } else {
                        $data['siswas'] = $siswas;
                    }
                    $index += 1;
                }
            } else {
                $data['guru_kelas_matpels'] = "";
                $data['siswas'] = "";
            }
        }

        // set texted field from update method
        $data['siswa_nilai']['guru_kelas_matpel_id'] = isset($this->session->userdata('field')['guru_kelas_matpel_id']) ?
                $this->session->userdata('field')['guru_kelas_matpel_id'] : $data['siswa_nilai']['guru_kelas_matpel_id'];
        $data['siswa_nilai']['siswa_id'] = isset($this->session->userdata('field')['siswa_id']) ?
                $this->session->userdata('field')['siswa_id'] : $data['siswa_nilai']['siswa_id'];
        $data['siswa_nilai']['jenis'] = isset($this->session->userdata('field')['jenis']) ?
                $this->session->userdata('field')['jenis'] : $data['siswa_nilai']['jenis'];
        $data['siswa_nilai']['nama'] = isset($this->session->userdata('field')['nama']) ?
                $this->session->userdata('field')['nama'] : $data['siswa_nilai']['nama'];
        $data['siswa_nilai']['nilai'] = isset($this->session->userdata('field')['nilai']) ?
                $this->session->userdata('field')['nilai'] : $data['siswa_nilai']['nilai'];

        $this->load_view('siswa_nilais', 'edit', $data);

        // unset session field data when error from method update
        $this->session->unset_userdata('field');
    }

    // for create new siswa_nilai
    public function create() {
        $this->is_guru('NEW_NILAI_SISWA');
        $this->load->library('form_validation');

        // Get siswa_nilai from input.
        $guru_kelas_matpel_id = trim($this->input->post('guru_kelas_matpel_id', TRUE));
        $siswa_id = trim($this->input->post('siswa_id', TRUE));
        $jenis = strtoupper(trim($this->input->post('jenis', TRUE)));
        $nama = trim($this->input->post('nama', TRUE));
        $nilai = trim($this->input->post('nilai', TRUE));

        $validation_rules = array(
            array('field' => 'guru_kelas_matpel_id', 'label' => 'Guru',
                'rules' => 'trim|required|integer'),
            array('field' => 'siswa_id', 'label' => 'Siswa',
                'rules' => 'trim|required|integer'),
            array('field' => 'jenis', 'label' => 'Jenis',
                'rules' => 'trim|required'),
            array('field' => 'nilai', 'label' => 'Nilai',
                'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
                'siswa_id' => $siswa_id,
                'jenis' => $jenis,
                'nama' => $nama,
                'nilai' => $nilai
            );

            if ($this->siswa_nilai_model->create($data,'NEW_NILAI_SISWA')) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data nilai siswa berhasil ditambah</div>');
                redirect('siswanilais');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('guru_kelas_matpel_id', form_error('guru_kelas_matpel_id'));
        $this->session->set_flashdata('siswa_id', form_error('siswa_id'));
        $this->session->set_flashdata('jenis', form_error('jenis'));
        $this->session->set_flashdata('nilai', form_error('nilai'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
            'siswa_id' => $siswa_id,
            'jenis' => $jenis,
            'nilai' => $nilai
        ));

        redirect('siswanilais/new');
    }

    // for update siswa_nilai
    public function update($id) {
        $this->is_guru('EDIT_NILAI_SISWA');
        $this->load->library('form_validation');

        // Get siswa_nilai from input.
        $guru_kelas_matpel_id = trim($this->input->post('guru_kelas_matpel_id', TRUE));
        $siswa_id = trim($this->input->post('siswa_id', TRUE));
        $jenis = strtoupper(trim($this->input->post('jenis', TRUE)));
        $nama = trim($this->input->post('nama', TRUE));
        $nilai = trim($this->input->post('nilai', TRUE));

        $validation_rules = array(
            array('field' => 'guru_kelas_matpel_id', 'label' => 'Guru',
                'rules' => 'trim|required|integer'),
            array('field' => 'siswa_id', 'label' => 'Siswa',
                'rules' => 'trim|required|integer'),
            array('field' => 'jenis', 'label' => 'Jenis',
                'rules' => 'trim|required'),
            array('field' => 'nilai', 'label' => 'Nilai',
                'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
                'siswa_id' => $siswa_id,
                'jenis' => $jenis,
                'nama' => $nama,
                'nilai' => $nilai
            );

            if ($this->siswa_nilai_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data siswa_nilai berhasil diubah</div>');
                redirect('siswanilais/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('guru_kelas_matpel_id', form_error('guru_kelas_matpel_id'));
        $this->session->set_flashdata('siswa_id', form_error('siswa_id'));
        $this->session->set_flashdata('jenis', form_error('jenis'));
        $this->session->set_flashdata('nilai', form_error('nilai'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
            'siswa_id' => $siswa_id,
            'jenis' => $jenis,
            'nilai' => $nilai
        ));

        redirect('siswanilais/' . $id . '/edit');
    }

    // for delete siswa_nilai with ID
    public function delete($id) {
        $this->is_guru('DELETE_NILAI_SISWA');

        $siswa_nilai = $this->siswa_nilai_model->get_siswa_nilai($id);

        if (count($siswa_nilai) > 0) {
            // only admin, privileged users, and guru matpel who can use
            if (!$this->check_privilege('EDIT_NILAI_SISWA')) {
                $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
                if (count($guru) > 0) {
                    $guru_kelas_matpel_ids = $this->guru_model->get_guru_kelas_matpel_ids($guru['id']);
                    if (!in_array($siswa_nilai['guru_kelas_matpel_id'], $guru_kelas_matpel_ids))
                        show_404();
                }else {
                    show_404();
                }
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data nilai siswa gagal dihapus</div>');
        }

        if ($this->siswa_nilai_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data nilai siswa berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data nilai siswa gagal dihapus</div>');
        }
        redirect('siswanilais');
    }

    // for delete siswa_nilai with multiple ID
    public function deletes() {
        $this->is_guru('DELETE_NILAI_SISWA');
        $affected_row = $this->input->post('ids', TRUE) ? $this->siswa_nilai_model->deletes($this->input->post('ids', TRUE)) : 0;
        if ($affected_row) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                    ' Data nilai siswa berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data nilai siswa gagal dihapus</div>');
        }
        redirect('siswanilais');
    }

}

?>
