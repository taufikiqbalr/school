<div id="mainmenu" class="span3 sidebar">
    <ul class="nav nav-list">
        <li class="nav-header">Main</li>
        <?php if (is_privilege('INDEX_GURU')) { ?>
            <li id="sidebar-guru" class="">
                <a href="<?php echo site_url("gurus"); ?>">Guru</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_SISWA')) { ?>
            <li id="sidebar-siswa" class="">
                <a href="<?php echo site_url("siswas"); ?>">Siswa</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_KELAS')) { ?>
            <li id="sidebar-kelas" class="">
                <a href="<?php echo site_url("kelas"); ?>">Kelas</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_JURUSAN', $this->session->userdata('privileges'))) { ?>
            <li id="sidebar-jurusan" class="">
                <a href="<?php echo site_url("jurusans"); ?>">Jurusan</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_KURIKULUM', $this->session->userdata('privileges'))) { ?>
            <li id="sidebar-kurikulum" class="">
                <a href="<?php echo site_url("kurikulums"); ?>">Kurikulum</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_TAHUN_AJARAN', $this->session->userdata('privileges'))) { ?>
            <li id="sidebar-tahun_ajaran" class="">
                <a href="<?php echo site_url("tahunajarans"); ?>">Tahun Ajaran</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_MATA_PELAJARAN')) { ?>
            <li id="sidebar-mata_pelajaran" class="">
                <a href="<?php echo site_url("matapelajarans"); ?>">Mata Pelajaran</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_ABSENSI')) { ?>
            <li id="sidebar-absensi" class="">
                <a href="<?php echo site_url("absensis"); ?>">Absensi</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_NILAI')) { ?>
            <li id="sidebar-nilai" class="">
                <a href="<?php echo site_url("siswanilais"); ?>">Nilai</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_PERSEN_MP')) { ?>
            <li id="sidebar-persen_mp" class="">
                <a href="<?php echo site_url("matapelajaranpersentases"); ?>">Persentase Nilai</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_STAFF')) { ?>
            <li id="sidebar-staff" class="">
                <a href="<?php echo site_url("staffs"); ?>">Staff</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_SPP')) { ?>
            <li id="sidebar-spp" class="">
                <a href="<?php echo site_url("spps"); ?>">SPP</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_USER')) { ?>
            <li class="nav-header">User Management</li>

            <li id="sidebar-user" class="">
                <a href="<?php echo site_url("users"); ?>">User</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_GRUP_USER')) { ?>
            <li id="sidebar-user_group" class="">
                <a href="<?php echo site_url("usergroups"); ?>">Grup User</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_HAK_AKSES')) { ?>
            <li id="sidebar-privilege" class="">
                <a href="<?php echo site_url("privileges"); ?>">Hak Akses</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_HAK_AKSES_USER')) { ?>
            <li id="sidebar-user_privilege" class="">
                <a href="<?php echo site_url("userprivileges"); ?>">Hak Akses User</a>
            </li>
        <?php } ?>
        <?php if (is_privilege('INDEX_HAK_AKSES_GRUP')) { ?>
            <li id="sidebar-group_privilege" class="">
                <a href="<?php echo site_url("groupprivileges"); ?>">Hak Akses Grup</a>
            </li>
        <?php } ?>
    </ul>
</div>
<div class="span12">