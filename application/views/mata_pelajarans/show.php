<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Mata Pelajaran
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Kode
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran['kode']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama
            </td>
            <td>:</td>
            <td>
                <?php echo $mata_pelajaran['nama']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
