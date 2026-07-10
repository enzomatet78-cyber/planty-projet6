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

    // Notre CSS ; dépend du style enfant (ctc-style) pour se charger après lui
    wp_enqueue_style(
        'planty-main',
        get_stylesheet_directory_uri() . '/assets/css/planty.css',
        array( 'chld_thm_cfg_separate' ),
        wp_get_theme()->get( 'Version' )
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

    $items .= '<li class="menu-item">
                  <a href="' . admin_url() . '">Admin</a>
               </li>';

    return $items;
}

add_filter('wp_nav_menu_items', 'ajouter_lien_admin', 10, 2);