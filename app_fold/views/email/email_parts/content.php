<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- content -->
<tr>
    <td style="padding-top:20px; padding-bottom:20px;padding-right:0; padding-left:0;">
        <?php if(!empty($email)): ?>
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0">
                <?php if(!empty($email['image'])):?>
                    <tr>
                        <td style="width:100%; height:auto; border:0; padding:0; margin:0;">
                            <img src="https://superbody.pro/<?php echo $email['image']; ?>" alt="" style="width:100%; height:auto; border:0; padding:0; margin:0; display:block;"/>
                        </td>
                    </tr>
                <?php endif;
                if(!empty($email['text'])): ?>
                    <tr>
                        <td style="width:100%; padding:0; margin:0;">
                            <?php echo $email['text']; ?>
                        </td>
                    </tr>
                <?php endif;
                if(!empty($system_message)): ?>
                    <tr>
                        <td style="width:100%; padding:0; margin:0;">
                            <?php echo $system_message; ?>
                        </td>
                    </tr>
                <?php endif;?>
            </table>
        <?php else: ?>
            <!--
            font-family: Arial, Helvetica, sans-serif;
            font-family: 'Arial Black', Gadget, sans-serif;
            font-family: Georgia, serif;
            font-family: 'MS Sans Serif', Geneva, sans-serif;
            font-family: 'MS Serif', 'New York', sans-serif;
            font-family: Tahoma, Geneva, sans-serif;
            font-family: 'Times New Roman', Times, serif;
            font-family: 'Trebuchet MS', Helvetica, sans-serif;
            font-family: Verdana, Geneva, sans-serif;
             -->
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0">
                <tr style="font-family: Arial, Helvetica, sans-serif;"><td style="padding-bottom:15px;">Контент</td></tr>
                <tr style="font-family: 'Arial Black', Gadget, sans-serif;"><td style="padding-bottom:15px;">Контент</td></tr>
                <tr style="font-family: Georgia, serif;"><td style="padding-bottom:15px;">Контент</td></tr>
                <tr style="font-family: 'MS Sans Serif', Geneva, sans-serif;"><td style="padding-bottom:15px;">Контент</td></tr>
                <tr style="font-family: 'MS Serif', 'New York', sans-serif;"><td style="padding-bottom:15px;">Контент</td></tr>
                <tr style="font-family: Tahoma, Geneva, sans-serif;"><td style="padding-bottom:15px;">Контент</td></tr>
                <tr style="font-family: 'Times New Roman', Times, serif;"><td style="padding-bottom:15px;">Контент</td></tr>
                <tr style="font-family: 'Trebuchet MS', Helvetica, sans-serif;"><td style="padding-bottom:15px;">Контент</td></tr>
                <tr style="font-family: Verdana, Geneva, sans-serif;"><td style="padding-bottom:15px;">Контент</td></tr>
            </table>

        <?php endif; ?>
    </td>
</tr><!-- content -->