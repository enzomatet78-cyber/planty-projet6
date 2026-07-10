<?php
/**
 * Pied de page du thème enfant Planty.
 *
 * Chargé par get_footer() en bas de chaque template.
 * Contenu : logo, menu du pied de page, mention légale, puis fermeture du document.
 *
 * @package astra-child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<footer class="planty-footer">
    <div class="planty-container planty-footer__inner">

        <a class="planty-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php bloginfo( 'name' ); ?><span>&#9670;</span>
        </a>

        <!-- Menu secondaire (emplacement "footer"). Le lien mentions légales
             peut mener vers une page vide ou l'accueil (non rédigé à ce stade). -->
        <nav class="planty-footer__nav" aria-label="<?php esc_attr_e( 'Menu du pied de page', 'astra-child' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>

        <p class="planty-footer__legal">
            &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> &mdash;
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Mentions légales', 'astra-child' ); ?></a>
        </p>

    </div>
</footer>

<?php wp_footer(); // Indispensable : WordPress et les plugins injectent ici leurs scripts de fin de page. ?>
</body>
</html>
