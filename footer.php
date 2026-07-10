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
    <div class="planty-container">
        <!-- Footer maquette : simplement le lien "Mentions légales", noir sur fond blanc.
             La page peut être vide à ce stade (mentions non rédigées). -->
        <p class="planty-footer__legal">
            <a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>"><?php esc_html_e( 'Mentions légales', 'astra-child' ); ?></a>
        </p>
    </div>
</footer>

<?php wp_footer(); // Indispensable : WordPress et les plugins injectent ici leurs scripts de fin de page. ?>
</body>
</html>
