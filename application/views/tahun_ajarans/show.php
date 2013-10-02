<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Tahun Ajaran
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Nama
            </td>
            <td>:</td>
            <td>
                <?php echo $tahun_ajaran['nama']."/".(((int)$tahun_ajaran['nama'])+1); ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
