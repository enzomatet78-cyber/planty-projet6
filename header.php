<?php
/**
 * En-tête du thème enfant Planty.
 *
 * Ce fichier remplace l'en-tête du thème parent (Astra).
 * Il est chargé par la fonction get_header() appelée en haut de chaque template.
 * Contenu : ouverture du document HTML, <head>, puis le logo et le menu principal.
 *
 * @package astra-child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Sécurité : empêche l'accès direct au fichier.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); // Indispensable : WordPress et les plugins injectent ici leurs styles/scripts. ?>
</head>

<body <?php body_class( 'planty' ); ?>>
<?php wp_body_open(); // Hook standard juste après l'ouverture du body (barre d'admin, etc.). ?>

<header class="planty-header">
    <div class="planty-container planty-header__inner">

        <!-- Logo : le nom du site, modifiable dans Réglages > Général (donc sans code) -->
        <a class="planty-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php bloginfo( 'name' ); ?><span>&#9670;</span>
        </a>

        <!-- Menu principal : géré dans Apparence > Menus, emplacement "primary".
             C'est sur ce menu que le hook ajoute le lien "Admin" quand on est connecté. -->
        <nav class="planty-nav" aria-label="<?php esc_attr_e( 'Menu principal', 'astra-child' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false, // On a déjà notre <nav>, pas besoin d'un conteneur en plus.
                'menu_id'        => 'menu-principal',
                'fallback_cb'    => false, // N'affiche rien si aucun menu n'est assigné.
            ) );
            ?>
        </nav>

    </div>
</header>
