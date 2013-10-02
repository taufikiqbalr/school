<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">Data Siswa</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="3" class="text-left">
                <?php echo $siswa['foto']; ?>
            </td>
        </tr>
        <tr>
            <td>
                NIS
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['nis']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['nama']; ?>
            </td>
        </tr>
        <tr>
            <td>
                E-Mail
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['email']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Agama
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['agama']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Jenis Kelamin
            </td>
            <td>:</td>
            <td>
                <?php echo ($siswa['jk'] === '1') ? "Laki-Laki" : "Perempuan"; ?>
            </td>
        </tr>
        <tr>
            <td>
                Lahir
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['tmptlhr'] . ", " . $siswa['tgllhr']; ?>
            </td>
        </tr>
        <tr>
            <td>
                No Telepon
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['notel']; ?>
            </td>
        </tr>
        <tr>
            <td>
                No Handphone
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['nohp']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama Sekolah
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['nmsekolah']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Alamat Sekolah
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['almtsekolah']; ?>
            </td>
        </tr>
        <tr>
            <td>
                No Ijazah
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['noijasah']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nilai Ijazah
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['nilaiijasah']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nilai SKL
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['nilaiskl']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Alamat
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['almt']; ?>
            </td>
        </tr>
        <tr>
            <td>
                RT
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['rt']; ?>
            </td>
        </tr>
        <tr>
            <td>
                RW
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['rw']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Desa
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['desa']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kecamatan
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['kec']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kode Pos
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['kodepos']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">Data Orangtua Siswa</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Nama Bapak
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['nmbpk']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Pendidikan Bapak
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['pendidikanbpk']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Pekerjaan Bapak
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['pkrjbpk']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama Ibu
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['nmibu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Pendidikan Ibu
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['pendidikanibu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Pekerjaan Ibu
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['pkrjibu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Alamat
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['almtortu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                RT
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['rtortu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                RW
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['rwortu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Desa
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['desaortu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kecamatan
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['kecortu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kota
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['kotaortu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kode Pos
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['kodeposortu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                No Telepon
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa['tlportu']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Penghasilan Orangtua
            </td>
            <td>:</td>
            <td>
                <?php echo get_penghasilan((int)$siswa['penghasilanortu']); ?>
            </td>
        </tr>
    </tbody>
</table>

Kelas:
<table class="table table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Kelas</td>
            <td>Tahun Ajaran</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($siswa_kelas)) { ?>
            <?php foreach ($siswa_kelas as $key => $siswa_kela): ?>
                <tr>
                    <td>
                        <?php echo $key + 1 ?>
                    </td>
                    <td>
                        <?php echo get_full_kelas($siswa_kela['kelas_bagian_id']) ?>
                    </td>
                    <td>
                        <?php echo get_nama_tahun_ajaran($siswa_kela['tahun_ajaran_id']) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="3"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
