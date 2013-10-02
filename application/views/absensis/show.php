<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Absensi
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Tanggal
            </td>
            <td>:</td>
            <td>
                <?php echo $absensi['tanggal'] . " " . get_month($absensi['bulan']) . " " . $absensi['tahun'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Kelas
            </td>
            <td>:</td>
            <td>
                <?php echo $absensi['tingkat'] . " " . $absensi['nama_jurusan'] . " " . $absensi['nama_kelas'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Guru
            </td>
            <td>:</td>
            <td>
                <?php echo $absensi['nip']." - ".$absensi['nama_guru']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Mata Pelajaran
            </td>
            <td>:</td>
            <td>
                <?php echo $absensi['kode_mata_pelajaran']." - ".$absensi['nama_mata_pelajaran']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Siswa
            </td>
            <td>:</td>
            <td>
                <?php echo $absensi['nis']." - ".$absensi['nama_siswa']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Absensi
            </td>
            <td>:</td>
            <td>
                <?php echo get_absensi($absensi['absensi']); ?>
            </td>
        </tr>
        <tr>
            <td>
                Keterangan
            </td>
            <td>:</td>
            <td>
                <?php echo $absensi['keterangan']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
