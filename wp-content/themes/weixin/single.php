<?php get_header();?>
<?php the_post(); ?>
<div id="main" class="clear">
    <?php zz_post_title(); ?>
    <div id="content">
        <div <?php post_class('post'); ?>>
            <?php zz_post_meta_top(); ?>
            <?php zz_post_content(); ?>
            <?php zz_post_meta_bottom(); ?>
        </div>
        <?php zz_nav_single(); ?> 
        <?php comments_template(); ?>
    </div>
    <?php //get_sidebar(); ?>
</div>
<?php get_footer(); ?>