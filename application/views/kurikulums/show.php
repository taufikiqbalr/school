<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Kurikulum
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
                <?php echo $kurikulum['nama']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
