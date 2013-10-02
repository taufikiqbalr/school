<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data SPP
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                NIS
            </td>
            <td>:</td>
            <td>
                <?php echo $spp['nis']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama
            </td>
            <td>:</td>
            <td>
                <?php echo $spp['nama']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Bulan
            </td>
            <td>:</td>
            <td>
                <?php echo $spp['bulan_tempo']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Tahun
            </td>
            <td>:</td>
            <td>
                <?php echo $spp['tahun_tempo']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Tanggal Bayar
            </td>
            <td>:</td>
            <td>
                <?php echo $spp['tanggal_bayar']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Biaya
            </td>
            <td>:</td>
            <td>
                <?php echo "Rp. ".$spp['biaya'].",00"; ?>
            </td>
        </tr>
        <tr>
            <td>
                Bayar
            </td>
            <td>:</td>
            <td>
                <?php echo "Rp. ".$spp['bayar'].",00"; ?>
            </td>
        </tr>
        <tr>
            <td>
                Status
            </td>
            <td>:</td>
            <td>
                <?php echo ($spp['lunas'] === '1') ? "Lunas" : "Belum Lunas"; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
