<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of guru_mata_pelajarans
 *
 * @author L745
 */
class guru_mata_pelajarans extends MY_application_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('guru_model');
        $this->load->model('guru_mata_pelajaran_model');
        $this->load->model('mata_pelajaran_model');
        $this->load->model('kurikulum_model');
        $this->load->model('tahun_ajaran_model');
        $this->load->vars('menu', 'guru_mata_pelajarans');
    }

    // for new view
    public function new_k($guru_id) {
        $this->is_privilege('NEW_GURU');
        $data['content_title'] = "Buat Data Mata Pelajaran";
        $data['breadc'] = array('menu' => "new_guru_mata_pelajaran", 'guru_id' => $guru_id);
        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['guru'] = $this->guru_model->get_guru($guru_id);

        // for select dropdown
        $data['mata_pelajarans'] = $this->mata_pelajaran_model->get_mata_pelajaran();
        $data['kurikulums'] = $this->kurikulum_model->get_kurikulum();
        $data['tahun_ajarans'] = $this->tahun_ajaran_model->get_tahun_ajaran();

        if (empty($data['guru']))
            show_404();

        // set texted field from create method
        $data['guru_id'] = isset($this->session->userdata('field')['guru_id']) ? $this->session->userdata('field')['guru_id'] : $guru_id;
        $data['guru_nama'] = isset($this->session->userdata('field')['guru_nama']) ?
                $this->session->userdata('field')['guru_nama'] : $data['guru']['nama'];
        $data['mata_pelajaran_id'] = isset($this->session->userdata('field')['mata_pelajaran_id']) ?
                $this->session->userdata('field')['mata_pelajaran_id'] : '';
        $data['kurikulum_id'] = isset($this->session->userdata('field')['kurikulum_id']) ?
                $this->session->userdata('field')['kurikulum_id'] : '';
        $data['tahun_ajaran_id'] = isset($this->session->userdata('field')['tahun_ajaran_id']) ?
                $this->session->userdata('field')['tahun_ajaran_id'] : '';
        $data['semester'] = isset($this->session->userdata('field')['tahun_ajaran_id']) ?
                $this->session->userdata('field')['semester'] : '';

        $this->load_view('guru_mata_pelajarans', 'new', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for edit view
    public function edit($id) {
        $this->is_privilege('EDIT_GURU');
        $data['content_title'] = "Ubah Data Mata Pelajaran";

        $data['title'] = $this->load->get_var('web_title') . " - " . $data['content_title'];
        $data['guru_mata_pelajaran'] = $this->guru_mata_pelajaran_model->get_guru_mata_pelajaran($id);

        // for select dropdown
        $data['mata_pelajarans'] = $this->mata_pelajaran_model->get_mata_pelajaran();
        $data['kurikulums'] = $this->kurikulum_model->get_kurikulum();
        $data['tahun_ajarans'] = $this->tahun_ajaran_model->get_tahun_ajaran();

        if (empty($data['guru_mata_pelajaran']))
            show_404();
        $data['guru'] = $this->guru_model->get_guru($data['guru_mata_pelajaran']['guru_id']);
        if (empty($data['guru']))
            show_404();
        $data['breadc'] = array('menu' => "edit_guru_mata_pelajaran", 'id' => $id, 'guru_id' => $data['guru']['id']);

        // set texted field from update method
        $data['guru_mata_pelajaran']['mata_pelajaran_id'] = isset($this->session->userdata('field')['mata_pelajaran_id']) ?
                $this->session->userdata('field')['mata_pelajaran_id'] : $data['guru_mata_pelajaran']['mata_pelajaran_id'];
        $data['guru_mata_pelajaran']['kurikulum_id'] = isset($this->session->userdata('field')['kurikulum_id']) ?
                $this->session->userdata('field')['kurikulum_id'] : $data['guru_mata_pelajaran']['kurikulum_id'];
        $data['guru_mata_pelajaran']['tahun_ajaran_id'] = isset($this->session->userdata('field')['tahun_ajaran_id']) ?
                $this->session->userdata('field')['tahun_ajaran_id'] : $data['guru_mata_pelajaran']['tahun_ajaran_id'];
        $data['guru_mata_pelajaran']['semester'] = isset($this->session->userdata('field')['semester']) ?
                $this->session->userdata('field')['semester'] : $data['guru_mata_pelajaran']['semester'];

        $this->load_view('guru_mata_pelajarans', 'edit', $data);

        // unset session field data when error from method create
        $this->session->unset_userdata('field');
    }

    // for create new guru_mata_pelajaran
    public function create($guru_id) {
        $this->is_privilege('NEW_GURU');
        $this->load->library('form_validation');

        // Get guru_mata_pelajaran from input.
        $guru_id = trim($this->input->post('guru_id', TRUE));
        $mata_pelajaran_id = trim($this->input->post('mata_pelajaran_id', TRUE));
        $kurikulum_id = trim($this->input->post('kurikulum_id', TRUE));
        $tahun_ajaran_id = trim($this->input->post('tahun_ajaran_id', TRUE));
        $semester = trim($this->input->post('semester', TRUE));
        $guru = $this->guru_model->get_guru($guru_id);
        if (empty($guru))
            show_404();
        $guru_nama = $guru['nama'];

        $ids = array('guru_id' => $guru_id,
            'tahun_ajaran_id' => $tahun_ajaran_id,
            'semester' => $semester);

        $validation_rules = array(
            array('field' => 'guru_id', 'label' => 'Guru',
                'rules' => 'trim|required|integer'),
            array('field' => 'mata_pelajaran_id', 'label' => 'Mata Pelajaran',
                'rules' => 'trim|required|integer|callback_unique_check['.implode(',',$ids).']'),
            array('field' => 'kurikulum_id', 'label' => 'Kurikulum',
                'rules' => 'trim|required|integer'),
            array('field' => 'tahun_ajaran_id', 'label' => 'Tahun Ajaran',
                'rules' => 'trim|required|integer'),
            array('field' => 'semester', 'label' => 'Semester',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'guru_id' => $guru_id,
                'mata_pelajaran_id' => $mata_pelajaran_id,
                'kurikulum_id' => $kurikulum_id,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'semester' => $semester
            );

            if ($this->guru_mata_pelajaran_model->create($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data mata pelajaran berhasil ditambah</div>');
                redirect('gurus/' . $guru_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('guru_id', form_error('guru_id'));
        $this->session->set_flashdata('mata_pelajaran_id', form_error('mata_pelajaran_id'));
        $this->session->set_flashdata('kurikulum_id', form_error('kurikulum_id'));
        $this->session->set_flashdata('tahun_ajaran_id', form_error('tahun_ajaran_id'));
        $this->session->set_flashdata('semester', form_error('semester'));

        // capture texted field
        $this->session->set_userdata('field', array('guru_id' => $guru_id, 'guru_nama' => $guru_nama,
            'mata_pelajaran_id' => $mata_pelajaran_id,
            'kurikulum_id' => $kurikulum_id, 'semester' => $semester,
            'tahun_ajaran_id' => $tahun_ajaran_id));

        redirect('gurumatapelajarans/new/'.$guru_id);
    }

    // for update guru_mata_pelajaran
    public function update($id) {
        $this->is_privilege('EDIT_GURU');
        $this->load->library('form_validation');

        // Get guru_mata_pelajaran from input.
        $guru_id = trim($this->input->post('guru_id', TRUE));
        $mata_pelajaran_id = trim($this->input->post('mata_pelajaran_id', TRUE));
        $kurikulum_id = trim($this->input->post('kurikulum_id', TRUE));
        $tahun_ajaran_id = trim($this->input->post('tahun_ajaran_id', TRUE));
        $semester = trim($this->input->post('semester', TRUE));
        $guru = $this->guru_model->get_guru($guru_id);
        if (empty($guru))
            show_404();
        $guru_nama = $guru['nama'];
        
        $ids = array('guru_id' => $guru_id,
            'tahun_ajaran_id' => $tahun_ajaran_id,
            'semester' => $semester, 'id' => $id);

        $validation_rules = array(
            array('field' => 'guru_id', 'label' => 'Guru',
                'rules' => 'trim|required|integer'),
            array('field' => 'mata_pelajaran_id', 'label' => 'Mata Pelajaran',
                'rules' => 'trim|required|integer|callback_unique_check_update['.implode(',',$ids).']'),
            array('field' => 'kurikulum_id', 'label' => 'Kurikulum',
                'rules' => 'trim|required|integer'),
            array('field' => 'tahun_ajaran_id', 'label' => 'Tahun Ajaran',
                'rules' => 'trim|required|integer'),
            array('field' => 'semester', 'label' => 'Semester',
                'rules' => 'trim|required|integer')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $data = array(
                'guru_id' => $guru_id,
                'mata_pelajaran_id' => $mata_pelajaran_id,
                'kurikulum_id' => $kurikulum_id,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'semester' => $semester
            );

            if ($this->guru_mata_pelajaran_model->update($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">' .
                        '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                        'Data mata pelajaran berhasil diubah</div>');
                redirect('gurus/' . $guru_id);
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="alert alert-error">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>', '</div>');
        $this->session->set_flashdata('message', $this->data['message']);
        $this->session->set_flashdata('guru_id', form_error('guru_id'));
        $this->session->set_flashdata('mata_pelajaran_id', form_error('mata_pelajaran_id'));
        $this->session->set_flashdata('kurikulum_id', form_error('kurikulum_id'));
        $this->session->set_flashdata('tahun_ajaran_id', form_error('tahun_ajaran_id'));
        $this->session->set_flashdata('semester', form_error('semester'));

        // capture texted field
        $this->session->set_userdata('field', array('guru_id' => $guru_id, 'guru_nama' => $guru_nama,
            'mata_pelajaran_id' => $mata_pelajaran_id,
            'kurikulum_id' => $kurikulum_id, 'semester' => $semester,
            'tahun_ajaran_id' => $tahun_ajaran_id));

        redirect('gurumatapelajarans/' . $id . '/edit');
    }

    // for delete kelas bagian with ID
    public function delete($id) {
        $this->is_privilege('DELETE_GURU');
        $guru_id = $this->guru_mata_pelajaran_model->get_guru_mata_pelajaran($id)['guru_id'];
        if ($this->guru_mata_pelajaran_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data mata pelajaran berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert">' .
                    '<a class="close" data-dismiss="alert" href="#">&times;</a>' .
                    'Data mata pelajaran gagal dihapus</div>');
        }
        redirect('gurus/' . $guru_id);
    }

    // for delete kelas bagian with multiple ID
    public function deletes($guru_id) {
        $this->is_privilege('DELETE_GURU');
        $affected_row = $this->input->post('ids', TRUE) ? $this->guru_mata_pelajaran_model->deletes($this->input->post('ids', TRUE)) : 0;
        $this->session->set_flashdata('message', '<div class="alert alert-info">' .
                '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $affected_row .
                ' data mata pelajaran berhasil dihapus</div>');
        redirect('gurus/' . $guru_id);
    }

    // validation for check unique group selection
    public function unique_check($mata_pelajaran_id, $ids) {
        $ids = explode(',', $ids);
        $query = $this->guru_mata_pelajaran_model->unique_check($mata_pelajaran_id, $ids[0], $ids[1], $ids[2]);
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('unique_check', 'Field %s sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // validation for check unique group selection in update
    public function unique_check_update($mata_pelajaran_id, $ids) {
        $ids = explode(',', $ids);
        $query = $this->guru_mata_pelajaran_model->unique_check($mata_pelajaran_id, $ids[0], $ids[1], $ids[2]);
        if ($query->num_rows() > 0) {
            $guru_matpel = $query->row_array();
            if (trim($ids[3]) === trim($guru_matpel['id'])) {
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
