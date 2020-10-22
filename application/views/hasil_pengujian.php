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
                        <!-- BEGIN PAGE TOOLBAR -->
                        <!-- END PAGE TOOLBAR -->
                    </div>
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container">
                        <!-- BEGIN PAGE BREADCRUMBS -->
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <span>Pengujian Air</span>
                            </li>
                        </ul>
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
                                                <i class="fa fa-eyedropper"></i>Hasil Pengujian </div>
                                            <div class="tools">
                                                <!-- <a href="javascript:;" class="collapse"> </a>
                                                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                                <a href="javascript:;" class="reload"> </a> -->
                                                <!-- <a href="javascript:;" class="remove"> </a> -->
                                            </div>
                                        </div>
                                        <div class="portlet-body flip-scroll">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr class="active">
                                                                <th width="50%">Variabel Input</th>
                                                                <th width="50%">Nilai</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Learning Rate (&alpha;) :</td>
                                                                <td><?= $this->input->post("learningRate") ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Epoch :</td>
                                                                <td><?= $this->input->post("epoch"); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Target :</td>
                                                                <td><?= $this->input->post("target"); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Window :</td>
                                                                <td><?= $this->input->post("window"); ?></td>
                                                            </tr>
                                                            <?php
                                                            foreach ($data_klasifikasi->result() as $klasifikasi) {
                                                                $nama_klasifikasi = $klasifikasi->nama_klasifikasi;
                                                                $id_klasifikasi = $klasifikasi->id_klasifikasi;
                                                                $lower_nama_klasifikasi = strtolower($nama_klasifikasi);
                                                            ?>
                                                                <tr>
                                                                    <td> <?= $nama_klasifikasi ?> :</td>
                                                                    <td><?= $this->input->post($lower_nama_klasifikasi) ?></td>
                                                                </tr>
                                                            <?php
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php $Target = $hasil['kelas']; ?>
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="success">
                                                                <th>Variabel Hasil Learning Vector Quantization 2</th>
                                                                <th>Hasil</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    Total Data Latih
                                                                </td>
                                                                <td>
                                                                    <?= $hasil['TotalDataLatihan']; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Total Data Yang Benar
                                                                </td>
                                                                <td>
                                                                    <?= $hasil['TotalDataSesuai']; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Akurasi </td>
                                                                <td> <?= $hasil['percentage'] . '%' ?> </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Target </td>
                                                                <td> <?= $Target ?> </td>
                                                            </tr>
                                                            <tr>
                                                                <?php $JenisAir = $this->air->getByIdJenis($Target)->row(); ?>
                                                                <td> Jenis Air </td>
                                                                <td> <?= $JenisAir->kategori_jenis; ?> </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <a href="<?= base_url('pengujian') ?>" class="btn blue">Lakukan Pengujian Ulang</a>
                                                </div>
                                            </div>
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