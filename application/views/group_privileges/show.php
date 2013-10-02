<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Hak Akses Grup
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Nama Grup
            </td>
            <td>:</td>
            <td>
                <?php echo $group_privilege['ugrp_name']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama Hak Akses
            </td>
            <td>:</td>
            <td>
                <?php echo $group_privilege['upriv_name']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>