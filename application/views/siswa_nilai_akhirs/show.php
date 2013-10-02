<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Nilai Akhir Siswa
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Mata Pelajaran
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai_akhir['kode'].' - '.$siswa_nilai_akhir['nama_mata_pelajaran'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Kurikulum
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai_akhir['nama_kurikulum']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kelas
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai_akhir['tingkat'].' '.$siswa_nilai_akhir['nama_jurusan'].' '.$siswa_nilai_akhir['nama_kelas'] ?>
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
                Siswa
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai_akhir['nis'].' - '.$siswa_nilai_akhir['nama_siswa'] ?>
            </td>
        </tr>
        <tr>
            <td>
                Nilai Akhir
            </td>
            <td>:</td>
            <td>
                <?php echo $siswa_nilai['nilai_akhir']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>

Rincian Nilai
<table>
    <thead>
        <tr>
            <?php if (!empty($siswa_nilais)) { ?>
                <?php foreach ($siswa_nilais as $siswa_nilai): ?>
                    <td>
                        <?php echo $siswa_nilai['jenis']." - ".$siswa_nilai['nama']; ?>
                    </td>
                 <?php endforeach; ?>
             <?php } ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php if (!empty($siswa_nilais)) { ?>
                <?php foreach ($siswa_nilais as $siswa_nilai): ?>
                    <td>
                        <?php echo $siswa_nilai['nilai']; ?>
                    </td>
                 <?php endforeach; ?>
             <?php } ?>
        </tr>
    </tbody>
</table>
