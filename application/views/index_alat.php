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
                            <h1>Olah Data Alat</h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <div class="page-toolbar">
                            <div style="margin-top: 15px;">
                                <a class="btn green btn-outline" href="<?=base_url('alat/add')?>"><i class="fa fa-plus-circle"></i> Tambah Alat</a>
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
                                <a href="<?=base_url();?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Air</span>
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
                                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-wrench"></i>Data Alat </div>
                                                <!-- <div class="tools">
                                                    <a href="javascript:;" class="collapse"> </a>
                                                    <a href="javascript:;" class="reload"> </a>
                                                    <a href="javascript:;" class="remove"> </a>
                                                </div> -->
                                            </div>
                                            <div class="portlet-body flip-scroll">
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead class="flip-content">
                                                        <tr>
                                                            <th width="5%" class="text-center">No</th>
                                                            <th> Nama Alat </th>
                                                            <th class="text-center"> Aksi </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($data_alat->num_rows() > 0): 
                                                            $no = 1;
                                                            foreach ($data_alat->result() as $alat) {
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?=$no;?></td>
                                                                    <td><?=$alat->nama_alat;?></td>
                                                                    <td class="text-center">
                                                                        <a class="btn btn-info" href="<?=base_url('alat/edit/').$alat->id_alat?>"><i class="fa fa-edit"></i> Edit</a>
                                                                        <a class="btn btn-danger" href="<?=base_url('alat/delete/').$alat->id_alat?>"><i class="fa fa-trash fa-fw"></i> Delete</a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $no++;
                                                            }
                                                            ?>
                                                            <?php elseif($data_alat->num_rows() == 0): ?>
                                                                <tr>
                                                                    <td colspan="3" class="text-center">
                                                                        <a class="btn btn-info" href="<?=base_url('alat/add')?>"><i class="fa fa-plus-circle"></i> Tambah Alat</a>
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
