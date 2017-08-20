<?php

function azexo_tgmpa_register() {

    $plugins = array(
        array(
            'name' => esc_html__('Redux Framework', 'sport-ak'),
            'slug' => 'redux-framework',
            'required' => true,
        ),
        array(
            'name' => esc_html__('Custom classes for page/post', 'sport-ak'),
            'slug' => 'custom-classes',
            'source' => get_template_directory() . '/plugins/custom-classes.zip',
            'required' => true,
            'version' => '0.1',
        ),
        array(
            'name' => esc_html__('WP-LESS', 'sport-ak'),
            'slug' => 'wp-less',
            'required' => true,
        ),
        array(
            'name' => esc_html__('WordPress Importer', 'sport-ak'),
            'slug' => 'wordpress-importer',
            'required' => true,
        ),
        array(
            'name' => esc_html__('Yellow Pencil visual theme customizer', 'sport-ak'),
            'slug' => 'yellow-pencil-visual-theme-customizer',
        ),
        array(
            'name' => esc_html__('Infinite scroll', 'sport-ak'),
            'slug' => 'infinite-scroll',
        ),
        array(
            'name' => esc_html__('Widget CSS Classes', 'sport-ak'),
            'slug' => 'widget-css-classes',
        ),
        array(
            'name' => esc_html__('JP Widget Visibility', 'sport-ak'),
            'slug' => 'jetpack-widget-visibility',
        ),
        array(
            'name' => esc_html__('Contact Form 7', 'sport-ak'),
            'slug' => 'contact-form-7',
        ),
        array(
            'name' => esc_html__('Custom Sidebars', 'sport-ak'),
            'slug' => 'custom-sidebars',
        ),
    );
    $plugin_path = get_template_directory() . '/plugins/js_composer.zip';
    if (file_exists($plugin_path)) {
        $plugins[] = array(
            'name' => esc_html__('WPBakery Visual Composer', 'sport-ak'),
            'slug' => 'js_composer',
            'source' => get_template_directory() . '/plugins/js_composer.zip',
            'required' => true,
            'version' => '4.12',
            'external_url' => '',
        );
    }
    tgmpa($plugins, array());


    $additional_plugins = array(
        'vc_widgets' => esc_html__('Visual Composer Widgets', 'sport-ak'),
        'azexo_vc_elements' => esc_html__('AZEXO Visual Composer elements', 'sport-ak'),
        'az_social_login' => esc_html__('AZEXO Social Login', 'sport-ak'),
        'az_email_verification' => esc_html__('AZEXO Email Verification', 'sport-ak'),
        'az_likes' => esc_html__('AZEXO Post/Comments likes', 'sport-ak'),
        'azexo_html' => esc_html__('AZEXO HTML cusomizer', 'sport-ak'),
        'az_listings' => esc_html__('AZEXO Listings', 'sport-ak'),
        'az_query_form' => esc_html__('AZEXO Query Form', 'sport-ak'),
        'az_group_buying' => esc_html__('AZEXO Group Buying', 'sport-ak'),
        'az_vouchers' => esc_html__('AZEXO Vouchers', 'sport-ak'),
        'az_bookings' => esc_html__('AZEXO Bookings', 'sport-ak'),
        'az_deals' => esc_html__('AZEXO Deals', 'sport-ak'),
        'az_sport_club' => esc_html__('AZEXO Sport Club', 'sport-ak'),
        'az_locations' => esc_html__('AZEXO Locations', 'sport-ak'),
        'circular_countdown' => esc_html__('Circular CountDown', 'sport-ak'),
    );

    foreach ($additional_plugins as $additional_plugin_slug => $additional_plugin_name) {
        $plugin_path = get_template_directory() . '/plugins/' . $additional_plugin_slug . '.zip';
        if (file_exists($plugin_path)) {
            $plugin = array(
                array(
                    'name' => $additional_plugin_name,
                    'slug' => $additional_plugin_slug,
                    'source' => $plugin_path,
                    'required' => true,
                    'version' => AZEXO_FRAMEWORK_VERSION,
                ),
            );
            tgmpa($plugin, array(
//                'is_automatic' => true,
            ));
        }
    }
}

add_action('tgmpa_register', 'azexo_tgmpa_register');
