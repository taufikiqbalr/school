<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kelas
 *
 * @author L745
 */
class kelas_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('kelas');
    }

    // get kelas with ID
    public function get_kelas($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get('kelas');
            return $query->result_array();
        }
        $query = $this->db->get_where('kelas', array('id' => $id));
        return $query->row_array();
    }

    public function get_id($tingkat, $jurusan_id) {
        $query = $this->tingkat_unique($tingkat, $jurusan_id);
        $kelas = $query->row_array();
        if (count($kelas))
            return $kelas['id'];
        else
            return '';
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond)) {
            $this->db->like('tingkat', $cond);
//            $this->db->or_like('tingkat',$cond);
        }
        return $this->db->count_all_results('kelas');
    }

    // get kelas for pagination
    public function fetch_kelas($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("tingkat", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('tingkat', $cond);
        $query = $this->db->get("kelas");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new kelas
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('kelas', $data);
        } else {
            return FALSE;
        }
    }

    // update kelas
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('kelas', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete kelas with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM kelas_bagians WHERE kelas_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $q2 = $this->db->query("SELECT * FROM mata_pelajaran_persentases WHERE kelas_id =" . $id);
        if ($q2->num_rows() > 0)
            return FALSE;
        $q3 = $this->db->query("SELECT * FROM siswa_nilais WHERE kelas_id =" . $id);
        if ($q3->num_rows() > 0)
            return FALSE;
        $query = $this->db->get_where("kelas", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('kelas', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $q1 = $this->db->query("SELECT * FROM kelas_bagians WHERE kelas_id IN (" . implode(',', $ids) . ");");
            if ($q1->num_rows() > 0)
                return FALSE;
            $q2 = $this->db->query("SELECT * FROM mata_pelajaran_persentases WHERE kelas_id IN (" . implode(',', $ids) . ");");
            if ($q2->num_rows() > 0)
                return FALSE;
            $q3 = $this->db->query("SELECT * FROM siswa_nilais WHERE kelas_id IN (" . implode(',', $ids) . ");");
            if ($q3->num_rows() > 0)
                return FALSE;
            $this->db->query("DELETE FROM kelas WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        }else {
            return 0;
        }
    }

    public function tingkat_unique($tingkat, $jurusan_id) {
        $this->db->where('tingkat', $tingkat);
        if (!empty($jurusan_id))
            $this->db->where('jurusan_id', $jurusan_id);
        else
            $this->db->where('jurusan_id', NULL);
        return $this->db->get('kelas');
    }

    public function is_unique($tingkat, $jurusan_id) {
        $this->db->where('tingkat', $tingkat);
        if (!empty($jurusan_id))
            $this->db->where('jurusan_id', $jurusan_id);
        else
            $this->db->where('jurusan_id', NULL);
        $query = $this->db->get('kelas');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function create_or_get_kelas_id($tingkat, $jurusan) {
        if (empty($tingkat))
            return '';
        $this->load->model('jurusan_model');
        $jurusan_id = NULL;
        if (!empty($jurusan)) {
            if ($this->jurusan_model->is_unique($jurusan)) {
                $this->db->insert('jurusans', array('nama' => $jurusan));
                $jurusan_id = $this->db->insert_id();
            } else {
                $jurusan_id = $this->jurusan_model->get_id($jurusan);
            }
        }
        $kelas_id = '';
        if ($this->is_unique($tingkat, $jurusan_id)) {
            $this->db->insert('kelas', array('tingkat' => $tingkat, 'jurusan_id' => $jurusan_id));
            $kelas_id = $this->db->insert_id();
        } else {
            $kelas_id = $this->get_id($tingkat, $jurusan_id);
        }
        return $kelas_id;
    }

    public function import($data) {
        $this->load->model('kelas_bagian_model');
        $kelas_bagian = array();
        $this->db->trans_begin();
        // create kelas from excel
        for ($i = 2; $i <= $data['numRows']; $i++) {
            $tingkat = strtoupper(trim($data['cells'][$i][1]));
            $jurusan = strtoupper(trim($data['cells'][$i][2]));
            $kelas_bagian['kelas_id'] = $this->create_or_get_kelas_id($tingkat, $jurusan);
            $kelas_bagian['nama'] = strtoupper(trim($data['cells'][$i][3]));
            // check validity data
            if (empty($kelas_bagian['kelas_id']) ||
                    empty($kelas_bagian['nama']) ||
                    !$this->kelas_bagian_model->is_unique($kelas_bagian['nama'], $kelas_bagian['kelas_id'])
            ) {
                $this->db->trans_rollback();
                return FALSE;
            }
            $this->kelas_bagian_model->create($kelas_bagian);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}

?>
