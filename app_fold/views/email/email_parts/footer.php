<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- footer -->
<tr>
    <td style="padding-top:0; padding-bottom:0; padding-right:10px; padding-left:10px; font-size:24px; width: 100%; color: #ffffff;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-spacing:0;" >
            <tr>
                <td align="center" style="padding-top:0; padding-bottom:0; padding-right:0;
                                        padding-left:0; font-size:12px; height:27px; line-height:14px; color:#ffffff;">
                    <a href="https://superbody.pro/unsubscribe" target="_blank" style="width:100%; text-decoration: none;
                        text-align:center; color: #606060; font-weight: 300; -webkit-text-size-adjust:none;">
                        Отписаться от рассылки
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="padding-top:0; padding-bottom:0; padding-right:10px; padding-left:10px;
                        font-family: Arial, Helvetica, sans-serif; font-size:24px; width: 100%; overflow: hidden;
                         background: #00bff0; color: #ffffff;">
        <!--[if (gte mso 9)|(IE)]>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td width="50%" valign="top" >
        <![endif]-->
        <div class="column" style="width:48%; display:inline-block; vertical-align:middle;" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;" >
                <tr>
                    <td align="center" style="padding-top:0; padding-bottom:0; padding-right:0;
                                        padding-left:0; font-size:12px; height:27px; line-height:14px; color:#ffffff;">
                        <?php echo $site_info['footer']; ?>
                    </td>
                </tr>
            </table>
        </div>
        <!--[if (gte mso 9)|(IE)]>
        </td><td width="50%" valign="top" >
        <![endif]-->
        <div class="column" style="width:48%; display:inline-block; vertical-align:middle;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;" >
                <tr>
                    <td align="right" style="padding-top:5px; padding-bottom:0; padding-right:0; padding-left:0;">
                        <?php if (!empty($site_info['phone'])): ?>
                            <table border="0" cellspacing="0" cellpadding="0" align="right">
                                <tr style="font-size:12px; color:#ffffff;">
                                    <td align="right">phone: </td>
                                    <td align="right" style="padding-left:10px;"><b><i><?php echo $site_info['phone']; ?></i></b></td>
                                </tr>
                            </table>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <td align="right" style="padding-top:5px; padding-bottom:5px; padding-right:0; padding-left:0;">
                        <?php if (!empty($site_info['email'])): ?>
                            <table border="0" cellspacing="0" cellpadding="0" align="right">
                                <tr style="font-size:12px; color:#ffffff;">
                                    <td align="right">e-mail:</td>
                                    <td align="right" style="padding-left:10px;"><b><i><?php echo $site_info['email']; ?></i></b></td>
                                </tr>
                            </table>
                        <?php endif;?>
                    </td>
                </tr>
            </table>
        </div>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </td>
</tr><!-- footer -->