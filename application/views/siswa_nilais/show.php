<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Nilai Siswa
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Guru
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['nip'].' - '.$siswa_nilai['nama_guru'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Siswa
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['nis'].' - '.$siswa_nilai['nama_siswa'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Mata Pelajaran
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['kode'].' - '.$siswa_nilai['nama_mata_pelajaran'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Kelas
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['tingkat'].' '.$siswa_nilai['nama_jurusan'].' '.$siswa_nilai['nama_kelas'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Kurikulum
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['nama_kurikulum']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Tahun Ajaran
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['nama_tahun_ajaran']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Semester
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['semester'] === "1" ? "Ganjil" : "Genap"; ?>
            </td>
        </tr>
        <tr>
            <td>
                Jenis
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['jenis']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['nama']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nilai
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['nilai']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
