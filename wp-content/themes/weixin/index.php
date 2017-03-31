<?php get_header();?>
<div id="main" class="clear">
    <?php zz_breadcrumb(); ?>
    <div id="content">
        <ul class="post-list">
            <?php while(have_posts()) : the_post(); ?>
            <li <?php post_class(); ?>>
                <?php zz_post_title(); ?>
                <?php zz_post_meta_top(); ?>
                <?php zz_post_thumbnail(); ?>
                <?php zz_post_excerpt(); ?>
            </li>
            <?php endwhile; ?>
        </ul>
        <?php zz_pagenavi(); ?>  			
    </div>
</div>
<?php get_footer(); ?>