<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of guru_kelas_matpels
 *
 * @author L745
 */
class guru_kelas_matpels extends MY_application_controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('guru_model');
        $this->load->model('guru_kelas_matpel_model');
        $this->load->model('kelas_bagian_model');
        $this->load->model('guru_mata_pelajaran_model');
        $this->load->vars('menu', 'guru_kelas_matpels');
    }
    
    // for new view
    public function new_k($guru_id) {
        $this->is_privilege('NEW_GURU');
        $data['content_title'] = "Buat Data Kelas";
        $data['breadc'] = array('menu' => "new_guru_kelas_matpel", 'guru_id' => $guru_id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['guru'] = $this->guru_model->get_guru($guru_id);
        
        // for select dropdown
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians();
        $data['guru_mata_pelajarans'] = $this->guru_mata_pelajaran_model->get_guru_mata_pelajarans($guru_id);
        
        if (empty($data['guru']))
            show_404();
        
        // set texted field from create method
        $data['guru_id'] = isset($this->session->userdata('field')['guru_id']) ? $this->session->userdata('field')['guru_id'] : $guru_id;
        $data['guru_nama'] = isset($this->session->userdata('field')['guru_nama']) ? 
                $this->session->userdata('field')['guru_nama'] : $data['guru']['nama'];
        $data['kelas_bagian_id'] = isset($this->session->userdata('field')['kelas_bagian_id']) ? 
                $this->session->userdata('field')['kelas_bagian_id'] : '';
        $data['guru_mata_pelajaran_id'] = isset($this->session->userdata('field')['guru_mata_pelajaran_id']) ? 
                $this->session->userdata('field')['guru_mata_pelajaran_id'] : '';

        $this->load_view('guru_kelas_matpels', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_GURU');
        $data['content_title'] = "Ubah Data Kelas";
        
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['guru_kelas_matpel'] = $this->guru_kelas_matpel_model->get_guru_kelas_matpel($id);
        if (empty($data['guru_kelas_matpel']))
            show_404();
        $data['guru'] = $this->guru_model->get_guru($data['guru_kelas_matpel']['guru_id']);
        if (empty($data['guru']))
            show_404();
        
        // for select dropdown
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians();
        $data['guru_mata_pelajarans'] = $this->guru_mata_pelajaran_model->get_guru_mata_pelajarans($data['guru']['id']);
        
        $data['breadc'] = array('menu' => "edit_guru_kelas_matpel", 'id' => $id, 'guru_id' => $data['guru']['id']);
        
        // set texted field from update method
        $data['guru_kelas_matpel']['kelas_bagian_id'] = isset($this->session->userdata('field')['kelas_bagian_id']) ? 
                $this->session->userdata('field')['kelas_bagian_id'] : '';
        $data['guru_kelas_matpel']['guru_mata_pelajaran_id'] = isset($this->session->userdata('field')['guru_mata_pelajaran_id']) ? 
                $this->session->userdata('field')['guru_mata_pelajaran_id'] : '';
        
        $this->load_view('guru_kelas_matpels', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new guru_kelas_matpel
    public function create($guru_id) {
        $this->is_privilege('NEW_GURU');
        $this->load->library('form_validation');
        
        // Get guru_kelas_matpel from input.
        $guru_id = trim($this->input->post('guru_id', TRUE));
        $kelas_bagian_id = trim($this->input->post('kelas_bagian_id', TRUE));
        $guru_mata_pelajaran_id = trim($this->input->post('guru_mata_pelajaran_id', TRUE));
        $guru = $this->guru_model->get_guru($guru_id);
        if (empty($guru))
            show_404();
        $guru_nama = $guru['nama'];
        
        $validation_rules = array(
            array('field' => 'guru_id', 'label' => 'Guru',
                'rules' => 'trim|required|integer'),
            array('field' => 'kelas_bagian_id', 'label' => 'Kelas',
                'rules' => 'trim|required|integer|callback_unique_check['.$guru_mata_pelajaran_id.']'),
            array('field' => 'guru_mata_pelajaran_id', 'label' => 'Mata Pelajaran',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'guru_id' => $guru_id,
                'kelas_bagian_id' => $kelas_bagian_id,
                'guru_mata_pelajaran_id' => $guru_mata_pelajaran_id
            );

            if ($this->guru_kelas_matpel_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data kelas berhasil ditambah</div>');
                redirect('gurus/'.$guru_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('guru_id', form_error('guru_id'));
        $this->session->set_flashdata('guru_mata_pelajaran_id', form_error('guru_mata_pelajaran_id'));
        $this->session->set_flashdata('kelas_bagian_id', form_error('kelas_bagian_id'));

        // capture texted field
        $this->session->set_userdata('field', 
                array('guru_id' => $guru_id, 'guru_nama' => $guru_nama,
                    'guru_mata_pelajaran_id' => $guru_mata_pelajaran_id, 
                    'kelas_bagian_id' => $kelas_bagian_id));

        redirect('gurukelasmatpels/new/'.$guru_id);
    }

    // for update guru_kelas_matpel
    public function update($id) {
        $this->is_privilege('EDIT_GURU');
        $this->load->library('form_validation');
        
        // Get guru_kelas_matpel from input.
        $guru_id = trim($this->input->post('guru_id', TRUE));
        $kelas_bagian_id = trim($this->input->post('kelas_bagian_id', TRUE));
        $guru_mata_pelajaran_id = trim($this->input->post('guru_mata_pelajaran_id', TRUE));
        $guru = $this->guru_model->get_guru($guru_id);
        if (empty($guru))
            show_404();
        $guru_nama = $guru['nama'];
        
        $ids = array('guru_mata_pelajaran_id' => $guru_mata_pelajaran_id, 'id' => $id);

        $validation_rules = array(
            array('field' => 'guru_id', 'label' => 'Guru',
                'rules' => 'trim|required|integer'),
            array('field' => 'kelas_bagian_id', 'label' => 'Kelas',
                'rules' => 'trim|required|integer|callback_unique_check_update['.implode(',',$ids).']'),
            array('field' => 'guru_mata_pelajaran_id', 'label' => 'Mata Pelajaran',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'guru_id' => $guru_id,
                'kelas_bagian_id' => $kelas_bagian_id,
                'guru_mata_pelajaran_id' => $guru_mata_pelajaran_id
            );

            if ($this->guru_kelas_matpel_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data kelas berhasil diubah</div>');
                redirect('gurus/' . $guru_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('guru_id', form_error('guru_id'));
        $this->session->set_flashdata('guru_mata_pelajaran_id', form_error('guru_mata_pelajaran_id'));
        $this->session->set_flashdata('kelas_bagian_id', form_error('kelas_bagian_id'));

        // capture texted field
        $this->session->set_userdata('field', 
                array('guru_id' => $guru_id, 'guru_nama' => $guru_nama,
                    'guru_mata_pelajaran_id' => $guru_mata_pelajaran_id, 
                    'kelas_bagian_id' => $kelas_bagian_id));
        
        redirect('gurukelasmatpels/' . $id . '/edit');
    }
    
    // for delete kelas bagian with ID
    public function delete($id) {
        $this->is_privilege('DELETE_GURU');
        $guru_id = $this->guru_kelas_matpel_model->get_guru_kelas_matpel($id)['guru_id'];
        if ($this->guru_kelas_matpel_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kelas berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kelas gagal dihapus</div>');
        }
        redirect('gurus/'.$guru_id);
    }

    // for delete kelas bagian with multiple ID
    public function deletes($guru_id) {
        $this->is_privilege('DELETE_GURU');
        $affected_row = $this->input->post('ids', TRUE) ? $this->guru_kelas_matpel_model->deletes($this->input->post('ids', TRUE)) : 0;
        $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data kelas berhasil dihapus</div>');
        redirect('gurus/'.$guru_id);
    }
    
    // validation for check unique group selection
    public function unique_check($kelas_bagian_id, $guru_mata_pelajaran_id) {
        $query = $this->guru_kelas_matpel_model->unique_check($kelas_bagian_id, $guru_mata_pelajaran_id);
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('unique_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique group selection in update
    public function unique_check_update($str, $ids) {
        $ids = explode(',', $ids);
        $query = $this->guru_kelas_matpel_model->unique_check($str, $ids[0]);
        if ($query->num_rows() > 0) {
            $guru_kelas_matpel = $query->row_array();
            if (trim($ids[1]) === trim($guru_kelas_matpel['id'])) {
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
