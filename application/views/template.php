<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= isset($title) ? $title : '' ?></title>
        <!-- Latest compiled and minified CSS -->
        <?= link_tag('assets/css/bootstrap.min.css') ?>
        <!-- Optional theme -->
        <?= link_tag('assets/css/bootstrap-theme.min.css') ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?= login() ?>
        <?= mensaje() ?>
        <?= $contents ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?= base_url('assets/js/jquery-2.2.0.min.js') ?>"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    </body>
</html>
