<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_group_model
 *
 * @author L745
 */
class user_group_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('user_groups');
    }

    // get kelas with ID
    public function get_user_group($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get('user_groups');
            return $query->result_array();
        }
        $query = $this->db->get_where('user_groups', array('ugrp_id' => $id));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond))
            $this->db->like('ugrp_name', $cond)->or_like('ugrp_desc', $cond);
        return $this->db->count_all_results('user_groups');
    }

    // get kelas for pagination
    public function fetch_user_groups($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("user_groups", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('ugrp_name', $cond)->or_like('ugrp_desc', $cond);
        $query = $this->db->get("user_groups");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    /**
     * insert user_group
     * Inserts a new user group.
     */
    function insert($group_name, $group_desc, $group_admin) {
        return $this->flexi_auth->insert_group($group_name, $group_desc, $group_admin);
    }

    /**
     * update user_group
     * Updates a specific user group.
     */
    function update($id, $data) {
        return $this->flexi_auth->update_group($id, $data);
    }

    // delete user_group with ID
    public function delete($id) {
        if (in_array($id, array(1, 2, 3, 4, 5)))
            return FALSE;
        $query = $this->db->get_where("user_groups", array('ugrp_id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('user_groups', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        $counter = count(array_intersect(array(1, 2, 3, 4, 5), $ids));
        if ($counter > 0) {
            return FALSE;
        }
        if (!empty($ids)) {
            $this->db->query("DELETE FROM user_groups WHERE ugrp_id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

}

?>
