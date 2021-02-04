<?php 
	require_once plugin_dir_path(__DIR__.'/../Kepler.php').'includes/KeplerVehiculeManagement.php'; 

	get_header();

?>

<section style="margin-bottom: 4rem;" id="header-sub-pages">
    <div class="header-wrapper">
        <h2> Nos véhicules</h2>
    </div>
</section>

<div class="wrapper">
	<h3 style="text-align: center;">Résultats de la recherche pour véhicule <span style="color: #3e3e3e"> de moins de 200.000km, essence. </span></h3>
	<div class="vehicules-wrapper">

		<?php 
			$query = new WP_Query([

				'post_type' => 'vehicule',
				'post_status' => 'publish',
				'perm' => 'readable',
				'meta_key' => '',
				'meta_value' => '',
				'meta_compare' => '',
			]);
	
			if($query->have_posts()) : while($query->have_posts()) : $query->the_post();

			while(have_rows('photo_group')) : the_row();
				$repeater = get_field('photo_group');
				$firstImage = $repeater[0]['original_photo'];
			endwhile;
		?>
		
		<div class="card">
			<a href="http://oto22.inodia.pro/vehicule/<?php the_field('reference') ?>">
				<div class="card-header">
					<img src="<?php echo $firstImage ?>" alt="vehicule">
				</div>
				<div class="card-body">
					<h3 class="card-title"><?php the_field('marque') ?> <?php the_field('modele') ?></h3>
					<p class="card-finition"><?php the_field('finition') ?></p>
					<p class="card-kilometrage"><?php the_field('kilometrage') ?>km - <span class="card-energie"><?php the_field('energie') ?></span></p>
					<h3 id="card-prix"><?php the_field('prix_ttc') ?> € TTC</h3>
					<p id="card-mensualite">À partir de <?php the_field('mensualite') ?>€/mois</p>
				</div>
			</a>
		</div>
		<?php endwhile ?>
		<?php endif ?>
		<?php wp_reset_postdata() ?>
	</div>
</div>


<?php get_footer() ?>

