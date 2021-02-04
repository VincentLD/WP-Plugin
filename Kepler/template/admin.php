<div class="wrap">

    <h1>Kepler plugin</h1>

    <?php settings_errors(); ?>

    <form method="POST" action="options.php">

        <?php

            settings_fields( 'kepler_options_group' );
            do_settings_sections( 'kepler_plugin' );
            submit_button();

        ?>

    </form>
</div>
