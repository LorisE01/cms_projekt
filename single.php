<?php get_header(); ?>

<main class="bg-light min-vh-100 py-5" style="padding-top: 140px !important;">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="bg-white rounded-4 shadow-lg p-4 p-md-5">
                <div class="row align-items-center g-5">
                    <!-- Bild der Person -->
                    <div class="col-md-4 text-center">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php
                            the_post_thumbnail(
                                'large',
                                array(
                                    'class' => 'img-fluid rounded-circle shadow border border-5 border-white',
                                    'style' => 'width: 300px; height: 300px; object-fit: cover;',
                                )
                            );
                            ?>
                        <?php else : ?>
                            <div
                                class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto shadow"
                                style="width: 300px; height: 300px; font-size: 5rem; font-weight: bold;"
                            >
                                <?php echo esc_html( strtoupper( substr( get_the_title(), 0, 1 ) ) ); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Inhalt -->
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                            <span class="text-uppercase fw-bold" style="color: #80bd24; letter-spacing: 2px;">
                                Lehrende
                            </span>

                            <!-- Hier werden die Kategorien Themengebiete angezeigt, zu denen die Lehrende gehören -->
                            <?php
                            $categories = get_the_category();

                            if ( ! empty( $categories ) ) :
                                foreach ( $categories as $category ) :

                                    // Optional: Kategorie "Lehrende" nicht nochmal anzeigen
                                    if ( $category->slug === 'lehrende' ) {
                                        continue;
                                    }
                                    ?>

                                    <span class="badge rounded-pill text-white px-3 py-2" style="background-color: #80bd24;">
                                        <?php echo esc_html( $category->name ); ?>
                                    </span>

                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </div>

                        <h1 class="display-4 fw-bold text-uppercase mb-3" style="color: #4a5e65;">
                            <?php the_title(); ?>
                        </h1>

                        <div
                            class="mb-4"
                            style="width: 90px; height: 5px; background-color: #80bd24; border-radius: 999px;"
                        ></div>

                        <div class="fs-5 lh-lg text-secondary">
                            <?php the_content(); ?>
                        </div>

                        <a
                            href="<?php echo esc_url( home_url( '/#lehrende' ) ); ?>"
                            class="btn btn-lg text-white fw-bold rounded-pill px-4 py-3 mt-4 shadow-sm"
                            style="background-color: #4a5e65;"
                        >
                            Zurück zur Übersicht
                        </a>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>