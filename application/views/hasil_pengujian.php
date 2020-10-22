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
                                > <a href="<?=base_url('pengujian')?>">Pengujian Air</a>
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
                                                <form action="<?= base_url('pengujian-air') ?>" method="POST" class="form-body col-sm-6">
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="fomr-group">
                                                                <label class="control-label col-sm-6" for="learningRate">Learning Rate&nbsp;(&alpha;)</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="number" min="0.1" name="learningRate" required="" id="learningRate" value="<?= $this->input->post("learningRate") ?>" step="0.1" max="1" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="fomr-group">
                                                                <label class="control-label col-sm-6" for="epoch">Epoch</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="number" min="1" name="epoch" required="" id="epoch" value="<?= $this->input->post("epoch"); ?>" step="1" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="fomr-group">
                                                                <label class="control-label col-sm-6" for="target">Target</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="number" min="1" name="target" required="" id="target" value="<?= $this->input->post("target"); ?>" max="3" step="1" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="fomr-group">
                                                                <label class="control-label col-sm-6" for="window">Window</label>
                                                                <div class="col-sm-6">
                                                                <input class="form-control" type="number" name="window" required="" id="window" value="<?= $this->input->post("window"); ?>"readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    try {
                                                        foreach ($data_klasifikasi->result() as $klasifikasi) {
                                                            $nama_klasifikasi = $klasifikasi->nama_klasifikasi;
                                                            $id_klasifikasi = $klasifikasi->id_klasifikasi;
                                                            $lower_nama_klasifikasi = strtolower($nama_klasifikasi);
                                                    ?>
                                                            <div class="portlet-body form">
                                                                <div class="form-body">
                                                                    <div class="fomr-group">
                                                                        <label class="control-label col-sm-6" for="klasifikasi_<?= $id_klasifikasi; ?>"><?= $nama_klasifikasi; ?></label>
                                                                        <div class="col-sm-6">
                                                                            <input class="form-control" type="number" name="<?= $lower_nama_klasifikasi ?>" readonly id="klasifikasi_<?= $id_klasifikasi; ?>" value="<?= $this->input->post($lower_nama_klasifikasi) ?>">
                                                                            <input type="hidden" name="id_klasifikasi" value="<?= $id_klasifikasi; ?>">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    } catch (Exception $e) {
                                                        ?>
                                                        <h3><?= $e->getMessage(); ?></h3>
                                                    <?php
                                                    }
                                                    $Target = $hasil['kelas'];

                                                    ?>

                                                </form>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="portlet-body table">
                                                        <div class="table-scrollable">
                                                            <table class="table table-striped table-hover">

                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            Total Data Latih
                                                                        </td>
                                                                        <td>
                                                                            <?=$hasil['TotalDataLatihan'];?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Total Data Yang Benar
                                                                        </td>
                                                                        <td>
                                                                            <?=$hasil['TotalDataSesuai'];?>
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
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <a href="<?=base_url('pengujian')?>" class="btn blue">Lakukan Pengujian Ulang</a>
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