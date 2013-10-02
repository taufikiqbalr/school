<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Staff
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-left" colspan="3">
                <?php echo $staff['foto']; ?>
            </td>
        </tr>
        <tr>
            <td>
                NIK
            </td>
            <td>:</td>
            <td>
                <?php echo $staff['nik']; ?>
            </td>
        </tr>
        <tr>
            <td>
                E-Mail
            </td>
            <td>:</td>
            <td>
                <?php echo $staff['email']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Jenis Kelamin
            </td>
            <td>:</td>
            <td>
                <?php echo ($staff['jenis_kelamin'] === '1') ? "Laki-Laki" : "Perempuan"; ?>
            </td>
        </tr>
        <tr>
            <td>
                Agama
            </td>
            <td>:</td>
            <td>
                <?php echo $staff['agama']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Lahir
            </td>
            <td>:</td>
            <td>
                <?php echo $staff['tempat_lahir'] . ", " . $staff['tanggal_lahir']; ?>
            </td>
        </tr>
        <tr>
            <td>
                No Telepon
            </td>
            <td>:</td>
            <td>
                <?php echo $staff['no_telepon']; ?>
            </td>
        </tr>
        <tr>
            <td>
                No Handphone
            </td>
            <td>:</td>
            <td>
                <?php echo $staff['no_handphone']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Alamat
            </td>
            <td>:</td>
            <td>
                <?php echo $staff['alamat']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Status
            </td>
            <td>:</td>
            <td>
                <?php echo $staff['status']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>

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
        <?php if (!empty($staff_ijazahs)) { ?>
            <?php foreach ($staff_ijazahs as $key => $staff_ijazah): ?>
                <tr>
                    <td>
                        <?php echo $key + 1 ?>
                    </td>
                    <td>
                        <?php echo $staff_ijazah['nama_instansi'] ?>
                    </td>
                    <td>
                        <?php echo $staff_ijazah['tingkat'] ?>
                    </td>
                    <td>
                        <?php echo $staff_ijazah['nama_gelar'] ?>
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
