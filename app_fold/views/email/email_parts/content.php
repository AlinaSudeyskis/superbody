<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- content -->
<tr>
    <td style="padding-top:0; padding-bottom:20px;padding-right:0; padding-left:0;">
        <?php if(!empty($email)):?>
            <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0">
                <?php if(!empty($email['image'])):?>
                    <tr>
                        <td style="width:100%; height:auto; border:0; padding:0; margin:0;">
                            <img src="https://superbody.pro/<?php echo $email['image']; ?>" alt="" style="width:100%; height:auto; border:0; padding:0; margin:0; display:block;"/>
                        </td>
                    </tr>
                <?php endif;
                if(!empty($email['text'])): ?>
                    <tr style="margin:0; padding:0">
                        <td style="width:100%; margin:0; padding-top:10px; padding-right:10px; padding-bottom:10px; padding-left:10px;">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%; background-color:#ffffff; border-bottom: 3px solid #cdcdcd;">
                                <tr style="margin:0; padding:0">
                                    <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">
                                        <?php echo $email['text']; ?>
                                    </td>
                                </tr>
                                <?php if(!empty($system_message['text'])): ?>
                                    <tr style="margin:0; padding:0">
                                        <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">
                                            <?php echo $system_message['text']; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </td>
                    </tr>
                <?php endif;
                include_once('./app_fold/views/email/email_parts/blocks/week_menu.php');
                ?>
            </table>
        <?php else: ?>
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width:100%;">
                <tr style="margin:0; padding:0">
                    <td style="width:100%; margin:0; padding-top:10px; padding-right:10px; padding-bottom:10px; padding-left:10px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; background-color:#ffffff; border-bottom: 3px solid #cdcdcd;">
                            <tr style="font-family: Arial, Helvetica, sans-serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">Arial, Helvetica, sans-serif</td>
                            </tr>
                            <tr style="font-family: 'Arial Black', Gadget, sans-serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">Arial Black, Gadget, sans-serif</td>
                            </tr>
                            <tr style="font-family: Georgia, serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">Georgia, serif</td>
                            </tr>
                            <tr style="font-family: 'MS Sans Serif', Geneva, sans-serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">MS Sans Serif, Geneva, sans-serif</td>
                            </tr>
                            <tr style="font-family: 'MS Serif', 'New York', sans-serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">MS Serif, New York, sans-serif</td>
                            </tr>
                            <tr style="font-family: Tahoma, Geneva, sans-serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">Tahoma, Geneva, sans-serif</td>
                            </tr>
                            <tr style="font-family: 'Times New Roman', Times, serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">Times New Roman', Times, serif</td>
                            </tr>
                            <tr style="font-family: 'Trebuchet MS', Helvetica, sans-serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">Trebuchet MS, Helvetica, sans-serif</td>
                            </tr>
                            <tr style="font-family: Verdana, Geneva, sans-serif;">
                                <td style="margin:0; padding-top:30px; padding-right:30px; padding-bottom:30px; padding-left:30px;">Verdana, Geneva, sans-serif</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        <?php endif; ?>
    </td>
</tr><!-- content -->