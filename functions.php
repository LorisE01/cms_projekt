<?php
// 1. CSS und JS einbinden (Dein ursprünglicher Code)
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


// 2. Theme-Funktionen für die Aufgabenstellung aktivieren
function thm_medieninformatik_setup() {
    // Beitragsbilder aktivieren, damit die Fotos der Lehrenden im Backend hochgeladen werden können
    add_theme_support('post-thumbnails'); 
    
    // Dynamisches Navigationsmenü registrieren (Bearbeitbar unter Design -> Menüs)
    register_nav_menus(array(
        'primary' => 'Hauptnavigation',
    ));
}
add_action('after_setup_theme', 'thm_medieninformatik_setup');


// 3. Dynamischen Footer als Widget registrieren
function thm_medieninformatik_widgets() {
    // Erstellt einen Widget-Bereich für den Footer (Bearbeitbar unter Design -> Widgets)
    register_sidebar(array(
        'name'          => 'Footer Widget Bereich',
        'id'            => 'footer-widget',
        'before_widget' => '<div class="col-lg-4 my-3 my-lg-0 footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'thm_medieninformatik_widgets');

// Fügt die Klasse 'nav-item' zu den <li> Elementen im Menü hinzu
function agency_add_li_class($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'agency_add_li_class', 1, 3);

// Fügt die Klasse 'nav-link' zu den <a> Elementen im Menü hinzu
function agency_add_a_class($atts, $item, $args) {
    if(isset($args->add_a_class)) {
        $atts['class'] = $args->add_a_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'agency_add_a_class', 1, 3);

?>