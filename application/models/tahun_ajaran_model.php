<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tahun_ajarans
 *
 * @author L745
 */
class tahun_ajaran_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    // get column names
    public function column_names(){
        return $this->db->list_fields('tahun_ajarans');
    }

    // get tahun_ajaran with ID
    public function get_tahun_ajaran($id = FALSE) {
        if ($id === FALSE) {
            $this->db->order_by("nama", "desc");
            $query = $this->db->get('tahun_ajarans');
            return $query->result_array();
        }
        $query = $this->db->get_where('tahun_ajarans', array('id' => $id));
        return $query->row_array();
    }
    
    public function get_id($tahun){
        $query = $this->db->get_where('tahun_ajarans', array('nama' => trim($tahun)));
        $tahun_ajaran = $query->row_array();
        if(count($tahun_ajaran))
            return $tahun_ajaran['id'];
        else return '';
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if(!empty($cond)) {
            $this->db->like('nama',$cond);
        }
        return $this->db->count_all_results('tahun_ajarans');
    }

    // get tahun_ajaran for pagination
    public function fetch_tahun_ajarans($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if($order === FALSE || $field === FALSE)
            $this->db->order_by("nama", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nama',$cond);
        $query = $this->db->get("tahun_ajarans");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new tahun_ajaran
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('tahun_ajarans', $data);
        } else {
            return FALSE;
        }
    }

    // update tahun_ajaran
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('tahun_ajarans', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete tahun_ajaran with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM guru_walis WHERE tahun_ajaran_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $q2 = $this->db->query("SELECT * FROM guru_mata_pelajarans WHERE tahun_ajaran_id =" . $id);
        if ($q2->num_rows() > 0)
            return FALSE;
        $q3 = $this->db->query("SELECT * FROM absensis WHERE tahun_ajaran_id =" . $id);
        if ($q3->num_rows() > 0)
            return FALSE;
        $q4 = $this->db->query("SELECT * FROM mata_pelajaran_persentases WHERE tahun_ajaran_id =" . $id);
        if ($q4->num_rows() > 0)
            return FALSE;
        $query = $this->db->get_where("tahun_ajarans", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('tahun_ajarans', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $q1 = $this->db->query("SELECT * FROM guru_walis WHERE tahun_ajaran_id IN (" . implode(',', $ids) . ");");
            if ($q1->num_rows() > 0)
                return FALSE;
            $q2 = $this->db->query("SELECT * FROM guru_mata_pelajarans WHERE tahun_ajaran_id IN (" . implode(',', $ids) . ");");
            if ($q2->num_rows() > 0)
                return FALSE;
            $q3 = $this->db->query("SELECT * FROM absensis WHERE tahun_ajaran_id IN (" . implode(',', $ids) . ");");
            if ($q3->num_rows() > 0)
                return FALSE;
            $q4 = $this->db->query("SELECT * FROM mata_pelajaran_persentases WHERE tahun_ajaran_id IN (" . implode(',', $ids) . ");");
            if ($q4->num_rows() > 0)
                return FALSE;
            $this->db->query("DELETE FROM tahun_ajarans WHERE id IN (".implode(',',$ids).");");
            return $this->db->affected_rows();
        }else{
            return 0;
        }
    }

}

?>
