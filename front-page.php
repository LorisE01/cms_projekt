<?php get_header(); ?>

<section class="page-section" id="allgemeines-schwerpunkte">
    <div class="container text-center">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                the_content(); 
            endwhile;
        endif;
        ?>
    </div>
</section>

<section class="page-section bg-light" id="lehrende">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-heading text-uppercase">Lehrende</h2>
        </div>
        
        <div class="accordion" id="accordionLehrende">
            <?php
            // Die Fächer als Kategorien abrufen
            $categories = get_categories(array(
                'include' => array(4, 5, 3), 
                'orderby' => 'include'
            ));

            $count = 0;
            foreach ($categories as $category) {
                $count++;
                $collapseId = "collapse" . $count;
                $headingId = "heading" . $count;
                $isOpen = ($count == 1) ? 'show' : ''; // Erstes Element aufklappen
                ?>
                
                <div class="accordion-item mb-3 border-0 shadow-sm">
                    <h3 class="accordion-header bg-secondary text-white p-3" id="<?php echo $headingId; ?>">
                        <button class="accordion-button text-white bg-transparent border-0 w-100 text-start font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseId; ?>" aria-expanded="true" aria-controls="<?php echo $collapseId; ?>">
                            <?php echo esc_html($category->name); ?>
                        </button>
                    </h3>
                    
                    <div id="<?php echo $collapseId; ?>" class="accordion-collapse collapse <?php echo $isOpen; ?>" aria-labelledby="<?php echo $headingId; ?>" data-bs-parent="#accordionLehrende">
                        <div class="accordion-body">
                            <div class="row text-center mt-4">
                                <?php
                                // Beiträge (Lehrende) der jeweiligen Kategorie (Fach) abfragen
                                $args = array(
                                    'post_type' => 'post',
                                    'cat' => $category->term_id,
                                    'orderby' => 'title', // Alphabetische Sortierung
                                    'order' => 'ASC',
                                    'posts_per_page' => -1
                                );
                                $lehrende_query = new WP_Query($args);

                                if ($lehrende_query->have_posts()) {
                                    while ($lehrende_query->have_posts()) {
                                        $lehrende_query->the_post();
                                        ?>
                                        <div class="col-lg-3 col-md-6 mb-4">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php 
                                                // Nur das Beitragsbild (Foto) auf der Startseite
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('medium', array('class' => 'rounded-circle img-fluid mb-3 shadow-sm', 'style' => 'width: 150px; height: 150px; object-fit: cover;'));
                                                } 
                                                ?>
                                            </a>
                                            <h5 class="fw-bold">
                                                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                                                    <?php the_title(); ?> 
                                                </a>
                                            </h5>
                                            <p class="text-muted small"><?php echo esc_html($category->name); ?></p>
                                            <div class="d-flex justify-content-center gap-2">
                                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;"><i class="fas fa-envelope fa-sm"></i></div>
                                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;"><i class="fas fa-globe fa-sm"></i></div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    wp_reset_postdata();
                                } else {
                                    echo '<p>Keine Lehrenden in dieser Kategorie gefunden.</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>