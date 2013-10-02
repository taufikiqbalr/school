<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of absensis
 *
 * @author L745
 */
class absensi_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // get column names
    public function column_names() {
        return array_merge(
                $this->db->list_fields('absensis'), $this->db->list_fields('siswas'), $this->db->list_fields('kelas')
        );
    }

    // get absensi with ID
    public function get_absensi($id = FALSE) {
        $this->join();
        if ($id === FALSE) {
            $query = $this->db->get('absensis');
            return $query->result_array();
        }
        $query = $this->db->get_where('absensis', array('absensis.id' => $id));
        return $query->row_array();
    }

    // count total rows
    public function get_total($cond = FALSE) {
        $this->join();
        if (!empty($cond)) {
            $this->db->like('nama', $cond)->or_like('nis', $cond)->
                    or_like('bulan', $cond)->or_like('tahun', $cond)->
                    or_like('keterangan', $cond)->or_like('tingkat', $cond)->
                    or_like('nama_kelas', $cond)->or_like('nama_jurusan', $cond)->
                    or_like('nama_mata_pelajaran', $cond)->
                    or_like('tanggal', $cond);
        }
        return $this->db->count_all_results('absensis');
    }

    // get absensi for pagination
    public function fetch_absensis($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        $this->join();
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("tanggal", "asc");
        else
            $this->db->order_by($field, $order);
        $this->db->limit($limit, $start);

        if ($cond != FALSE && !empty($cond))
            $this->db->like('nama', $cond)->or_like('nis', $cond)->
                    or_like('bulan', $cond)->or_like('tahun', $cond)->
                    or_like('keterangan', $cond)->or_like('tingkat', $cond)->
                    or_like('nama_kelas', $cond)->or_like('nama_jurusan', $cond)->
                    or_like('nama_mata_pelajaran', $cond)->
                    or_like('tanggal', $cond);
        $query = $this->db->get("absensis");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // create new absensi
    public function create($data) {
        if (isset($data)) {
            // check semester
            if (((int) $data['bulan']) > 6)
                $data['semester'] = "1";
            else
                $data['semester'] = "2";
            return $this->db->insert('absensis', $data);
        } else {
            return FALSE;
        }
    }

    // update absensi
    public function update($id, $data) {
        if (isset($data)) {
            // check semester
            if (((int) $data['bulan']) > 6)
                $data['semester'] = "1";
            else
                $data['semester'] = "2";
            $this->db->where('id', $id);
            $this->db->update('absensis', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // delete absensi with ID
    public function delete($id) {
        $query = $this->db->get_where("absensis", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('absensis', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM absensis WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function import($data) {
        $this->load->model('siswa_model');
        $this->load->model('kelas_bagian_model');
        $this->load->model('tahun_ajaran_model');
        $this->load->model('mata_pelajaran_model');
        $this->load->model('guru_model');

        // get general info from excel
        list($day, $full_date) = explode(',', $data['cells'][1][2]);
        list($date, $month, $year) = explode('-', $full_date);
        list($kode_mp, $nama_mp) = explode('-', $data['cells'][3][2]);
        list($nip, $nama_guru) = explode('-', $data['cells'][4][2]);
        list($tingkat, $kelas) = explode('-', $data['cells'][5][2]);

        // get info from db
        $absensi = array();
        $absensi['tanggal'] = $date;
        $absensi['bulan'] = $month;
        $absensi['kelas_bagian_id'] = $this->kelas_bagian_model->get_id(trim($tingkat), strtoupper(trim($kelas)));
        $absensi['tahun_ajaran_id'] = $this->tahun_ajaran_model->get_id($year);
        $absensi['mata_pelajaran_id'] = $this->mata_pelajaran_model->get_id(strtoupper(trim($kode_mp)));
        $absensi['guru_id'] = $this->guru_model->get_id(trim($nip));

        $absensi['user_id'] = $this->flexi_auth->get_user_id();
        $absensi['is_matpel'] = 1;

        $this->db->trans_begin();
        // get siswa info from excel
        for ($i = 9; $i <= $data['numRows']; $i++) {
            $absensi['siswa_id'] = $this->siswa_model->get_id($data['cells'][$i][1]);
            $absensi['absensi'] = $this->absensi_to_int($data['cells'][$i][3]);
            $absensi['keterangan'] = $data['cells'][$i][4];
            // check validity data
            if (!$this->is_unique(
                            $absensi['siswa_id'], $absensi['tanggal'], $absensi['kelas_bagian_id'], $absensi['tahun_ajaran_id'], $absensi['bulan'], $absensi['guru_id'], $absensi['mata_pelajaran_id']
                    ) || 
                    empty($absensi['siswa_id']) || 
                    empty($absensi['absensi']) ||
                    empty($absensi['tanggal']) || 
                    empty($absensi['bulan']) ||
                    empty($absensi['kelas_bagian_id']) || 
                    empty($absensi['tahun_ajaran_id']) ||
                    empty($absensi['mata_pelajaran_id']) || 
                    empty($absensi['guru_id']) ||
                    empty($absensi['absensi'])
            ) {
                $this->db->trans_rollback();
                return FALSE;
            }
            $this->create($absensi);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function absensi_to_int($string) {
        $string = ucfirst(strtolower(trim($string)));
        switch ($string) {
            case 'Hadir':
                return 1;
                break;
            case 'Izin':
                return 2;
                break;
            case 'Sakit':
                return 3;
                break;
            case 'Alpha':
                return 4;
                break;
            default :
                return '';
                break;
        }
    }

    // hitung absensi sakit siswa per semester
    // siswa, tahun ajaran, semester
    public function hitung_sakit_semester($siswa_id, $tahun_ajaran_id, $semester) {
//        $this->db->where('absensi', "3");
//        $this->db->where('siswa_id', $siswa_id);
//        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
//        $this->db->where('semester', $semester);
//        $this->db->from('absensis');
//        return $this->db->count_all_results();
        $query = $this->db->query('
            SELECT count(id) AS count_absensi 
            FROM absensis 
            WHERE siswa_id=' . $siswa_id .
                ' AND tahun_ajaran_id=' . $tahun_ajaran_id .
                ' AND absensi = 3 
                    AND semester=' . $semester);
        $result = $query->row_array();
        if (((int) $result['count_absensi']) > 0)
            return ((int) $result['count_absensi']);
        else
            return 1;
    }

    // hitung absensi izin siswa per semester
    // siswa, tahun ajaran, semester
    public function hitung_izin_semester($siswa_id, $tahun_ajaran_id, $semester) {
//        $this->db->where('absensi', "2");
//        $this->db->where('siswa_id', $siswa_id);
//        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
//        $this->db->where('semester', $semester);
//        $this->db->from('absensis');
//        return $this->db->count_all_results();
        $query = $this->db->query('
            SELECT count(id) AS count_absensi 
            FROM absensis 
            WHERE siswa_id=' . $siswa_id .
                ' AND tahun_ajaran_id=' . $tahun_ajaran_id .
                ' AND absensi = 2 
                    AND semester=' . $semester);
        $result = $query->row_array();
        if (((int) $result['count_absensi']) > 0)
            return ((int) $result['count_absensi']);
        else
            return 1;
    }

    // hitung absensi alpha siswa per semester
    // siswa, tahun ajaran, semester
    public function hitung_alpha_semester($siswa_id, $tahun_ajaran_id, $semester) {
//        $this->db->where('absensi', "4");
//        $this->db->where('siswa_id', $siswa_id);
//        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
//        $this->db->where('semester', $semester);
//        $this->db->from('absensis');
//        return $this->db->count_all_results();
        $query = $this->db->query('
            SELECT count(id) AS count_absensi 
            FROM absensis 
            WHERE siswa_id=' . $siswa_id .
                ' AND tahun_ajaran_id=' . $tahun_ajaran_id .
                ' AND absensi = 4 
                    AND semester=' . $semester);
        $result = $query->row_array();
        if (((int) $result['count_absensi']) > 0)
            return ((int) $result['count_absensi']);
        else
            return 1;
    }

    // hitung absensi masuk siswa per mata pelajaran
    // siswa, mata pelajaran, kelas, guru, tahun ajaran, semester
    public function hitung_absensi_mp($siswa_id, $mata_pelajaran_id, $kelas_bagian_id, $guru_id, $tahun_ajaran_id, $semester) {
//        $this->db->where_in('absensi', array("1", "2", "3"));
//        $this->db->where('siswa_id', $siswa_id);
//        $this->db->where('mata_pelajaran_id', $mata_pelajaran_id);
//        $this->db->where('kelas_bagian_id', $kelas_bagian_id);
//        $this->db->where('guru_id', $guru_id);
//        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
//        $this->db->where('semester', $semester);
//        $this->db->from('absensis');
//        return $this->db->count_all_results();
        $query = $this->db->query('
            SELECT count(id) AS count_absensi 
            FROM absensis 
            WHERE siswa_id=' . $siswa_id .
                ' AND mata_pelajaran_id=' . $mata_pelajaran_id .
                ' AND kelas_bagian_id=' . $kelas_bagian_id .
                ' AND guru_id=' . $guru_id .
                ' AND tahun_ajaran_id=' . $tahun_ajaran_id .
                ' AND absensi IN (1,2,3) 
                    AND semester=' . $semester);
        $result = $query->row_array();
        if (((int) $result['count_absensi']) > 0)
            return ((int) $result['count_absensi']);
        else
            return 1;
    }

    // hitung absensi total siswa per mata pelajaran
    // siswa, mata pelajaran, kelas, guru, tahun ajaran, semester
    public function hitung_total_mp($siswa_id, $mata_pelajaran_id, $kelas_bagian_id, $guru_id, $tahun_ajaran_id, $semester) {
//        $this->db->where('siswa_id', $siswa_id);
//        $this->db->where('mata_pelajaran_id', $mata_pelajaran_id);
//        $this->db->where('kelas_bagian_id', $kelas_bagian_id);
//        $this->db->where('guru_id', $guru_id);
//        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
//        $this->db->where('semester', $semester);
//        $this->db->from('absensis');
//        if($this->db->count_all_results() > 0)
//            return $this->db->count_all_results();
//        else
//            return 1;
        $query = $this->db->query('SELECT count(id) AS count_absensi 
            FROM absensis 
            WHERE siswa_id=' . $siswa_id .
                ' AND mata_pelajaran_id=' . $mata_pelajaran_id .
                ' AND kelas_bagian_id=' . $kelas_bagian_id .
                ' AND guru_id=' . $guru_id .
                ' AND tahun_ajaran_id=' . $tahun_ajaran_id .
                ' AND semester=' . $semester);
        $result = $query->row_array();
        if (((int) $result['count_absensi']) > 0)
            return ((int) $result['count_absensi']);
        else
            return 1;
    }

    // join query with siswas, kelas bagians, kelas, jurusans, mata_pelajarans and tahun_ajarans
    public function join() {
        $this->db->
                select('absensis.id AS id, kelas.tingkat AS tingkat,
                    kelas_bagians.nama AS nama_kelas, siswas.nis AS nis,
                    siswas.nama AS nama_siswa, absensis.absensi AS absensi,
                    gurus.nip AS nip, gurus.nama AS nama_guru,
                    absensis.keterangan AS keterangan, absensis.tanggal AS tanggal,
                    absensis.siswa_id AS siswa_id, absensis.tahun_ajaran_id AS tahun_ajaran_id,
                    absensis.bulan AS bulan, tahun_ajarans.nama AS tahun,
                    absensis.mata_pelajaran_id AS mata_pelajaran_id,
                    absensis.kelas_bagian_id AS kelas_bagian_id,
                    absensis.guru_id AS guru_id,
                    jurusans.nama AS nama_jurusan, mata_pelajarans.kode AS kode_mata_pelajaran,
                    mata_pelajarans.nama AS nama_mata_pelajaran')->
                join('kelas_bagians', 'kelas_bagians.id = absensis.kelas_bagian_id', 'left')->
                join('kelas', 'kelas.id = kelas_bagians.kelas_id', 'left')->
                join('jurusans', 'jurusans.id = kelas.jurusan_id', 'left')->
                join('siswas', 'siswas.id = absensis.siswa_id', 'left')->
                join('gurus', 'gurus.id = absensis.guru_id', 'left')->
                join('mata_pelajarans', 'mata_pelajarans.id = absensis.mata_pelajaran_id', 'left')->
                join('tahun_ajarans', 'tahun_ajarans.id = absensis.tahun_ajaran_id', 'left');
    }

    // is_matpel = 1
    public function is_unique($siswa_id, $tanggal, $kelas_bagian_id, $tahun_ajaran_id, $bulan, $guru_id, $mata_pelajaran_id) {
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tanggal', $tanggal);
        $this->db->where('kelas_bagian_id', $kelas_bagian_id);
        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
        $this->db->where('bulan', $bulan);
        $this->db->where('guru_id', $guru_id);
        $this->db->where('mata_pelajaran_id', $mata_pelajaran_id);
        $query = $this->db->get('absensis');
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    // is_matpel = 1
    public function unique_check($siswa_id, $tanggal, $kelas_bagian_id, $tahun_ajaran_id, $bulan, $guru_id, $mata_pelajaran_id) {
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tanggal', $tanggal);
        $this->db->where('kelas_bagian_id', $kelas_bagian_id);
        $this->db->where('tahun_ajaran_id', $tahun_ajaran_id);
        $this->db->where('bulan', $bulan);
        $this->db->where('guru_id', $guru_id);
        $this->db->where('mata_pelajaran_id', $mata_pelajaran_id);
        return $this->db->get('absensis');
    }

}

?>
