<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of guru_ijazahs
 *
 * @author L745
 */
class guru_ijazahs extends MY_application_controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('guru_model');
        $this->load->model('guru_ijazah_model');
        $this->load->vars('menu', 'guru_ijazahs');
    }
    
    // for new view
    public function new_k($guru_id) {
        $this->is_privilege('NEW_GURU');
        $data['content_title'] = "Buat Data Ijazah";
        $data['breadc'] = array('menu' => "new_guru_ijazah", 'guru_id' => $guru_id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['guru'] = $this->guru_model->get_guru($guru_id);
        
        if (empty($data['guru']))
            show_404();
        
        // set texted field from create method
        $data['guru_id'] = isset($this->session->userdata('field')['guru_id']) ? $this->session->userdata('field')['guru_id'] : $guru_id;
        $data['guru_nama'] = isset($this->session->userdata('field')['guru_nama']) ? 
                $this->session->userdata('field')['guru_nama'] : $data['guru']['nama'];
        $data['nama_instansi'] = isset($this->session->userdata('field')['nama_instansi']) ? 
                $this->session->userdata('field')['nama_instansi'] : '';
        $data['tingkat'] = isset($this->session->userdata('field')['tingkat']) ? 
                $this->session->userdata('field')['tingkat'] : '';
        $data['nama_gelar'] = isset($this->session->userdata('field')['nama_gelar']) ? 
                $this->session->userdata('field')['nama_gelar'] : '';

        $this->load_view('guru_ijazahs', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_GURU');
        $data['content_title'] = "Ubah Data Ijazah";
        
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['guru_ijazah'] = $this->guru_ijazah_model->get_guru_ijazah($id);
        
        if (empty($data['guru_ijazah']))
            show_404();
        $data['guru'] = $this->guru_model->get_guru($data['guru_ijazah']['guru_id']);
        if (empty($data['guru']))
            show_404();
        $data['breadc'] = array('menu' => "edit_guru_ijazah", 'id' => $id, 'guru_id' => $data['guru']['id']);
        
        // set texted field from update method
        $data['guru_ijazah']['nama_instansi'] = isset($this->session->userdata('field')['nama_instansi']) ? 
                $this->session->userdata('field')['nama_instansi'] : $data['guru_ijazah']['nama_instansi'];
        $data['guru_ijazah']['tingkat'] = isset($this->session->userdata('field')['tingkat']) ? 
                $this->session->userdata('field')['tingkat'] : $data['guru_ijazah']['tingkat'];
        $data['guru_ijazah']['nama_gelar'] = isset($this->session->userdata('field')['nama_gelar']) ? 
                $this->session->userdata('field')['nama_gelar'] : $data['guru_ijazah']['nama_gelar'];
        
        $this->load_view('guru_ijazahs', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new guru_ijazah
    public function create($guru_id) {
        $this->is_privilege('NEW_GURU');
        $this->load->library('form_validation');
        
        // Get guru_ijazah from input.
        $guru_id = trim($this->input->post('guru_id', TRUE));
        $nama_instansi = strtoupper(trim($this->input->post('nama_instansi', TRUE)));
        $tingkat = strtoupper(trim($this->input->post('tingkat', TRUE)));
        $nama_gelar = trim($this->input->post('nama_gelar', TRUE));
        $guru = $this->guru_model->get_guru($guru_id);
        if (empty($guru))
            show_404();
        $guru_nama = $guru['nama'];

        $validation_rules = array(
            array('field' => 'guru_id', 'label' => 'Guru',
                'rules' => 'trim|required'),
            array('field' => 'nama_instansi', 'label' => 'Nama Instansi',
                'rules' => 'trim|required'),
            array('field' => 'tingkat', 'label' => 'Tingkat',
                'rules' => 'trim|required'),
            array('field' => 'nama_gelar', 'label' => 'Nama Gelar',
                'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'guru_id' => $guru_id,
                'nama_instansi' => $nama_instansi,
                'nama_gelar' => $nama_gelar,
                'tingkat' => $tingkat
            );

            if ($this->guru_ijazah_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data ijazah berhasil ditambah</div>');
                redirect('gurus/'.$guru_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('guru_id', form_error('guru_id'));
        $this->session->set_flashdata('nama_instansi', form_error('nama_instansi'));
        $this->session->set_flashdata('tingkat', form_error('tingkat'));
        $this->session->set_flashdata('nama_gelar', form_error('nama_gelar'));

        // capture texted field
        $this->session->set_userdata('field', 
                array('guru_id' => $guru_id, 'guru_nama' => $guru_nama,
                    'nama_instansi' => $nama_instansi, 
                    'nama_gelar' => $nama_gelar, 'tingkat' => $tingkat));

        redirect('guruijazahs/new/'.$guru_id);
    }

    // for update guru_ijazah
    public function update($id) {
        $this->is_privilege('EDIT_GURU');
        $this->load->library('form_validation');
        
        // Get guru_ijazah from input.
        $guru_id = trim($this->input->post('guru_id', TRUE));
        $nama_instansi = strtoupper(trim($this->input->post('nama_instansi', TRUE)));
        $tingkat = strtoupper(trim($this->input->post('tingkat', TRUE)));
        $nama_gelar = trim($this->input->post('nama_gelar', TRUE));
        $guru = $this->guru_model->get_guru($guru_id);
        if (empty($guru))
            show_404();
        $guru_nama = $guru['nama'];

        $validation_rules = array(
            array('field' => 'guru_id', 'label' => 'Guru',
                'rules' => 'trim|required'),
            array('field' => 'nama_instansi', 'label' => 'Nama Instansi',
                'rules' => 'trim|required'),
            array('field' => 'tingkat', 'label' => 'Tingkat',
                'rules' => 'trim|required'),
            array('field' => 'nama_gelar', 'label' => 'Nama Gelar',
                'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'guru_id' => $guru_id,
                'nama_instansi' => $nama_instansi,
                'nama_gelar' => $nama_gelar,
                'tingkat' => $tingkat
            );

            if ($this->guru_ijazah_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data ijazah berhasil diubah</div>');
                redirect('gurus/' . $guru_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('guru_id', form_error('guru_id'));
        $this->session->set_flashdata('nama_instansi', form_error('nama_instansi'));
        $this->session->set_flashdata('tingkat', form_error('tingkat'));
        $this->session->set_flashdata('nama_gelar', form_error('nama_gelar'));

        // capture texted field
        $this->session->set_userdata('field', 
                array('guru_id' => $guru_id, 'guru_nama' => $guru_nama,
                    'nama_instansi' => $nama_instansi, 
                    'nama_gelar' => $nama_gelar, 'tingkat' => $tingkat));
        
        redirect('guruijazahs/' . $id . '/edit');
    }
    
    // for delete kelas bagian with ID
    public function delete($id) {
        $this->is_privilege('DELETE_GURU');
        $guru_id = $this->guru_ijazah_model->get_guru_ijazah($id)['guru_id'];
        if ($this->guru_ijazah_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data ijazah berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data ijazah gagal dihapus</div>');
        }
        redirect('gurus/'.$guru_id);
    }

    // for delete kelas bagian with multiple ID
    public function deletes($guru_id) {
        $this->is_privilege('DELETE_GURU');
        $affected_row = $this->input->post('ids', TRUE) ? $this->guru_ijazah_model->deletes($this->input->post('ids', TRUE)) : 0;
        $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data ijazah berhasil dihapus</div>');
        redirect('gurus/'.$guru_id);
    }
    
}

?>
