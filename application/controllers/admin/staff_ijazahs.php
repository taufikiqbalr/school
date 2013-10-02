<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of staff_ijazahs
 *
 * @author L745
 */
class staff_ijazahs extends MY_application_controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('staff_model');
        $this->load->model('staff_ijazah_model');
        $this->load->vars('menu', 'staff_ijazahs');
    }
    
    // for new view
    public function new_k($staff_id) {
        $this->is_privilege('NEW_STAFF');
        $data['content_title'] = "Buat Data Ijazah";
        $data['breadc'] = array('menu' => "new_staff_ijazah", 'staff_id' => $staff_id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['staff'] = $this->staff_model->get_staff($staff_id);
        
        if (empty($data['staff']))
            show_404();
        
        // set texted field from create method
        $data['staff_id'] = isset($this->session->userdata('field')['staff_id']) ? $this->session->userdata('field')['staff_id'] : $staff_id;
        $data['staff_nama'] = isset($this->session->userdata('field')['staff_nama']) ? 
                $this->session->userdata('field')['staff_nama'] : $data['staff']['nama'];
        $data['nama_instansi'] = isset($this->session->userdata('field')['nama_instansi']) ? 
                $this->session->userdata('field')['nama_instansi'] : '';
        $data['tingkat'] = isset($this->session->userdata('field')['tingkat']) ? 
                $this->session->userdata('field')['tingkat'] : '';
        $data['nama_gelar'] = isset($this->session->userdata('field')['nama_gelar']) ? 
                $this->session->userdata('field')['nama_gelar'] : '';

        $this->load_view('staff_ijazahs', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_STAFF');
        $data['content_title'] = "Ubah Data Ijazah";
        
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['staff_ijazah'] = $this->staff_ijazah_model->get_staff_ijazah($id);
        
        if (empty($data['staff_ijazah']))
            show_404();
        $data['staff'] = $this->staff_model->get_staff($data['staff_ijazah']['staff_id']);
        if (empty($data['staff']))
            show_404();
        $data['breadc'] = array('menu' => "edit_staff_ijazah", 'id' => $id, 'staff_id' => $data['staff']['id']);
        
        // set texted field from update method
        $data['staff_ijazah']['nama_instansi'] = isset($this->session->userdata('field')['nama_instansi']) ? 
                $this->session->userdata('field')['nama_instansi'] : $data['staff_ijazah']['nama_instansi'];
        $data['staff_ijazah']['tingkat'] = isset($this->session->userdata('field')['tingkat']) ? 
                $this->session->userdata('field')['tingkat'] : $data['staff_ijazah']['tingkat'];
        $data['staff_ijazah']['nama_gelar'] = isset($this->session->userdata('field')['nama_gelar']) ? 
                $this->session->userdata('field')['nama_gelar'] : $data['staff_ijazah']['nama_gelar'];
        
        $this->load_view('staff_ijazahs', 'edit', $data);
        
        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new staff_ijazah
    public function create($staff_id) {
        $this->is_privilege('NEW_STAFF');
        $this->load->library('form_validation');
        
        // Get staff_ijazah from input.
        $staff_id = trim($this->input->post('staff_id', TRUE));
        $nama_instansi = strtoupper(trim($this->input->post('nama_instansi', TRUE)));
        $tingkat = strtoupper(trim($this->input->post('tingkat', TRUE)));
        $nama_gelar = trim($this->input->post('nama_gelar', TRUE));
        $staff = $this->staff_model->get_staff($staff_id);
        if (empty($staff))
            show_404();
        $staff_nama = $staff['nama'];

        $validation_rules = array(
            array('field' => 'staff_id', 'label' => 'Staff',
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
                'staff_id' => $staff_id,
                'nama_instansi' => $nama_instansi,
                'nama_gelar' => $nama_gelar,
                'tingkat' => $tingkat
            );

            if ($this->staff_ijazah_model->create($data)) {
                $this->session->set_flashdata('message',
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data ijazah berhasil ditambah</div>');
                redirect('staffs/'.$staff_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('staff_id', form_error('staff_id'));
        $this->session->set_flashdata('nama_instansi', form_error('nama_instansi'));
        $this->session->set_flashdata('tingkat', form_error('tingkat'));
        $this->session->set_flashdata('nama_gelar', form_error('nama_gelar'));

        // capture texted field
        $this->session->set_userdata('field', 
                array('staff_id' => $staff_id, 'staff_nama' => $staff_nama,
                    'nama_instansi' => $nama_instansi, 
                    'nama_gelar' => $nama_gelar, 'tingkat' => $tingkat));

        redirect('staffijazahs/new/'.$staff_id);
    }

    // for update staff_ijazah
    public function update($id) {
        $this->is_privilege('EDIT_STAFF');
        $this->load->library('form_validation');
        
        // Get staff_ijazah from input.
        $staff_id = trim($this->input->post('staff_id', TRUE));
        $nama_instansi = strtoupper(trim($this->input->post('nama_instansi', TRUE)));
        $tingkat = strtoupper(trim($this->input->post('tingkat', TRUE)));
        $nama_gelar = trim($this->input->post('nama_gelar', TRUE));
        $staff = $this->staff_model->get_staff($staff_id);
        if (empty($staff))
            show_404();
        $staff_nama = $staff['nama'];

        $validation_rules = array(
            array('field' => 'staff_id', 'label' => 'Staff',
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
                'staff_id' => $staff_id,
                'nama_instansi' => $nama_instansi,
                'nama_gelar' => $nama_gelar,
                'tingkat' => $tingkat
            );

            if ($this->staff_ijazah_model->update($id, $data)) {
                $this->session->set_flashdata('message', 
                        '<div class="alert alert-success">'.
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                        'Data ijazah berhasil diubah</div>');
                redirect('staffs/' . $staff_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('staff_id', form_error('staff_id'));
        $this->session->set_flashdata('nama_instansi', form_error('nama_instansi'));
        $this->session->set_flashdata('tingkat', form_error('tingkat'));
        $this->session->set_flashdata('nama_gelar', form_error('nama_gelar'));

        // capture texted field
        $this->session->set_userdata('field', 
                array('staff_id' => $staff_id, 'staff_nama' => $staff_nama,
                    'nama_instansi' => $nama_instansi, 
                    'nama_gelar' => $nama_gelar, 'tingkat' => $tingkat));
        
        redirect('staffijazahs/' . $id . '/edit');
    }
    
    // for delete kelas bagian with ID
    public function delete($id) {
        $this->is_privilege('DELETE_STAFF');
        $staff_id = $this->staff_ijazah_model->get_staff_ijazah($id)['staff_id'];
        if ($this->staff_ijazah_model->delete($id)) {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-info">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data ijazah berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">'.
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>'.
                    'Data ijazah gagal dihapus</div>');
        }
        redirect('staffs/'.$staff_id);
    }

    // for delete kelas bagian with multiple ID
    public function deletes($staff_id) {
        $this->is_privilege('DELETE_STAFF');
        $affected_row = $this->input->post('ids', TRUE) ? $this->staff_ijazah_model->deletes($this->input->post('ids', TRUE)) : 0;
        $this->session->set_flashdata('message',
                '<div class="alert alert-info">'.
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data ijazah berhasil dihapus</div>');
        redirect('staffs/'.$staff_id);
    }
    
}

?>
