<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of privilege_group_model
 *
 * @author L745
 */
class group_privilege_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return array("ugrp_name", "upriv_name");
    }

    // get privilege_group with ID
    public function get_group_privilege($id = FALSE) {
        $this->join_upriv_ugrp();
        if ($id === FALSE) {
            $query = $this->db->get('user_privilege_groups');
            return $query->result_array();
        }
        $this->db->where('upriv_groups_id', $id);
        $query = $this->db->get('user_privilege_groups');
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond)) {
            $this->join_upriv_ugrp();
            $this->db->like('user_privileges.upriv_name', $cond)->
                    or_like('user_groups.ugrp_name', $cond);
        }
        return $this->db->count_all_results('user_privilege_groups');
    }

    // get privilege_group for pagination
    public function fetch_group_privileges($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("ugrp_name", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);
        $this->join_upriv_ugrp();

        if ($cond != FALSE && !empty($cond))
            $this->db->like('user_privileges.upriv_name', $cond)->
                    or_like('user_groups.ugrp_name', $cond);
        $query = $this->db->get('user_privilege_groups');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    /**
     * insert user_privilege_group
     * Inserts a new user privilege_group.
     */
    function insert($ugrp_id, $upriv_id) {
        return $this->flexi_auth->insert_user_group_privilege($ugrp_id, $upriv_id);
    }

    /**
     * update user_privilege_group
     * Updates a specific user privilege_group.
     */
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('upriv_groups_id', $id);
            $this->db->update('user_privilege_groups', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete user_privilege_group with ID
    public function delete($id) {
        $query = $this->db->get_where("user_privilege_groups", array('upriv_groups_id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('user_privilege_groups', array('upriv_groups_id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM user_privilege_groups WHERE upriv_groups_id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    // join query with privileges and user groups
    public function join_upriv_ugrp() {
        $this->db->
                select('user_privilege_groups.upriv_groups_id AS id,user_groups.ugrp_name AS ugrp_name,user_privileges.upriv_name AS upriv_name,user_privilege_groups.upriv_groups_ugrp_fk,user_privilege_groups.upriv_groups_upriv_fk')->
//                from('user_privilege_groups')->
                join('user_groups', 'user_groups.ugrp_id = user_privilege_groups.upriv_groups_ugrp_fk', 'left')->
                join('user_privileges', 'user_privileges.upriv_id = user_privilege_groups.upriv_groups_upriv_fk', 'left');
    }

    public function group_priv_unique($ugrp_id, $upriv_id) {
        $this->db->where('upriv_groups_ugrp_fk', $ugrp_id);
        $this->db->where('upriv_groups_upriv_fk', $upriv_id);
        return $this->db->get('user_privilege_groups');
    }

}

?>
