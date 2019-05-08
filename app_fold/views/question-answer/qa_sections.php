<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_list">
    <?php if(!empty($sections)): ?>
        <?php foreach ($sections as $section): ?>
            <div class="admin_item parent">
                <div class="admin_cont">
                    <div class="admin_name">
                        <a href="/administration/question-answer/section/<?php echo $section['id']; ?>"><?php echo $section['name']; ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach;
        unset($section);?>
    <?php endif; ?>
</div>