<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of privilege_model
 *
 * @author L745
 */
class privilege_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('user_privileges');
    }

    // get privilege with ID
    public function get_privilege($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get('user_privileges');
            return $query->result_array();
        }
        $query = $this->db->get_where('user_privileges', array('upriv_id' => $id));
        return $query->row_array();
    }

    public function get_user_privileges($user_id) {
        $this->db->select('user_privileges.upriv_name AS name')->
                from('user_accounts')->
                join('user_groups', 'user_groups.ugrp_id = user_accounts.uacc_group_fk', 'left')->
                join('user_privilege_groups', 'user_groups.ugrp_id = user_privilege_groups.upriv_groups_ugrp_fk', 'left')->
                join('user_privilege_users', 'user_accounts.uacc_id = user_privilege_users.upriv_users_uacc_fk', 'left')->
                join('user_privileges', 
                        'user_privileges.upriv_id = user_privilege_groups.upriv_groups_upriv_fk OR user_privileges.upriv_id = user_privilege_users.upriv_users_upriv_fk', 'left');
        $this->db->where('uacc_id', $user_id);
        $query = $this->db->get();
        $results = array();
        foreach ($query->result_array() as $value) {
            array_push($results, $value['name']);
        }
        return $results;
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond))
            $this->db->like('upriv_name', $cond)->or_like('upriv_desc', $cond);
        return $this->db->count_all_results('user_privileges');
    }

    // get privilege for pagination
    public function fetch_privileges($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("upriv_name", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('upriv_name', $cond)->or_like('upriv_desc', $cond);
        $query = $this->db->get("user_privileges");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    /**
     * insert user_privilege
     * Inserts a new user privilege.
     */
    function insert($priv_name, $priv_desc) {
        return $this->flexi_auth->insert_privilege($priv_name, $priv_desc);
    }

    /**
     * update user_privilege
     * Updates a specific user privilege.
     */
    function update($id, $data) {
        return $this->flexi_auth->update_privilege($id, $data);
    }

    // delete user_privilege with ID
    public function delete($id) {
        $query = $this->db->get_where("user_privileges", array('upriv_id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('user_privileges', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM user_privileges WHERE upriv_id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

}

?>
