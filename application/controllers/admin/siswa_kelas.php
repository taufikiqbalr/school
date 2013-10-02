<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswa_kelas
 *
 * @author L745
 */
class siswa_kelas extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('siswa_kelas_model');
        $this->load->model('kelas_bagian_model');
        $this->load->model('siswa_model');
        $this->load->model('tahun_ajaran_model');
        // used in script to determine menu
        $this->load->vars('menu', 'siswa_kelas');
    }

    // for new view
    public function new_k($siswa_id) {
        $this->is_privilege('NEW_KELAS_SISWA');
        $data['content_title'] = "Buat Data Kelas Siswa";
        $data['breadc'] = array('menu' => "new_siswa_kelas", 'siswa_id' => $siswa_id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['siswa'] = $this->siswa_model->get_siswa($siswa_id);
        
        // for select
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians();
        $data['tahun_ajarans'] = $this->tahun_ajaran_model->get_tahun_ajaran();
        $data['siswas'] = $this->siswa_model->get_siswa();
        
        if (empty($data['siswa']))
            show_404();
        
        // set texted field from create method
        $data['siswa_id'] = isset($this->session->userdata('field')['siswa_id']) ?
                $this->session->userdata('field')['siswa_id'] : $siswa_id;
        $data['siswa_nama'] = isset($this->session->userdata('field')['siswa_nama']) ? 
                $this->session->userdata('field')['siswa_nama'] : $data['siswa']['nama'];
        $data['kelas_bagian_id'] = isset($this->session->userdata('field')['kelas_bagian_id']) ?
                $this->session->userdata('field')['kelas_bagian_id'] : '';
        $data['tahun_ajaran_id'] = isset($this->session->userdata('field')['tahun_ajaran_id']) ? 
                $this->session->userdata('field')['tahun_ajaran_id'] : '';

        $this->load_view('siswa_kelas', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_KELAS_SISWA');
        $data['content_title'] = "Ubah Data Kelas Siswa";
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['siswa_kelas'] = $this->siswa_kelas_model->get_siswa_kelas($id);
        if (empty($data['siswa_kelas']))
            show_404();
        
        // for select
        $data['kelas_bagians'] = $this->kelas_bagian_model->get_kelas_bagians();
        $data['tahun_ajarans'] = $this->tahun_ajaran_model->get_tahun_ajaran();
        $data['siswas'] = $this->siswa_model->get_siswa();
        
        $data['siswa'] = $this->siswa_model->get_siswa($data['siswa_kelas']['siswa_id']);
        if (empty($data['siswa']))
            show_404();
        
        $data['breadc'] = array('menu' => "edit_siswa_kelas", 'id' => $id, 'siswa_id' => $data['siswa']['id']);
        
        // set texted field from update method
        $data['siswa_kelas']['siswa_id'] = isset($this->session->userdata('field')['siswa_id']) ?
                $this->session->userdata('field')['siswa_id'] : $data['siswa_kelas']['siswa_id'];
        $data['siswa_kelas']['kelas_bagian_id'] = isset($this->session->userdata('field')['kelas_bagian_id']) ?
                $this->session->userdata('field')['kelas_bagian_id'] : $data['siswa_kelas']['kelas_bagian_id'];
        $data['siswa_kelas']['tahun_ajaran_id'] = isset($this->session->userdata('field')['tahun_ajaran_id']) ? 
                $this->session->userdata('field')['tahun_ajaran_id'] : $data['siswa_kelas']['tahun_ajaran_id'];
        
        $this->load_view('siswa_kelas', 'edit', $data);

        // unset session field data when error from method update
        $this->session->unset_userdata('field');
    }

    // for create new siswa_kelas
    public function create($siswa_id) {
        $this->is_privilege('NEW_KELAS_SISWA');
        $this->load->library('form_validation');

        // Get siswa_kelas from input.
        $siswa_id = trim($this->input->post('siswa_id', TRUE));
        $kelas_bagian_id = strtoupper(trim($this->input->post('kelas_bagian_id', TRUE)));
        $tahun_ajaran_id = trim($this->input->post('tahun_ajaran_id', TRUE));
        $siswa = $this->siswa_model->get_siswa($siswa_id);
        if (empty($siswa))
            show_404();
        $siswa_nama = $siswa['nama'];
        
        $validation_rules = array(
            array('field' => 'siswa_id', 'label' => 'Siswa',
                'rules' => 'trim|required|integer|callback_unique_check['.$kelas_bagian_id.']'),
            array('field' => 'kelas_bagian_id', 'label' => 'Kelas',
                'rules' => 'trim|required|integer'),
            array('field' => 'tahun_ajaran_id', 'label' => 'Tahun Ajaran',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'siswa_id' => $siswa_id,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'kelas_bagian_id' => $kelas_bagian_id
            );

            if ($this->siswa_kelas_model->create($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data kelas siswa berhasil ditambah</div>');
                redirect('siswas/'.$siswa_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('siswa_id', form_error('siswa_id'));
        $this->session->set_flashdata('kelas_bagian_id', form_error('kelas_bagian_id'));
        $this->session->set_flashdata('tahun_ajaran_id', form_error('tahun_ajaran_id'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'siswa_id' => $siswa_id,
            'siswa_nama' => $siswa_nama,
            'tahun_ajaran_id' => $tahun_ajaran_id,
            'kelas_bagian_id' => $kelas_bagian_id
        ));

        redirect('siswakelas/new/'.$siswa_id);
    }

    // for update siswa_kelas
    public function update($id) {
        $this->is_privilege('EDIT_KELAS_SISWA');
        $this->load->library('form_validation');

        // Get siswa_kelas from input.
        $siswa_id = trim($this->input->post('siswa_id', TRUE));
        $kelas_bagian_id = strtoupper(trim($this->input->post('kelas_bagian_id', TRUE)));
        $tahun_ajaran_id = trim($this->input->post('tahun_ajaran_id', TRUE));
        $siswa = $this->siswa_model->get_siswa($siswa_id);
        if (empty($siswa))
            show_404();
        $siswa_nama = $siswa['nama'];
        
        $ids = array('kelas_bagian_id' => $kelas_bagian_id, 'id' => $id);
        
        $validation_rules = array(
            array('field' => 'siswa_id', 'label' => 'Siswa',
                'rules' => 'trim|required|integer|callback_unique_check_update['.implode(',',$ids).']'),
            array('field' => 'kelas_bagian_id', 'label' => 'Kelas',
                'rules' => 'trim|required'),
            array('field' => 'tahun_ajaran_id', 'label' => 'Tahun Ajaran',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'siswa_id' => $siswa_id,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'kelas_bagian_id' => $kelas_bagian_id
            );

            if ($this->siswa_kelas_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data kelas siswa berhasil diubah</div>');
                redirect('siswakelas/' . $id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('siswa_id', form_error('siswa_id'));
        $this->session->set_flashdata('kelas_bagian_id', form_error('kelas_bagian_id'));
        $this->session->set_flashdata('tahun_ajaran_id', form_error('tahun_ajaran_id'));

        // capture texted field
        $this->session->set_userdata('field', array(
            'siswa_id' => $siswa_id,
            'siswa_nama' => $siswa_nama,
            'tahun_ajaran_id' => $tahun_ajaran_id,
            'kelas_bagian_id' => $kelas_bagian_id
        ));

        redirect('siswakelas/' . $id . '/edit');
    }

    // for delete siswa_kelas with ID
    public function delete($id) {
        $this->is_privilege('DELETE_KELAS_SISWA');
        $siswa_id = $this->siswa_kelas_model->get_siswa_kelas($id)['siswa_id'];
        if ($this->siswa_kelas_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data kelas siswa berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data kelas siswa gagal dihapus</div>');
        }
        redirect('siswakelas/'.$siswa_id);
    }

    // for delete siswa_kelas with multiple ID
    public function deletes($siswa_id) {
        $this->is_privilege('DELETE_KELAS_SISWA');
        $affected_row = $this->input->post('ids', TRUE) ? $this->siswa_kelas_model->deletes($this->input->post('ids', TRUE)) : 0;
        if ($affected_row) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                    ' Data kelas siswa berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data kelas siswa gagal dihapus</div>');
        }
        redirect('siswakelas/'.$siswa_id);
    }
    
    // validation for check unique group selection
    public function unique_check($siswa_id, $kelas_bagian_id) {
        $query = $this->siswa_kelas_model->unique_check($siswa_id, $kelas_bagian_id);
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
        $query = $this->siswa_kelas_model->unique_check($siswa_id, $ids[0]);
        if ($query->num_rows() > 0) {
            $siswa_kelas = $query->row_array();
            if (trim($ids[1]) === trim($siswa_kelas['id'])) {
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
