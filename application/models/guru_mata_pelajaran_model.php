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
class guru_mata_pelajaran_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    // get column names
    public function column_names(){
        return $this->db->list_fields('guru_mata_pelajarans');
    }

    // get mata_pelajaran with ID guru
    public function get_guru_mata_pelajarans($id = FALSE) {
        $this->db->order_by("tahun_ajaran_id", "desc");
        $query = ($id === FALSE) ? 
                $this->db->get('guru_mata_pelajarans') : 
            $this->db->get_where('guru_mata_pelajarans', array('guru_id' => $id));
        return $query->result_array();
    }
    
    public function get_guru_mata_pelajaran($id){
        $query = $this->db->get_where('guru_mata_pelajarans', array('id' => $id));
        return $query->row_array();
    }

    // create new kelas
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('guru_mata_pelajarans', $data);
        } else {
            return FALSE;
        }
    }

    // update kelas
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('guru_mata_pelajarans', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete kelas with ID
    public function delete($id) {
        $query = $this->db->get_where("guru_mata_pelajarans", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('guru_mata_pelajarans', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM guru_mata_pelajarans WHERE id IN (".implode(',',$ids).");");
            return $this->db->affected_rows();
        }else{
            return 0;
        }
    }
    
    public function unique_check($mata_pelajaran_id, $guru_id, $tahun_ajaran_id, $semester) {
        $this->db->where('guru_id', $guru_id);
        $this->db->where('mata_pelajaran_id', $mata_pelajaran_id);
        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
        $this->db->where('semester', $semester);
        return $this->db->get('guru_mata_pelajarans');
    }

}

?>
