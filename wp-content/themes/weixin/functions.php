<?php
/**
 * Author: zhanqi 主题功能函数
 */
function zz_setup() {
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'nav-menu-header' => __('头部右侧主菜单')
    ));
}
add_action('after_setup_theme', 'zz_setup');
// add_action('widgets_init', 'zz_widgets_init');

/**
 * 页面标题
 */
function zz_wp_title($title) {
    $title = trim($title);
    if (is_home()) {
        return $title = get_bloginfo('name') . ' - 写尽无眠';
    }
    if (is_search()) {
        $title = '搜索结果：' . strip_tags(get_query_var('s'));
    }
    return $title . ' - ' . get_bloginfo('name');
}
add_filter('wp_title', 'zz_wp_title');

/**
 * 
 */
function zz_template_include($template) {
    if (is_page() && ! get_page_template()) {
        $template = 'single.php';
    } else if (is_search()) {
        $template = 'index.php';
    } else if(is_404()){
        $template = 'search.php';
    } else{
        return $template;
    }
    return get_template_directory() . '/' . $template;
}
add_filter('template_include', 'zz_template_include');

/**
 * 
 */
function zz_wp_tag_cloud($return) {
    $return = preg_replace_callback('|<a(.*?)</a>|i', 'tag_cloud_callback', $return);
    return $return;
}
add_filter('wp_tag_cloud', 'zz_wp_tag_cloud');
function tag_cloud_callback($matches) {
    $link = $matches[0];
    $color = dechex(rand(0, 16777215));
    $link = preg_replace('|style=\'(.*?)\'|', "style='color:#{$color};'", $link);
    return $link;
}

/**
 * 
 * @param unknown_type $comment_id
 */
function comment_mail_notify($comment_id) {
    global $wpdb;
    $admin_notify = '1';
    $admin_email = 'admin@zhanqi.net';
    $comment = get_comment($comment_id);
    $comment_author_email = trim($comment->comment_author_email);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == ''){
        $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
    }
    if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1')){
        $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
    }
    $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
    $spam_confirmed = $comment->comment_approved;
    if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
        $wp_email = 'admin@zhanqi.net';
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = '您在 [' . get_option("blogname") . '] 的留言有了回应';
        $message = '
        <div style="background-color: #eef2fa; border: 1px solid #d8e3e8; color: #111; padding: 0 15px; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;">'
                . trim(get_comment($parent_id)->comment_author) . ', 您好!您曾在《'
                        . get_the_title($comment->comment_post_ID) . '》的留言:'
                                . nl2br(get_comment($parent_id)->comment_content) . trim($comment->comment_author) . ' 给您的回应:'
                                        . nl2br($comment->comment_content)
                                        . '您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment')))
                                        . '">查看回应完整内容</a>欢迎再度光临 <a href="' . get_option('home') . '">'
                                                . get_option('blogname') . '</a>(此邮件由系统自动发出, 请勿回复.)</div>';
        $from = "From: \"" . get_option('blogname') . "\" ";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail( $to, $subject, $message, $headers );
        //echo 'mail to ', $to, '' , $subject, $message; // for testing
    }
}
//add_action('comment_post', 'comment_mail_notify');

/**
 * 评论邮件通知
 */
function add_checkbox() {
    echo '<div class="comment-mail-notify"><input id="comment-mail-notify" type="checkbox" name="comment_mail_notify" checked="checked" /><label for="comment-mail-notify">有人回复时邮件通知我</label></div>';
}
add_action('comment_form', 'add_checkbox');

/**
 * nav-menu-header
 */
function zz_nav_menu_header() {
    wp_nav_menu(array(
            'menu' => 'nav-menu-header',
            'menu_class' => 'nav-menu navigator clear'
    ));
}

/**
 * 面包屑导航
 */
function zz_breadcrumb() {
    $label =  '站内搜索';
    if (is_archive()) {
        $label = single_term_title('', false);
    } else if (is_home()) {
        $label =  '首页';
    } else if (is_search()) {
        $label =  strip_tags(get_query_var('s'));
    } else if(is_404()){
        $label = '页面未找到';
    } 
    ?>
<div class="breadcrumb">
    <h2>
        <span><?php echo $label; ?></span>
    </h2>
</div>
<?php
}

/**
 * 
 */
function zz_post_thumbnail() {
    // $thumbID = get_the_post_thumbnail( $post->ID, ‘two’, $imgsrcparam );
    $src = get_post_meta(get_the_ID(), 'thumbnail_src', true);
    // if (has_post_thumbnail()) {
    if ($src) {
        ?>
<div class="thumbnail">
    <a href="<?php echo $src; ?>" target="_blank"> <img data-original="<?php echo $src; ?>" alt="" /></a>
<?php //the_post_thumbnail(); ?>
</div>
<?php
    } else {
        ?>
<div class="thumbnail">
    <a target="_blank" href="http://open.weixin.qq.com/static/zh_CN/app/images/open-api_00.png"> <img data-original="http://open.weixin.qq.com/static/zh_CN/app/images/open-api_00.png"/></a>
</div>
<?php
    }
}

/**
 * post-title
 */
function zz_post_title() {
    if (is_singular()) {
        ?>
<div class="post-title breadcrumb">
    <h2><?php the_title(); ?></h2>
</div>
<?php return; }?>
<h3 class="post-title">
    <a href="<?php the_permalink(); ?>" title=""><?php the_title(); ?> </a>
</h3>
<?php
}

/**
 * meta-top
 */
function zz_post_meta_top() {
    if (is_page()) {
        return;
    }
    ?>
<div class="post-meta post-meta-top clear">
    <span>Publish: <?php the_time('Y-m-d H:i'); ?></span> <span>Category: <?php the_category('、'); ?></span>
    <?php //zz_post_views(); ?>
    <span class="no-border"><?php comments_popup_link('No Comments', '1 Comments','% Comments'); ?></span>
    <?php edit_post_link('编辑'); ?>
</div>
<?php
}

/**
 * meta-bottom
 */
function zz_post_meta_bottom() {
    ?>
<div class="post-meta post-meta-bottom clear">
   <?php the_tags(null, '', ''); ?>
</div>
<?php
}

/**
 * excerpt
 */
function zz_post_excerpt() {
    // if (has_excerpt()) {
    ?>
<div class="post-content">
<?php the_content('Continue Reading ...'); ?>
   </div>
<?php
}

/**
 * post-content
 */
function zz_post_content() {
    ?>
<div class="post-content">
    <?php the_content(); ?>
</div>
<?php
}

/**
 * views
 */
function zz_post_views() {
    if (function_exists('the_views')) {
        // echo '<span>' . the_views(false) . '</span>';
    }
}

/**
 * pagenavi
 */
function zz_pagenavi() {
    if (function_exists('wp_pagenavi')) {
        wp_pagenavi();
    }
}
/**
 * nav-single
 */
function zz_nav_single() {
    if (is_page()) {
        return;
    }
    ?>
<div class="nav-single clear">
    <div class="previous-post-link">
        <?php previous_post_link('上一篇：%link'); ?>
    </div>
    <div class="next-post-link">
        <?php next_post_link('下一篇：%link'); ?>
    </div>
</div>
<?php
}