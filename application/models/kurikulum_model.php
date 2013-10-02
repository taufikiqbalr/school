<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kurikulums
 *
 * @author L745
 */
class kurikulum_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    // get column names
    public function column_names(){
        return $this->db->list_fields('kurikulums');
    }

    // get kurikulum with ID
    public function get_kurikulum($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get('kurikulums');
            return $query->result_array();
        }
        $query = $this->db->get_where('kurikulums', array('id' => $id));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if(!empty($cond)) {
            $this->db->like('nama',$cond);
        }
        return $this->db->count_all_results('kurikulums');
    }

    // get kurikulum for pagination
    public function fetch_kurikulums($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if($order === FALSE || $field === FALSE)
            $this->db->order_by("nama", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nama',$cond);
        $query = $this->db->get("kurikulums");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new kurikulum
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('kurikulums', $data);
        } else {
            return FALSE;
        }
    }

    // update kurikulum
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('kurikulums', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete kurikulum with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM guru_mata_pelajarans WHERE kurikulum_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $query = $this->db->get_where("kurikulums", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('kurikulums', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $query = $this->db->query("SELECT * FROM guru_mata_pelajarans WHERE kurikulum_id IN (" . implode(',', $ids) . ");");
            if ($query->num_rows() > 0)
                return FALSE;
            $this->db->query("DELETE FROM kurikulums WHERE id IN (".implode(',',$ids).");");
            return $this->db->affected_rows();
        }else{
            return 0;
        }
    }

}

?>
