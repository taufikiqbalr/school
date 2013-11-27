<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-absensi a").each(function() {
            var g = "&order=<?php echo $order ?>&column=<?php echo $column ?>&cond=<?php echo $cond ?>";
            var href = $(this).attr('href');
            $(this).attr('href', href + g);
        });
    });
</script>

<?php echo $this->session->flashdata('message'); ?>
<div class="accordion" id="accordion2">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="float: right;">
                Advance <i class="icon-filter"></i> 
            </a>
            <div class="clearfix"></div>
        </div>
        <div id="collapseOne" class="accordion-body collapse out">
            <div class="accordion-inner">
                <?php if (is_privilege('NEW_ABSENSI')) { ?>
                    <?php echo form_open_multipart('absensis/upload'); ?>

                    <input type="file" name="absensi" size="20" />

                    <input type="submit" value="upload" />

                    <a href="#download-absensi" role="button" class="btn" data-toggle="modal">Download Template Absensi</a>

                    </form>
 
					<!-- Modal -->
					<div id="download-absensi" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="download-absensiLabel" aria-hidden="true">
					  <div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					    <h3 id="myModalLabel">Download Template Absensi</h3>
					  </div>
					  <div class="modal-body">
					    <?php echo form_open('absensis/download', array('class' => 'form-horizontal', 'id' => 'download-absensi-form')) ?>
					    	<div class="control-group">
							    <label class="control-label" for="tanggal">Tanggal</label>
							    <div class="controls">
							        <div id="dp-download-absensi-tanggal" class="input-append date" data-date-format="dd-mm-yyyy" data-date="<?php echo date('d-m-Y') ?>">
							            <input class="span2" type="text" readonly="" value="" name="tanggal">
							            <span class="add-on">
							                <i class="icon-calendar"></i>
							            </span>
							        </div>
							    </div>
							</div>
							<div class="control-group">
							    <label class="control-label" for="jam">Jam</label>
							    <div class="controls">
							    	<div id="download-absensi-jam_awal" class="input-append">
										<input name="jam_awal" data-format="hh:mm" type="text" class="input-small" readonly=""></input>
									    <span class="add-on">
									    	<i data-time-icon="icon-time" data-date-icon="icon-calendar">
									      	</i>
									    </span>
									</div>
									<label>-</label>
									<div id="download-absensi-jam_akhir" class="input-append">
										<input name="jam_akhir" data-format="hh:mm" type="text" class="input-small" readonly=""></input>
									    <span class="add-on">
									    	<i data-time-icon="icon-time" data-date-icon="icon-calendar">
									      	</i>
									    </span>
									</div>
							    </div>
							</div>
							<div class="control-group">
							    <label class="control-label" for="mata_pelajaran">Mata Pelajaran</label>
							    <div class="controls">
							        <select class="span2" name="mata_pelajaran">
							            <?php if (!empty($mata_pelajarans)) { ?>
							                <?php foreach ($mata_pelajarans as $mata_pelajaran): ?>
							                    <option value="<?php echo get_full_mata_pelajaran($mata_pelajaran['id'],TRUE) ?>"><?php echo get_full_mata_pelajaran($mata_pelajaran['id'],TRUE) ?></option>
							                <?php endforeach; ?>
							            <?php }else { ?>
							                    <option value=""> </option>
							            <?php } ?>
							        </select>
							    </div>
							</div>
							<div class="control-group">
							    <label class="control-label" for="guru">Guru</label>
							    <div class="controls">
							        <select class="span2" name="guru">
							            <?php if (!empty($gurus)) { ?>
							                <?php foreach ($gurus as $guru): ?>
							                    <option value="<?php echo get_full_guru($guru['id'],TRUE) ?>"><?php echo get_full_guru($guru['id'],TRUE) ?></option>
							                <?php endforeach; ?>
							            <?php }else { ?>
							                    <option value=""> </option>
							            <?php } ?>
							        </select>
							    </div>
							</div>
							<div class="control-group">
							    <label class="control-label" for="kelas_bagian_id">Kelas</label>
							    <div class="controls">
							        <select class="span2" name="kelas_bagian_id">
							            <?php if (!empty($kelas_bagians)) { ?>
							                <?php foreach ($kelas_bagians as $kelas_bagian): ?>
							                    <option value="<?php echo $kelas_bagian['id'] ?>"><?php echo get_full_kelas($kelas_bagian['id'],TRUE) ?></option>
							                <?php endforeach; ?>
							            <?php }else { ?>
							                    <option value=""> </option>
							            <?php } ?>
							        </select>
							    </div>
							</div>
					    </form>
					  </div>
					  <div class="modal-footer">
					    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
					    <button id="download-absensi-submit" class="btn btn-primary">Download</button>
					  </div>
					</div>
                <?php } ?>

                <form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('absensis') ?>">
                    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
                    <label>Kelas</label>
                    <select class="span1" name="kelas">
                        <option value=""> </option>
                        <?php if (!empty($kelas_bagians)) { ?>
                            <?php foreach ($kelas_bagians as $kelas_bagian): ?>
                                <option value="<?php echo $kelas_bagian['id'] ?>" <?php echo $kelas_bagian_id === $kelas_bagian['id'] ? "selected" : "" ?>><?php echo get_full_kelas($kelas_bagian['id']) ?></option>
                            <?php endforeach; ?>
                        <?php } ?>
                    </select>
                    <label>Tanggal</label>
                    <select class="span1" name="tanggal">
                        <option value=""> </option>
                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                            <option value="<?php echo $i ?>" <?php echo $tanggal === $i ? "selected" : "" ?>><?php echo $i ?></option>
                        <?php } ?>
                    </select>
                    <label>Bulan</label>
                    <select class="span1" name="bulan">
                        <option value=""> </option>
                        <?php foreach (months() as $key => $month) : ?>
                            <option value="<?php echo $key + 1 ?>" <?php echo ($key + 1) === ((int) $bulan) ? "selected" : "" ?>><?php echo $month ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Tahun</label>
                    <select class="span1" name="tahun_ajaran_id">
                        <option value=""> </option>
                        <?php if (!empty($tahun_ajarans)) { ?>
                            <?php foreach ($tahun_ajarans as $tahun_ajaran): ?>
                                <option value="<?php echo $tahun_ajaran['id'] ?>" <?php echo $tahun_ajaran_id === $tahun_ajaran['id'] ? "selected" : "" ?>><?php echo $tahun_ajaran['nama'] ?></option>
                            <?php endforeach; ?>
                        <?php } ?>
                    </select>
                    <label>Sort</label>
                    <select class="span1" name="order" id="absensi-order">
                        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
                        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
                    </select>
                    <label>By</label>
                    <select class="span2" name="column" id="absensi-column">
                        <option value="tanggal" <?php echo $column === "tanggal" ? "selected" : "" ?>>Tanggal</option>
                        <option value="nis" <?php echo $column === "nis" ? "selected" : "" ?>>NIS</option>
                        <option value="tingkat" <?php echo $column === "tingkat" ? "selected" : "" ?>>Kelas</option>
                    </select>
                    <button type="submit" class="btn">GO</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('absensis/deletes', 'id="tb_absensi_idx_frm"') ?>
