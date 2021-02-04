<?php

class KeplerAdmin {

    private $settings;
    private $sections;
    private $fields;

    public function __construct() {
        
        $this->initFields();
    }

     // Print the template
     public static function admin_index() {

        require_once plugin_dir_path(__DIR__.'/../Kepler.php').'template/admin.php';
    }

    
    // Add Kepler in subMenu 'Réglages'
    public function add_submenu_page() {

        add_submenu_page(
            'options-general.php', 
            'Kepler Plugin',
            'Kepler',
            'manage_options',
            'kepler_plugin',
            array($this, 'admin_index')
        );
    }

    public function initFields() {
        $this->settings = array(
            array(
                'option_group' => 'kepler_options_group',
                'option_name' => 'apiKey',
            ),
        );

        $this->sections = array(
            array(
                'id' => 'kepler_admin_index',
                'title' => 'Paramètres',
                'callback' => '',
                'page' => 'kepler_plugin',
            )
        );

        $this->fields = array(
            array(
                'id' => 'apiKey',
                'title' => 'Clé de l\'API',
                'callback' => array($this, 'apiKeyInput'),
                'page' => 'kepler_plugin',
                'section' => 'kepler_admin_index',
                'args' => array('label_for' => 'apiKey') 
            ),
        );
    }

    public function apiKeyInput() {
        
        $value = esc_attr( get_option('apiKey') );
        echo '<input type="text" class="regular-text" name="apiKey" value="'. $value .'">';
    }


    public function registerCustomFields() {

        if( (!empty($this->settings)) || (!empty($this->sections)) || (!empty($this->fields)) ) {

            foreach($this->settings as $setting) {
                // register_setting( string $option_group, string $option_name, array $args = array() )
                register_setting(
                    $setting["option_group"],
                    $setting["option_name"],
                    (isset($setting["args"]) ? $setting["args"] : '')
                );
            }
            
            foreach($this->sections as $section) {
                // add_settings_section( string $id, string $title, callable $callback, string $page )
                add_settings_section(
                    $section["id"],
                    $section["title"],
                    (isset($section["callback"]) ? $section["callback"] : ''),
                    $section["page"]
                );
            }
            
            foreach($this->fields as $field) {
                // add_settings_field( string $id, string $title, callable $callback, string $page, string $section = 'default', array $args = array() )
                add_settings_field(
                    $field["id"],
                    $field["title"],
                    (isset($field["callback"]) ? $field["callback"] : ''),
                    $field["page"],
                    $field["section"],
                    (isset($field["args"]) ? $field["args"] : '')
                );
            }
        }
    }
}