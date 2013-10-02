<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-mata_pelajaran_persentase a").each(function() {
            var g = "&order=<?php echo $order ?>&column=<?php echo $column ?>&cond=<?php echo $cond ?>";
            var href = $(this).attr('href');
            $(this).attr('href', href + g);
        });
    });
</script>

<?php echo $this->session->flashdata('message'); ?>

<form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('matapelajaranpersentases') ?>">
    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
    <label>Sort</label>
    <select class="span1" name="order" id="mata_pelajaran_persentase-order">
        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
    </select>
    <label>By</label>
    <select class="span2" name="column" id="mata_pelajaran_persentase-column">
        <option value="nip" <?php echo $column === "nip" ? "selected" : "" ?>>Guru</option>
        <option value="kode" <?php echo $column === "kode" ? "selected" : "" ?>>Kode</option>
        <option value="tingkat" <?php echo $column === "tingkat" ? "selected" : "" ?>>Tingkat</option>
        <option value="jenis" <?php echo $column === "jenis" ? "selected" : "" ?>>Jenis</option>
    </select>
    <button type="submit" class="btn">GO</button>
</form>

<table class="table table-hover mata_pelajaran_persentase_index">
    <thead>
        <tr>
            <td>Guru</td>
            <td>Mata Pelajaran</td>
            <td>Kelas</td>
            <td>Jenis</td>
            <td>Persentase</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($mata_pelajaran_persentases)) { ?>
            <?php foreach ($mata_pelajaran_persentases as $key => $mata_pelajaran_persentase): ?>
                <tr>
                    <td>
                        <?php echo $mata_pelajaran_persentase['nip'].' - '.$mata_pelajaran_persentase['nama_guru'] ?>
                    </td>
                    <td>
                        <?php echo $mata_pelajaran_persentase['kode'].' - '.$mata_pelajaran_persentase['nama_mata_pelajaran'] ?>
                    </td>
                    <td>
                        <?php echo $mata_pelajaran_persentase['tingkat'].' '.$mata_pelajaran_persentase['nama_jurusan'].' '.$mata_pelajaran_persentase['nama_kelas'] ?>
                    </td>
                    <td>
                        <?php echo $mata_pelajaran_persentase['jenis'] ?>
                    </td>
                    <td>
                        <?php echo $mata_pelajaran_persentase['persentase'].'%' ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_PERSEN_MP', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('matapelajaranpersentases/' . $mata_pelajaran_persentase['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_PERSEN_MP', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('matapelajaranpersentases/' . $mata_pelajaran_persentase['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                        </p>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="6"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="clearfix"></div>
<div class="pagination-text pull-left">Halaman <?php echo $cur_page; ?> dari <?php echo $num_pages; ?> dengan total <?php echo $total_rows; ?> data</div>
<div id="pagination-mata_pelajaran_persentase" class="pagination-textlink pull-left"><?php echo $links; ?></div>
