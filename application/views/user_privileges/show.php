<?php echo $this->session->flashdata('message'); ?>

<table>
    <thead>
        <tr>
            <td colspan="3" class="text-left">
                Data Hak Akses User
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Nama User
            </td>
            <td>:</td>
            <td>
                <?php echo $user_privilege['username']; ?>
            </td>
        </tr>
        <tr>
            <td>
                Nama Hak Akses
            </td>
            <td>:</td>
            <td>
                <?php echo $user_privilege['upriv_name']; ?>
            </td>
        </tr>
    </tbody>
</table>
<br/>