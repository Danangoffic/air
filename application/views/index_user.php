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
                            <h1>Management User
                                <small></small>
                            </h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <!-- <div class="page-toolbar">
                            <div style="margin-top: 15px;">
                            <a class="btn green btn-outline" href="<?= base_url('alat/add') ?>"><i class="fa fa-plus-circle"></i> Tambah Alat</a>
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
                                <span>Home</span>
                            </li>
                        </ul> -->
                        <!-- END PAGE BREADCRUMBS -->
                        <!-- BEGIN PAGE CONTENT INNER -->
                        <div class="page-content-inner">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-12">
                                            <a href="<?= base_url('Users/add') ?>" class="btn blue pull-right">Tambahkan User</a>
                                        </div>
                                    </div>
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
                                        </div>
                                    </div>
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-table"></i>Tabel data user </div>
                                        </div>
                                        <div class="portlet-body">
                                            <table class="table table-bordered table-hover table-condended">
                                                <thead>
                                                    <tr>
                                                        <th>Username</th>
                                                        <th>Userclass</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($data_user->result() as $user) {
                                                    ?>
                                                        <tr>
                                                            <td><?= $user->username ?></td>
                                                            <td><?= strtoupper($user->user_class) ?></td>
                                                            <td>
                                                                <a href="<?= base_url('users/edit/' . $user->id_user) ?>" class="btn green">Edit</a>
                                                                <a href="<?= base_url('users/delete/' . $user->id_user) ?>" class="btn red">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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