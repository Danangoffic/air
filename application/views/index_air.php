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
                            <h1>Data Jenis Air</h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <!-- <div class="page-toolbar">
                            <div style="margin-top: 15px;">
                                <a class="btn green btn-outline" href="<?= base_url('air/add') ?>"><i class="fa fa-plus-circle"></i> Tambah Jenis Air</a>
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
                                                <i class="fa fa-table"></i>Tabel Data Jenis Air </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"> </a>
                                                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                                <a href="javascript:;" class="reload"> </a>
                                                <!-- <a href="javascript:;" class="remove"> </a> -->
                                            </div>
                                        </div>
                                        <div class="portlet-body flip-scroll">
                                            <table class="table table-bordered table-striped table-condensed flip-content">
                                                <thead class="flip-content">
                                                    <tr>
                                                        <th width="10%" class="text-center"> No </th>
                                                        <th width="60%" class="text-center"> Jenis Air </th>
                                                        <!-- <th class="text-center"> Aksi </th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($data_air->num_rows() > 0) :
                                                        $no = 1;
                                                        foreach ($data_air->result() as $jenis_air) {
                                                    ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no; ?></td>
                                                                <td class="text-left"><?= $jenis_air->kategori_jenis; ?></td>
                                                                <!-- <td class="text-center" nowrap> -->
                                                                    <!-- <a href="<?= base_url("air/detail/" . $jenis_air->id_jenis) ?>" class="btn btn-default"><i class="fa fa-eye"></i> Detail</a> -->
                                                                    <!-- <a class="btn btn-info" href="<?= base_url('air/edit/') . $jenis_air->id_jenis ?>"><i class="fa fa-edit"></i> Edit</a> -->
                                                                    <!-- <a class="btn btn-danger" href="<?= base_url('air/delete/') . $jenis_air->id_jenis ?>"><i class="fa fa-trash fa-fw"></i> Delete</a> -->
                                                                <!-- </td> -->
                                                            </tr>
                                                        <?php
                                                            $no++;
                                                        }
                                                        ?>
                                                    <?php elseif ($data_air->num_rows() == 0) : ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center">
                                                                <a class="btn btn-info" href="<?= base_url('air/add') ?>"><i class="fa fa-plus-circle"></i> Tambah Jenis air</a>
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