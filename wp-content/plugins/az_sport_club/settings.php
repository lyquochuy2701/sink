<?php
add_action('admin_menu', 'azsc_admin_menu');

function azsc_admin_menu() {
    add_menu_page(__('Sport Club Settings', 'azsc'), __('Sport Club Settings', 'azsc'), 'manage_options', 'azsc-settings', 'azsc_settings_page');
}

function azsc_settings_page() {
    ?>

    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php _e('AZEXO Sport Club Settings', 'azsc'); ?></h2>

        <form method="post" action="options.php" class="azsc-form">
            <?php
            settings_errors();
            settings_fields('azsc-settings');
            do_settings_sections('azsc-settings');
            submit_button('Save Settings');
            ?>
        </form>
    </div>

    <?php
}

function azsc_general_options_callback() {
    
}

add_action('admin_init', 'azsc_general_options');

function azsc_general_options() {
    add_settings_section(
            'azsc_general_options_section', // Section ID
            '', // Title above settings section
            'azsc_general_options_callback', // Name of function that renders a description of the settings section
            'azsc-settings'                     // Page to show on
    );
    register_setting('azsc-settings', 'azsc-settings');

    add_settings_field(
            'gmap_api_key', // Field ID
            esc_html__('Google Map API key', 'azsc'), // Label to the left
            'azsc_textfield', // Name of function that renders options on the page
            'azsc-settings', // Page to show on
            'azsc_general_options_section', // Associate with which settings section?
            array(
        'id' => 'gmap_api_key',
        'default' => '',
        'desc' => '',
            )
    );
}

function azsc_checkbox($args) {
    extract($args);
    $settings = get_option('azsc-settings');
    if (isset($default) && !isset($settings[$id])) {
        $settings[$id] = $default;
    }
    foreach ($options as $value => $label) {
        ?>
        <div>
            <input id="<?php print esc_attr($id) . esc_attr($value); ?>" type="checkbox" name="azsc-settings[<?php print esc_attr($id); ?>][<?php print esc_attr($value); ?>]" value="1" <?php @checked($settings[$id][$value], 1); ?>>
            <label for="<?php print esc_attr($id) . esc_attr($value); ?>"><?php print esc_html($label); ?></label>
        </div>
        <?php
    }
    ?>
    <p><em>
            <?php print esc_html($desc); ?>
        </em></p>
    <?php
}

function azsc_textfield($args) {
    extract($args);
    $settings = get_option('azsc-settings');
    if (isset($default) && !isset($settings[$id])) {
        $settings[$id] = $default;
    }
    ?>
    <input type="text" name="azsc-settings[<?php print esc_attr($id); ?>]" value="<?php print esc_attr($settings[$id]); ?>">
    <p><em>
            <?php print esc_html($desc); ?>
        </em></p>
    <?php
}

function azsc_textarea($args) {
    extract($args);
    $settings = get_option('azsc-settings');
    if (isset($default) && !isset($settings[$id])) {
        $settings[$id] = $default;
    }
    ?>
    <textarea name="azsc-settings[<?php print esc_attr($id); ?>]" cols="50" rows="5"><?php print esc_attr($settings[$id]); ?></textarea>
    <p><em>
            <?php print esc_html($desc); ?>
        </em></p>
    <?php
}
