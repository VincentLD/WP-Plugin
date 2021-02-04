<?php
/**
 * @package Kepler
 */

/**
 * Plugin Name: Kepler
 * Plugin URI: https://www.inodia.fr/
 * Description: Récupérer des voitures sur la plateforme KeplerVo, solution informatique pour les garagistes.
 * Version: 1.0.0
 * Author: Inodia
 * Author URI: https://www.inodia.fr/
 * License: GPLv2 or later
 */

if ( !class_exists('Kepler')) {

    include 'includes/KeplerAdmin.php';
    include 'includes/KeplerApi.php';
    include 'includes/KeplerCron.php';
    include 'includes/KeplerVehiculeManagement.php';

    class Kepler {

        public function __construct() {

        }

        public function register() {
            register_activation_hook(__FILE__, array($this, 'activate'));
            register_deactivation_hook(__FILE__, array($this, 'deactivate'));

            $kepler_admin = new KeplerAdmin();
            // Add menus
            add_action('admin_menu', array($kepler_admin, 'add_submenu_page'));

            // Init custom setting fields
            add_action('admin_init', array($kepler_admin, 'registerCustomFields'));

            // Bypass WordPress template hierachy
            add_filter('archive_template', array($this, 'kepler_archive_template'));
            add_filter('single_template', array($this, 'kepler_single_template'));


            // Init cronjob
            //add_action('wp', array($this, 'kepler_cron'));
         
        
           /*  $keplerApi = KeplerApi::getInstance();
            $vehicules = $keplerApi::kepler_get_vehicles(); 

            echo '<pre>';
            var_dump($vehicules);
            echo '</pre>'; */
        }

        public function kepler_cron() {
            $kepler_cron = KeplerCron::getInstance();
            $kepler_cron::run(KeplerApi::getInstance());
        }

        public function kepler_archive_template($archive) {

            global $post;

            /* Checks for archive template by post type */
            if ( $post->post_type == 'vehicule' ) {
                if ( file_exists( plugin_dir_path( __FILE__ ) . 'template/archive-vehicule.php' ) ) {
                    return plugin_dir_path( __FILE__ ) . 'template/archive-vehicule.php';
                }
            }
            
            return $archive;
        }

        public function kepler_single_template($single) {

            global $post;

            /* Checks for single template by post type */
            if ( $post->post_type == 'vehicule' ) {
                if ( file_exists( plugin_dir_path( __FILE__ ) . 'template/single-vehicule.php' ) ) {
                    return plugin_dir_path( __FILE__ ) . 'template/single-vehicule.php';
                }
            }
            
            return $single;
        }

        public static function activate() {
            flush_rewrite_rules();
        }

        public function deactivate() {
            flush_rewrite_rules();
        }
    }

    $kepler = new Kepler();
    $kepler->register();
}
    

