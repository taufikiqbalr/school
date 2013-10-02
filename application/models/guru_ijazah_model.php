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
class guru_ijazah_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    // get column names
    public function column_names(){
        return $this->db->list_fields('guru_ijazahs');
    }

    // get ijazah with ID guru
    public function get_guru_ijazahs($id = FALSE) {
        $this->db->order_by("tingkat", "asc");
        $query = ($id === FALSE) ? 
                $this->db->get('guru_ijazahs') : 
            $this->db->get_where('guru_ijazahs', array('guru_id' => $id));
        return $query->result_array();
    }
    
    public function get_guru_ijazah($id){
        $query = $this->db->get_where('guru_ijazahs', array('id' => $id));
        return $query->row_array();
    }

    // create new kelas
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('guru_ijazahs', $data);
        } else {
            return FALSE;
        }
    }

    // update kelas
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('guru_ijazahs', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete kelas with ID
    public function delete($id) {
        $query = $this->db->get_where("guru_ijazahs", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('guru_ijazahs', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM guru_ijazahs WHERE id IN (".implode(',',$ids).");");
            return $this->db->affected_rows();
        }else{
            return 0;
        }
    }

}

?>
