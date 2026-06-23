<?php get_header(); // Lädt die Navigation und den Header ?>

<div class="single-person-page container py-5">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="row">
            <!-- Das Bild der Person -->
            <div class="col-md-4 text-center">
                <?php if ( has_post_thumbnail() ) { 
                    the_post_thumbnail('large', array('class' => 'single-person-image img-fluid rounded-circle'));
                } ?>
            </div>

            <!-- Der Inhalt (Name, Text, Links) -->
            <div class="col-md-8">
                <h1 class="single-person-title text-uppercase"><?php the_title(); ?></h1>
                <hr>
                <div class="mt-4">
                    <?php the_content(); ?>
                </div>
                <a href="<?php echo home_url(); ?>#lehrende" class="single-person-back btn mt-4">Zurück zur Übersicht</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); // Lädt den Footer ?>