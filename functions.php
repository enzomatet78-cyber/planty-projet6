<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_separate', trailingslashit( get_stylesheet_directory_uri() ) . 'ctc-style.css', array( 'astra-theme-css' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

/**
 * Charge la police Syne (Google Fonts) et la feuille de style de nos templates.
 * Accrochée à wp_enqueue_scripts, le hook standard pour ajouter styles et scripts.
 */
function planty_enqueue_assets() {
    // Police Syne utilisée dans toute la maquette
    wp_enqueue_style(
        'planty-google-fonts',
        'https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&display=swap',
        array(),
        null
    );

    // Notre CSS ; dépend du style enfant (ctc-style) pour se charger après lui.
    // Version = date de modif du fichier (filemtime) : le cache navigateur se
    // met à jour automatiquement à chaque modification du CSS.
    $planty_css = get_stylesheet_directory() . '/assets/css/planty.css';
    wp_enqueue_style(
        'planty-main',
        get_stylesheet_directory_uri() . '/assets/css/planty.css',
        array( 'chld_thm_cfg_separate' ),
        file_exists( $planty_css ) ? filemtime( $planty_css ) : '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 'planty_enqueue_assets', 20 );

function ajouter_lien_admin($items, $args) {


    if ($args->theme_location !== 'primary') {
        return $items;
    }

    if (!is_user_logged_in()) {
        return $items;
    }

    $admin = '<li class="menu-item menu-item-admin">
                  <a href="' . admin_url() . '">Admin</a>
               </li>';

    // La maquette place « Admin » AVANT le bouton « Commander », qui est le
    // dernier élément du menu. On insère donc le lien juste avant ce dernier
    // <li> au lieu de l'ajouter à la fin.
    $position = strrpos( $items, '<li' );

    if ( false !== $position ) {
        $items = substr( $items, 0, $position ) . $admin . substr( $items, $position );
    } else {
        $items .= $admin;
    }

    return $items;
}

add_filter('wp_nav_menu_items', 'ajouter_lien_admin', 10, 2);
/**
 * Page Commander : charge le script des boutons + / − et Ok des parfums.
 * is_page( 'commander' ) : le fichier n'est chargé que sur cette page,
 * inutile de l'imposer aux visiteurs des autres pages.
 */
function planty_script_commande() {
    if ( ! is_page( 'commander' ) ) {
        return;
    }

    $fichier = get_stylesheet_directory() . '/assets/js/commande.js';
    wp_enqueue_script(
        'planty-commande',
        get_stylesheet_directory_uri() . '/assets/js/commande.js',
        array(),                                          // aucune dépendance (pas besoin de jQuery)
        file_exists( $fichier ) ? filemtime( $fichier ) : '1.0',
        true                                              // en bas de page : le HTML est déjà chargé
    );
}
add_action( 'wp_enqueue_scripts', 'planty_script_commande' );

/**
 * Ajoute au mail de précommande le nombre total de bouteilles commandées.
 *
 * Contact Form 7 ne sait pas additionner des champs : il se contente de
 * remplacer chaque balise par la valeur saisie. On crée donc une « balise
 * spéciale » [_total_bouteilles], utilisable dans le sujet et le corps du
 * mail comme n'importe quelle autre balise.
 *
 * Le filtre wpcf7_special_mail_tags est appelé pour chaque balise commençant
 * par un souligné. On ne répond qu'à la nôtre et on laisse les autres passer.
 */
add_filter( 'wpcf7_special_mail_tags', 'planty_total_bouteilles', 10, 4 );
function planty_total_bouteilles( $sortie, $nom, $html, $balise ) {

    if ( '_total_bouteilles' !== $nom && 'total_bouteilles' !== $nom ) {
        return $sortie;
    }

    // Les données envoyées par le formulaire qui vient d'être soumis.
    $envoi = WPCF7_Submission::get_instance();

    if ( ! $envoi ) {
        return $sortie;
    }

    $donnees = $envoi->get_posted_data();
    $total   = 0;

    foreach ( array( 'fraise', 'pamplemousse', 'framboise', 'citron' ) as $parfum ) {
        if ( isset( $donnees[ $parfum ] ) ) {
            $total += (int) $donnees[ $parfum ];
        }
    }

    return $total;
}
