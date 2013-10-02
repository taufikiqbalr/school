<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswas
 *
 * @author L745
 */
class siswa_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('siswas');
    }

    // get siswa with ID
    public function get_siswa($id = FALSE) {
        if ($id === FALSE) {
            $query = $this->db->get('siswas');
            return $query->result_array();
        }
        $query = $this->db->get_where('siswas', array('id' => $id));
        return $query->row_array();
    }

    public function get_id($nis) {
        $query = $this->db->get_where('siswas', array('nis' => trim($nis)));
        $siswa = $query->row_array();
        if (count($siswa))
            return $siswa['id'];
        else
            return '';
    }

    public function get_user_id($uid) {
        $query = $this->db->get_where('siswas', array('user_id' => $uid));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        if (!empty($cond)) {
            $this->db->like('nis', $cond)->
                    or_like('nama', $cond)->
                    or_like('nohp', $cond);
        }
        return $this->db->count_all_results('siswas');
    }

    // get siswa for pagination
    public function fetch_siswas($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("nis", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nis', $cond)->
                    or_like('nama', $cond)->
                    or_like('nohp', $cond);
        $query = $this->db->get("siswas");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new siswa
    public function create($data) {
        if (isset($data)) {
            // set default email
            $email = empty($data['email']) ? "empty@empty.empty" : $data['email'];
            // create user(email,username,password,user data, user group, instant activate)
            $group_id = 5;
            $data['user_id'] = $this->flexi_auth->insert_user($email, $data['nis'], $data['nis'], FALSE, $group_id, TRUE);

            return $this->db->insert('siswas', $data);
        } else {
            return FALSE;
        }
    }

    // update siswa
    public function update($id, $data) {
        if (isset($data)) {
            // set default email
            $email = empty($data['email']) ? "empty@empty.empty" : $data['email'];
            // update user username and email
            $siswa = $this->get_siswa($id);
            $profile_data = array(
                $this->flexi_auth->db_column('user_acc', 'email') => $email,
                $this->flexi_auth->db_column('user_acc', 'username') => $data['nis']
            );
            $this->flexi_auth->update_user($siswa['user_id'], $profile_data);

            $this->db->where('id', $id);
            $this->db->update('siswas', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete siswa with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM absensis WHERE siswa_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $q2 = $this->db->query("SELECT * FROM siswa_kelas WHERE siswa_id =" . $id);
        if ($q2->num_rows() > 0)
            return FALSE;
        $q3 = $this->db->query("SELECT * FROM siswa_nilais WHERE siswa_id =" . $id);
        if ($q3->num_rows() > 0)
            return FALSE;
        $q4 = $this->db->query("SELECT * FROM spps WHERE siswa_id =" . $id);
        if ($q4->num_rows() > 0)
            return FALSE;
        $query = $this->db->get_where("siswas", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $siswa = $query->row_array();
            $this->db->delete('user_accounts', array('uacc_id' => $siswa['user_id']));
            $this->db->delete('siswas', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        $query = $this->db->query("SELECT user_id FROM siswas WHERE id IN (" . implode(',', $ids) . ");");
        $results = array();
        foreach ($query->result_array() as $value) {
            array_push($results, $value['user_id']);
        }
        if (!empty($ids)) {
            $q1 = $this->db->query("SELECT * FROM absensis WHERE siswa_id IN (" . implode(',', $ids) . ");");
            if ($q1->num_rows() > 0)
                return FALSE;
            $q2 = $this->db->query("SELECT * FROM siswa_kelas WHERE siswa_id IN (" . implode(',', $ids) . ");");
            if ($q2->num_rows() > 0)
                return FALSE;
            $q3 = $this->db->query("SELECT * FROM siswa_nilais WHERE siswa_id IN (" . implode(',', $ids) . ");");
            if ($q3->num_rows() > 0)
                return FALSE;
            $q4 = $this->db->query("SELECT * FROM spps WHERE siswa_id IN (" . implode(',', $ids) . ");");
            if ($q4->num_rows() > 0)
                return FALSE;
            if (!empty($results)) {
                $this->db->query("DELETE FROM user_accounts WHERE uacc_id IN (" . implode(',', $results) . ");");
            }
            $this->db->query("DELETE FROM siswas WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function import($data) {
        $siswa = array();
        $this->db->trans_begin();
        // create siswa from excel
        for ($i = 2; $i <= $data['numRows']; $i++) {
            $siswa['nis'] = strtoupper(trim($data['cells'][$i][1]));
            $siswa['nama'] = strtoupper(trim($data['cells'][$i][2]));
            $siswa['email'] = trim($data['cells'][$i][3]);
            $siswa['tmptlhr'] = strtoupper(trim($data['cells'][$i][4]));
            // convert
            $siswa['tgllhr'] = trim($data['cells'][$i][5]);
            $siswa['notel'] = trim($data['cells'][$i][6]);
            $siswa['nohp'] = trim($data['cells'][$i][7]);
            // convert
            $siswa['jk'] = $this->get_jenis_kelamin($data['cells'][$i][8]);
            $siswa['agama'] = strtoupper(trim($data['cells'][$i][9]));
            $siswa['almt'] = strtoupper(trim($data['cells'][$i][10]));
            $siswa['rt'] = trim($data['cells'][$i][11]);
            $siswa['rw'] = trim($data['cells'][$i][12]);
            $siswa['desa'] = strtoupper(trim($data['cells'][$i][13]));
            $siswa['kec'] = strtoupper(trim($data['cells'][$i][14]));
            $siswa['kodepos'] = trim($data['cells'][$i][15]);
            $siswa['nmsekolah'] = trim($data['cells'][$i][16]);
            $siswa['almtsekolah'] = trim($data['cells'][$i][17]);
            $siswa['noijasah'] = trim($data['cells'][$i][18]);
            $siswa['nilaiijasah'] = trim($data['cells'][$i][19]);
            $siswa['nmbpk'] = trim($data['cells'][$i][20]);
            $siswa['pkrjbpk'] = trim($data['cells'][$i][21]);
            $siswa['pendidikanbpk'] = strtoupper(trim($data['cells'][$i][22]));
            $siswa['nmibu'] = trim($data['cells'][$i][23]);
            $siswa['pkrjibu'] = trim($data['cells'][$i][24]);
            $siswa['pendidikanibu'] = strtoupper(trim($data['cells'][$i][25]));
            $siswa['almtortu'] = strtoupper(trim($data['cells'][$i][26]));
            $siswa['rtortu'] = trim($data['cells'][$i][27]);
            $siswa['rwortu'] = trim($data['cells'][$i][28]);
            $siswa['desaortu'] = strtoupper(trim($data['cells'][$i][29]));
            $siswa['kecortu'] = strtoupper(trim($data['cells'][$i][30]));
            $siswa['kotaortu'] = strtoupper(trim($data['cells'][$i][31]));
            $siswa['kodeposortu'] = trim($data['cells'][$i][32]);
            $siswa['tlportu'] = trim($data['cells'][$i][33]);
            $siswa['penghasilanortu'] = $this->get_penghasilanortu(trim($data['cells'][$i][34]));
            $siswa['tahun_masuk'] = strtoupper(trim($data['cells'][$i][35]));
            $siswa['tahun_keluar'] = '';
            // check validity data
            if (empty($siswa['nis']) ||
                    empty($siswa['nama']) ||
                    empty($siswa['tmptlhr']) ||
                    empty($siswa['tgllhr']) ||
                    empty($siswa['jk']) ||
                    empty($siswa['penghasilanortu']) ||
                    empty($siswa['agama']) ||
                    !is_numeric($siswa['notel']) ||
                    !is_numeric($siswa['nohp']) ||
                    !is_numeric($siswa['rt']) ||
                    !is_numeric($siswa['rw']) ||
                    !is_numeric($siswa['rtortu']) ||
                    !is_numeric($siswa['rwortu']) ||
                    !is_numeric($siswa['kodepos']) ||
                    !is_numeric($siswa['kodeposortu']) ||
                    !is_numeric($siswa['nis']) ||
                    !is_numeric($siswa['penghasilanortu']) ||
                    !is_numeric($siswa['tahun_masuk']) ||
                    !$this->is_unique($siswa['nis']) ||
                    !$this->is_valid_date($siswa['tgllhr']) ||
                    !$this->is_valid_email($siswa['email'])) {
                $this->db->trans_rollback();
                return FALSE;
            }
            $this->create($siswa);
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

    public function get_penghasilanortu($p_ortu) {
        if (((int) $p_ortu) < 500000)
            return 1;
        else if (((int) $p_ortu) >= 500000 && ((int) $p_ortu) <= 1000000)
            return 2;
        else if (((int) $p_ortu) > 1000000 && ((int) $p_ortu) <= 1500000)
            return 3;
        else if (((int) $p_ortu) > 1500000 && ((int) $p_ortu) <= 2000000)
            return 4;
        else if (((int) $p_ortu) > 2000000 && ((int) $p_ortu) <= 3000000)
            return 5;
        else if (((int) $p_ortu) > 3000000 && ((int) $p_ortu) <= 5000000)
            return 6;
        else if (((int) $p_ortu) > 5000000)
            return 7;
        else
            return '';
    }

    public function unique_check($nis) {
        $this->db->where('nis', $nis);
        return $this->db->get('siswas');
    }

    public function is_unique($nis) {
        $this->db->where('nis', $nis);
        $query = $this->db->get('siswas');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_siswas_with_kelas($kelas_bagian_id, $tahun_ajaran_id) {
        $this->db->join('siswa_kelas', 'siswas.id = siswa_kelas.siswa_id', 'left');
        $this->db->where('siswa_kelas.kelas_bagian_id', $kelas_bagian_id);
        $this->db->where('siswa_kelas.tahun_ajaran_id', $tahun_ajaran_id);
        $query = $this->db->get('siswas');
        return $query->result_array();
    }
    
    public function get_siswa_with_kelas($siswa_id, $kelas_bagian_id, $tahun_ajaran_id) {
        $this->db->join('siswa_kelas', 'siswas.id = siswa_kelas.siswa_id', 'left');
        $this->db->where('siswas.id', $siswa_id);
        $this->db->where('siswa_kelas.kelas_bagian_id', $kelas_bagian_id);
        $this->db->where('siswa_kelas.tahun_ajaran_id', $tahun_ajaran_id);
        $query = $this->db->get('siswas');
        return $query->row_array();
    }

}

?>
