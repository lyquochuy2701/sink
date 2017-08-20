<?php
/*
  Field Name: Product share for coupon
 */
?>
<?php
global $product;
$coupon = get_post_meta($product->id, 'coupon', true);
wp_enqueue_script('azexo-fields', get_template_directory_uri() . '/js/fields.js', array('jquery'), AZEXO_FRAMEWORK_VERSION, true);
?>

<?php if (!empty($coupon)) : ?>
    <div class="share-for-coupon">
        <div class="coupon-wrapper">
            <label><?php esc_attr_e('Coupon:', 'sport-ak'); ?></label> <span data-code="<?php print esc_attr($coupon); ?>" class="coupon" data-copied="<?php esc_attr_e('Code copied to the clipboard', 'sport-ak'); ?>"><?php esc_attr_e('Share for view', 'sport-ak'); ?></span>
        </div>
        <div class="entry-share"><?php azexo_entry_share(); ?></div>
    </div>
<?php endif; ?>


