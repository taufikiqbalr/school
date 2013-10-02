<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of spps
 *
 * @author L745
 */
class spp_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return array_merge(
                $this->db->list_fields('spps'),
                $this->db->list_fields('siswas')
                );
    }

    // get spp with ID
    public function get_spp($id = FALSE) {
        $this->join();
        if ($id === FALSE) {
            $query = $this->db->get('spps');
            return $query->result_array();
        }
        $query = $this->db->get_where('spps', array('spps.id' => $id));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        $this->join();
        if (!empty($cond)) {
            $this->db->like('nis', $cond)->
                    or_like('nama', $cond)->
                    or_like('bulan_tempo', $cond)->
                    or_like('tahun_tempo', $cond);
        }
        return $this->db->count_all_results('spps');
    }

    // get spp for pagination
    public function fetch_spps($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        $this->join();
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("nis", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nis', $cond)->
                    or_like('nama', $cond)->
                    or_like('bulan_tempo', $cond)->
                    or_like('tahun_tempo', $cond);
        $query = $this->db->get("spps");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new spp
    public function create($data) {
        if (isset($data)) {
            // check is lunas
            if(((int)$data['bayar']) > ((int)$data['biaya']))
                $data['lunas'] = "1";
            else
                $data['lunas'] = "0";
            
            return $this->db->insert('spps', $data);
        } else {
            return FALSE;
        }
    }

    // update spp
    public function update($id, $data) {
        if (isset($data)) {
            // check is lunas
            if(((int)$data['bayar']) > ((int)$data['biaya']))
                $data['lunas'] = "1";
            else
                $data['lunas'] = "0";
            
            $this->db->where('id', $id);
            $this->db->update('spps', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete spp with ID
    public function delete($id) {
        $query = $this->db->get_where("spps", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('spps', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM spps WHERE id IN (".implode(',',$ids).");");
            return $this->db->affected_rows();
        }else{
            return 0;
        }
    }

    // join with siswa
    public function join() {
        $this->db->
                select('spps.id AS id, spps.siswa_id AS siswa_id,
                    siswas.nis AS nis, siswas.nama AS nama,
                    spps.bulan_tempo AS bulan_tempo, spps.tahun_tempo AS tahun_tempo,
                    spps.lunas AS lunas, spps.bayar AS bayar, spps.biaya AS biaya,
                    spps.user_id AS user_id, spps.tanggal_bayar AS tanggal_bayar')->
                join('siswas', 'siswas.id = spps.siswa_id', 'left');
    }

}

?>
