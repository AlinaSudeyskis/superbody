<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="qa_container">
    <div class="qa_menu">
        <div class="qa_item">
            <?php if(!empty($section)):
                if(empty($def_nutrition)): ?>
                    <div class="qa_item_h"><?php echo $section['name']; ?></div>
                <?php endif;
                foreach($section['subsections'] as $subsec_id => $subsec): ?>
                    <?php if(!empty($articles[$subsec_id])): ?>
                        <div class="qa_item_cont<?php if(!empty($subsection) and $subsection['id'] == $subsec_id): ?> active<?php endif;?>">
                            <!--<a href="<?php /*echo $url_path; */?><?php /*echo $section['id']; */?>/<?php /*echo $subsec_id; */?>"
                            <?php /*if(!empty($subsection) and $subsection['id'] == $subsec_id): */?>class="active"<?php /*endif;*/?> ><?php /*echo $subsec['name']; */?></a>-->
                            <span><?php echo $subsec['name']; ?></span>
                        </div>
                        <div class="qa_subitem_wrap">
                            <?php foreach($articles[$subsec_id] as $article_id => $subsec_article): ?>
                                <div class="qa_subitem_cont<?php if(!empty($article) and $article['id'] == $article_id): ?> active<?php endif;?>">
                                    <a href="<?php echo $url_path; ?><?php echo $section['id']; ?>/<?php echo $subsec_id; ?>/<?php echo $article_id; ?>"><?php echo $subsec_article['name']; ?></a>
                                </div>
                            <?php endforeach;
                            unset($subsec_article); ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach;
                unset($subsec);
            endif;?>
        </div>
    </div><!-- qa_menu -->
    <div class="qa_content">
        <h3 class="info">Выберите статью</h3>
    </div><!-- qa_content -->
</div>