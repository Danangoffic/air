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
                            <h1>Data Latih</h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <div class="page-toolbar">
                            <div style="margin-top: 15px;">
                                <a class="btn green btn-outline" href="<?= base_url('latih/add') ?>"><i class="fa fa-plus-circle"></i> Tambah Data Latih</a>
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
                        <!-- <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?= base_url(); ?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Klasifikasi Air</span>
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
                                                <i class="fa fa-table"></i>Tabel Data Latih </div>
                                        </div>
                                        <div class="portlet-body flip-scroll">
                                            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                                <thead class="flip-content">
                                                    <tr>
                                                        <th width="5%" class="text-center"> No </th>
                                                        <?php
                                                        foreach ($data_klasifikasi->result() as $klasifikasi) {
                                                        ?>
                                                            <th class="text-center"><?= $klasifikasi->nama_klasifikasi; ?></th>
                                                        <?php
                                                        }
                                                        ?>
                                                        <th class="text-center">TARGET</th>
                                                        <th class="text-center"> Aksi </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($data_latih->num_rows() > 0) :
                                                        $no = 1;
                                                        foreach ($data_latih->result() as $latih) {
                                                    ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no; ?></td>
                                                                <?php
                                                                foreach ($data_klasifikasi->result() as $klasifikasi) {
                                                                    $name_klas = strtolower($klasifikasi->nama_klasifikasi);
                                                                ?>
                                                                    <td><?= $latih->$name_klas ?></td>
                                                                <?php
                                                                }
                                                                ?>
                                                                <td class="text-center"><?=$latih->target;?></td>
                                                                <td class="text-center">
                                                                    <a href="<?=base_url('latih/edit/') . $latih->id_data_latih; ?>" class="btn btn-info"><i class="fa fa-edit fa-fw"></i> Edit</a>
                                                                    <a class="btn btn-danger" href="<?= base_url('latih/delete/') . $latih->id_data_latih ?>"><i class="fa fa-trash fa-fw"></i> Delete</a>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $no++;
                                                        }
                                                        ?>
                                                    <?php elseif ($data->num_rows() == 0) : ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center">
                                                                <a class="btn btn-info" href="<?= base_url('latih/add') ?>"><i class="fa fa-plus-circle"></i> Tambah Data Latih</a>
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