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
class siswa_kelas_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('siswa_kelas');
    }

    // get siswa_kelas with ID
    public function get_siswa_kelas($id = FALSE) {
        $this->join();
        if ($id === FALSE) {
            $this->db->order_by("nis", "asc");
            $query = $this->db->get('siswa_kelas');
            return $query->result_array();
        }
        $query = $this->db->get_where('siswa_kelas', array('siswa_kelas.id' => $id));
        return $query->row_array();
    }
    
    // get wali with ID siswa
    public function get_kelas($id = FALSE) {
        $this->db->order_by("tahun_ajaran_id", "desc");
        $query = ($id === FALSE) ? 
                $this->db->get('siswa_kelas') : 
            $this->db->get_where('siswa_kelas', array('siswa_id' => $id));
        return $query->result_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        $this->join();
        if (!empty($cond)) {
            $this->db->like('nis', $cond)->
                    or_like('tingkat', $cond)->
                    or_like('nama_jurusan', $cond)->
                    or_like('nama_kelas', $cond)->
                    or_like('nama_siswa', $cond);
        }
        return $this->db->count_all_results('siswa_kelas');
    }

    // get siswa_kelas for pagination
    public function fetch_siswa_kelas($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        $this->join();
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("nis", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nis', $cond)->
                    or_like('tingkat', $cond)->
                    or_like('nama_jurusan', $cond)->
                    or_like('nama_kelas', $cond)->
                    or_like('nama_siswa', $cond);
        $query = $this->db->get("siswa_kelas");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new siswa_kelas
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('siswa_kelas', $data);
        } else {
            return FALSE;
        }
    }

    // update siswa_kelas
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('siswa_kelas', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete siswa_kelas with ID
    public function delete($id) {
        $query = $this->db->get_where("siswa_kelas", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('siswa_kelas', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM siswa_kelas WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }
    
    public function unique_check($siswa_id, $kelas_bagian_id) {
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('kelas_bagian_id', $kelas_bagian_id);
        return $this->db->get('siswa_kelas');
    }

    public function join() {
        $this->db->
                select('siswa_kelas.id AS id, 
                    siswa_kelas.siswa_id AS siswa_id,
                    siswa_kelas.kelas_bagian_id AS kelas_bagian_id,
                    siswa_kelas.tahun_ajaran_id AS tahun_ajaran_id,
                    kelas.tingkat AS tingkat, kelas_bagians.nama AS nama_kelas,
                    siswas.nis AS nis, siswas.nama AS nama_siswa,
                    jurusans.nama AS nama_jurusan')->
                join('kelas_bagians', 'kelas_bagians.id = siswa_kelas.kelas_bagian_id', 'left')->
                join('kelas', 'kelas.id = kelas_bagians.kelas_id', 'left')->
                join('siswas', 'siswas.id = siswa_kelas.siswa_id', 'left')->
                join('jurusans', 'jurusans.id = kelas.jurusan_id', 'left');
    }

}

?>
