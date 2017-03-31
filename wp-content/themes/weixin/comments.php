<div id="comments">
    <h3><?php comments_number(__('', '1 Comment', '% Comments' ));?></h3>
<?php if ( have_comments() ) : ?>
    <ul>
<?php wp_list_comments(array('avatar_size' => '48', 'type' => 'comment')); ?>
    </ul>
<?php endif; ?>
<?php comment_form(); ?>
</div>