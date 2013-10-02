<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mata_pelajaran_persentases
 *
 * @author L745
 */
class mata_pelajaran_persentase_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return array_merge(
                $this->db->list_fields('mata_pelajaran_persentases'), $this->db->list_fields('gurus'), $this->db->list_fields('mata_pelajarans'), $this->db->list_fields('tahun_ajarans'), $this->db->list_fields('mata_pelajaran_persentases'), $this->db->list_fields('kelas')
        );
    }

    // get mata_pelajaran_persentase with ID
    public function get_mata_pelajaran_persentase($id = FALSE) {
        $this->join();
        if ($id === FALSE) {
            $this->db->order_by("kode", "asc");
            $query = $this->db->get('mata_pelajaran_persentases');
            return $query->result_array();
        }
        $query = $this->db->get_where('mata_pelajaran_persentases', array('id' => $id));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        $this->join();
        if (!empty($cond)) {
            $this->db->like('nama_mata_pelajaran', $cond)->
                    or_like('kode', $cond)->
                    or_like('jenis', $cond);
        }
        return $this->db->count_all_results('mata_pelajaran_persentases');
    }

    // get mata_pelajaran_persentase for pagination
    public function fetch_mata_pelajaran_persentases($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        $this->join();
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("kode", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nama_mata_pelajaran', $cond)->
                    or_like('kode', $cond)->
                    or_like('jenis', $cond);
        $query = $this->db->get("mata_pelajaran_persentases");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // update mata_pelajaran_persentase
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('mata_pelajaran_persentases', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    // get persentase per jenis
    // mata pelajaran, jenis bobot
    public function get_persentase($guru_kelas_matpel_id, $jenis){
        $this->db->where('guru_kelas_matpel_id', $guru_kelas_matpel_id);
        $this->db->where('jenis', $jenis);
        $query = $this->db->get('mata_pelajaran_persentases');
        $mp_persentase = $query->row_array();
        if(isset($mp_persentase))
            return ((int) $mp_persentase['persentase']);
        else
            return 0;
    }

    public function join() {
        $this->db->
                select('mata_pelajaran_persentases.id AS id, 
                    mata_pelajaran_persentases.jenis AS jenis,
                    mata_pelajaran_persentases.persentase AS persentase,
                    kelas.tingkat AS tingkat, kelas_bagians.nama AS nama_kelas,
                    kurikulums.nama AS nama_kurikulum, tahun_ajarans.nama AS nama_tahun_ajaran,
                    guru_mata_pelajarans.semester AS semester, gurus.nama AS nama_guru,
                    gurus.nip AS nip, mata_pelajarans.kode AS kode,
                    mata_pelajarans.nama AS nama_mata_pelajaran,
                    jurusans.nama AS nama_jurusan')->
                join('guru_kelas_matpels', 'guru_kelas_matpels.id = mata_pelajaran_persentases.guru_kelas_matpel_id', 'left')->
                join('guru_mata_pelajarans', 'guru_mata_pelajarans.id = guru_kelas_matpels.guru_mata_pelajaran_id', 'left')->
                join('gurus', 'gurus.id = guru_mata_pelajarans.guru_id', 'left')->
                join('mata_pelajarans', 'mata_pelajarans.id = guru_mata_pelajarans.mata_pelajaran_id', 'left')->
                join('kurikulums', 'kurikulums.id = guru_mata_pelajarans.kurikulum_id', 'left')->
                join('tahun_ajarans', 'tahun_ajarans.id = guru_mata_pelajarans.tahun_ajaran_id', 'left')->
                join('kelas_bagians', 'kelas_bagians.id = guru_kelas_matpels.kelas_bagian_id', 'left')->
                join('kelas', 'kelas.id = kelas_bagians.kelas_id', 'left')->
                join('jurusans', 'jurusans.id = kelas.jurusan_id', 'left');
    }

}

?>
