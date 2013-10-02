<?php

// only admin, privileged user, and guru kelas matpel who can edit
// params siswa_nilais.guru_kelas_bagian_id, users/gurus.guru_kelas_matpel_ids
function is_guru_matpel($guru_kelas_bagian_id, $priv, $privs) {
    $ci = & get_instance();
    if (!$ci->flexi_auth->is_admin() &&
            !in_array($privilege, $ci->session->userdata('privileges'))) {
        if (!in_array($guru_kelas_bagian_id, $privs)) {
            return FALSE;
        } else {
            return TRUE;
        }
    } else {
        return TRUE;
    }
}

function months() {
    return array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
}

function get_month($id) {
    switch ($id) {
        case 1:
            return 'Januari';
            break;
        case 2:
            return 'Februari';
            break;
        case 3:
            return 'Maret';
            break;
        case 4:
            return 'April';
            break;
        case 5:
            return 'Mei';
            break;
        case 6:
            return 'Juni';
            break;
        case 7:
            return 'Juli';
            break;
        case 8:
            return 'Agustus';
            break;
        case 9:
            return 'September';
            break;
        case 10:
            return 'Oktober';
            break;
        case 11:
            return 'Nopember';
            break;
        case 12:
            return 'Desember';
            break;
        default :
            return 'No Month';
            break;
    }
}

function absensi() {
    return array('Hadir', 'Izin', 'Sakit', 'Alpha');
}

function get_penghasilan($id) {
    switch ($id) {
        case 1:
            return '< Rp. 500.000';
            break;
        case 2:
            return ' Rp. 500.000 - Rp. 1.000.000';
            break;
        case 3:
            return 'Rp. 1.000.000 - Rp. 1.500.000';
            break;
        case 4:
            return 'Rp. 1.500.000 - Rp. 2.000.000';
            break;
        case 5:
            return 'Rp. 2.000.000 - Rp. 3.000.000';
            break;
        case 6:
            return 'Rp. 3.000.000 - Rp. 5.000.000';
            break;
        case 7:
            return '> Rp. 5.000.000';
            break;
    }
}

function get_absensi($id) {
    switch ($id) {
        case 1:
            return 'Hadir';
            break;
        case 2:
            return 'Izin';
            break;
        case 3:
            return 'Sakit';
            break;
        case 4:
            return 'Alpha';
            break;
        default :
            return 'Alpha';
            break;
    }
}

function is_privilege($privilege, $privileges = FALSE) {
    $ci = & get_instance();
    if ($ci->flexi_auth->is_admin() || in_array($privilege, $ci->session->userdata('privileges')))
        return TRUE;
    else
        return FALSE;
}

function is_guru($privilege, $privileges = FALSE) {
    $ci = & get_instance();
    if ($ci->flexi_auth->is_admin() ||
            in_array($privilege, $ci->session->userdata('privileges')) &&
            $ci->flexi_auth->get_user_group_id() != "2")
        return TRUE;
    else
        return FALSE;
}

function get_full_kelas($kelas_bagian_id) {
    $kelas_bagian = get_kelas_bagian($kelas_bagian_id);
    $kelas = get_kelas($kelas_bagian['kelas_id']);
    $jurusan = get_jurusan($kelas['jurusan_id']);
    $jurusan_nama = (count($jurusan) > 0) ? $jurusan['nama'] : "";
    return trim($jurusan_nama . ' ' . $kelas['tingkat'] . '-' . $kelas_bagian['nama']);
}

function get_full_mata_pelajaran($matpel_id) {
    $matpel = get_mata_pelajaran($matpel_id);
    if (count($matpel) > 0)
        return $matpel['kode'] . '-' . $matpel['nama'];
    else
        return '';
}

function get_full_guru($guru_id) {
    $guru = get_guru($guru_id);
    if (count($guru) > 0)
        return $guru['nip'] . '-' . $guru['nama'];
    else
        return '';
}

function get_nama_tahun_ajaran($tahun_ajaran_id) {
    $tahun_ajaran = get_tahun_ajaran($tahun_ajaran_id);
    if (count($tahun_ajaran) > 0)
        return $tahun_ajaran['nama'] . "/" . (((int) $tahun_ajaran['nama']) + 1);
    else
        return '';
}

function get_nama_kurikulum($kurikulum_id) {
    $kur = get_kurikulum($kurikulum_id);
    if (count($kur) > 0)
        return $kur['nama'];
    else
        return '';
}

function get_nama_jurusan($jurusan_id) {
    $jur = get_jurusan($jurusan_id);
    if (count($jur) > 0)
        return $jur['nama'];
    else
        return '';
}

function get_kelas($kelas_id) {
    $ci = & get_instance();
    $ci->load->model('kelas_model');
    $kelas = $ci->kelas_model->get_kelas($kelas_id);
    if (empty($kelas))
        return "";
    return $kelas;
}

function get_jurusan($jurusan_id) {
    $ci = & get_instance();
    $ci->load->model('jurusan_model');
    $jurusan = $ci->jurusan_model->get_jurusan($jurusan_id);
    if (count($jurusan) < 1)
        return "";
    return $jurusan;
}

function get_kelas_bagian($kelas_bagian_id) {
    $ci = & get_instance();
    $ci->load->model('kelas_bagian_model');
    $kelas_bagian = $ci->kelas_bagian_model->get_kelas_bagian($kelas_bagian_id);
    if (count($kelas_bagian) < 1)
        return "";
    return $kelas_bagian;
}

function get_tahun_ajaran($tahun_ajaran_id) {
    $ci = & get_instance();
    $ci->load->model('tahun_ajaran_model');
    $tahun_ajaran = $ci->tahun_ajaran_model->get_tahun_ajaran($tahun_ajaran_id);
    if (count($tahun_ajaran) < 1)
        return "";
    return $tahun_ajaran;
}

function get_kurikulum($kurikulum_id) {
    $ci = & get_instance();
    $ci->load->model('kurikulum_model');
    $kurikulum = $ci->kurikulum_model->get_kurikulum($kurikulum_id);
    if (count($kurikulum) < 1)
        return "";
    return $kurikulum;
}

function get_mata_pelajaran($matpel_id) {
    $ci = & get_instance();
    $ci->load->model('mata_pelajaran_model');
    $matpel = $ci->mata_pelajaran_model->get_mata_pelajaran($matpel_id);
    if (count($matpel) < 1)
        return "";
    return $matpel;
}

function get_guru($guru_id) {
    $ci = & get_instance();
    $ci->load->model('guru_model');
    $guru = $ci->guru_model->get_guru($guru_id);
    if (count($guru) < 1)
        return "";
    return $guru;
}
