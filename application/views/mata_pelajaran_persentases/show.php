<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Bobot Nilai
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
                <?php echo $mata_pelajaran_persentase['nip'].' - '.$mata_pelajaran_persentase['nama_guru'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Mata Pelajaran
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran_persentase['kode'].' - '.$mata_pelajaran_persentase['nama_mata_pelajaran'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Kelas
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran_persentase['tingkat'].' '.$mata_pelajaran_persentase['nama_jurusan'].' '.$mata_pelajaran_persentase['nama_kelas'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Kurikulum
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran_persentase['nama_kurikulum']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Tahun Ajaran
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran_persentase['nama_tahun_ajaran']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Semester
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran_persentase['semester']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Jenis
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran_persentase['jenis']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Persentase
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran_persentase['persentase']."%"; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
