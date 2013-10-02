<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jurusans
 *
 * @author L745
 */
class jurusan_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('jurusans');
    }

    // get jurusan with ID
    public function get_jurusan($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get('jurusans');
            return $query->result_array();
        }
        $query = $this->db->get_where('jurusans', array('id' => $id));
        return $query->row_array();
    }
    
    public function get_id($nama) {
        $query = $this->db->get_where('jurusans', array('nama' => trim($nama)));
        $jurusan = $query->row_array();
        if(count($jurusan))
            return $jurusan['id'];
        else return '';
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond)) {
            $this->db->like('nama', $cond);
        }
        return $this->db->count_all_results('jurusans');
    }

    // get jurusan for pagination
    public function fetch_jurusans($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("nama", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nama', $cond);
        $query = $this->db->get("jurusans");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new jurusan
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('jurusans', $data);
        } else {
            return FALSE;
        }
    }

    // update jurusan
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('jurusans', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete jurusan with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM kelas WHERE jurusan_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $query = $this->db->get_where("jurusans", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('jurusans', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $query = $this->db->query("SELECT * FROM kelas WHERE jurusan_id IN (" . implode(',', $ids) . ");");
            if ($query->num_rows() > 0)
                return FALSE;
            $this->db->query("DELETE FROM jurusans WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }
    
    public function unique_check($nama) {
        $this->db->where('nama', $nama);
        return $this->db->get('jurusans');
    }
    
    public function is_unique($nama) {
        $this->db->where('nama', $nama);
        $query = $this->db->get('jurusans');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>
