<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of staffs
 *
 * @author L745
 */
class staff_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('staffs');
    }

    // get staff with ID
    public function get_staff($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get('staffs');
            return $query->result_array();
        }
        $query = $this->db->get_where('staffs', array('id' => $id));
        return $query->row_array();
    }
    
    public function get_id($nik){
        $query = $this->db->get_where('staffs', array('nik' => trim($nik)));
        $staff = $query->row_array();
        if(count($staff))
            return $staff['id'];
        else return '';
    }

    public function get_user_id($uid) {
        $query = $this->db->get_where('staffs', array('user_id' => $uid));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond)) {
            $this->db->like('nik', $cond)->
                    or_like('nama', $cond)->
                    or_like('no_handphone', $cond);
        }
        return $this->db->count_all_results('staffs');
    }

    // get staff for pagination
    public function fetch_staffs($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("nik", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nik', $cond)->
                    or_like('nama', $cond)->
                    or_like('no_handphone', $cond);
        $query = $this->db->get("staffs");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new staff
    public function create($data) {
        if (isset($data)) {
            // set default email
            $email = empty($data['email']) ? "empty@empty.empty" : $data['email'];
            // create user(email,username,password,user data, user group, instant activate)
            $group_id = 3;
            $data['user_id'] = $this->flexi_auth->insert_user($email, $data['nik'], $data['nik'], FALSE, $group_id, TRUE);

            return $this->db->insert('staffs', $data);
        } else {
            return FALSE;
        }
    }

    // update staff
    public function update($id, $data) {
        if (isset($data)) {
            // set default email
            $email = empty($data['email']) ? "empty@empty.empty" : $data['email'];
            // update user username and email
            $staff = $this->get_staff($id);
            $profile_data = array(
                $this->flexi_auth->db_column('user_acc', 'email') => $email,
                $this->flexi_auth->db_column('user_acc', 'username') => $data['nik']
            );            
            $this->flexi_auth->update_user($staff['user_id'], $profile_data);

            $this->db->where('id', $id);
            $this->db->update('staffs', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete staff with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM staff_ijazahs WHERE staff_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $query = $this->db->get_where("staffs", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $staff = $query->row_array();
            $this->db->delete('user_accounts', array('uacc_id' => $staff['user_id']));
            $this->db->delete('staffs', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        $query = $this->db->query("SELECT user_id FROM staffs WHERE id IN (" . implode(',', $ids) . ");");
        $results = array();
        foreach ($query->result_array() as $value) {
            array_push($results, $value['user_id']);
        }
        if (!empty($ids)) {
            $q1 = $this->db->query("SELECT * FROM staff_ijazahs WHERE staff_id IN (" . implode(',', $ids) . ");");
            if ($q1->num_rows() > 0)
                return FALSE;
            if (!empty($results)) {
                $this->db->query("DELETE FROM user_accounts WHERE uacc_id IN (" . implode(',', $results) . ");");
            }
            $this->db->query("DELETE FROM staffs WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

}

?>
