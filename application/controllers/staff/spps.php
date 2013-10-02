<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of spps
 *
 * @author L745
 */
class spps extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('spp_model');
        $this->load->model('siswa_model');
        // used in script to determine menu
        $this->load->vars('menu', 'spps');
    }

    // for index view
    public function index() {
        $this->is_privilege('INDEX_SPP');
        // pagination
        $this->load->library('pagination');

        // condition for pagination
        if ($this->input->get('column'))
            $data['column'] = in_array(trim($this->input->get('column', TRUE)), $this->spp_model->column_names()) ? trim($this->input->get('column', TRUE)) : "nis";
        else
            $data['column'] = "nis";
        if ($this->input->get('order', TRUE))
            $data['order'] = in_array(trim($this->input->get('order', TRUE)), array("asc", "desc")) ? trim($this->input->get('order', TRUE)) : "asc";
        else
            $data['order'] = "asc";
        $data['cond'] = $this->input->get('cond', TRUE) ? trim($this->input->get('cond', TRUE)) : "";

        // set pagination custom config
        $config['base_url'] = site_url('spps?');
        $config['total_rows'] = $this->spp_model->get_total($data['cond']);
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

        // fetch spp
        $data['spps'] = $this->spp_model->
                fetch_spps($config["per_page"], $page, $data['order'], $data['column'], $data['cond']);

        $data['content_title'] = "Data SPP";
        $data['breadc'] = array('menu' => "index_spp");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        $this->load_view('spps', 'index', $data);
    }

    // for show view
    public function show($id) {
        $this->is_privilege('SHOW_SPP');
        $data['content_title'] = "Lihat SPP";
        $data['breadc'] = array('menu' => "show_spp", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['spp'] = $this->spp_model->get_spp($id);
        if (empty($data['spp']))
            show_404();

        $this->load_view('spps', 'show', $data);
    }

    // for new view
    public function new_k() {
        $this->is_privilege('NEW_SPP');
        $data['content_title'] = "Buat Data SPP";
        $data['breadc'] = array('menu' => "new_spp");
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];

        // for select
        $data['siswas'] = $this->siswa_model->get_siswa();
        
        // set texted field from create method
        $data['siswa_id'] = isset($this->session->userdata('field')['siswa_id']) ? $this->session->userdata('field')['siswa_id'] : '';
        $data['bulan_tempo'] = isset($this->session->userdata('field')['bulan_tempo']) ? $this->session->userdata('field')['bulan_tempo'] : '';
        $data['tahun_tempo'] = isset($this->session->userdata('field')['tahun_tempo']) ? $this->session->userdata('field')['tahun_tempo'] : '';
        $data['bayar'] = isset($this->session->userdata('field')['bayar']) ? $this->session->userdata('field')['bayar'] : '';
        $data['biaya'] = isset($this->session->userdata('field')['biaya']) ? $this->session->userdata('field')['biaya'] : '';
        $data['tanggal_bayar'] = isset($this->session->userdata('field')['tanggal_bayar']) ? $this->session->userdata('field')['tanggal_bayar'] : '';

        $this->load_view('spps', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_SPP');
        $data['content_title'] = "Ubah Data SPP";
        $data['breadc'] = array('menu' => "edit_spp", 'id' => $id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['spp'] = $this->spp_model->get_spp($id);
        if (empty($data['spp']))
            show_404();

        // for select
        $data['siswas'] = $this->siswa_model->get_siswa();

        // set texted field from create method
        $data['spp']['siswa_id'] = isset($this->session->userdata('field')['siswa_id']) ? $this->session->userdata('field')['siswa_id'] : $data['spp']['siswa_id'];
        $data['spp']['bulan_tempo'] = isset($this->session->userdata('field')['bulan_tempo']) ? $this->session->userdata('field')['bulan_tempo'] : $data['spp']['bulan_tempo'];
        $data['spp']['tahun_tempo'] = isset($this->session->userdata('field')['tahun_tempo']) ? $this->session->userdata('field')['tahun_tempo'] : $data['spp']['tahun_tempo'];
        $data['spp']['bayar'] = isset($this->session->userdata('field')['bayar']) ? $this->session->userdata('field')['bayar'] : $data['spp']['bayar'];
        $data['spp']['biaya'] = isset($this->session->userdata('field')['biaya']) ? $this->session->userdata('field')['biaya'] : $data['spp']['biaya'];
        $data['spp']['tanggal_bayar'] = isset($this->session->userdata('field')['tanggal_bayar']) ? $this->session->userdata('field')['tanggal_bayar'] : $data['spp']['tanggal_bayar'];
        
        $this->load_view('spps', 'edit', $data);
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new spp
    public function create() {
        $this->is_privilege('NEW_SPP');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'siswa_id', 'label' => 'Nama', 'rules' => 'trim|required|integer'),
            array('field' => 'bulan_tempo', 'label' => 'Bulan', 'rules' => 'trim|required|integer'),
            array('field' => 'tahun_tempo', 'label' => 'Tahun', 'rules' => 'trim|required|integer'),
            array('field' => 'bayar', 'label' => 'Bayar', 'rules' => 'trim|required|integer'),
            array('field' => 'biaya', 'label' => 'Biaya', 'rules' => 'trim|required|integer'),
            array('field' => 'tanggal_bayar', 'label' => 'Tanggal Bayar', 'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get spp from input.
        $siswa_id = strtoupper(trim($this->input->post('siswa_id', TRUE)));
        $bulan_tempo = trim($this->input->post('bulan_tempo', TRUE));
        $tahun_tempo = strtoupper(trim($this->input->post('tahun_tempo', TRUE)));
        $bayar = trim($this->input->post('bayar', TRUE));
        $biaya = trim($this->input->post('biaya', TRUE));
        $tanggal_bayar = trim($this->input->post('tanggal_bayar', TRUE));
        
        // user yg input
        $user_id = $this->flexi_auth->get_user_id();

        if ($this->form_validation->run()) {
            $data = array(
                'siswa_id' => $siswa_id,
                'bulan_tempo' => $bulan_tempo,
                'tahun_tempo' => $tahun_tempo,
                'bayar' => $bayar,
                'biaya' => $biaya,
                'tanggal_bayar' => $tanggal_bayar,
                
                // user_id
                'user_id' => $user_id
            );

            if ($this->spp_model->create($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data spp berhasil ditambah</div>');
                redirect('spps');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('siswa_id', form_error('siswa_id'));
        $this->session->set_flashdata('bulan_tempo', form_error('bulan_tempo'));
        $this->session->set_flashdata('tahun_tempo', form_error('tahun_tempo'));
        $this->session->set_flashdata('bayar', form_error('bayar'));
        $this->session->set_flashdata('biaya', form_error('biaya'));
        $this->session->set_flashdata('tanggal_bayar', form_error('tanggal_bayar'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'siswa_id' => $siswa_id,
            'bulan_tempo' => $bulan_tempo,
            'tahun_tempo' => $tahun_tempo,
            'bayar' => $bayar,
            'biaya' => $biaya,
            'tanggal_bayar' => $tanggal_bayar
        ));

        redirect('spps/new');
    }

    // for update spp
    public function update($id) {
        $this->is_privilege('EDIT_SPP');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'siswa_id', 'label' => 'Nama', 'rules' => 'trim|required|integer'),
            array('field' => 'bulan_tempo', 'label' => 'Bulan', 'rules' => 'trim|required|integer'),
            array('field' => 'tahun_tempo', 'label' => 'Tahun', 'rules' => 'trim|required|integer'),
            array('field' => 'bayar', 'label' => 'Bayar', 'rules' => 'trim|required|integer'),
            array('field' => 'biaya', 'label' => 'Biaya', 'rules' => 'trim|required|integer'),
            array('field' => 'tanggal_bayar', 'label' => 'Tanggal Bayar', 'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Get spp from input.
        $siswa_id = strtoupper(trim($this->input->post('siswa_id', TRUE)));
        $bulan_tempo = trim($this->input->post('bulan_tempo', TRUE));
        $tahun_tempo = strtoupper(trim($this->input->post('tahun_tempo', TRUE)));
        $bayar = trim($this->input->post('bayar', TRUE));
        $biaya = trim($this->input->post('biaya', TRUE));
        $tanggal_bayar = trim($this->input->post('tanggal_bayar', TRUE));

        if ($this->form_validation->run()) {
            $data = array(
                'siswa_id' => $siswa_id,
                'bulan_tempo' => $bulan_tempo,
                'tahun_tempo' => $tahun_tempo,
                'bayar' => $bayar,
                'biaya' => $biaya,
                'tanggal_bayar' => $tanggal_bayar
            );

            if ($this->spp_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data spp berhasil diubah</div>');
                redirect('spps/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('siswa_id', form_error('siswa_id'));
        $this->session->set_flashdata('bulan_tempo', form_error('bulan_tempo'));
        $this->session->set_flashdata('tahun_tempo', form_error('tahun_tempo'));
        $this->session->set_flashdata('bayar', form_error('bayar'));
        $this->session->set_flashdata('biaya', form_error('biaya'));
        $this->session->set_flashdata('tanggal_bayar', form_error('tanggal_bayar'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'siswa_id' => $siswa_id,
            'bulan_tempo' => $bulan_tempo,
            'tahun_tempo' => $tahun_tempo,
            'bayar' => $bayar,
            'biaya' => $biaya,
            'tanggal_bayar' => $tanggal_bayar
        ));

        redirect('spps/' . $id . '/edit');
    }

    // for delete spp with ID
    public function delete($id) {
        $this->is_privilege('DELETE_SPP');
        if ($this->spp_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data spp berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data spp gagal dihapus</div>');
        }
        redirect('spps');
    }

    // for delete spp with multiple ID
    public function deletes() {
        $this->is_privilege('DELETE_SPP');
        $affected_row = $this->input->post('ids', TRUE) ? $this->spp_model->deletes($this->input->post('ids', TRUE)) : 0;
        if ($affected_row) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                    ' data spp berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data spp gagal dihapus</div>');
        }

        redirect('spps');
    }

    // TO DO
    // validation for check unique nis, bulan, tahun
    public function nik_check($str) {
        $query = $this->db->get_where('spps', array('nik' => trim($str)));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('nik_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // TO DO
    // validation for check unique nis, bulan, tahun in update
    public function nik_check_update($str, $id) {
        $query = $this->db->get_where('spps', array('nik' => trim($str)));
        if ($query->num_rows() > 0) {
            $spp = $query->row_array();
            if (trim($id) === trim($spp['id'])) {
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
