<?php if (isset($breadc)) { ?>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
                <span class="divider">/</span>
            </li>
<!-- Kelas -->
<?php    if ($breadc['menu'] === "index_kelas") { ?>
            <li class="active">Kelas</li>
    <?php }
         else if($breadc['menu'] === "new_kelas") { ?>
            <li>
                <a href="<?php echo site_url('kelas'); ?>">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_kelas") { ?>
            <li>
                <a href="<?php echo site_url('kelas'); ?>">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_kelas") { ?>
            <li>
                <a href="<?php echo site_url('kelas'); ?>">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('kelas/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Kelas Bagian -->
    <?php }
         else if($breadc['menu'] === "new_kelas_bagian") { ?>
            <li>
                <a href="<?php echo site_url('kelas'); ?>">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('kelas/'.$breadc['kelas_id']); ?>"><?php echo $breadc['kelas_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Kelas Bagian</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "edit_kelas_bagian") { ?>
            <li>
                <a href="<?php echo site_url('kelas'); ?>">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('kelas/'.$breadc['kelas_id']); ?>"><?php echo $breadc['kelas_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Kelas Bagian</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Staff -->
    <?php }
         else if($breadc['menu'] === "index_staff") { ?>
            <li class="active">Staff</li>
    <?php }
         else if($breadc['menu'] === "new_staff") { ?>
            <li>
                <a href="<?php echo site_url('staffs'); ?>">Staff</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_staff") { ?>
            <li>
                <a href="<?php echo site_url('staffs'); ?>">Staff</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_staff") { ?>
            <li>
                <a href="<?php echo site_url('staffs'); ?>">Staff</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('staffs/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- SPP -->
    <?php }
         else if($breadc['menu'] === "index_spp") { ?>
            <li class="active">SPP</li>
    <?php }
         else if($breadc['menu'] === "new_spp") { ?>
            <li>
                <a href="<?php echo site_url('spps'); ?>">SPP</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_spp") { ?>
            <li>
                <a href="<?php echo site_url('spps'); ?>">SPP</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_spp") { ?>
            <li>
                <a href="<?php echo site_url('spps'); ?>">SPP</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('spps/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Guru -->
<?php }
         else if($breadc['menu'] === "index_guru") { ?>
            <li class="active">Guru</li>
    <?php }
         else if($breadc['menu'] === "new_guru") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_guru") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_guru") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Guru Ijazah -->
    <?php }
         else if($breadc['menu'] === "new_guru_ijazah") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['guru_id']); ?>"><?php echo $breadc['guru_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Ijazah</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "edit_guru_ijazah") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['guru_id']); ?>"><?php echo $breadc['guru_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Ijazah</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Guru Wali -->
    <?php }
         else if($breadc['menu'] === "new_guru_wali") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['guru_id']); ?>"><?php echo $breadc['guru_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Ijazah</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "edit_guru_wali") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['guru_id']); ?>"><?php echo $breadc['guru_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Wali</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Guru Mata Pelajaran -->
    <?php }
         else if($breadc['menu'] === "new_guru_mata_pelajaran") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['guru_id']); ?>"><?php echo $breadc['guru_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Mata Pelajaran</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "edit_guru_mata_pelajaran") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['guru_id']); ?>"><?php echo $breadc['guru_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Mata Pelajaran</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Guru Kelas Matpel -->
    <?php }
         else if($breadc['menu'] === "new_guru_kelas_matpel") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['guru_id']); ?>"><?php echo $breadc['guru_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "edit_guru_kelas_matpel") { ?>
            <li>
                <a href="<?php echo site_url('gurus'); ?>">Guru</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('gurus/'.$breadc['guru_id']); ?>"><?php echo $breadc['guru_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Siswa -->
    <?php }
         else if($breadc['menu'] === "index_siswa") { ?>
            <li class="active">Siswa</li>
    <?php }
         else if($breadc['menu'] === "new_siswa") { ?>
            <li>
                <a href="<?php echo site_url('siswas'); ?>">Siswa</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_siswa") { ?>
            <li>
                <a href="<?php echo site_url('siswas'); ?>">Siswa</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_siswa") { ?>
            <li>
                <a href="<?php echo site_url('siswas'); ?>">Siswa</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('siswas/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Siswa Kelas -->
    <?php }
         else if($breadc['menu'] === "new_siswa_kelas") { ?>
            <li>
                <a href="<?php echo site_url('siswas'); ?>">Siswa</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('siswas/'.$breadc['siswa_id']); ?>"><?php echo $breadc['siswa_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "edit_siswa_kelas") { ?>
            <li>
                <a href="<?php echo site_url('siswas'); ?>">Siswa</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('siswas/'.$breadc['siswa_id']); ?>"><?php echo $breadc['siswa_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Kelas</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="#"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Siswa Nilai -->
    <?php }
         else if($breadc['menu'] === "index_siswa_nilai") { ?>
            <li class="active">Nilai</li>
    <?php }
         else if($breadc['menu'] === "new_siswa_nilai") { ?>
            <li>
                <a href="<?php echo site_url('siswanilais'); ?>">Nilai</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_siswa_nilai") { ?>
            <li>
                <a href="<?php echo site_url('siswanilais'); ?>">Nilai</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_siswa_nilai") { ?>
            <li>
                <a href="<?php echo site_url('siswanilais'); ?>">Nilai</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('siswanilais/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- User -->
    <?php }
         else if($breadc['menu'] === "index_user") { ?>
            <li class="active">User</li>
    <?php }
         else if($breadc['menu'] === "new_user") { ?>
            <li>
                <a href="<?php echo site_url('users'); ?>">User</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_user") { ?>
            <li>
                <a href="<?php echo site_url('users'); ?>">User</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_user") { ?>
            <li>
                <a href="<?php echo site_url('users'); ?>">User</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('users/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
    <?php }
         else if($breadc['menu'] === "edit_password_user") { ?>
            <li>
                <a href="<?php echo site_url('users'); ?>">User</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('users/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('users/'.$breadc['id'].'/edit'); ?>">Edit</a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit Password</li>
<!-- User Group -->
    <?php }
         else if($breadc['menu'] === "index_user_group") { ?>
            <li class="active">User Group</li>
    <?php }
         else if($breadc['menu'] === "new_user_group") { ?>
            <li>
                <a href="<?php echo site_url('usergroups'); ?>">User Group</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_user_group") { ?>
            <li>
                <a href="<?php echo site_url('usergroups'); ?>">Grup User</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['ugrp_id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_user_group") { ?>
            <li>
                <a href="<?php echo site_url('usergroups'); ?>">Grup User</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('usergroups/'.$breadc['ugrp_id']); ?>"><?php echo $breadc['ugrp_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Privilege -->
    <?php }
         else if($breadc['menu'] === "index_privilege") { ?>
            <li class="active">Privilege</li>
    <?php }
         else if($breadc['menu'] === "new_privilege") { ?>
            <li>
                <a href="<?php echo site_url('privileges'); ?>">Hak Akses</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_privilege") { ?>
            <li>
                <a href="<?php echo site_url('privileges'); ?>">Hak Akses</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['upriv_id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_privilege") { ?>
            <li>
                <a href="<?php echo site_url('privileges'); ?>">Hak Akses</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('privileges/'.$breadc['upriv_id']); ?>"><?php echo $breadc['upriv_id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Group Privilege -->
    <?php }
         else if($breadc['menu'] === "index_group_privilege") { ?>
            <li class="active">User Privilege</li>
    <?php }
         else if($breadc['menu'] === "new_group_privilege") { ?>
            <li>
                <a href="<?php echo site_url('groupprivileges'); ?>">Hak Akses Grup</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_group_privilege") { ?>
            <li>
                <a href="<?php echo site_url('groupprivileges'); ?>">Hak Akses Grup</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_group_privilege") { ?>
            <li>
                <a href="<?php echo site_url('groupprivileges'); ?>">Hak Akses Grup</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('groupprivileges/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- User Privilege -->
    <?php }
         else if($breadc['menu'] === "index_user_privilege") { ?>
            <li class="active">User Privilege</li>
    <?php }
         else if($breadc['menu'] === "new_user_privilege") { ?>
            <li>
                <a href="<?php echo site_url('userprivileges'); ?>">User Privilege</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_user_privilege") { ?>
            <li>
                <a href="<?php echo site_url('userprivileges'); ?>">User Privilege</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_user_privilege") { ?>
            <li>
                <a href="<?php echo site_url('userprivileges'); ?>">User Privilege</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('userprivileges/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Kurikulum -->
    <?php }
         else if($breadc['menu'] === "index_kurikulum") { ?>
            <li class="active">Kurikulum</li>
    <?php }
         else if($breadc['menu'] === "new_kurikulum") { ?>
            <li>
                <a href="<?php echo site_url('kurikulums'); ?>">Kurikulum</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_kurikulum") { ?>
            <li>
                <a href="<?php echo site_url('kurikulums'); ?>">Kurikulum</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_kurikulum") { ?>
            <li>
                <a href="<?php echo site_url('kurikulums'); ?>">Kurikulum</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('kurikulums/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Tahun Ajaran -->
    <?php }
         else if($breadc['menu'] === "index_tahun_ajaran") { ?>
            <li class="active">Tahun Ajaran</li>
    <?php }
         else if($breadc['menu'] === "new_tahun_ajaran") { ?>
            <li>
                <a href="<?php echo site_url('tahunajarans'); ?>">Tahun Ajaran</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_tahun_ajaran") { ?>
            <li>
                <a href="<?php echo site_url('tahunajarans'); ?>">Tahun Ajaran</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_tahun_ajaran") { ?>
            <li>
                <a href="<?php echo site_url('tahunajarans'); ?>">Tahun Ajaran</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('tahunajarans/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Jurusan -->
    <?php }
         else if($breadc['menu'] === "index_jurusan") { ?>
            <li class="active">Jurusan</li>
    <?php }
         else if($breadc['menu'] === "new_jurusan") { ?>
            <li>
                <a href="<?php echo site_url('jurusans'); ?>">Jurusan</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_jurusan") { ?>
            <li>
                <a href="<?php echo site_url('jurusans'); ?>">Jurusan</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_jurusan") { ?>
            <li>
                <a href="<?php echo site_url('jurusans'); ?>">Jurusan</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('jurusans/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Persentase Nilai -->
    <?php }
         else if($breadc['menu'] === "index_mata_pelajaran_persentase") { ?>
            <li class="active">Jurusan</li>
    <?php }
         else if($breadc['menu'] === "new_mata_pelajaran_persentase") { ?>
            <li>
                <a href="<?php echo site_url('matapelajaranpersentases'); ?>">Persentase Nilai</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_mata_pelajaran_persentase") { ?>
            <li>
                <a href="<?php echo site_url('matapelajaranpersentases'); ?>">Persentase Nilai</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_mata_pelajaran_persentase") { ?>
            <li>
                <a href="<?php echo site_url('matapelajaranpersentases'); ?>">Persentase Nilai</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('matapelajaranpersentases/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
<!-- Mata Pelajaran -->
    <?php }
         else if($breadc['menu'] === "index_mata_pelajaran") { ?>
            <li class="active">Mata Pelajaran</li>
    <?php }
         else if($breadc['menu'] === "new_mata_pelajaran") { ?>
            <li>
                <a href="<?php echo site_url('matapelajarans'); ?>">Mata Pelajaran</a>
                <span class="divider">/</span>
            </li>
            <li class="active">New</li>
    <?php }
         else if($breadc['menu'] === "show_mata_pelajaran") { ?>
            <li>
                <a href="<?php echo site_url('matapelajarans'); ?>">Mata Pelajaran</a>
                <span class="divider">/</span>
            </li>
            <li class="active"><?php echo $breadc['id']; ?></li>
    <?php }
         else if($breadc['menu'] === "edit_mata_pelajaran") { ?>
            <li>
                <a href="<?php echo site_url('matapelajarans'); ?>">Mata Pelajaran</a>
                <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo site_url('matapelajarans/'.$breadc['id']); ?>"><?php echo $breadc['id']; ?></a>
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
    <?php } ?>
        </ul>
<?php } ?>

