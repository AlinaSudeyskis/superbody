<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php if(!empty($title)): echo $title; endif; ?><?php if(!empty($metadata[1]['title'])): echo $metadata[1]['title'];  endif; ?></title>
    <?php include_once('./app_fold/views/header/lp_styles_scripts.php'); ?>
</head>
<body class="dark_lp lp_page">

<?php include_once('./app_fold/views/header/reporting_services.php'); ?>
<?php include_once('./app_fold/views/header/policy_pop_up.php'); ?>