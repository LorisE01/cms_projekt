<?php get_header(); ?>

<main class="single-page">

  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

      <?php
        $funktion = get_post_meta( get_the_ID(), 'funktion', true );
        $email    = get_post_meta( get_the_ID(), 'email', true );
        $raum     = get_post_meta( get_the_ID(), 'raum', true );
        $telefon  = get_post_meta( get_the_ID(), 'telefon', true );
        $website  = get_post_meta( get_the_ID(), 'website', true );

        $categories = get_the_category_list( ' / ' );
      ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-person-page' ); ?>>

        <header class="single-person-hero">
          <div class="single-person-hero-inner">

            <div class="single-person-image">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large' ); ?>
              <?php else : ?>
                <div class="single-person-placeholder">
                  <?php echo esc_html( strtoupper( substr( get_the_title(), 0, 1 ) ) ); ?>
                </div>
              <?php endif; ?>
            </div>

            <div class="single-person-intro">
              <?php if ( $categories ) : ?>
                <div class="single-person-category">
                  <?php echo $categories; ?>
                </div>
              <?php endif; ?>

              <h1><?php the_title(); ?></h1>

              <?php if ( $funktion ) : ?>
                <p class="single-person-function">
                  <?php echo esc_html( $funktion ); ?>
                </p>
              <?php endif; ?>

              <div class="single-person-meta">
                <span><?php echo get_the_date(); ?></span>
              </div>
            </div>

          </div>
        </header>

        <div class="single-person-layout">

          <section class="single-person-content">
            <?php the_content(); ?>

            <?php
              wp_link_pages( array(
                'before' => '<div class="page-links">Seiten: ',
                'after'  => '</div>',
              ) );
            ?>
          </section>

          <aside class="single-person-sidebar">
            <div class="single-person-contact-card">
              <h2>Kontakt</h2>

              <?php if ( $email || $raum || $telefon || $website ) : ?>

                <ul>
                  <?php if ( $email ) : ?>
                    <li>
                      <strong>E-Mail</strong>
                      <a href="mailto:<?php echo esc_attr( sanitize_email( $email ) ); ?>">
                        <?php echo esc_html( antispambot( $email ) ); ?>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ( $telefon ) : ?>
                    <li>
                      <strong>Telefon</strong>
                      <span><?php echo esc_html( $telefon ); ?></span>
                    </li>
                  <?php endif; ?>

                  <?php if ( $raum ) : ?>
                    <li>
                      <strong>Raum</strong>
                      <span><?php echo esc_html( $raum ); ?></span>
                    </li>
                  <?php endif; ?>

                  <?php if ( $website ) : ?>
                    <li>
                      <strong>Website</strong>
                      <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener">
                        Website öffnen
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>

              <?php else : ?>

                <p>Für diese Person wurden noch keine Kontaktdaten hinterlegt.</p>

              <?php endif; ?>
            </div>
          </aside>

        </div>

        <nav class="single-person-navigation">
          <div>
            <?php previous_post_link( '%link', '← Vorheriger Beitrag' ); ?>
          </div>
          <div>
            <?php next_post_link( '%link', 'Nächster Beitrag →' ); ?>
          </div>
        </nav>

      </article>

    <?php endwhile; ?>
  <?php else : ?>

    <p>Der Beitrag wurde nicht gefunden.</p>

  <?php endif; ?>

</main>

<?php get_footer(); ?>