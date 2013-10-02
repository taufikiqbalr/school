<?php echo $this->session->flashdata('message'); ?>
<!--<a href="<?php echo site_url('kelas') ?>" class="btn pull-right">Kembali</a>-->
<a href="<?php echo site_url('kelas/'.$kela['id'].'/edit') ?>" class="btn btn-warning pull-right" style="margin-right: 10px">Ubah</a><br/>
<div class="clearfix"></div>
<h3>Tingkat <?php echo $kela['tingkat']; ?></h3>

Bagian:
<table class="table table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($kelas_bagians)) { ?>
            <?php foreach ($kelas_bagians as $key => $kelas_bagian): ?>
                <tr>
                    <td>
                        <?php echo $key + 1 ?>
                    </td>
                    <td>
                        <?php echo $kelas_bagian['nama'] ?>
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

