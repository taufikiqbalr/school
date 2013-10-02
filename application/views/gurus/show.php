<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Guru
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-left" colspan="3">
                <?php echo $guru['foto']; ?>
            </td>
        </tr>
        <tr>
            <td>
                NIP
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['nip']; ?>
            </td>
        </tr>
        <tr>
            <td>
                E-Mail
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['email']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Jenis Kelamin
            </td>
            <td>:</td>
            <td>
                <?php echo ($guru['jenis_kelamin'] === '1') ? "Laki-Laki" : "Perempuan"; ?>
            </td>
        </tr>
        <tr>
            <td>
                Agama
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['agama']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Lahir
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['tempat_lahir'] . ", " . $guru['tanggal_lahir']; ?>
            </td>
        </tr>
        <tr>
            <td>
                No Telepon
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['no_telepon']; ?>
            </td>
        </tr>
        <tr>
            <td>
                No Handphone
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['no_handphone']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Alamat
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['alamat']; ?>
            </td>
        </tr>
        <tr>
            <td>
                RT
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['rt']; ?>
            </td>
        </tr>
        <tr>
            <td>
                RW
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['rw']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Desa
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['desa']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kecamatan
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['kec']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kota
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['kota']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Kode Pos
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['kodepos']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Status
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['status']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Tanggal Pengangkatan
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['tanggal_pengangkatan']; ?>
            </td>
        </tr>
        <tr>
            <td>
                NUPTK
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['nuptk']; ?>
            </td>
        </tr>
        <tr>
            <td>
                NRG
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['nrg']; ?>
            </td>
        </tr>
        <tr>
            <td>
                NSG
            </td>
            <td>:</td>
            <td>
                <?php echo $guru['nsg']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>

Wali:
<table class="table table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Kelas</td>
            <td>Tahun Ajaran</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($guru_walis)) { ?>
            <?php foreach ($guru_walis as $key => $guru_wali): ?>
                <tr>
                    <td>
                        <?php echo $key + 1 ?>
                    </td>
                    <td>
                        <?php echo get_full_kelas($guru_wali['kelas_bagian_id']) ?>
                    </td>
                    <td>
                        <?php echo get_nama_tahun_ajaran($guru_wali['tahun_ajaran_id']) ?>
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

Ijazah:
<table class="table table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama Instansi</td>
            <td>Tingkat</td>
            <td>Nama Gelar</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($guru_ijazahs)) { ?>
            <?php foreach ($guru_ijazahs as $key => $guru_ijazah): ?>
                <tr>
                    <td>
                        <?php echo $key + 1 ?>
                    </td>
                    <td>
                        <?php echo $guru_ijazah['nama_instansi'] ?>
                    </td>
                    <td>
                        <?php echo $guru_ijazah['tingkat'] ?>
                    </td>
                    <td>
                        <?php echo $guru_ijazah['nama_gelar'] ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="4"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

Mengajar Matapelajaran:
<table class="table table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Mata Pelajaran</td>
            <td>Kurikulum</td>
            <td>Tahun Ajaran</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($guru_mata_pelajarans)) { ?>
            <?php foreach ($guru_mata_pelajarans as $key => $guru_mata_pelajaran): ?>
                <tr>
                    <td>
                        <?php echo $key + 1 ?>
                    </td>
                    <td>
                        <?php echo get_full_mata_pelajaran($guru_mata_pelajaran['mata_pelajaran_id']) ?>
                    </td>
                    <td>
                        <?php echo get_nama_kurikulum($guru_mata_pelajaran['kurikulum_id']) ?>
                    </td>
                    <td>
                        <?php echo get_nama_tahun_ajaran($guru_mata_pelajaran['tahun_ajaran_id']) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="4"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

Mengajar Di Kelas:
<table class="table table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Kelas</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($guru_kelas_matpels)) { ?>
            <?php foreach ($guru_kelas_matpels as $key => $guru_kelas_matpel): ?>
                <tr>
                    <td>
                        <?php echo $key + 1 ?>
                    </td>
                    <td>
                        <?php echo get_full_kelas($guru_kelas_matpel['kelas_bagian_id']) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="2"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
