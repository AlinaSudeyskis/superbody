<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-lg-3 left_sidebar">
        <div class="qa_item">
            <div class="qa_item_h"><?php echo $section['name']; ?></div>
            <?php foreach($section['subsections'] as $subsec_id => $subsec): ?>
                <div class="qa_item_cont">
                    <?php if(!empty($subsection) and $subsection['id'] == $subsec_id): ?>
                        <span><?php echo $subsec['name']; ?></span>
                    <?php else: ?>
                        <a href="/support/<?php echo $section['id']; ?>/<?php echo $subsec_id; ?>"><?php echo $subsec['name']; ?></a>
                    <?php endif; ?>
                </div>
            <?php endforeach;
            unset($subsec); ?>
        </div>
    </div><!-- left_sidebar -->
    <div class="col-lg-9 content_col">
        <div class="content_block new_content_block">
            <div class="kurs_block_val support">
                <div class="comment_page_block">
                    <div class="parent">
                        <div class="comment_page_cont">
                            <div class="comment_page_cont_h"><?php echo $article['name']; ?></div>
                            <div class="comment_page_cont_txt"><?php echo $article['text']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- content_col -->
</div>