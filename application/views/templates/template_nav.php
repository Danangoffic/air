<div class="page-wrapper-row">
    <div class="page-wrapper-top">
        <!-- BEGIN HEADER -->
        <div class="page-header">
            <!-- BEGIN HEADER TOP -->
            <div class="page-header-top">
                <div class="container">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="index.html">
                            <!-- <span class="fa fa-user logo-default"></span> -->
                            <!-- <img src="<?= base_url() ?>/assets/layouts/layout3/img/logo-default.jpg" alt="logo" class="logo-default"> -->
                        </a>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">

                            <li class="droddown dropdown-separator">
                                <span class="separator"></span>
                            </li>
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <!-- <span class="fa fa-user img-circle"></span> -->
                                    <img alt="" class="img-circle" src="<?= base_url() ?>/assets/layouts/layout3/img/avatar9.jpg">
                                    <span class="username username-hide-mobile"><?=ucwords($this->session->username)?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="page_user_profile_1.html">
                                            <i class="icon-user"></i> My Profile </a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="<?= base_url('users/logout') ?>">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- END HEADER TOP -->
            <!-- BEGIN HEADER MENU -->
            <div class="page-header-menu">
                <div class="container">
                    <!-- BEGIN MEGA MENU -->
                    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                    <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                    <div class="hor-menu  ">
                        <ul class="nav navbar-nav">
                            <?php
                            if ($this->session->userdata("user_class") == "admin") {
                            ?>
                                <li>
                                    <a href="<?= base_url() ?>" class="nav-link">
                                        <i class="icon-bar-chart"></i> Dashboard
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            <?php
                            if ($this->session->userdata("user_class") == "penguji") {
                            ?>
                                <li>
                                    <a href="<?= base_url('pengujian') ?>" class="nav-link">
                                        <i class="fa fa-bolt"></i> Uji Kelayakan
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            <!-- <li>
                                            <a href="<?= base_url('alat') ?>" class="nav-link">
                                                <i class="icon-wrench"></i> Setting Alat
                                            </a>
                                        </li> -->
                            <?php
                            if ($this->session->userdata("user_class") == "admin") {
                            ?>
                                <li>
                                    <a href="<?= base_url('air') ?>" class="nav-link">
                                        <i class="fa fa-eyedropper"></i> Olah Data Air
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="<?= base_url('klasifikasi') ?>">
                                        <i class="fa fa-server"></i> Olah Klasifikasi Air
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url('users') ?>">
                                        <i class="fa fa-users"></i> Olah Data Pengguna
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- END MEGA MENU -->
                </div>
            </div>
            <!-- END HEADER MENU -->
            <!-- END HEADER TOP -->
        </div>
        <!-- END HEADER -->
    </div>
</div>