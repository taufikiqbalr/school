<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mata_pelajarans
 *
 * @author L745
 */
class mata_pelajaran_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    // get column names
    public function column_names(){
        return $this->db->list_fields('mata_pelajarans');
    }

    // get mata_pelajaran with ID
    public function get_mata_pelajaran($id = FALSE) {
        if ($id === FALSE) {
            $this->db->order_by("kode", "asc");
            $query = $this->db->get('mata_pelajarans');
            return $query->result_array();
        }
        $query = $this->db->get_where('mata_pelajarans', array('id' => $id));
        return $query->row_array();
    }
    
    public function get_id($kode){
        $query = $this->db->get_where('mata_pelajarans', array('kode' => trim($kode)));
        $matpel = $query->row_array();
        if(count($matpel))
            return $matpel['id'];
        else return '';
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if(!empty($cond)) {
            $this->db->like('nama',$cond)->or_like('kode',$cond)->
                    or_like('jumlah_jam',$cond);
        }
        return $this->db->count_all_results('mata_pelajarans');
    }

    // get mata_pelajaran for pagination
    public function fetch_mata_pelajarans($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if($order === FALSE || $field === FALSE)
            $this->db->order_by("kode", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nama',$cond)->or_like('kode',$cond)->
                    or_like('jumlah_jam',$cond);
        $query = $this->db->get("mata_pelajarans");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new mata_pelajaran
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('mata_pelajarans', $data);
        } else {
            return FALSE;
        }
    }

    // update mata_pelajaran
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('mata_pelajarans', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete mata_pelajaran with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM guru_mata_pelajarans WHERE mata_pelajaran_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $q2 = $this->db->query("SELECT * FROM siswa_nilais WHERE mata_pelajaran_id =" . $id);
        if ($q2->num_rows() > 0)
            return FALSE;
        $q3 = $this->db->query("SELECT * FROM mata_pelajaran_persentases WHERE mata_pelajaran_id =" . $id);
        if ($q3->num_rows() > 0)
            return FALSE;
        $query = $this->db->get_where("mata_pelajarans", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('mata_pelajarans', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $q1 = $this->db->query("SELECT * FROM guru_mata_pelajarans WHERE mata_pelajaran_id IN (" . implode(',', $ids) . ");");
            if ($q1->num_rows() > 0)
                return FALSE;
            $q2 = $this->db->query("SELECT * FROM siswa_nilais WHERE mata_pelajaran_id IN (" . implode(',', $ids) . ");");
            if ($q2->num_rows() > 0)
                return FALSE;
            $q3 = $this->db->query("SELECT * FROM mata_pelajaran_persentases WHERE mata_pelajaran_id IN (" . implode(',', $ids) . ");");
            if ($q3->num_rows() > 0)
                return FALSE;
            $this->db->query("DELETE FROM mata_pelajarans WHERE id IN (".implode(',',$ids).");");
            return $this->db->affected_rows();
        }else{
            return 0;
        }
    }

}

?>