<table class="table table-hover absensi_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="absensi_checkall" name="absensi_checkall" value="absensi_checkall" />
            </td>
            <td>Tanggal</td>
            <td>NIS</td>
            <td>Nama</td>
            <td>Kelas</td>
            <td>Mata Pelajaran</td>
            <td>Absensi</td>
            <td>Keterangan</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_ABSENSI')) { ?>
                            <li>
                                <a href="#modal_absensi_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($absensis)) { ?>
            <?php foreach ($absensis as $key => $absensi): ?>
                <tr>
                    <td>
                        <input class="absensi_index_ck" name="ids[]" type="checkbox" value="<?php echo $absensi['id']; ?>">
                    </td>
                    <td>
                        <?php echo $absensi['tanggal'] . " " . get_month($absensi['bulan']) . " " . $absensi['tahun'] ?>
                    </td>
                    <td>
                        <?php echo $absensi['nis'] ?>
                    </td>
                    <td>
                        <?php echo $absensi['nama_siswa'] ?>
                    </td>
                    <td>
                        <?php echo $absensi['tingkat'] . " " . $absensi['nama_jurusan'] . " " . $absensi['nama_kelas'] ?>
                    </td>
                    <td>
                        <?php echo $absensi['kode_mata_pelajaran'] . "-" . $absensi['nama_mata_pelajaran'] ?>
                    </td>
                    <td>
                        <?php echo get_absensi($absensi['absensi']) ?>
                    </td>
                    <td>
                        <?php echo $absensi['keterangan'] ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_ABSENSI')) { ?>
                                <a href="<?php echo site_url('absensis/' . $absensi['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_ABSENSI')) { ?>
                                <a href="<?php echo site_url('absensis/' . $absensi['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_ABSENSI')) { ?>
                                <a href="#modal_absensi_delete<?php echo $absensi['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_absensi_delete<?php echo $absensi['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Data Absensi</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus data absensi <?php echo $absensi['nip'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('absensis/' . $absensi['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="8"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>
<div class="clearfix"></div>
<div class="pagination-text pull-left">Halaman <?php echo $cur_page; ?> dari <?php echo $num_pages; ?> dengan total <?php echo $total_rows; ?> data</div>
<div id="pagination-absensi" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_ABSENSI')) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('absensis/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_absensi_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Data Absensi</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="absensi_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
