<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data User
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Username
            </td>
            <td>:</td>
            <td>
                <?php echo $user['uacc_username']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Email
            </td>
            <td>:</td>
            <td>
                <?php echo $user['uacc_email']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Grup
            </td>
            <td>:</td>
            <td>
                <?php echo $user['ugrp_name']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>
