<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kelas
 *
 * @author L745
 */
class guru_kelas_matpel_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return $this->db->list_fields('guru_kelas_matpels');
    }

    // get kelas_matpel with ID guru
    public function get_guru_kelas_matpels($id = FALSE) {
        $this->join();
        $this->db->order_by("kelas_bagian_id", "asc");
        $query = ($id === FALSE) ?
                $this->db->get('guru_kelas_matpels') :
                $this->db->get_where('guru_kelas_matpels', 
                        array('guru_kelas_matpels.guru_id' => $id));
        return $query->result_array();
    }

    public function get_guru_kelas_matpel($id) {
        $this->join();
        $query = $this->db->get_where('guru_kelas_matpels', array('guru_kelas_matpels.id' => $id));
        return $query->row_array();
    }

    // create new kelas
    public function create($data) {
        if (isset($data)) {
            // insert guru_kelas_matpel
            $status = $this->db->insert('guru_kelas_matpels', $data);
            // get id
            $guru_kelas_matpel_id = $this->db->insert_id();
            // insert bobot (absensi 10%, tugas 30%, uts 30%, uas 30%)
            $this->db->insert('mata_pelajaran_persentases', array(
                'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
                'jenis' => 'ABSENSI',
                'persentase' => 10
            ));
            $this->db->insert('mata_pelajaran_persentases', array(
                'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
                'jenis' => 'TUGAS',
                'persentase' => 30
            ));
            $this->db->insert('mata_pelajaran_persentases', array(
                'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
                'jenis' => 'UTS',
                'persentase' => 30
            ));
            $this->db->insert('mata_pelajaran_persentases', array(
                'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
                'jenis' => 'UAS',
                'persentase' => 30
            ));
            return $status;
        } else {
            return FALSE;
        }
    }

    // update kelas
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('guru_kelas_matpels', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete kelas with ID
    public function delete($id) {
        $q1 = $this->db->query("SELECT * FROM siswa_nilais WHERE guru_kelas_matpel_id =" . $id);
        if ($q1->num_rows() > 0)
            return FALSE;
        $query = $this->db->get_where("guru_kelas_matpels", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            // delete bobot nilai
            $this->db->delete('mata_pelajaran_persentases', array('guru_kelas_matpel_id' => $id));
            
            // delete nilai akhir
            $this->db->delete('siswa_nilai_akhirs', array('guru_kelas_matpel_id' => $id));

            $this->db->delete('guru_kelas_matpels', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $q1 = $this->db->query("SELECT * FROM siswa_nilais WHERE guru_kelas_matpel_id IN (" . implode(',', $ids) . ");");
            if ($q1->num_rows() > 0)
                return FALSE;
            $this->db->query("DELETE FROM guru_kelas_matpels WHERE id IN (" . implode(',', $ids) . ");");
            $affected_rows = $this->db->affected_rows();
            // delete bobot nilai
            $this->db->query("DELETE FROM mata_pelajaran_persentases WHERE guru_kelas_matpel_id IN (" . implode(',', $ids) . ");");
            
            // delete nilai akhir
            $this->db->query("DELETE FROM siswa_nilai_akhirs WHERE guru_kelas_matpel_id IN (" . implode(',', $ids) . ");");

            return $affected_rows;
        }else {
            return 0;
        }
    }
    
    public function unique_check($kelas_bagian_id, $guru_mata_pelajaran_id) {
        $this->db->where('kelas_bagian_id', $kelas_bagian_id);
        $this->db->where('guru_mata_pelajaran_id', $guru_mata_pelajaran_id);
        return $this->db->get('guru_kelas_matpels');
    }
    
    public function join() {
        $this->db->
                select('guru_kelas_matpels.id AS id,
                    guru_kelas_matpels.kelas_bagian_id AS kelas_bagian_id,
                    guru_kelas_matpels.guru_id AS guru_id,
                    guru_kelas_matpels.guru_mata_pelajaran_id AS guru_mata_pelajaran_id,
                    kelas.tingkat AS tingkat, 
                    kelas_bagians.nama AS nama_kelas,
                    kurikulums.nama AS nama_kurikulum, 
                    tahun_ajarans.id AS tahun_ajaran_id, tahun_ajarans.nama AS nama_tahun_ajaran,
                    guru_mata_pelajarans.semester AS semester, 
                    gurus.id AS guru_id, gurus.nama AS nama_guru,gurus.nip AS nip, 
                    mata_pelajarans.id AS mata_pelajaran_id, mata_pelajarans.kode AS kode,mata_pelajarans.nama AS nama_mata_pelajaran,
                    jurusans.nama AS nama_jurusan')->
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
