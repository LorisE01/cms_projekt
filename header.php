<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
        <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico" />
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?> id="page-top">
        
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                    <span class="text-success">Medien</span>informatik
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'navbar-nav text-uppercase ms-auto py-4 py-lg-0',
                        'container'      => false,
                    ));
                    ?>
                </div>
            </div>
        </nav>

        <header class="masthead" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/header-laptop.jpg'); background-size: cover;">
            <div class="container">
                <div class="masthead-subheading">Technische Hochschule Mittelhessen</div>
                <div class="masthead-heading text-uppercase">MEDIENINFORMATIK</div>
            </div>
        </header>