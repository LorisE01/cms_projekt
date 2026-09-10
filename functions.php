<?php
// 1. CSS und JS einbinden (Dein ursprünglicher Code)
function agency_theme_assets() {
    // Google Fonts
    wp_enqueue_style('google-fonts-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,700', [], null);
    wp_enqueue_style('google-fonts-roboto', 'https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700', [], null);

    // Theme CSS (enthält Bootstrap)
    $styles_path = get_template_directory() . '/css/styles.css';
    wp_enqueue_style(
        'agency-styles',
        get_template_directory_uri() . '/css/styles.css',
        [],
        filemtime($styles_path)
    );

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

// 4. WooCommerce Produktgalerie Unterstützung aktivieren
function thm_theme_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'thm_theme_woocommerce_support' );

// 5. Produktkategorien auf der Shop-Seite filtern
function thm_shop_category_filter() {
    if ( ! is_shop() && ! is_product_category() ) {
        return;
    }

    $selected_category = '';

    if ( isset( $_GET['product_cat'] ) ) {
        $selected_category = sanitize_title(
            wp_unslash( $_GET['product_cat'] )
        );
    } elseif ( is_product_category() ) {
        $selected_category = get_queried_object()->slug;
    }
    ?>

    <form
        class="thm-shop-filter"
        method="get"
        action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
    >
        <div class="thm-shop-filter__field">
            <label for="product-category">Produktkategorie</label>

            <?php
            wc_product_dropdown_categories(
                array(
                    'id'                => 'product-category',
                    'name'              => 'product_cat',
                    'selected'          => $selected_category,
                    'show_option_none'  => 'Alle Kategorien',
                    'option_none_value' => '',
                    'orderby'           => 'name',
                    'hierarchical'      => true,
                    'hide_empty'        => true,
                )
            );
            ?>
        </div>

        <?php
        if ( isset( $_GET['orderby'] ) ) :
            ?>
            <input
                type="hidden"
                name="orderby"
                value="<?php echo esc_attr( wc_clean( wp_unslash( $_GET['orderby'] ) ) ); ?>"
            >
        <?php endif; ?>

        <button type="submit">Filtern</button>
    </form>

    <?php
}
add_action( 'woocommerce_before_shop_loop', 'thm_shop_category_filter', 15 );

?>
