<?php
/**
 * Template Name: 链接表/书签
 */
get_header();
?>
<div id="main" class="clear search">
    <div class="breadcrumb">
        <h2>
            <span>网站收藏 </span>
        </h2>
    </div>
    <div id="content" class="clear">
        <ul class="bookmarks left">
            <?php
            wp_list_bookmarks();
            ?>
        </ul>
    </div>
</div>
<?php get_footer(); ?>