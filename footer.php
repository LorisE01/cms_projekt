<footer class="footer py-4 bg-dark text-white-50">
            <div class="container">
                <div class="row align-items-center">
                    <?php if ( is_active_sidebar( 'footer-widget' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-widget' ); ?>
                    <?php else: ?>
                        <div class="col-lg-4 text-lg-start">Bitte Footer-Widgets im Backend hinzufügen.</div>
                    <?php endif; ?>
                </div>
            </div>
        </footer>
        
        <?php wp_footer(); ?>
    </body>
</html>