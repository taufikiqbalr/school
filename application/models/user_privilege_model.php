<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_privilege_model
 *
 * @author L745
 */
class user_privilege_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    // get column names
    public function column_names() {
        return array("username", "upriv_name");
    }

    // get privilege_user with ID
    public function get_user_privilege($id = FALSE) {
        $this->join_upriv_uacc();
        if ($id === FALSE) {
            $query = $this->db->get('user_privilege_users');
            return $query->result_array();
        }
        $this->db->where('upriv_users_id', $id);
        $query = $this->db->get('user_privilege_users');
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond)) {
            $this->join_upriv_uacc();
            $this->db->like('user_privileges.upriv_name', $cond)->
                    or_like('user_accounts.uacc_username', $cond);
        }
        return $this->db->count_all_results('user_privilege_users');
    }

    // get privilege_user for pagination
    public function fetch_user_privileges($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("username", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);
        $this->join_upriv_uacc();

        if ($cond != FALSE && !empty($cond))
            $this->db->like('user_privileges.upriv_name', $cond)->
                    or_like('user_accounts.uacc_username', $cond);
        $query = $this->db->get('user_privilege_users');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    /**
     * insert privilege_user
     * Inserts a new user privilege_user.
     */
    function insert($uacc_id, $upriv_id) {
        return $this->flexi_auth->insert_privilege_user($uacc_id, $upriv_id);
    }

    /**
     * update privilege_user
     * Updates a specific user privilege_user.
     */
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('upriv_users_id', $id);
            $this->db->update('user_privilege_users', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete privilege_user with ID
    public function delete($id) {
        $query = $this->db->get_where("user_privilege_users", array('upriv_users_id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('user_privilege_users', array('upriv_users_id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM user_privilege_users WHERE upriv_users_id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    // join query with privileges and user accounts
    public function join_upriv_uacc() {
        $this->db->
                select('user_privilege_users.upriv_users_id AS id,user_accounts.uacc_username AS username,user_privileges.upriv_name AS upriv_name,user_privilege_users.upriv_users_uacc_fk,user_privilege_users.upriv_users_upriv_fk')->
//                from('user_privilege_users')->
                join('user_accounts', 'user_accounts.uacc_id = user_privilege_users.upriv_users_uacc_fk', 'left')->
                join('user_privileges', 'user_privileges.upriv_id = user_privilege_users.upriv_users_upriv_fk', 'left');
    }

    public function user_priv_unique($uacc_id, $upriv_id) {
        $this->db->where('upriv_users_uacc_fk', $uacc_id);
        $this->db->where('upriv_users_upriv_fk', $upriv_id);
        return $this->db->get('user_privilege_users');
    }
    
}

?>
