<?php
/**
 * Template Name: 标签云页面模板
 */
get_header();
?>
<?php 
function catch_that_image(){
      global $post, $posts;
      $first_img = '';
      ob_start();
      ob_end_clean();
      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
      $first_img = $matches [1] [0];
      if(empty($first_img)){ //Defines a default image
        $first_img ="0";
      }
      return $first_img;
    };
    ?>

<div class="thumbnail">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if ( get_post_meta($post->ID, 'image', true) ) : ?>
<?php $image = get_post_meta($post->ID, 'image', true); ?>
<img width="225px" height="136px" src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
<?php elseif( has_post_thumbnail() ): ?>
<?php the_post_thumbnail(array( 225, 136 ), array('alt' => '<?php the_title(); ?>','title'=>trim(strip_tags( $attachment->post_title )) ));?>
<?php elseif(catch_that_image()) : ?>
<img src="<?php echo catch_that_image()?>" width="225" height="136" alt="<?php the_title(); ?>" />
<?php else : ?>
<img src="<?php bloginfo('template_url'); ?>/images/random/<?php echo rand(1,16)?>.jpg" width="225" height="136" alt="<?php the_title(); ?>" />
<?php endif;?></a>
</div>
