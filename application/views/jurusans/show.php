<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Jurusan
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
                <?php echo $jurusan['nama']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
