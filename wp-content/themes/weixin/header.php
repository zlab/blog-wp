<!DOCTYPE html>
<html>
<head>
<title><?php wp_title(''); ?></title>
<meta charset="utf-8" />
<meta name="keywords" content="wordpress java 程序员 博客" />
<meta name="description" content="java程序员博客" />
<!-- <link rel="shortcut icon" href="http://zhanqi.net/favicon.ico"/> -->
<link rel="stylesheet" type="text/css" href="http://1.zhanqi.sinaapp.com/widget/sh2/styles/shDefault.css" />
<link rel="stylesheet" type="text/css" href="http://1.zhanqi.sinaapp.com/widget/fancybox/source/jquery.fancybox.css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://1.zhanqi.sinaapp.com/widget/lazyload/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="http://1.zhanqi.sinaapp.com/widget/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="http://1.zhanqi.sinaapp.com/widget/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="http://1.zhanqi.sinaapp.com/widget/sh2/scripts/shDefault.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/common.js'; ?>"></script>
<?php 
if (is_singular() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
}
wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="header">
        <div class="title">
            <a href="<?php echo home_url('/') ?>"><?php bloginfo('name'); ?></a>
        </div>
    <?php zz_nav_menu_header(); ?>
</div>