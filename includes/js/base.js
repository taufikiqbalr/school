$(document).ready(function() {
    $('.button-save').button();

    $('.button-save').on("click", function() {
        var btn = $(this);
        btn.button('loading');
        setTimeout(function() {
            btn.button('reset');
        }, 3000);
    });

    // kelas
    $('#kelas_checkall').on('change', function(event) {
        $('table.kelas_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.kelas_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#kelas_checkall').prop("checked", false);
        }
    });

    $('#kelas_idx_del').on('click', function() {
        $("#tb_kelas_idx_frm").submit();
    });

    $('#submit-kelas-edit').on('click', function() {
        $("#form-kelas-edit").submit();
    });

    $('#submit-kelas_bagian-deletes').on('click', function() {
        $("#form-kelas_bagian-edit").submit();
    });

    $('#kelas_bagian_checkall').on('change', function(event) {
        $('table.kelas_bagian-edit input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.kelas_bagian_edit_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#kelas_bagian_checkall').prop("checked", false);
        }
    });
    
    // user
    $('#user_checkall').on('change', function(event) {
        $('table.user_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.user_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#user_checkall').prop("checked", false);
        }
    });

    $('#user_idx_del').on('click', function() {
        $("#tb_user_idx_frm").submit();
    });

    // user group
    $('#user_group_checkall').on('change', function(event) {
        $('table.user_group_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.user_group_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#user_group_checkall').prop("checked", false);
        }
    });

    $('#user_group_idx_del').on('click', function() {
        $("#tb_user_group_idx_frm").submit();
    });

    // privilege
    $('#privilege_checkall').on('change', function(event) {
        $('table.privilege_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.privilege_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#privilege_checkall').prop("checked", false);
        }
    });

    $('#privilege_idx_del').on('click', function() {
        $("#tb_privilege_idx_frm").submit();
    });
    
    // user privilege
    $('#user_privilege_checkall').on('change', function(event) {
        $('table.user_privilege_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.user_privilege_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#user_privilege_checkall').prop("checked", false);
        }
    });

    $('#user_privilege_idx_del').on('click', function() {
        $("#tb_user_privilege_idx_frm").submit();
    });

    // group privilege
    $('#group_privilege_checkall').on('change', function(event) {
        $('table.group_privilege_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.group_privilege_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#group_privilege_checkall').prop("checked", false);
        }
    });

    $('#group_privilege_idx_del').on('click', function() {
        $("#tb_group_privilege_idx_frm").submit();
    });
    
    // staff
    $('#staff_checkall').on('change', function(event) {
        $('table.staff_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.staff_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#staff_checkall').prop("checked", false);
        }
    });

    $('#staff_idx_del').on('click', function() {
        $("#tb_staff_idx_frm").submit();
    });
    
    // staff ijazah
    $('#submit-staff_ijazah-deletes').on('click', function() {
        $("#form-staff_ijazah-edit").submit();
    });

    $('#staff_ijazah_checkall').on('change', function(event) {
        $('table.staff_ijazah-edit input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.staff_ijazah_edit_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#staff_ijazah_checkall').prop("checked", false);
        }
    });

    // guru
    $('#guru_checkall').on('change', function(event) {
        $('table.guru_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.guru_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#guru_checkall').prop("checked", false);
        }
    });

    $('#guru_idx_del').on('click', function() {
        $("#tb_guru_idx_frm").submit();
    });
    
    // guru wali
    $('#submit-guru_wali-deletes').on('click', function() {
        $("#form-guru_wali-edit").submit();
    });

    $('#guru_wali_checkall').on('change', function(event) {
        $('table.guru_wali-edit input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.guru_wali_edit_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#guru_wali_checkall').prop("checked", false);
        }
    });
    
    // guru ijazah
    $('#submit-guru_ijazah-deletes').on('click', function() {
        $("#form-guru_ijazah-edit").submit();
    });

    $('#guru_ijazah_checkall').on('change', function(event) {
        $('table.guru_ijazah-edit input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.guru_ijazah_edit_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#guru_ijazah_checkall').prop("checked", false);
        }
    });
    
    // guru mata pelajaran
    $('#submit-guru_mata_pelajaran-deletes').on('click', function() {
        $("#form-guru_mata_pelajaran-edit").submit();
    });

    $('#guru_mata_pelajaran_checkall').on('change', function(event) {
        $('table.guru_mata_pelajaran-edit input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.guru_mata_pelajaran_edit_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#guru_mata_pelajaran_checkall').prop("checked", false);
        }
    });
    
    // guru kelas matpel
    $('#submit-guru_kelas_matpel-deletes').on('click', function() {
        $("#form-guru_kelas_matpel-edit").submit();
    });

    $('#guru_kelas_matpel_checkall').on('change', function(event) {
        $('table.guru_kelas_matpel-edit input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.guru_kelas_matpel_edit_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#guru_kelas_matpel_checkall').prop("checked", false);
        }
    });

    // siswa
    $('#siswa_checkall').on('change', function(event) {
        $('table.siswa_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.siswa_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#siswa_checkall').prop("checked", false);
        }
    });

    $('#siswa_idx_del').on('click', function() {
        $("#tb_siswa_idx_frm").submit();
    });
    
    // siswa_nilai
    $('#siswa_nilai_checkall').on('change', function(event) {
        $('table.siswa_nilai_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.siswa_nilai_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#siswa_nilai_checkall').prop("checked", false);
        }
    });

    $('#siswa_nilai_idx_del').on('click', function() {
        $("#tb_siswa_nilai_idx_frm").submit();
    });
    
    // siswa_kelas
    $('#siswa_kelas_checkall').on('change', function(event) {
        $('table.siswa_kelas_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.siswa_kelas_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#siswa_kelas_checkall').prop("checked", false);
        }
    });

    $('#siswa_kelas_idx_del').on('click', function() {
        $("#tb_siswa_kelas_idx_frm").submit();
    });

    // kurikulum
    $('#kurikulum_checkall').on('change', function(event) {
        $('table.kurikulum_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.kurikulum_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#kurikulum_checkall').prop("checked", false);
        }
    });

    $('#kurikulum_idx_del').on('click', function() {
        $("#tb_kurikulum_idx_frm").submit();
    });

    // tahun_ajaran
    $('#tahun_ajaran_checkall').on('change', function(event) {
        $('table.tahun_ajaran_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.tahun_ajaran_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#tahun_ajaran_checkall').prop("checked", false);
        }
    });

    $('#tahun_ajaran_idx_del').on('click', function() {
        $("#tb_tahun_ajaran_idx_frm").submit();
    });

    // mata_pelajaran
    $('#mata_pelajaran_checkall').on('change', function(event) {
        $('table.mata_pelajaran_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.mata_pelajaran_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#mata_pelajaran_checkall').prop("checked", false);
        }
    });

    $('#mata_pelajaran_idx_del').on('click', function() {
        $("#tb_mata_pelajaran_idx_frm").submit();
    });
    
    // mata_pelajaran_persentase
    $('#mata_pelajaran_persentase_checkall').on('change', function(event) {
        $('table.mata_pelajaran_persentase_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.mata_pelajaran_persentase_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#mata_pelajaran_persentase_checkall').prop("checked", false);
        }
    });

    $('#mata_pelajaran_persentase_idx_del').on('click', function() {
        $("#tb_mata_pelajaran_persentase_idx_frm").submit();
    });
    
    // jurusan
    $('#jurusan_checkall').on('change', function(event) {
        $('table.jurusan_index input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $('.jurusan_index_ck').on('change', function(event) {
        if (!$(this).prop('checked')) {
            $('#jurusan_checkall').prop("checked", false);
        }
    });

    $('#jurusan_idx_del').on('click', function() {
        $("#tb_jurusan_idx_frm").submit();
    });
    
    // download template absensi
    $('#download-absensi-submit').on('click', function() {
        $("#download-absensi-form").submit();
    });
    
    $('#download-absensi-jam_awal').datetimepicker({
    	pickDate: false,
    	pickSeconds: false
	});
    
    $('#download-absensi-jam_akhir').datetimepicker({
    	pickDate: false,
    	pickSeconds: false
	});

    // date picker
    $('.date').datepicker();
//    $('#dp-guru-new-tgl_pgkt').datepicker();
//    $('#dp-guru-new-tgl_lhr').datepicker();
//    $('#dp-guru-edit-tgl_pgkt').datepicker();
//    $('#dp-guru-edit-tgl_lhr').datepicker();
//    $('#dp-siswa-new-tgl_lhr').datepicker();
//    $('#dp-siswa-edit-tgl_lhr').datepicker();
//    $('#dp-staff-new-tgl_lhr').datepicker();
//    $('#dp-staff-edit-tgl_lhr').datepicker();
    
    // time picker
    $('.timepicker').datetimepicker({
    	pickDate: false,
    	pickSeconds: false
	});
    

    // jquery numeric
    $(".numeric").numeric();
    $(".integer").numeric(false, function() {
        alert("Integers only");
        this.value = "";
        this.focus();
    });
    $(".positive").numeric({negative: false}, function() {
        alert("No negative values");
        this.value = "";
        this.focus();
    });
    $(".positive-integer").numeric({decimal: false, negative: false}, function() {
        alert("Positive integers only");
        this.value = "";
        this.focus();
    });

    // tempat
    $('.typeahead-tempat').typeahead({
        source: [
            "Jakarta", "Bandung", "Semarang", "Soreang",
            "Surabaya", "Sumedang", "Subang", "Cimahi", "Bogor"
        ]
    });

    // agama
    $('.typeahead-agama').typeahead({
        source: [
            "Islam", "Kristen Protestan", "Hindu", "Budha", "Kristen Katolik",
            "Konghucu"
        ]
    });
    
    // bulan
    $('.typeahead-bulan').typeahead({
        source: [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
            "Agustus", "September", "Oktober", "Nopember", "Desember"
        ]
    });
    
    // tahun
    $('.typeahead-tahun').typeahead({
        source: [
            "1990", "1991", "1992", "1993", "1994", "1995", "1996", "1997", "1998",
            "1999", "2000", "2001", "2002", "2003", "2004", "2005", "2006", "2007",
            "2008", "2009", "2010", "2011", "2012", "2013"
        ]
    });
    
});