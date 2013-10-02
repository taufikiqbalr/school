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
class staff_ijazah_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    // get column names
    public function column_names(){
        return $this->db->list_fields('staff_ijazahs');
    }

    // get ijazah with ID staff
    public function get_staff_ijazahs($id = FALSE) {
        $this->db->order_by("tingkat", "asc");
        $query = ($id === FALSE) ? 
                $this->db->get('staff_ijazahs') : 
            $this->db->get_where('staff_ijazahs', array('staff_id' => $id));
        return $query->result_array();
    }
    
    public function get_staff_ijazah($id){
        $query = $this->db->get_where('staff_ijazahs', array('id' => $id));
        return $query->row_array();
    }

    // create new kelas
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('staff_ijazahs', $data);
        } else {
            return FALSE;
        }
    }

    // update kelas
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('staff_ijazahs', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete kelas with ID
    public function delete($id) {
        $query = $this->db->get_where("staff_ijazahs", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('staff_ijazahs', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM staff_ijazahs WHERE id IN (".implode(',',$ids).");");
            return $this->db->affected_rows();
        }else{
            return 0;
        }
    }

}

?>
