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
                            <h1>Pengujian Air</h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <div class="page-toolbar">
                            <div style="margin-top: 15px;">
                                <a class="btn green btn-outline" href="<?= base_url($act . '/history_pengujian') ?>"><i class="fa fa-minus-circle"></i> Lihat Sejarah Pengujian</a>
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
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?= base_url(); ?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
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
                                                <i class="fa fa-eyedropper"></i>Lakukan Pengujian </div>
                                            <div class="tools">
                                                <!-- <a href="javascript:;" class="collapse"> </a>
                                                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                                <a href="javascript:;" class="reload"> </a> -->
                                                <!-- <a href="javascript:;" class="remove"> </a> -->
                                            </div>
                                        </div>
                                        <div class="portlet-body flip-scroll">
                                            <div class="row">
                                                <form action="<?= base_url($act . '/doPengujian') ?>" method="" novalidate="" class="form-body col-sm-6">
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="fomr-group">
                                                                <label class="control-label col-sm-6" for="learningRate">Learning Rate&nbsp;(&alpha;)</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="number" min="0.1" name="learningRate" required="" id="learningRate" value="0" step="0.1" max="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    try {
                                                        foreach ($data_klasifikasi->result() as $klasifikasi) {
                                                    ?>
                                                            <div class="portlet-body form">
                                                                <div class="form-body">
                                                                    <div class="fomr-group">
                                                                        <label class="control-label col-sm-6" for="klasifikasi_<?= $klasifikasi->id_klasifikasi; ?>"><?= $klasifikasi->nama_klasifikasi; ?></label>
                                                                        <div class="col-sm-6">
                                                                            <input <?= ($klasifikasi->nama_klasifikasi == "PH") ? "max=\"14\" step=\"0.1\"" : ""; ?> class="form-control" type="number" min="0" name="<?=$klasifikasi->nama_klasifikasi?>" required="" id="klasifikasi_<?= $klasifikasi->id_klasifikasi; ?>" value="0">
                                                                            <input type="hidden" name="id_klasifikasi" value="<?= $klasifikasi->id_klasifikasi; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    } catch (Exception $e) {
                                                        ?>
                                                        <h3><?= $e ?></h3>
                                                    <?php
                                                    }

                                                    ?>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="form-group m-t-20">
                                                                <button class="btn btn-primary" type="submit">Uji Data</button>
                                                                <button class="btn btn-danger" type="reset">Reset</button>
                                                                <a class="btn btn-default" href="<?= base_url($act . '/history_pengujian') ?>">Lihat History</a>
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