<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gurus
 *
 * @author L745
 */
class guru_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('gurus');
    }

    // get guru with ID
    public function get_guru($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get('gurus');
            return $query->result_array();
        }
        $query = $this->db->get_where('gurus', array('id' => $id));
        return $query->row_array();
    }

    public function get_id($nip) {
        $query = $this->db->get_where('gurus', array('nip' => trim($nip)));
        $guru = $query->row_array();
        if (count($guru))
            return $guru['id'];
        else
            return '';
    }

    public function get_user_id($uid) {
        $query = $this->db->get_where('gurus', array('user_id' => $uid));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond)) {
            $this->db->like('nip', $cond)->
                    or_like('nama', $cond)->
                    or_like('no_handphone', $cond);
        }
        return $this->db->count_all_results('gurus');
    }

    // get guru for pagination
    public function fetch_gurus($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("nip", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nip', $cond)->
                    or_like('nama', $cond)->
                    or_like('no_handphone', $cond);
        $query = $this->db->get("gurus");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new guru
    public function create($data) {
        if (isset($data)) {
            // set default email
            $email = empty($data['email']) ? "empty@empty.empty" : $data['email'];
            // create user(email,username,password,user data, user group, instant activate)
            $group_id = 2;
            $data['user_id'] = $this->flexi_auth->insert_user($email, $data['nip'], $data['nip'], FALSE, $group_id, TRUE);

            return $this->db->insert('gurus', $data);
        } else {
            return FALSE;
        }
    }

    // update guru
    public function update($id, $data) {
        if (isset($data)) {
            // set default email
            $email = empty($data['email']) ? "empty@empty.empty" : $data['email'];
            // update user username and email
            $guru = $this->get_guru($id);
            $profile_data = array(
                $this->flexi_auth->db_column('user_acc', 'email') => $email,
                $this->flexi_auth->db_column('user_acc', 'username') => $data['nip']
            );
            $this->flexi_auth->update_user($guru['user_id'], $profile_data);

            $this->db->where('id', $id);
            $this->db->update('gurus', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete guru with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM guru_ijazahs WHERE guru_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $q2 = $this->db->query("SELECT * FROM guru_kelas_matpels WHERE guru_id =" . $id);
        if ($q2->num_rows() > 0)
            return FALSE;
        $q3 = $this->db->query("SELECT * FROM guru_mata_pelajarans WHERE guru_id =" . $id);
        if ($q3->num_rows() > 0)
            return FALSE;
        $q4 = $this->db->query("SELECT * FROM guru_walis WHERE guru_id =" . $id);
        if ($q4->num_rows() > 0)
            return FALSE;
        $this->db->start_cache();
        $query = $this->db->get_where("gurus", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $guru = $query->row_array();
            $this->db->stop_cache();
            $this->db->flush_cache();
            $this->db->start_cache();
            $this->db->delete('user_accounts', array('uacc_id' => $guru['user_id']));
            $this->db->stop_cache();
            $this->db->flush_cache();
            $this->db->start_cache();
            $this->db->delete('gurus', array('id' => $id));
            $this->db->stop_cache();
            $this->db->flush_cache();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        $query = $this->db->query("SELECT user_id FROM gurus WHERE id IN (" . implode(',', $ids) . ");");
        $results = array();
        foreach ($query->result_array() as $value) {
            array_push($results, $value['user_id']);
        }
        if (!empty($ids)) {
            $q1 = $this->db->query("SELECT * FROM guru_ijazahs WHERE guru_id IN (" . implode(',', $ids) . ");");
            if ($q1->num_rows() > 0)
                return FALSE;
            $q2 = $this->db->query("SELECT * FROM guru_kelas_matpels WHERE guru_id IN (" . implode(',', $ids) . ");");
            if ($q2->num_rows() > 0)
                return FALSE;
            $q3 = $this->db->query("SELECT * FROM guru_mata_pelajarans WHERE guru_id IN (" . implode(',', $ids) . ");");
            if ($q3->num_rows() > 0)
                return FALSE;
            $q4 = $this->db->query("SELECT * FROM guru_walis WHERE guru_id IN (" . implode(',', $ids) . ");");
            if ($q4->num_rows() > 0)
                return FALSE;
            if (!empty($results)) {
                $this->db->query("DELETE FROM user_accounts WHERE uacc_id IN (" . implode(',', $results) . ");");
            }
            $this->db->query("DELETE FROM gurus WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function import($data) {
        $guru = array();
        $this->db->trans_begin();
        // create guru from excel
        for ($i = 2; $i <= $data['numRows']; $i++) {
            $guru['nip'] = strtoupper(trim($data['cells'][$i][1]));
            $guru['nama'] = strtoupper(trim($data['cells'][$i][2]));
            $guru['email'] = trim($data['cells'][$i][3]);
            $guru['tempat_lahir'] = strtoupper(trim($data['cells'][$i][4]));
            // convert
            $guru['tanggal_lahir'] = trim($data['cells'][$i][5]);
            $guru['no_telepon'] = trim($data['cells'][$i][6]);
            $guru['no_handphone'] = trim($data['cells'][$i][7]);
            // convert
            $guru['jenis_kelamin'] = $this->get_jenis_kelamin($data['cells'][$i][8]);
            $guru['agama'] = strtoupper(trim($data['cells'][$i][9]));
            $guru['alamat'] = strtoupper(trim($data['cells'][$i][10]));
            $guru['rt'] = trim($data['cells'][$i][11]);
            $guru['rw'] = trim($data['cells'][$i][12]);
            $guru['desa'] = strtoupper(trim($data['cells'][$i][13]));
            $guru['kec'] = strtoupper(trim($data['cells'][$i][14]));
            $guru['kodepos'] = trim($data['cells'][$i][15]);
            $guru['nuptk'] = trim($data['cells'][$i][16]);
            $guru['nrg'] = trim($data['cells'][$i][17]);
            $guru['nsg'] = trim($data['cells'][$i][18]);
            $guru['status'] = trim($data['cells'][$i][19]);
//            print_r($this->is_valid_email($guru['email']));exit();
            // check validity data
            if (empty($guru['nip']) ||
                    empty($guru['nama']) ||
                    empty($guru['tempat_lahir']) ||
                    empty($guru['tanggal_lahir']) ||
                    empty($guru['jenis_kelamin']) ||
                    !is_numeric($guru['no_telepon']) ||
                    !is_numeric($guru['no_handphone']) ||
                    !is_numeric($guru['rt']) ||
                    !is_numeric($guru['rw']) ||
                    !is_numeric($guru['kodepos']) ||
                    !is_numeric($guru['nip']) ||
                    !is_numeric($guru['nuptk']) ||
                    !is_numeric($guru['nrg']) ||
                    !is_numeric($guru['nsg']) ||
                    !$this->is_unique($guru['nip']) ||
                    !$this->is_valid_date($guru['tanggal_lahir']) ||
                    !$this->is_valid_email($guru['email'])) {
                $this->db->trans_rollback();
                return FALSE;
            }
            $this->create($guru);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function is_valid_date($date) {
        if (preg_match('/\d{4}-\d{2}-\d{2}/', $date)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function is_valid_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function get_jenis_kelamin($jk) {
        if (strtoupper(trim($jk)) == 'LAKI-LAKI')
            return 1;
        else
            return 0;
    }

    public function unique_check($nip) {
        $this->db->where('nip', $nip);
        return $this->db->get('gurus');
    }

    public function is_unique($nip) {
        $this->db->where('nip', $nip);
        $query = $this->db->get('gurus');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function count_guru_wali($guru_id) {
        $this->db->start_cache();
        
        $this->db->where('guru_id', $guru_id);
        $count = $this->db->count_all_results('guru_walis');
        
        $this->db->stop_cache();
        $this->db->flush_cache();
        
        return $count;
    }

    public function get_guru_kelas_matpel_ids($guru_id) {
        $this->db->start_cache();
        
        $this->db->where('guru_id', $guru_id);
        $q1 = $this->db->get('guru_kelas_matpels');
        
        $guru_kelas_matpels = $q1->result_array();
        $guru_kelas_matpel_ids = array();
        foreach ($guru_kelas_matpels as $guru_kelas_matpel):
            array_push($guru_kelas_matpel_ids, $guru_kelas_matpel['id']);
        endforeach;
        
        $this->db->stop_cache();
        $this->db->flush_cache();
        
        return $guru_kelas_matpel_ids;
    }

}

?>
