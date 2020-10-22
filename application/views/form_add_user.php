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
                                                <i class="fa fa-eyedropper"></i>Form Input User </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"> </a>
                                                <!-- <a href="#portlet-config" data-toggle="modal" class="config"> </a> -->
                                                <a href="javascript:;" class="reload"> </a>
                                                <!-- <a href="javascript:;" class="remove"> </a> -->
                                                <!-- <a class="btn blue btn-outline btn-sm" href="<?= base_url($act . '/history_pengujian') ?>"><i class="fa fa-minus-circle"></i> Lihat Sejarah Pengujian</a> -->
                                            </div>
                                        </div>
                                        <div class="portlet-body flip-scroll">
                                            <div class="row">
                                                <form action="<?= base_url('Users/insert') ?>" method="POST" class="form-body col-sm-6">
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="fomr-group">
                                                                <label class="control-label col-sm-6" for="username">Username&nbsp;</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="text" minlength="3" name="username" required="" id="username" autocomplete="off" autofocus>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="fomr-group">
                                                                <label class="control-label col-sm-6" for="password">Password&nbsp;</label>
                                                                <div class="col-sm-6">
                                                                    <input class="form-control" type="password" minlength="4" name="password" required="" id="password" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form">
                                                        <div class="form-body">
                                                            <div class="fomr-group">
                                                                <label class="control-label col-sm-6" for="user_class">User Class &nbsp;</label>
                                                                <div class="col-sm-6">
                                                                    <select name="user_class" id="user_class" class="form-control">
                                                                        <optgroup>Pilih Userclass Pengguna
                                                                            <option value="admin" label="Admin">Admin</option>
                                                                            <option value="penguji" label="Penguji">Penguji</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="portlet-body form">
                                                        <div class="col-md-12">
                                                            <div class="form-body">
                                                                <div class="form-group m-t-20">
                                                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                                                    <button class="btn btn-danger" type="reset">Reset</button>
                                                                    <a href="<?= base_url('Users') ?>" class="btn btn-default">Batal</a>
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