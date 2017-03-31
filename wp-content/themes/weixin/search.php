<?php
/**
 * Template Name: 站内搜索
 */
get_header();
?>
<div id="main" class="clear search">
    <?php zz_breadcrumb(); ?>
    <div id="content" class="clear">
        <?php get_search_form(); ?>
        <div class="clear">
             <ul class="list-cats">
                 <?php //wp_list_categories();?>
             </ul>
            <div class="color-tags">
                <?php wp_tag_cloud('smallest=14&largest=14&unit=px&number=100'); ?>
            </div>
            <div class="rand-posts">
                <h4 class="subtitle">随机文章</h4>
                <ul>
                    <?php
                    $rand_posts = get_posts('numberposts=10&orderby=rand');
                    foreach ( $rand_posts as $post ) :
                    ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>