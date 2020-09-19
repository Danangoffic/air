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
                            <h1>Detail Data Air <?=$nama_air?></h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <div class="page-toolbar">
                        
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
                                <a href="<?=base_url();?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="<?=base_url('air')?>">Air</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span><?=$nama_air;?></span>
                            </li>
                        </ul>
                        <!-- END PAGE BREADCRUMBS -->
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="page-content-inner">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-eyedropper"></i>Detail Data Jenis Air </div>
                                            <div class="tools">
                                                
                                                <!-- <a href="javascript:;" class="remove"> </a> -->
                                            </div>
                                        </div>
                                        <div class="portlet-body flip-scroll">
                                            <!-- <div class="col-sm-12">
                                            <div class="row"> -->
                                                <div class="form-group">
                                                    <label for="Jenis_air" class="label-control col-sm-2">Jenis Air : </label>
                                                    <b type="text" class="form-control-static" id="Jenis_air"><?=$nama_air;?></b>
                                                </div>
                                                <?php
                                                $no = 1;
                                                foreach($detail_data->result() as $data){
                                                ?>
                                                <div class="form-group">
                                                    <label for="jenis_klasifikasi_<?=$no;?>" class="label-control col-sm-2"><?=$data->nama_klasifikasi?> : </label>
                                                    <b type="text" class="form-control-static" id="jenis_klasifikasi_<?=$no;?>" readonly><?=$data->bobot;?></b>
                                                </div>
                                                <?php
                                                $no++;
                                                }
                                                ?>
                                            <!-- </div>
                                            <div class="row"> -->
                                                <div class="form-group">
                                                <a href="<?=base_url('air/edit/'.$detail_air->id_jenis)?>" class="btn btn-success">Edit</a>
                                                <a href="<?=base_url('air')?>" class="btn btn-default">Kembali</a>
                                                </div>
                                            <!-- </div>
                                            </div> -->
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
