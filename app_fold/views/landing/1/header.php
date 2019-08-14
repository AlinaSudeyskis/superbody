<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php echo $title; ?><?php echo $metadata[1]['title']; ?></title>
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <meta name="description" content="<?php echo $description; ?>">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="/css/google_fonts.css">
    <link rel="stylesheet" href="/css/grid.css">
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/jquery.formstyler.css">
    <link rel="stylesheet" href="/css/lightbox.css">

    <script src="/js/jquery.min.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="/js/jquery.formstyler.js"></script>

    <!-- version 1 (?version=1) -->
    <link rel="stylesheet" href="/css/style.css?version=1">
    <link rel="stylesheet" href="/css/styles.css?version=1.1">
    <script src="/js/lp_script.js?version=1"></script>
</head>
<body class="light_lp lp_page">

<div id="policy_pop-up">
    <div class="policy_pop-up_cont">
        <div class="policy_pop-up_close"></div>
        <div class="policy_pop-up_h">Подтверждая данное действие, я (Клиент) даю своё согласие ООО «Лайф Технолоджи Рус.» на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных
            <a href="<?php if (!empty($site_info['personal_data'])): echo $site_info['personal_data']; endif;?>" class="policy" target="_blank">Политикой обработки персональных данных</a>
        </div>
    </div>
</div><!-- home_pop-up -->