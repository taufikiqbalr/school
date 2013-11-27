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
class guru_wali_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    // get column names
    public function column_names(){
        return $this->db->list_fields('guru_walis');
    }

    // get wali with ID guru
    public function get_guru_walis($id = FALSE) {
        $this->db->order_by("tahun_ajaran_id", "desc");
        $query = ($id === FALSE) ? 
                $this->db->get('guru_walis') : 
            $this->db->get_where('guru_walis', array('guru_id' => $id));
        return $query->result_array();
    }
    
    public function get_guru_wali($id){
        $query = $this->db->get_where('guru_walis', array('id' => $id));
        return $query->row_array();
    }

    // create new kelas
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('guru_walis', $data);
        } else {
            return FALSE;
        }
    }

    // update kelas
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('guru_walis', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete kelas with ID
    public function delete($id) {
        $query = $this->db->get_where("guru_walis", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('guru_walis', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM guru_walis WHERE id IN (".implode(',',$ids).");");
            return $this->db->affected_rows();
        }else{
            return 0;
        }
    }
    
    public function unique_check($tahun_ajaran_id, $guru_id, $kelas_bagian_id) {
        $this->db->where('guru_id', $guru_id);
        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
        $this->db->where('kelas_bagian_id', $kelas_bagian_id);
        return $this->db->get('guru_walis');
    }
    
    public function get_guru_wali_kelas($tahun_ajaran_id, $kelas_bagian_id) {
    	if(empty($tahun_ajaran_id)) $tahun_ajaran_id = 0;
    	if(empty($kelas_bagian_id)) $kelas_bagian_id = 0;
    	$query = $this->db->query("SELECT guru_id FROM guru_walis WHERE tahun_ajaran_id = ".$tahun_ajaran_id." AND kelas_bagian_id =".$kelas_bagian_id);
    	$result = $query->row_array();
    	$guru_id = 0;
    	if ($query->num_rows() > 0)
    		$guru_id = ((int) $result['guru_id']);
    	$query = $this->db->query("SELECT * FROM gurus WHERE id = ".$guru_id);
    	return $query->row_array();
    }
    

}

?>
