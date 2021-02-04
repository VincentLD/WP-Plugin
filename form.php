<?php
add_shortcode('findCar', function() {

$query = new WP_Query([
    'post_type' => 'vehicule',
    'post_status' => 'publish',
    'perm' => 'readable',
]);

return
'<form method="GET" action="#" class="findCarForm">
    <div class="form-group-wrapper">
        <div class="form-group">
            <select class="selectCar selectCarMarque" id="selectCarMarque" name="selectCarMarque">
                <option></option>'
                ?>
                <?php if($query->have_posts()) : while($query->have_posts()) : $query->the_post(); ?>
                    <?php '<option class="selectCarOption" value="'?>
                    <?php the_field('marque') ?>
                    <?php'">'?>
                    <?php the_field('marque') ?>
                    <?php'</option>'?> 
                <?php endwhile?>
                <?php endif ?>
                <?php wp_reset_postdata() ?>
                <?php'
            </select>
        </div>
        <div class="form-group">
            <select class="selectCar selectCarModele" id="selectCarModele" name="selectCarModele">
                <option></option>'
                ?>
                <?php if($query->have_posts()) : while($query->have_posts()) : $query->the_post(); ?>
                    <?php '<option class="selectCarOption" value="'?>
                    <?php the_field('modele') ?>
                    <?php'">'?>
                    <?php the_field('modele') ?>
                    <?php'</option>'?> 
                <?php endwhile?>
                <?php endif ?>
                <?php wp_reset_postdata() ?>
                <?php'
            </select>
            </select>
        </div>
        <div class="form-group">
            <select class="selectCar selectCarPrixMax" id="selectCarPrixMax" name="selectCarPrixMax">
                <option></option>
                <option class="selectCarOption value="">2500€</option>
                <option class="selectCarOption value="">2500€</option>
                <option class="selectCarOption value="">2500€</option>
                <option class="selectCarOption value="">2500€</option>
            </select>
        </div>
        <div class="form-group">
            <select class="selectCar selectCarMensMax" id="selectCarMensMax" name="selectCarMensMax">
                <option></option>
                <option class="selectCarOption" value="">250€</option>
                <option class="selectCarOption" value="">250€</option>
                <option class="selectCarOption" value="">250€</option>
                <option class="selectCarOption" value="">250€</option>
            </select>
        </div>
        <div class="form-group">
            <select class="selectCar selectCarKmMax" id="selectCarKmMax" name="selectCarKmMax">
                <option></option>
                <option class="selectCarOption" value="">165000</option>
                <option class="selectCarOption" value="">165000</option>
                <option class="selectCarOption" value="">165000</option>
                <option class="selectCarOption" value="">165000</option>
            </select>
        </div>
        <div class="form-group">
            <input class="bouton" type="submit" value="Rechercher">
        </div>            
    </div>
</form>'?><?php
});
