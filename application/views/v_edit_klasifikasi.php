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
                            <h1>Ubah Data Klasifikasi Air</h1>
                        </div>
                    </div>
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container">
                        <!-- BEGIN PAGE BREADCRUMBS -->
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?=base_url();?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="<?=base_url('klasifikasi')?>">Klasifikasi Air</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Ubah Klasifikasi Air</span>
                            </li>
                        </ul>
                        <!-- END PAGE BREADCRUMBS -->
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="page-content-inner">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Success!</strong> <?=$this->session->flashdata('success');?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($this->session->flashdata('error')): ?>
                                        <div class="alert alert-warning alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Warning!</strong> <?=$this->session->flashdata('error');?>
                                        </div>                                        
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-settings"></i>
                                                <span class="caption-subject bold uppercase"> Form Tambah Klasifikasi Air</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <form class="form-horizontal" role="form" action="<?=base_url('klasifikasi/update');?>" method="POST">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Jenis Klasifikasi</label>
                                                        <div class="col-md-9">
                                                            <input type="hidden" name="id_klasifikasi" value="<?=$data->id_klasifikasi;?>">
                                                            <input type="text" class="form-control" placeholder="Jeni Klasifikasi" name="jenis_klasifikasi" id="jenis_klasifikasi" required="" title="Jenis Klasifikasi harap diisi" data-toggle="tooltip" value="<?=$data->nama_klasifikasi;?>">
                                                            <span class="help-block"> Jenis Klasifikasi Wajib Diisi </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-action">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green">Submit</button>
                                                                <button type="button" class="btn default" onclick="return window.location.assign('<?=base_url('klasifikasi')?>')">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
