<?php

class KeplerVehiculeManagement {

    public static function fieldQuery(string $field)  : array  {

        $query = new WP_Query([

            'post_type' => 'vehicule',
            'post_status' => 'publish'
        ]);

         $results = []; 

        if($query->have_posts()) : while($query->have_posts()) : $query->the_post();

            $results[] = get_field($field);

            /* $field = get_field($field);

            if (!in_array($field, $results)) {

                $results[] = $field;
            } */

        endwhile;
        endif;

        wp_reset_postdata();

        return $results; 
    }
}