<?php 

/* require_once ABSPATH . "wp-includes/pluggable.php";
require_once ABSPATH . "wp-includes/wp-load.php"; */
require_once 'KeplerApi.php';

class KeplerCron {
    
    private static $instance;

    private function __construct() {
        
        //
    }

    // Singleton
    public static function getInstance(): self  {

        if (is_null(self::$instance)) {

            self::$instance = new KeplerCron();
        }

        return self::$instance;
    }

    private static function get_cpt_id( $title, $content = '', $date = '', $type = '' ) {

        global $wpdb;
     
        $post_title   = wp_unslash( sanitize_post_field( 'post_title', $title, 0, 'db' ) );
        $post_content = wp_unslash( sanitize_post_field( 'post_content', $content, 0, 'db' ) );
        $post_date    = wp_unslash( sanitize_post_field( 'post_date', $date, 0, 'db' ) );
        $post_type    = wp_unslash( sanitize_post_field( 'post_type', $type, 0, 'db' ) );
     
        $query = "SELECT ID FROM $wpdb->posts WHERE 1=1";
        $args  = array();
     
        if ( ! empty( $date ) ) {
            $query .= ' AND post_date = %s';
            $args[] = $post_date;
        }
     
        if ( ! empty( $title ) ) {
            $query .= ' AND post_title = %s';
            $args[] = $post_title;
        }
     
        if ( ! empty( $content ) ) {
            $query .= ' AND post_content = %s';
            $args[] = $post_content;
        }
     
        if ( ! empty( $type ) ) {
            $query .= ' AND post_type = %s';
            $args[] = $post_type;
        }
     
        if ( ! empty( $args ) ) {
            return (int) $wpdb->get_var( $wpdb->prepare( $query, $args ) );
        }
     
        return 0;
    }

    public static function run(KeplerGetVehicules $kepler_get_vehicules) {

        $vehicules = $kepler_get_vehicules::kepler_get_vehicles();

        foreach($vehicules as $vehicule) {

            $postID = self::get_cpt_id($vehicule['reference'], $content = null, $date = null, 'vehicule');

            if ($postID == 0) {

                $my_post = [
                    'post_type' => 'vehicule',
                    'post_title' => $vehicule['reference'],
                    'post_content' => '',
                    'post_status' => 'publish',
                ];

                $postID = wp_insert_post($my_post);

            }

            foreach($vehicule['gallery'] as $vGal) {

                $row = array (
                    'original_photo' => $vGal['photo'],
                    'thumb_photo' => $vGal['thumb'],
                );

                add_row('photo_group', $row, $postID);
            }

            update_field('marque', $vehicule['brand']['name'], $postID);
            update_field('modele',  $vehicule['model']['name'], $postID);
            update_field('finition', $vehicule['version']['name'], $postID);
            update_field('couleur', $vehicule['color']['name'], $postID);
            update_field('kilometrage', $vehicule['distanceTraveled'], $postID);
            update_field('energie', $vehicule['energy']['name'], $postID);
            update_field('transmission', $vehicule['gearbox']['name'], $postID);
            update_field('prix_ttc', $vehicule['purchasePriceWithTax'], $postID);
            update_field('date_circulation', $vehicule['dateOfDistribution'], $postID);
            update_field('co2', $vehicule['extraUrbanKmConsumption'], $postID);
            update_field('puissance_din', $vehicule['horsepower'], $postID);
            update_field('reference', $vehicule['reference'], $postID);
            update_field('seats', $vehicule['seats'], $postID);
            update_field('mixteConsumption', $vehicule['mixteConsumption'], $postID);
            
        }
    }
}
