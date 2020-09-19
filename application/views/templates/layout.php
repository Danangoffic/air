<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Aplikasi Klasifikasi Tingkat Kualitas Air | <?=$title;?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #3 for responsive bootstrap table demos" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/')?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?=base_url()?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?=base_url()?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?=base_url()?>/assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>/assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?=base_url()?>/assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    
</head>
<body class="page-container-bg-solid">
        <div class="page-wrapper">
            <?php $this->load->view('templates/template_nav'); ?>
            <?php $this->load->view($page); ?>
        </div>
            <?php $this->load->view('templates/template_script'); ?>
            <?php if(!empty($script)){$this->load->view($script);} ?>
</body>
</html>