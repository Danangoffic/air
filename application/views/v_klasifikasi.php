<div class="page-wrapper-row full-height">
	<div class="page-wrapper-middle">
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<!-- BEGIN CONTENT BODY -->
				<!-- BEGIN PAGE HEAD-->
				<div class="page-head">
					<div class="container">
						<!-- BEGIN PAGE TITLE -->
						<div class="page-title">
							<h1>Data Kandungan Air</h1>
						</div>
						<!-- END PAGE TITLE -->
						<!-- BEGIN PAGE TOOLBAR -->
						<div class="page-toolbar">
							<div style="margin-top: 15px;">
								<a class="btn green btn-outline" href="<?= base_url('klasifikasi/add') ?>"><i class="fa fa-plus-circle"></i> Tambah Data Kandungan Air</a>
							</div>
						</div>
						<!-- END PAGE TOOLBAR -->
					</div>
				</div>
				<!-- END PAGE HEAD-->
				<!-- BEGIN PAGE CONTENT BODY -->
				<div class="page-content">
					<div class="container">
						<!-- BEGIN PAGE BREADCRUMBS -->
						<!-- <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?= base_url(); ?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Klasifikasi Air</span>
                            </li>
                        </ul> -->
						<!-- END PAGE BREADCRUMBS -->
						<!-- BEGIN PAGE CONTENT INNER -->
						<div class="page-content-inner">
							<div class="row">
								<div class="col-md-12">
									<?php if ($this->session->flashdata('success')) : ?>
										<div class="alert alert-success alert-dismissable">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
											<strong>Success!</strong> <?= $this->session->flashdata('success'); ?>
										</div>
									<?php endif; ?>
									<?php if ($this->session->flashdata('error')) : ?>
										<div class="alert alert-warning alert-dismissable">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
											<strong>Warning!</strong> <?= $this->session->flashdata('error'); ?>
										</div>
									<?php endif; ?>
									<!-- BEGIN SAMPLE TABLE PORTLET-->
									<div class="portlet box green">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-table"></i>Tabel Data Kandungan Air </div>
										</div>
										<div class="portlet-body flip-scroll">
											<table class="table table-bordered table-striped table-condensed flip-content table-hover">
												<thead class="flip-content">
													<tr>
														<th width="5%" class="text-center"> No </th>
														<th> Kandungan Air </th>
														<th class="text-center"> Aksi </th>
													</tr>
												</thead>
												<tbody>
													<?php if ($data->num_rows() > 0) :
														$no = 1;
														foreach ($data->result() as $kandungan_air) {
															$kandungan = $kandungan_air->nama_klasifikasi;
													?>
															<tr>
																<td class="text-center"><?= $no; ?></td>
																<td><?= $kandungan; ?></td>
																<td class="text-center">
																	<?php if ($kandungan == "PH" || $kandungan == "TDS" || $kandungan == "TH" || $kandungan == "Fe" || $kandungan == "Mn" || $kandungan == "SO4" || $kandungan == "TC") : ?>
																	<?php else : ?>
																		<a class="btn btn-info" href="<?= base_url('klasifikasi/edit/') . $kandungan_air->id_klasifikasi ?>"><i class="fa fa-edit"></i> Edit</a>
																		<a class="btn btn-danger" href="<?= base_url('klasifikasi/delete/') . $kandungan_air->id_klasifikasi ?>"><i class="fa fa-trash fa-fw"></i> Delete</a>
																	<?php endif; ?>
																</td>
															</tr>
														<?php
															$no++;
														}
														?>
													<?php elseif ($data->num_rows() == 0) : ?>
														<tr>
															<td colspan="3" class="text-center">
																<a class="btn btn-info" href="<?= base_url('klasifikasi/add') ?>"><i class="fa fa-plus-circle"></i> Tambah Jenis Klasifikasi</a>
															</td>
														</tr>
													<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
									<!-- END SAMPLE TABLE PORTLET-->
								</div>
							</div>
						</div>
						<!-- END PAGE CONTENT INNER -->
					</div>
				</div>
				<!-- END PAGE CONTENT BODY -->
				<!-- END CONTENT BODY -->
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END CONTAINER -->
	</div>
</div>
