<?php get_header(); // Lädt die Navigation und den Header ?>

<div class="container py-5" style="margin-top: 100px;">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="row">
            <!-- Das Bild der Person -->
            <div class="col-md-4 text-center">
                <?php if ( has_post_thumbnail() ) { 
                    the_post_thumbnail('large', array('class' => 'img-fluid rounded-circle', 'style' => 'width: 300px; height: 300px; object-fit: cover;')); 
                } ?>
            </div>

            <!-- Der Inhalt (Name, Text, Links) -->
            <div class="col-md-8">
                <h1 class="text-uppercase" style="color: #4a5e65;"><?php the_title(); ?></h1>
                <hr>
                <div class="mt-4">
                    <?php the_content(); ?>
                </div>
                <a href="<?php echo home_url(); ?>#lehrende" class="btn btn-secondary mt-4" style="background-color: #4a5e65;">Zurück zur Übersicht</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); // Lädt den Footer ?>