<?php
$options = get_option(AZEXO_FRAMEWORK);
global $azexo_queried_object;
?>

<?php if (is_404()) : ?>
    <div class="page-header">
        <h1 class="page-title"><?php esc_html_e('Not Found', 'sport-ak'); ?></h1>
    </div>
<?php elseif (is_category()): ?>
    <div class="archive-header">
        <h1 class="archive-title"><?php echo single_cat_title('', false); ?></h1>
        <div class="archive-subtitle"><?php echo esc_html__('Category archives', 'sport-ak'); ?></div>
        <?php if (category_description()) : // Show an optional category description ?>
            <div class="archive-meta"><?php echo category_description(); ?></div>
        <?php endif; ?>
    </div><!-- .archive-header -->
<?php elseif (is_tag()): ?>
    <div class="archive-header">
        <h1 class="archive-title"><?php echo single_tag_title('', false); ?></h1>
        <div class="archive-subtitle"><?php echo esc_html__('Tag archives', 'sport-ak'); ?></div>
        <?php if (tag_description()) : // Show an optional tag description  ?>
            <div class="archive-meta"><?php echo tag_description(); ?></div>
        <?php endif; ?>
    </div><!-- .archive-header -->
<?php elseif (is_archive()): ?>
    <div class="archive-header">
        <h1 class="archive-title"><?php
            if (is_day()) :
                echo get_the_date();
            elseif (is_month()) :
                echo get_the_date(_x('F Y', 'monthly archives date format', 'sport-ak'));
            elseif (is_year()) :
                echo get_the_date(_x('Y', 'yearly archives date format', 'sport-ak'));
            else :
                if (function_exists('is_shop') && is_shop()) {
                    if (isset($options['shop_title'])) {
                        print esc_html($options['shop_title']);
                    } else {
                        esc_html_e('Shop', 'sport-ak');
                    }
                } else {
                    esc_html_e('Archives', 'sport-ak');
                }
            endif;
            ?></h1>
        <?php if (is_day() || is_month() || is_year()) : ?>
            <div class="archive-subtitle"><?php
                if (is_day()) :
                    esc_html_e('Daily Archives', 'sport-ak');
                elseif (is_month()) :
                    esc_html_e('Monthly Archives', 'sport-ak');
                elseif (is_year()) :
                    esc_html_e('Yearly Archives', 'sport-ak');
                endif;
                ?></div>
        <?php endif; ?>
    </div><!-- .archive-header -->
<?php elseif (is_search()): ?>
    <div class="page-header">
        <h1 class="page-title"><?php echo esc_html__('Search Results for', 'sport-ak'); ?></h1>
        <div class="page-subtitle"><?php echo get_search_query(); ?></div>
    </div>
<?php elseif (isset($options['post_page_title']) && !empty($options['post_page_title']) && is_single()) : ?>
    <div class="page-header"><?php print azexo_entry_field($options['post_page_title']); ?></div>
<?php elseif (is_singular() || is_page() || isset($azexo_queried_object)): ?>
    <div class="page-header">
        <h1 class="page-title"><?php
            global $azexo_current_post_stack;
            $current_post = reset($azexo_current_post_stack);
            if (isset($azexo_queried_object)) {
                $current_post = $azexo_queried_object;
            }
            if ($current_post) {
                print esc_html(apply_filters('azexo_page_title', get_the_title($current_post)));
            }
            ?></h1>
        <?php if (isset($options['show_breadcrumbs']) && $options['show_breadcrumbs']): ?>
            <div class="page-subtitle"><?php azexo_breadcrumbs(); ?></div>        
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="page-header">
        <h1 class="page-title"><?php
            print apply_filters('azexo_page_title', isset($options['default_title']) ? esc_html($options['default_title']) : '');
            ?></h1>
    </div>
<?php endif; ?>
