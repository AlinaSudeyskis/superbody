<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Error</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php /*echo $heading; */?></h1>
		<?php /*echo $message; */?>
	</div>
</body>
</html>-->

<?php $title = 'Error';
$page_menu = '';
$message = '';
include_once('./app_fold/views/header/header.php');
include_once('./app_fold/views/header/profile.php');
?>

<div id="content" class="container">
    <div class="content_block no_content_block">
        <div class="no_content_block_cont">
            <div class="no_content_val"><?php echo $heading; ?></div>
            <div class="no_content_desk">
                <div class="no_content_desk_line"><?php echo $message; ?></div>
                <div class="no_content_desk_line">вы можете перейти <a href="/">на главную</a></div>
            </div>
        </div>
    </div>
</div><!-- content -->


<?php include_once('./app_fold/views/footer/footer.php');?>