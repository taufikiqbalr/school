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
class kelas_bagian_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return array_merge(
                $this->db->list_fields('kelas'), $this->db->list_fields('kelas_bagians')
        );
    }

    // get kelas bagian with ID kelas
    public function get_kelas_bagians($id = FALSE) {
        $this->db->order_by("nama", "asc");
        $query = ($id === FALSE) ?
                $this->db->get('kelas_bagians') :
                $this->db->get_where('kelas_bagians', array('kelas_id' => $id));
        return $query->result_array();
    }

    public function get_kelas_bagian($id) {
        $query = $this->db->get_where('kelas_bagians', array('id' => $id));
        return $query->row_array();
    }

    public function get_id($tingkat, $kelas) {
        $this->db->select('kelas_bagians.id AS id, kelas.tingkat AS tingkat, kelas_bagians.nama AS nama')->
                join('kelas', 'kelas.id = kelas_bagians.kelas_id', 'left')->
                where('tingkat', trim($tingkat))->where('nama', trim($kelas));
        $query = $this->db->get("kelas_bagians");
        $kelas_bagian = $query->row_array();
        if(count($kelas_bagian))
            return $kelas_bagian['id'];
        else return '';
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond)) {
            $this->db->like('nama', $cond);
//            $this->db->or_like('tingkat',$cond);
        }
        return $this->db->count_all_results('kelas_bagians');
    }

    // get kelas for pagination
    public function fetch_kelas($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("nama", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nama', $cond);
        $query = $this->db->get("kelas_bagians");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new kelas
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('kelas_bagians', $data);
        } else {
            return FALSE;
        }
    }

    // update kelas
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('kelas_bagians', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete kelas with ID
    public function delete($id) {
        $query = $this->db->get_where("kelas_bagians", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('kelas_bagians', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM kelas_bagians WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function nama_unique($nama, $kelas_id) {
        $this->db->where('nama', $nama);
        $this->db->where('kelas_id', $kelas_id);
        return $this->db->get('kelas_bagians');
    }
    
    public function is_unique($nama, $kelas_id) {
        $this->db->where('nama', $nama);
        $this->db->where('kelas_id', $kelas_id);
        $query = $this->db->get('kelas_bagians');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>
