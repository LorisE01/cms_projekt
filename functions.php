<?php
function agency_theme_assets() {
    // Google Fonts
    wp_enqueue_style('google-fonts-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,700', [], null);
    wp_enqueue_style('google-fonts-roboto', 'https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700', [], null);

    // Theme CSS (enthält Bootstrap)
    wp_enqueue_style('agency-styles', get_template_directory_uri() . '/css/styles.css', [], '1.0');

    // Font Awesome
    wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/releases/v6.3.0/js/all.js', [], null, false);
    wp_script_add_data('font-awesome', 'crossorigin', 'anonymous');

    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js', [], '5.2.3', true);

    // Theme JS
    wp_enqueue_script('agency-scripts', get_template_directory_uri() . '/js/scripts.js', ['bootstrap-js'], '1.0', true);

    // SB Forms JS
    wp_enqueue_script('sb-forms', 'https://cdn.startbootstrap.com/sb-forms-latest.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'agency_theme_assets');