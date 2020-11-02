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
                            <h1>Ubah Data Latih</h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <!-- <div class="page-toolbar">
                            <div style="margin-top: 15px;">
                            <a class="btn green btn-outline" href="<?= base_url('air/add') ?>"><i class="fa fa-plus-circle"></i> Tambah Alat</a>
                            </div>
                        </div> -->
                        <!-- END PAGE TOOLBAR -->
                    </div>
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container">
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="page-content-inner">
                            <div class="row">
                                <!-- ALERT -->
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <form class="form-horizontal" role="form" action="<?= base_url('latih/update'); ?>" method="POST">
                                    <input type="hidden" name="id_data_latih" value="<?=$detail->id_data_latih;?>">
                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-settings"></i>
                                                    <span class="caption-subject bold uppercase"> Form Ubah Data Latih</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                <?php
                                                foreach ($data_klasifikasi->result() as $key) {
                                                    $new_name = strtolower($key->nama_klasifikasi);
                                                ?>
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="<?= $new_name ?>"><?= $key->nama_klasifikasi ?></label>
                                                            <div class="col-md-9">
                                                                <input value="<?=$detail->$new_name;?>" type="number" min="0" step="0.000001" class="form-control" placeholder="<?= $key->nama_klasifikasi ?>" name="<?= $new_name ?>" id="<?= $new_name ?>" required="" title="<?= $key->nama_klasifikasi ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="target">TARGET</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" placeholder="TARGET" name="target" id="target" required="" title="Target" value="<?=$detail->target?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-action">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-offset-8 col-md-4">
                                                            <button type="submit" class="btn green">Submit</button>
                                                            <button type="button" class="btn default" onclick="return window.location.assign('<?= base_url('latih') ?>')">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="portlet light">
                                            
                                        </div> -->
                                    </form>
                                </div>
                                <div class="col-md-6"></div>
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