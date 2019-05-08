<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row qa_row">
    <?php if(!empty($sections)): ?>
        <?php foreach($sections as $sec_id => $section): ?>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 qa_col">
                <div class="qa_item">
                    <div class="qa_item_h"><a href="/support/<?php echo $sec_id; ?>"><?php echo $section['name']; ?></a></div>
                    <?php $i = 1;
                    $count_subsections = count($section['subsections']);
                    foreach($section['subsections'] as $subsec_id => $subsection): ?>
                        <?php if($i == 6):
                            break;
                        endif;?>
                        <div class="qa_item_cont">
                            <a href="/support/<?php echo $sec_id; ?>/<?php echo $subsec_id; ?>"><?php echo $subsection['name']; ?></a>
                            <?php if($i == 5 and $count_subsections > 5): ?>...<?php endif; ?>
                        </div>
                        <?php $i++;
                    endforeach;
                    unset($subsection);?>
                </div>
            </div><!-- qa_col -->
        <?php endforeach;
        unset($section); ?>
    <?php elseif(!empty($search_qa_articles)): ?>
        <?php foreach($search_qa_articles as $sec_id => $section): ?>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 qa_col">
                <div class="qa_item">
                    <div class="qa_item_h"><a href="/support/<?php echo $sec_id; ?>"><?php echo $section['name']; ?></a></div>
                    <?php $i = 1;
                    $count_subsections = count($section['subsections']);
                    foreach($section['subsections'] as $subsec_id => $subsection): ?>
                        <?php foreach($subsection['articles'] as $article_id => $article): ?>
                            <div class="qa_item_cont">
                                <a href="/support/<?php echo $sec_id; ?>/<?php echo $subsec_id; ?>/<?php echo $article_id; ?>"><?php echo $article['name']; ?></a>
                            </div>
                        <?php endforeach;
                        unset($article); ?>
                    <?php endforeach;
                    unset($subsection);?>
                </div>
            </div><!-- qa_col -->
        <?php endforeach;
        unset($section); ?>
    <?php endif; ?>
</div><!-- qa_row -->