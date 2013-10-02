<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kelas_bagians
 *
 * @author L745
 */
class kelas_bagians extends MY_application_controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('kelas_model');
        $this->load->model('kelas_bagian_model');
        $this->load->vars('menu', 'kelas_bagians');
    }
    
    // for new view
    public function new_k($kelas_id) {
        $this->is_privilege('NEW_KELAS');
        $data['content_title'] = "Buat Kelas Bagian";
        $data['breadc'] = array('menu' => "new_kelas_bagian", 'kelas_id' => $kelas_id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['kelas'] = $this->kelas_model->get_kelas($kelas_id);
        
        if (empty($data['kelas']))
            show_404();
        // set texted field from create method
        $data['kelas_id'] = isset($this->session->userdata('field')['kelas_id']) ? $this->session->userdata('field')['kelas_id'] : $kelas_id;
        $data['kelas_tingkat'] = isset($this->session->userdata('field')['kelas_tingkat']) ? $this->session->userdata('field')['kelas_tingkat'] : $data['kelas']['tingkat'];
        $data['nama'] = isset($this->session->userdata('field')['nama']) ? $this->session->userdata('field')['nama'] : '';

        $this->load_view('kelas_bagians', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_KELAS');
        $data['content_title'] = "Ubah Kelas Bagian";
        
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['kelas_bagian'] = $this->kelas_bagian_model->get_kelas_bagian($id);
        
        if (empty($data['kelas_bagian']))
            show_404();
        $data['kelas'] = $this->kelas_model->get_kelas($data['kelas_bagian']['kelas_id']);
        if (empty($data['kelas']))
            show_404();
        $data['breadc'] = array('menu' => "edit_kelas_bagian", 'id' => $id, 'kelas_id' => $data['kelas']['id']);
        
        // set texted field from create method
        $data['kelas_id'] = isset($this->session->userdata('field')['kelas_id']) ? $this->session->userdata('field')['kelas_id'] : $data['kelas']['id'];
        $data['kelas_tingkat'] = isset($this->session->userdata('field')['kelas_tingkat']) ? $this->session->userdata('field')['kelas_tingkat'] : $data['kelas']['tingkat'];
        $data['kelas_bagian']['nama'] = isset($this->session->userdata('field')['nama']) ? $this->session->userdata('field')['nama'] : $data['kelas_bagian']['nama'];
        
        $this->load_view('kelas_bagians', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new kelas bagian
    public function create($kelas_id) {
        $this->is_privilege('NEW_KELAS');
        $this->load->library('form_validation');
        
        // Get kelas bagian from input.
        $kelas_id = trim($this->input->post('kelas_id', TRUE));
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        $kelas = $this->kelas_model->get_kelas($kelas_id);
        
        if (empty($kelas))
            show_404();
        $kelas_tingkat = $kelas['tingkat'];

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama',
                'rules' => 'trim|required|callback_nama_check[' . $kelas_id . ']'),
            array('field' => 'kelas_id', 'label' => 'Kelas',
                'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'kelas_id' => $kelas_id,
                'nama' => $nama
            );

            if ($this->kelas_bagian_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data kelas bagian berhasil ditambah</div>');
                redirect('kelas/'.$kelas_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('kelas_id', form_error('kelas_id'));
        $this->session->set_flashdata('nama', form_error('nama'));

        // capture texted field
        $this->session->set_userdata('field', 
                array('kelas_id' => $kelas_id, 'kelas_tingkat' => $kelas_tingkat,
                    'nama' => $nama));

        redirect('kelasbagians/new/'.$kelas_id);
    }

    // for update kelas bagian
    public function update($id) {
        $this->is_privilege('EDIT_KELAS');
        $this->load->library('form_validation');
        
        // Get kelas bagian from input.
        $kelas_id = trim($this->input->post('kelas_id', TRUE));
        $nama = strtoupper(trim($this->input->post('nama', TRUE)));
        
        $ids = array('kelas_id' => $kelas_id, 'id' => $id);
        
        $kelas = $this->kelas_model->get_kelas($kelas_id);
        
        if (empty($kelas))
            show_404();
        $kelas_tingkat = $kelas['tingkat'];

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama',
                'rules' => 'trim|required|callback_nama_check_update['.implode(',',$ids).']'),
            array('field' => 'kelas_id', 'label' => 'Kelas',
                'rules' => 'trim|required')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'kelas_id' => $kelas_id,
                'nama' => $nama
            );

            if ($this->kelas_bagian_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data kelas bagian berhasil diubah</div>');
                redirect('kelas/' . $kelas_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('kelas_id', form_error('kelas_id'));
        $this->session->set_flashdata('nama', form_error('nama'));
        
        // capture texted field
        $this->session->set_userdata('field', 
                array('kelas_id' => $kelas_id, 'kelas_tingkat' => $kelas_tingkat,
                    'nama' => $nama));
        
        redirect('kelasbagians/' . $id . '/edit');
    }
    
    // for delete kelas bagian with ID
    public function delete($id) {
        $this->is_privilege('DELETE_KELAS');
        $kelas_id = $this->kelas_bagian_model->get_kelas_bagian($id)['kelas_id'];
        if ($this->kelas_bagian_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kelas bagian berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data kelas bagian gagal dihapus</div>');
        }
        redirect('kelas/'.$kelas_id);
    }

    // for delete kelas bagian with multiple ID
    public function deletes($kelas_id) {
        $this->is_privilege('DELETE_KELAS');
        $affected_row = $this->input->post('ids', TRUE) ? $this->kelas_bagian_model->deletes($this->input->post('ids', TRUE)) : 0;
        $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data kelas bagian berhasil dihapus</div>');
        redirect('kelas/'.$kelas_id);
    }
    
    // validation for check unique group selection
    public function nama_check($str, $kelas_id) {
        $query = $this->kelas_bagian_model->nama_unique($str, $kelas_id);
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('nama_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique group selection in update
    public function nama_check_update($str, $ids) {
        $ids = explode(',', $ids);
        $query = $this->kelas_bagian_model->nama_unique($str, $ids[0]);
        if ($query->num_rows() > 0) {
            $kelas_bagian = $query->row_array();
            if (trim($ids[1]) === trim($kelas_bagian['id'])) {
                return TRUE;
            } else {
                $this->form_validation->set_message('nama_check_update', 'Field %s sudah ada');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }
}

?>
