<?php
if (post_password_required())
    return;
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php comments_number(esc_html__('No Comments', 'sport-ak'), esc_html__('One Comment', 'sport-ak'), esc_html__('% Comments', 'sport-ak'));
            ?>
        </h3>

        <ol class="comment-list">
            <?php
            $options = get_option(AZEXO_FRAMEWORK);
            wp_list_comments(array(
                'walker' => new AZEXO_Walker_Comment(),
                'avatar_size' => isset($options['avatar_size']) ? $options['avatar_size'] : 32,
            ));
            ?>
        </ol><!-- .comment-list -->

        <?php
        // Are there comments to navigate through?
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h1 class="screen-reader-text section-heading"><?php esc_html_e('Comment navigation', 'sport-ak'); ?></h1>
                <div class="nav-previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'sport-ak')); ?></div>
                <div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'sport-ak')); ?></div>
            </nav><!-- .comment-navigation -->
        <?php endif; // Check for comment navigation   ?>

        <?php if (!comments_open() && get_comments_number()) : ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'sport-ak'); ?></p>
        <?php endif; ?>

    <?php endif; // have_comments()   ?>

    <?php
    if (comments_open()) :
        $args = array(
            'id_form' => 'commentform',
            'id_submit' => 'submit',
            'submit_field' => '<div class="form-submit">%1$s %2$s</div>',
            'title_reply' => esc_html__('Leave a Reply', 'sport-ak'),
            'title_reply_to' => esc_html__('Leave a Reply to %s', 'sport-ak'),
            'cancel_reply_link' => esc_html__('Cancel Reply', 'sport-ak'),
            'label_submit' => esc_html__('submit', 'sport-ak'),
            'comment_field' => '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_html__('comment', 'sport-ak') . '"></textarea>',
            'must_log_in' => '<p class="must-log-in">' .
            sprintf(
                    wp_kses(__('You must be <a href="%s">logged in</a> to post a comment.', 'sport-ak'), array('a' => array('href' => array()))), esc_url(wp_login_url(apply_filters('the_permalink', get_permalink())))
            ) . '</p>',
            'logged_in_as' => '<p class="logged-in-as">' .
            sprintf(
                    wp_kses(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'sport-ak'), array('a' => array('href' => array()))), esc_url(admin_url('profile.php')), $user_identity, esc_url(wp_logout_url(apply_filters('the_permalink', get_permalink())))
            ) . '</p>',
            'comment_notes_before' => '',
            'comment_notes_after' => '',
            'fields' => apply_filters('comment_form_default_fields', array(
                'author' =>
                '<div class="comment-fields"><div class="author-email"><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" placeholder="' . esc_html__('name', 'sport-ak') . '"/>',
                'email' =>
                '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" placeholder="' . esc_html__('email', 'sport-ak') . '" /></div>',
                'url' =>
                '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" placeholder="' . esc_html__('website', 'sport-ak') . '" /></div>'
                    )
            ),
        );
        comment_form($args);
    endif;
    ?>
</div><!-- #comments -->