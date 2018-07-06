<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="ru">
<head>
    <title><?php echo $title; ?> - Super Body</title>
</head>
<body style="font-family: Verdana, Geneva, sans-serif;">
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0; padding:0; font-family: Verdana, Geneva, sans-serif;">
    <tr style="margin:0; padding:0; font-family: Verdana, Geneva, sans-serif;">
        <td align="center" style="margin:0; padding:0; font-family: Verdana, Geneva, sans-serif;">
            <!--[if (gte mso 9)|(IE)]>
            <table width="600" cellspacing="0" cellpadding="0" border="0" align="center"><tr><td style="padding-top:0; padding-bottom:0; padding-right:0; padding-left:0; margin:0;">
            <![endif]-->
            <table align="center" cellspacing="0" cellpadding="0" border="0" style="width: 100%; max-width: 600px;
                border:0; margin:0; padding:0; background-color: #f3f3f3;" >
                <?php include_once('./app_fold/views/email/email_parts/header.php');?>
                <?php include_once('./app_fold/views/email/email_parts/content.php');?>
                <?php include_once('./app_fold/views/email/email_parts/footer.php');?>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td></tr></table>
            <![endif]-->
        </td>
    </tr>
</table>
</body>
</html>