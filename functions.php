<?php
// 1. CSS und JS einbinden
function agency_theme_assets() {
    // Google Fonts
    wp_enqueue_style('google-fonts-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,700', [], null);
    wp_enqueue_style('google-fonts-roboto', 'https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700', [], null);

    // Theme CSS (enthält Bootstrap)
    $styles_path = get_template_directory() . '/css/styles.css';
    if (file_exists($styles_path)) {
        wp_enqueue_style(
            'agency-styles',
            get_template_directory_uri() . '/css/styles.css',
            [],
            filemtime($styles_path)
        );
    }

    // Font Awesome
    wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/releases/v6.3.0/js/all.js', [], null, false);
    wp_script_add_data('font-awesome', 'crossorigin', 'anonymous');

    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js', [], '5.2.3', true);

    // Theme JS
    wp_enqueue_script('agency-scripts', get_template_directory_uri() . '/js/scripts.js', ['bootstrap-js'], '1.0', true);

    // API JavaScript: Auf allen Unterseiten einbinden
    if (!is_front_page()) {
        wp_enqueue_script(
            'custom-api-script',
            get_stylesheet_directory_uri() . '/js/api-handler.js',
            [],
            '1.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'agency_theme_assets');


// 2. Theme-Funktionen für die Aufgabenstellung aktivieren
function thm_medieninformatik_setup() {
    // Beitragsbilder aktivieren, damit die Fotos der Lehrenden im Backend hochgeladen werden können
    add_theme_support('post-thumbnails');

    // Erweiterte Block-Einstellungen wie Margin, Padding und Rahmen
    add_theme_support( 'appearance-tools' );

    
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

// Liest die ausgewählten Kategorien aus der URL und bereinigt ihre Slugs.
function thm_get_selected_product_categories() {
    if ( empty( $_GET['product_categories'] ) ) {
        return array();
    }

    $categories = array_filter(
        (array) wp_unslash( $_GET['product_categories'] ),
        'is_string'
    );

    return array_values(
        array_filter( array_map( 'sanitize_title', $categories ) )
    );
}

// Erstellt die Mehrfachauswahl oberhalb der WooCommerce-Produktliste.
function thm_shop_category_filter() {
    // Der Filter soll nur im Shop und auf Produktkategorie-Seiten erscheinen.
    if ( ! is_shop() && ! is_product_category() ) {
        return;
    }

    $selected_categories = thm_get_selected_product_categories();

    // Beim direkten Aufruf einer Kategorie-Seite wird diese vorausgewählt.
    if ( empty( $selected_categories ) && is_product_category() ) {
        $selected_categories[] = get_queried_object()->slug;
    }

    // Es werden nur Kategorien angezeigt, denen veröffentlichte Produkte zugeordnet sind.
    $product_categories = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'orderby'    => 'name',
            'order'      => 'ASC',
        )
    );

    if ( is_wp_error( $product_categories ) || empty( $product_categories ) ) {
        return;
    }
    ?>

    <form
        class="thm-shop-filter"
        method="get"
        action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
    >
        <fieldset class="thm-shop-filter__field">
            <legend>Produktkategorien</legend>

            <div class="thm-shop-filter__options">
                <?php foreach ( $product_categories as $product_category ) : ?>
                    <label class="thm-shop-filter__option">
                        <input
                            type="checkbox"
                            name="product_categories[]"
                            value="<?php echo esc_attr( $product_category->slug ); ?>"
                            <?php checked( in_array( $product_category->slug, $selected_categories, true ) ); ?>
                        >
                        <span><?php echo esc_html( $product_category->name ); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </fieldset>

        <?php
        // Behält die vorhandene WooCommerce-Sortierung, zum Beispiel nach Preis, bei.
        if ( isset( $_GET['orderby'] ) ) :
            ?>
            <input
                type="hidden"
                name="orderby"
                value="<?php echo esc_attr( wc_clean( wp_unslash( $_GET['orderby'] ) ) ); ?>"
            >
        <?php endif; ?>

        <button type="submit">Filtern</button>

        <?php if ( ! empty( $selected_categories ) ) : ?>
            <a
                class="thm-shop-filter__reset"
                href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
            >
                Zurücksetzen
            </a>
        <?php endif; ?>
    </form>

    <?php
}

// Positioniert den Kategorie-Filter vor der eigentlichen Produktliste.
add_action( 'woocommerce_before_shop_loop', 'thm_shop_category_filter', 15 );

// Ergänzt die WooCommerce-Produktabfrage um die ausgewählten Kategorien.
function thm_filter_products_by_categories( $tax_query ) {
    $selected_categories = thm_get_selected_product_categories();

    if ( ! empty( $selected_categories ) ) {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $selected_categories,
            // IN bedeutet: Das Produkt muss mindestens einer Auswahl angehören.
            'operator' => 'IN',
        );
    }

    return $tax_query;
}
add_filter( 'woocommerce_product_query_tax_query', 'thm_filter_products_by_categories' );

// Standard-Sidebar von WooCommerce entfernen
function thm_remove_woocommerce_sidebar() {
    remove_action(
        'woocommerce_sidebar',
        'woocommerce_get_sidebar',
        10
    );
}
add_action( 'wp', 'thm_remove_woocommerce_sidebar' );
?>
