<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="parent kurs_cur_wrap" style="justify-content: center; -webkit-justify-content: center;">
    <div class="kurs_cur_h"><?php if(!empty($course)): echo $course['name']; endif; ?></div>
</div>
<div class="separator"></div>
<?php //include_once('./app_fold/views/authorization/short_auth.php'); ?>
<?php include_once('./app_fold/views/course/course_payment_item.php');?>
