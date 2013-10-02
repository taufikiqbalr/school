<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswa_nilais
 *
 * @author L745
 */
class siswa_nilai_model extends CI_Model {

    private $count_row = 0;

    public function __construct() {
        $this->load->database();
        $this->load->model('guru_model');
        $this->load->model('guru_wali_model');
        $this->load->model('siswa_nilai_akhir_model');
    }

    // get column names
    public function column_names() {
        return array_merge(
                $this->db->list_fields('siswa_nilais'), $this->db->list_fields('siswas'), $this->db->list_fields('kelas'), $this->db->list_fields('gurus'), $this->db->list_fields('mata_pelajarans')
        );
    }

    // get siswa_nilai with ID
    public function get_siswa_nilai($id = FALSE) {
        $this->join();
        if ($id === FALSE) {
            $this->db->order_by("nip", "asc");
            $query = $this->db->get('siswa_nilais');
            return $query->result_array();
        }
        $query = $this->db->get_where('siswa_nilais', array('siswa_nilais.id' => $id));
        return $query->row_array();
    }

    // get siswa nilai with siswa_id
    public function get_siswa_nilais($siswa_id) {
        $this->db->order_by("id", "asc");
        $query = $this->db->get_where('siswa_nilais', array('siswa_id' => $siswa_id));
        return $query->result_array();
    }

    // count total rows
    public function get_total() {
        return $this->count_row;
    }

