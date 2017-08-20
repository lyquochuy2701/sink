<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 10.0.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $post, $woocommerce_loop;

if (empty($woocommerce_loop['loop'])) {
    $woocommerce_loop['loop'] = 0;
}
if (empty($woocommerce_loop['columns'])) {
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);
}

if (!$product) {
    return;
}

$options = get_option(AZEXO_FRAMEWORK);
if (!isset($product_template)) {
    if (isset($template_name)) {
        $product_template = $template_name;
    } else {
        $product_template = isset($options['default_' . get_post_type() . '_template']) ? $options['default_' . get_post_type() . '_template'] : 'shop_product';
    }
}

if (isset($options[$product_template . '_is_visible']) && $options[$product_template . '_is_visible']) {
    if (!$product->is_visible()) {
        return;
    }
}

$woocommerce_loop['loop'] ++;

if (!isset($azexo_woo_base_tag)) {
    $azexo_woo_base_tag = 'li';
}
$single = ($product_template == 'single_product');
$more_link_text = sprintf(wp_kses(__('Read more<span class="meta-nav"> &rsaquo;</span>', 'sport-ak'), array('span' => array('class' => array()))));
$thumbnail_size = isset($options[$product_template . '_thumbnail_size']) && !empty($options[$product_template . '_thumbnail_size']) ? $options[$product_template . '_thumbnail_size'] : 'large';
azexo_add_image_size($thumbnail_size);
$image_thumbnail = isset($options[$product_template . '_image_thumbnail']) ? $options[$product_template . '_image_thumbnail'] : false;

$images_links = azexo_woo_get_images_links($thumbnail_size);
?>
<<?php print $azexo_woo_base_tag; ?> <?php post_class(array(str_replace('_', '-', $product_template))); ?>>

<div class="entry" itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>">
    <?php do_action('azexo_entry_open'); ?>
    <meta itemprop="url" content="<?php print esc_url(get_permalink()); ?>" />
    <meta itemprop="image" content="<?php print esc_url(wp_get_attachment_url(get_post_thumbnail_id($post->ID))); ?>" />
    <?php
    if (!$single) {
        do_action('woocommerce_before_shop_loop_item');
    }
    ?>
    <?php if (isset($options[$product_template . '_show_thumbnail']) && $options[$product_template . '_show_thumbnail']): ?>
        <?php if ((count($images_links) > 1) && !$image_thumbnail): ?>
            <div class="entry-gallery">
                <?php
                azexo_woo_product_gallery_field($product_template);
                $hover = azexo_entry_meta($product_template, 'hover');
                ?>
                <?php if (!empty($hover)): ?>
                    <div class="entry-hover"><?php print $hover; ?></div>
                <?php endif; ?>
                <?php print azexo_entry_meta($product_template, 'thumbnail'); ?>
            </div>
        <?php else: ?>  
            <?php
            $url = azexo_get_the_post_thumbnail(get_the_ID(), $thumbnail_size, true);
            if ($url):
                ?>   
                <div class="entry-thumbnail">
                    <?php
                    azexo_woo_product_thumbnail_field($product_template);
                    $hover = azexo_entry_meta($product_template, 'hover');
                    ?>
                    <?php if (!empty($hover)): ?>
                        <div class="entry-hover"><?php print $hover; ?></div>
                    <?php endif; ?>
                    <?php print azexo_entry_meta($product_template, 'thumbnail'); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>   
    <?php
    if ($single) {
        do_action('woocommerce_before_single_product_summary');
    }
    ?>
    <div class="entry-data">
        <div class="entry-header"><?php
            $extra = azexo_entry_meta($product_template, 'extra');
            if (!$single) {
                ob_start();
                do_action('woocommerce_before_shop_loop_item_title');
                $extra .= ob_get_clean();
            }
            $extra = trim($extra);
            ?><?php if (!empty($extra)) : ?>
                <div class="entry-extra"><?php print $extra; ?></div>
            <?php endif; ?><?php
            if (isset($options[$product_template . '_show_title']) && $options[$product_template . '_show_title']) {
                if ($single) {
                    woocommerce_template_single_title();
                } else {
                    ?>
                    <a class="entry-title" href="<?php the_permalink(); ?>">
                        <h3 itemprop="name"><?php the_title(); ?></h3>
                    </a>                    
                    <?php
                }
            }
            ?><?php
            $meta = azexo_entry_meta($product_template, 'meta');
            if (!$single) {
                ob_start();
                do_action('woocommerce_after_shop_loop_item_title');
                $meta .= ob_get_clean();
            }
            $meta = trim($meta);
            ?><?php if (!empty($meta)) : ?>
                <div class="entry-meta"><?php print $meta; ?></div>
            <?php endif; ?><?php
            print azexo_entry_meta($product_template, 'header');
            ?></div>
        <?php if (isset($options[$product_template . '_show_content']) && $options[$product_template . '_show_content'] != 'hidden'): ?>
            <?php if ($options[$product_template . '_show_content'] == 'excerpt') : ?>
                <?php
                $summary = '';
                if ($single) {
                    ob_start();
                    woocommerce_template_single_excerpt();
                    $summary = ob_get_clean();
                } else {
                    $summary = azexo_excerpt(apply_filters('woocommerce_short_description', $post->post_excerpt), isset($options[$product_template . '_excerpt_length']) ? $options[$product_template . '_excerpt_length'] : false, isset($options[$product_template . '_excerpt_words_trim']) ? $options[$product_template . '_excerpt_words_trim'] : true);
                }
                $summary = trim($summary);
                ?>
                <?php if (!empty($summary)) : ?>
                    <div class="entry-summary"><?php print $summary; ?></div>
                <?php endif; ?>        
            <?php else : ?>
                <?php
                $content = '';
                if (isset($options[$product_template . '_more_inside_content']) && $options[$product_template . '_more_inside_content']) {
                    ob_start();
                    the_content($more_link_text);
                    $content = ob_get_clean();
                } else {
                    ob_start();
                    the_content('');
                    $content = ob_get_clean();
                }
                $content = trim($content);
                ?>                    
                <?php if (!empty($content)) : ?>
                    <div class="entry-content"><?php print $content; ?></div>
                <?php endif; ?>        
            <?php endif; ?>  
        <?php endif; ?>   

        <?php
        $footer = azexo_entry_meta($product_template, 'footer');
        ?>
        <?php if (!empty($footer)) : ?>
            <div class="entry-footer"><?php print $footer; ?></div>
        <?php endif; ?>


        <?php print azexo_entry_meta($product_template, 'data'); ?>
        <?php
        if ($single) {
            do_action('woocommerce_single_product_summary');
        }
        ?>
        <?php
        if (!$single) {
            do_action('woocommerce_after_shop_loop_item');
        }
        ?>
    </div>
    <?php
    $additions = azexo_entry_meta($product_template, 'additions');
    ?>
    <?php if (!empty($additions)) : ?>
        <div class="entry-additions"><?php print $additions; ?></div>
    <?php endif; ?>
    <?php do_action('azexo_entry_close'); ?>
</div>
</<?php print $azexo_woo_base_tag; ?>>
<?php
print azexo_entry_meta($product_template, 'next');
?>
