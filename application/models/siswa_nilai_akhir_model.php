<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswa_nilai_akhirs
 *
 * @author L745
 */
class siswa_nilai_akhir_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return array_merge(
                $this->db->list_fields('siswa_nilai_akhirs'), $this->db->list_fields('siswas'), $this->db->list_fields('kelas'), $this->db->list_fields('gurus'), $this->db->list_fields('mata_pelajarans')
        );
    }

    // get siswa_nilai_akhir with ID
    public function get_siswa_nilai_akhir($id = FALSE) {
        $this->join();
        if ($id === FALSE) {
            $this->db->order_by("kode", "asc");
            $query = $this->db->get('siswa_nilai_akhirs');
            return $query->result_array();
        }
        $query = $this->db->get_where('siswa_nilai_akhirs', array('siswa_nilai_akhirs.id' => $id));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        $this->join();
        if (!empty($cond)) {
            $this->db->like('nip', $cond)->
                    or_like('nis', $cond)->
                    or_like('nama_guru', $cond)->
                    or_like('nama_siswa', $cond)->
                    or_like('nama_mata_pelajaran', $cond)->
                    or_like('kode', $cond)->
                    or_like('nama_tahun_ajaran', $cond)->
                    or_like('semester', $cond)->
                    or_like('nilai_akhir', $cond)->
                    or_like('tingkat', $cond);
        }
        return $this->db->count_all_results('siswa_nilai_akhirs');
    }

    // get siswa_nilai_akhir for pagination
    public function fetch_siswa_nilai_akhirs($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        $this->join();
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("kode", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nip', $cond)->
                    or_like('nis', $cond)->
                    or_like('nama_guru', $cond)->
                    or_like('nama_siswa', $cond)->
                    or_like('nama_mata_pelajaran', $cond)->
                    or_like('kode', $cond)->
                    or_like('nama_tahun_ajaran', $cond)->
                    or_like('semester', $cond)->
                    or_like('nilai_akhir', $cond)->
                    or_like('tingkat', $cond);
        $query = $this->db->get("siswa_nilai_akhirs");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new siswa_nilai_akhir
    public function create($data) {
        if (isset($data)) {
            return $this->db->insert('siswa_nilai_akhirs', $data);
        } else {
            return FALSE;
        }
    }

    // update siswa_nilai_akhir
    public function update($id, $data) {
        if (isset($data)) {
            $this->db->where('id', $id);
            $this->db->update('siswa_nilai_akhirs', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete siswa_nilai_akhir with ID
    public function delete($id) {
        $query = $this->db->get_where("siswa_nilai_akhirs", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('siswa_nilai_akhirs', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM siswa_nilai_akhirs WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function hitung_nilai_akhir($siswa_id, $guru_kelas_matpel_id, $skala = FALSE) {
        if (!$skala)
            $skala = 100.0;
        $this->load->model('absensi_model');
        $this->load->model('mata_pelajaran_persentase_model');
        $this->load->model('siswa_nilai_model');
        $this->load->model('guru_kelas_matpel_model');
        $nilai_akhir = 0.0;

        // get guru_kelas_matpel
        $guru_kelas_matpel = $this->guru_kelas_matpel_model->get_guru_kelas_matpel($guru_kelas_matpel_id);

        // absensi
        $persentase_absensi = $this->mata_pelajaran_persentase_model->get_persentase($guru_kelas_matpel_id, 'ABSENSI');
        $absensi_masuk = $this->absensi_model->hitung_absensi_mp($siswa_id, $guru_kelas_matpel['mata_pelajaran_id'], $guru_kelas_matpel['kelas_bagian_id'], $guru_kelas_matpel['guru_id'], $guru_kelas_matpel['tahun_ajaran_id'], $guru_kelas_matpel['semester']);
        $total_absensi = $this->absensi_model->hitung_total_mp($siswa_id, $guru_kelas_matpel['mata_pelajaran_id'], $guru_kelas_matpel['kelas_bagian_id'], $guru_kelas_matpel['guru_id'], $guru_kelas_matpel['tahun_ajaran_id'], $guru_kelas_matpel['semester']);
        $nilai_absensi = (
                $absensi_masuk /
                $total_absensi
                ) * ($persentase_absensi/100.0);
        $nilai_akhir += ($nilai_absensi / 100.0) * $skala;
//        print_r($nilai_absensi);exit();

        // tugas
        $persentase_tugas = $this->mata_pelajaran_persentase_model->get_persentase($guru_kelas_matpel_id, 'TUGAS');
        $nilai_tugas = (
                $this->siswa_nilai_model->sum_nilai($siswa_id, $guru_kelas_matpel_id, 'TUGAS') /
                $this->siswa_nilai_model->count_nilai($siswa_id, $guru_kelas_matpel_id, 'TUGAS')
                ) * ($persentase_tugas/100.0);
        $nilai_akhir += ($nilai_tugas / 100.0) * $skala;
//        print_r($nilai_tugas);exit();

        // uts
        $persentase_uts = $this->mata_pelajaran_persentase_model->get_persentase($guru_kelas_matpel_id, 'UTS');
        $nilai_uts = (
                $this->siswa_nilai_model->sum_nilai($siswa_id, $guru_kelas_matpel_id, 'UTS') / 
                $this->siswa_nilai_model->count_nilai($siswa_id, $guru_kelas_matpel_id, 'UTS')
                ) * ($persentase_uts/100.0);
        $nilai_akhir += ($nilai_uts / 100.0) * $skala;
//        print_r($nilai_uts);exit();

        // uas
        $persentase_uas = $this->mata_pelajaran_persentase_model->get_persentase($guru_kelas_matpel_id, 'UAS');
        $nilai_uas = (
                $this->siswa_nilai_model->sum_nilai($siswa_id, $guru_kelas_matpel_id, 'UAS') / 
                $this->siswa_nilai_model->count_nilai($siswa_id, $guru_kelas_matpel_id, 'UAS')
                ) * ($persentase_uas/100.0);
        $nilai_akhir += ($nilai_uas / 100.0) * $skala;
//        print_r($nilai_akhir);exit();

        $data = array(
            'siswa_id' => $siswa_id,
            'guru_kelas_matpel_id' => $guru_kelas_matpel_id,
            'nilai_akhir' => $nilai_akhir
        );

        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('guru_kelas_matpel_id', $guru_kelas_matpel_id);
        $query = $this->db->get('siswa_nilai_akhirs');
        if ($query->num_rows() > 0)
            return $this->update($query->row_array()['id'], $data);
        else
            return $this->create($data);
    }

    public function join() {
        $this->db->
                select('siswa_nilai_akhirs.id AS id, 
                    siswa_nilai_akhirs.siswa_id AS siswa_id,
                    siswa_nilai_akhirs.nilai_akhir AS nilai_akhir,
                    siswa_nilai_akhirs.guru_kelas_matpel_id AS guru_kelas_matpel_id,
                    kelas.tingkat AS tingkat, kelas_bagians.nama AS nama_kelas,
                    kurikulums.nama AS nama_kurikulum, tahun_ajarans.nama AS nama_tahun_ajaran,
                    guru_mata_pelajarans.semester AS semester, gurus.nama AS nama_guru,
                    gurus.nip AS nip, mata_pelajarans.kode AS kode,
                    mata_pelajarans.nama AS nama_mata_pelajaran,
                    siswas.nis AS nis, siswas.nama AS nama_siswa,
                    jurusans.nama AS nama_jurusan')->
                join('guru_kelas_matpels', 'guru_kelas_matpels.id = siswa_nilai_akhirs.guru_kelas_matpel_id', 'left')->
                join('guru_mata_pelajarans', 'guru_mata_pelajarans.id = guru_kelas_matpels.guru_mata_pelajaran_id', 'left')->
                join('gurus', 'gurus.id = guru_mata_pelajarans.guru_id', 'left')->
                join('mata_pelajarans', 'mata_pelajarans.id = guru_mata_pelajarans.mata_pelajaran_id', 'left')->
                join('kurikulums', 'kurikulums.id = guru_mata_pelajarans.kurikulum_id', 'left')->
                join('tahun_ajarans', 'tahun_ajarans.id = guru_mata_pelajarans.tahun_ajaran_id', 'left')->
                join('kelas_bagians', 'kelas_bagians.id = guru_kelas_matpels.kelas_bagian_id', 'left')->
                join('kelas', 'kelas.id = kelas_bagians.kelas_id', 'left')->
                join('siswas', 'siswas.id = siswa_nilai_akhirs.siswa_id', 'left')->
                join('jurusans', 'jurusans.id = kelas.jurusan_id', 'left');
    }

}

?>