    // get siswa_nilai for pagination
    public function fetch_siswa_nilais($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        $this->join();
        if ($order === FALSE || $field === FALSE)
            $this->db->order_by("nip", "asc");
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
                    or_like('jenis', $cond)->
                    or_like('tingkat', $cond);
        $query = $this->db->get("siswa_nilais");
        $this->count_row = count($query->result_array());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    // get siswa_nilai for pagination
    public function fetch_siswa_nilais_per_guru_matpel($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
        if (count($guru) > 0) {
            $guru_kelas_matpel_ids = $this->guru_model->get_guru_kelas_matpel_ids($guru['id']);
            $this->join();
            if ($order === FALSE || $field === FALSE)
                $this->db->order_by("nip", "asc");
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
                        or_like('jenis', $cond)->
                        or_like('tingkat', $cond);
            $this->db->where_in("siswa_nilais.guru_kelas_matpel_id", $guru_kelas_matpel_ids);
            $query = $this->db->get("siswa_nilais");
            $siswa_nilais = $query->result_array();
            $this->count_row = $query->num_rows();
            if ($query->num_rows() > 0) {
                return $siswa_nilais;
            }
            return FALSE;
        } else {
            return FALSE;
        }
    }

    // get siswa_nilai for pagination
    public function fetch_siswa_nilais_per_guru_wali($limit, $start, $order = FALSE, $field = FALSE, $cond = FALSE) {
        $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
        if (count($guru) > 0) {
            // guru kelas
            $guru_kelas_matpel_ids = $this->guru_model->get_guru_kelas_matpel_ids($guru['id']);
            // guru wali
            $guru_walis = $this->guru_wali_model->get_guru_walis($guru['id']);
            $siswa_nilais = array();
            // return mata pelajaran
            $this->db->start_cache();
            $this->join();
            if ($order === FALSE || $field === FALSE)
                $this->db->order_by("nip", "asc");
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
                        or_like('jenis', $cond)->
                        or_like('tingkat', $cond);
            if (count($guru_kelas_matpel_ids) > 0)
                $this->db->where_in("siswa_nilais.guru_kelas_matpel_id", $guru_kelas_matpel_ids);
            $query = $this->db->get("siswa_nilais");
            if ($query->num_rows() > 0) {
                $siswa_nilais = $query->result_array();
            }

            // reset query
            $this->db->stop_cache();
            $this->db->flush_cache();

            // return wali
            foreach ($guru_walis as $guru_wali) {
                $this->db->start_cache();
                $this->join();
                if ($order === FALSE || $field === FALSE)
                    $this->db->order_by("nip", "asc");
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
                            or_like('jenis', $cond)->
                            or_like('tingkat', $cond);

                $this->db->where("kelas_bagians.id", $guru_wali['kelas_bagian_id']);
                $this->db->where("tahun_ajarans.id", $guru_wali['tahun_ajaran_id']);
                $query = $this->db->get("siswa_nilais");
                $siswa_nilai_s = $query->result_array();
                $siswa_nilais = array_merge($siswa_nilais, $siswa_nilai_s);

                // reset query
                $this->db->stop_cache();
                $this->db->flush_cache();
            }

            // remove same row
            $siswa_nilais_unique = array();
            foreach ($siswa_nilais as $siswa_nilai) {
                $hash = $siswa_nilai['id'];
                $siswa_nilais_unique[$hash] = $siswa_nilai;
            }
            $this->count_row = count($siswa_nilais_unique);

            if ($this->count_row > 0) {
                return $siswa_nilais_unique;
            }
            return FALSE;
        } else {
            return FALSE;
        }
    }

    public function raw_create($data) {
        $this->db->start_cache();
        
        // if uas hitung nilai akhir
        if ($data['jenis'] === 'UAS')
            $this->siswa_nilai_akhir_model->hitung_nilai_akhir($data['siswa_id'], $data['guru_kelas_matpel_id']);
        $status = $this->db->insert('siswa_nilais', $data);
        
        $this->db->stop_cache();
        $this->db->flush_cache();
        
        return $status;
    }

    // create new siswa_nilai
    public function create($data, $privilege = FALSE) {
        if (isset($data)) {
            if ($this->flexi_auth->is_admin() ||
                    in_array($privilege, $this->session->userdata('privileges'))) {
                $this->raw_create($data);
            } else {
                $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
                if (count($guru) > 0) {
                    $guru_kelas_matpel_ids = $this->guru_model->get_guru_kelas_matpel_ids($guru['id']);
                    $guru_kelas_matpel = $this->guru_kelas_matpel_model->get_guru_kelas_matpel($data["guru_kelas_matpel_id"]);
                    $siswa = $this->siswa_model->get_siswa_with_kelas($data["siswa_id"], $guru_kelas_matpel['kelas_bagian_id'], $guru_kelas_matpel['tahun_ajaran_id']);
                    if (in_array($data["guru_kelas_matpel_id"], $guru_kelas_matpel_ids) && count($siswa) > 0) {
                        $this->raw_create($data);
                    }
                    else
                        return FALSE;
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    public function raw_update($id, $data, $siswa_nilai) {
        $this->db->start_cache();

        $this->db->where('id', $id);
        $this->db->update('siswa_nilais', $data);
        // if uas hitung nilai akhir
        if ($siswa_nilai['jenis'] === 'UAS')
            $this->siswa_nilai_akhir_model->hitung_nilai_akhir($siswa_nilai['siswa_id'], $siswa_nilai['guru_kelas_matpel_id']);

        $this->db->stop_cache();
        $this->db->flush_cache();

        return TRUE;
    }

    // update siswa_nilai
    public function update($id, $data, $privilege = FALSE) {

        if (isset($data)) {
            $query = $this->db->get_where('siswa_nilais', array('id' => $id));
            $siswa_nilai = $query->row_array();
            if ($this->flexi_auth->is_admin() ||
                    in_array($privilege, $this->session->userdata('privileges'))) {
                $this->raw_update($id, $data, $siswa_nilai);
            } else {
                $guru = $this->guru_model->get_guru($this->session->userdata('user_data')['id']);
                if (count($guru) > 0) {
                    $guru_kelas_matpel_ids = $this->guru_model->get_guru_kelas_matpel_ids($guru['id']);
                    if (in_array($siswa_nilai['guru_kelas_matpel_id'], $guru_kelas_matpel_ids)) {
                        $this->raw_update($id, $data, $siswa_nilai);
                    } else {
                        return FALSE;
                    }
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    // delete siswa_nilai with ID
    public function delete($id) {
        $query = $this->db->get_where("siswa_nilais", array('id' => trim($id)));
        if ($query->num_rows() > 0) {
            $this->db->delete('siswa_nilais', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletes($ids) {
        if (!empty($ids)) {
            $this->db->query("DELETE FROM siswa_nilais WHERE id IN (" . implode(',', $ids) . ");");
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    // total nilai per jenis
    public function sum_nilai($siswa_id, $guru_kelas_matpel_id, $jenis) {
//        $this->db->select_sum('nilai');
//        $this->db->where('siswa_id', $siswa_id);
//        $this->db->where('guru_kelas_matpel_id', $guru_kelas_matpel_id);
//        $this->db->where('jenis', $jenis);
//        $query = $this->db->get('siswa_nilais');
//        $siswa_nilai = $query->row_array();
//        if (isset($siswa_nilai))
//            return ((int) $siswa_nilai['nilai']);
//        else
//            return 0;
        $query = $this->db->query('select sum(nilai) as sum_nilai from siswa_nilais where siswa_id=' . $siswa_id . '  and guru_kelas_matpel_id=' . $guru_kelas_matpel_id . ' and jenis="' . $jenis . '"');
        $result = $query->row_array();
        if (((int) $result['sum_nilai']) > 0)
            return ((int) $result['sum_nilai']);
        else
            return 1;
    }

    // jumlah ada berapa nilai per jenis
    public function count_nilai($siswa_id, $guru_kelas_matpel_id, $jenis) {
//        $this->db->where('siswa_id', $siswa_id);
//        $this->db->where('guru_kelas_matpel_id', $guru_kelas_matpel_id);
//        $this->db->where('jenis', $jenis);
//        $this->db->from('siswa_nilais');
//        if(((int)$this->db->count_all_results()) > 0)
//            return ((int)$this->db->count_all_results());
//        else
//            return 1;
        $query = $this->db->query('select count(nilai) as count_nilai from siswa_nilais where siswa_id=' . $siswa_id . '  and guru_kelas_matpel_id=' . $guru_kelas_matpel_id . ' and jenis="' . $jenis . '"');
        $result = $query->row_array();
        if (((int) $result['count_nilai']) > 0)
            return ((int) $result['count_nilai']);
        else
            return 1;
    }

    public function join() {
        $this->db->
                select('siswa_nilais.id AS id, 
                    siswa_nilais.jenis AS jenis,
                    siswa_nilais.nilai AS nilai,
                    siswa_nilais.nama AS nama,
                    siswa_nilais.siswa_id AS siswa_id,
                    siswa_nilais.guru_kelas_matpel_id AS guru_kelas_matpel_id,
                    kelas.tingkat AS tingkat, kelas_bagians.nama AS nama_kelas,
                    kelas_bagians.id AS kelas_bagian_id, tahun_ajarans.id AS tahun_ajaran_id,
                    kurikulums.nama AS nama_kurikulum, tahun_ajarans.nama AS nama_tahun_ajaran,
                    guru_mata_pelajarans.semester AS semester, gurus.nama AS nama_guru,
                    gurus.nip AS nip, mata_pelajarans.kode AS kode,
                    mata_pelajarans.nama AS nama_mata_pelajaran,
                    siswas.nis AS nis, siswas.nama AS nama_siswa,
                    jurusans.nama AS nama_jurusan')->
                join('guru_kelas_matpels', 'guru_kelas_matpels.id = siswa_nilais.guru_kelas_matpel_id', 'left')->
                join('guru_mata_pelajarans', 'guru_mata_pelajarans.id = guru_kelas_matpels.guru_mata_pelajaran_id', 'left')->
                join('gurus', 'gurus.id = guru_mata_pelajarans.guru_id', 'left')->
                join('mata_pelajarans', 'mata_pelajarans.id = guru_mata_pelajarans.mata_pelajaran_id', 'left')->
                join('kurikulums', 'kurikulums.id = guru_mata_pelajarans.kurikulum_id', 'left')->
                join('tahun_ajarans', 'tahun_ajarans.id = guru_mata_pelajarans.tahun_ajaran_id', 'left')->
                join('kelas_bagians', 'kelas_bagians.id = guru_kelas_matpels.kelas_bagian_id', 'left')->
                join('kelas', 'kelas.id = kelas_bagians.kelas_id', 'left')->
                join('siswas', 'siswas.id = siswa_nilais.siswa_id', 'left')->
                join('jurusans', 'jurusans.id = kelas.jurusan_id', 'left');
    }

}

?>
