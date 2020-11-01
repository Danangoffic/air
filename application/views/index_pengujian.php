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
                        <!-- <div class="page-title">
                            <h1>Pengujian Air</h1>
                        </div> -->
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <!-- <div class="page-toolbar">
                            <div style="margin-top: 15px;">
                                
                            </div>
                        </div> -->
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
                                <span>Pengujian Air</span>
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
                                                <i class="fa fa-eyedropper"></i>Form Input Pengujian </div>
                                        </div>
                                        <div class="portlet-body flip-scroll">
                                            <div class="row">
                                                <form action="<?= base_url('pengujian-air') ?>" method="POST" class="form-body col-sm-6">
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-6" for="learningRate">Learning Rate&nbsp;(&alpha;)</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="number" min="0.1" name="learningRate" required="" id="learningRate" value="0" step="0.1" max="1" value="0.1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-6" for="epoch">Epoch</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="number" min="1" name="epoch" required="" id="epoch" value="1" step="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-6" for="window">Window</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="number" min="0.1" name="window" required="" id="window" value="0.1" max="1" step="0.1">
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
                                                                        <div class="form-group">
                                                                            <label class="control-label col-sm-6" for="klasifikasi_<?= $id_klasifikasi; ?>"><?= $nama_klasifikasi; ?></label>
                                                                            <div class="col-sm-6">
                                                                                <input step="0.00001" class="form-control" type="number" min="0" name="<?= $lower_nama_klasifikasi ?>" required="" id="klasifikasi_<?= $id_klasifikasi; ?>" value="<?=$input_user[$lower_nama_klasifikasi]?>">
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
                                                        ?>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="col-md-12">
                                                            <div class="form-body">
                                                                <div class="form-group m-t-20">
                                                                    <button class="btn btn-primary" type="submit">Uji Data</button>
                                                                    <button class="btn btn-danger" type="reset">Reset</button>
                                                                    <!-- <a class="btn btn-default" href="<?= base_url($act . '/history_pengujian') ?>">Lihat History</a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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