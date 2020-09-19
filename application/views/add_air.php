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
                            <h1>Tambah Data Air</h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <!-- <div class="page-toolbar">
                            <div style="margin-top: 15px;">
                            <a class="btn green btn-outline" href="<?=base_url('air/add')?>"><i class="fa fa-plus-circle"></i> Tambah Alat</a>
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
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?=base_url();?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="<?=base_url('air')?>">Air</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Tambah Air</span>
                            </li>
                        </ul>
                        <!-- END PAGE BREADCRUMBS -->
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="page-content-inner">
                            <div class="row">
                            <!-- ALERT -->
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
                                    <form class="form-horizontal" role="form" action="<?=base_url('air/insert');?>" method="POST">
                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-settings"></i>
                                                    <span class="caption-subject bold uppercase"> Form Tambah Jenis Air</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Nama Jenis Air</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Jenis Air" name="nama_air" id="nama_air" required="" title="Jenis Air" data-toggle="tooltip">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="portlet light">
                                            <div class="portlet-body form">
                                            <?php
                                            if($data_klasifikasi->num_rows() > 0){
                                                foreach ($data_klasifikasi->result() as $klasifikasi) {
                                                ?>
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><?=$klasifikasi->nama_klasifikasi?></label>
                                                        <div class="col-md-9">
                                                        <input type="hidden" name="id_klasifikasi[]" value="<?=$klasifikasi->id_klasifikasi;?>">
                                                            <input type="number" value="0" step="0.1" min="0" class="form-control" placeholder="Bobot Klasifikasi <?=$klasifikasi->nama_klasifikasi?>" name="klasifikasi[]" id="klasifikasi" required="" title="Bobot Klasifikasi <?=$klasifikasi->nama_klasifikasi?>" data-toggle="tooltip">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </div>
                                            <div class="form-action">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green">Submit</button>
                                                                <button type="button" class="btn default" onclick="return window.location.assign('<?=base_url('air')?>')">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
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
