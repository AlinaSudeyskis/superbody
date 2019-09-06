<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-lg-3 left_sidebar">
        <div class="qa_item">
            <?php if(empty($def_nutrition)): ?>
                <div class="qa_item_h"><?php echo $section['name']; ?></div>
            <?php endif;?>
            <?php foreach($section['subsections'] as $subsec_id => $subsec): ?>
                <div class="qa_item_cont">
                    <?php /*if(!empty($subsection) and $subsection['id'] == $subsec_id and empty($def_nutrition)): */?><!--
                        <span><?php /*echo $subsec['name']; */?></span>
                    --><?php /*else: */?>
                        <a href="<?php echo $url_path; ?><?php echo $section['id']; ?>/<?php echo $subsec_id; ?>"
                            <?php if(!empty($subsection) and $subsection['id'] == $subsec_id): ?>class="active"<?php endif;?> ><?php echo $subsec['name']; ?></a>
                    <?php /*endif; */?>
                </div>
            <?php endforeach;
            unset($subsec); ?>
        </div>
    </div><!-- left_sidebar -->
    <div class="col-lg-9 content_col">
        <div class="content_block new_content_block">
            <div class="content_block_container_wrap">
                <div class="content_block_container">
                    <div class="content_block_h new_content_block_h parent">
                        <?php $block_title = (!empty($subsection['name'])) ? $subsection['name'] : 'Статьи' ; ?>
                        <h3><?php echo $block_title; ?></h3>
                    </div>
                </div>
            </div>
            <div class="kurs_block_val support">
                <?php if(!empty($articles) and empty($article)): ?>
                    <div class="admin_list">
                        <?php foreach($articles as $article_id => $article): ?>
                            <div class="admin_item parent">
                                <div class="admin_cont">
                                    <div class="admin_name">
                                        <a href="<?php echo $url_path; ?><?php echo $section['id']; ?>/<?php echo $subsection['id']; ?>/<?php echo $article_id; ?>"><?php echo $article['name']; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                        unset($article); ?>
                    </div>
                <?php elseif($def_nutrition === true and !empty($article)): ?>
                    <div class="comment_page_block">
                        <div class="parent">
                            <div class="comment_page_cont">
                                <div class="comment_page_cont_h"><?php echo $article['name']; ?></div>
                                <div class="comment_page_cont_txt"><?php echo $article['text']; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div><!-- content_col -->
</div>