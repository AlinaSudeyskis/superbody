<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="journal_block_cont">
    <?php if (!empty($articles)):
        foreach($articles as $article) : ?>
            <div class="journal_block_item">
                <div class="journal_block_h"><a href="/journal/article/<?php echo $article['id'];?>"><?php echo $article['name'];?></a></div>
                <div class="journal_block_img"><a href="#"><img src="<?php echo  $article['image'];?>" alt=""></a></div>
                <div class="journal_block_txt">Краткое описание: <?php echo  $article['short_desc'];?>...</div>
                <div class="journal_block_buts parent">
                    <div class="journal_block_buts_l parent">
                        <div class="journal_block_buts_in">
                            <div class="journal_block_time">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <span><?php echo  $article['date'];?></span>
                            </div>
                            <div class="journal_block_like">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                <span>1205</span>
                            </div>
                            <div class="journal_block_comm">
                                <i class="fa fa-comment" aria-hidden="true"></i>
                                <span>1205</span>
                            </div>
                        </div>
                        <div class="journal_block_name">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <a href="#"><?php echo  $article['author'];?></a>
                        </div>
                    </div>
                    <a href="/journal/article/<?php echo $article['id'];?>" class="journal_block_more">Узнать больше</a>
                </div>
            </div>
        <?php endforeach;
    endif;?>
</div>
