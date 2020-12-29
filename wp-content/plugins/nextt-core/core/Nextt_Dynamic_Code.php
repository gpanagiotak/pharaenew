<?php

/**
 * Class Theme_functions
 */
class Nextt_Dynamic_Code{

    private $header_tags_array = array();


    function __construct(){
        add_action('admin_init', array($this, 'addSettingsFields'));
    }

    function addSettingsFields(){

        add_settings_section( 'nextt_dynamic_code', 'Nextt Dynamic Code Section' , array($this, 'nextt_dynamic_head_section_cb'), 'general' );
        add_settings_field( 'enable_nextt_dynamic_css', 'Enable Style Tag', array($this, 'enable_nextt_dynamic_css_cb'), 'general', 'nextt_dynamic_code' );
        add_settings_field( 'nextt_dynamic_css', 'Dynamic Head Style Tag', array($this, 'nextt_dynamic_css_cb'), 'general', 'nextt_dynamic_code' );
        add_settings_field( 'enable_nextt_dynamic_js', 'Enable Head Script Tag', array($this, 'enable_nextt_dynamic_js_cb'), 'general', 'nextt_dynamic_code' );
        add_settings_field( 'nextt_dynamic_js', 'Dynamic Head Script Tag', array($this, 'nextt_dynamic_js_cb'), 'general', 'nextt_dynamic_code' );
        add_settings_field( 'enable_nextt_dynamic_footer_js', 'Enable Footer Script Tag', array($this, 'enable_nextt_dynamic_js_footer_cb'), 'general', 'nextt_dynamic_code' );
        add_settings_field( 'nextt_dynamic_footer_js', 'Dynamic Footer Script Tag', array($this, 'nextt_dynamic_js_footer_cb'), 'general', 'nextt_dynamic_code' );
        register_setting( 'general', 'enable_nextt_dynamic_css' );
        register_setting( 'general', 'nextt_dynamic_css' );
        register_setting( 'general', 'enable_nextt_dynamic_js' );
        register_setting( 'general', 'nextt_dynamic_js' );
        register_setting( 'general', 'enable_nextt_dynamic_footer_js' );
        register_setting( 'general', 'nextt_dynamic_footer_js' );
    }


    function nextt_dynamic_css_cb() {
        echo "<textarea id='nextt_dynamic_css' name='nextt_dynamic_css' rows='10' cols='100' type='textarea'>".get_option('nextt_dynamic_css')."</textarea>";    

    }

    function nextt_dynamic_js_cb() {
        echo "<textarea id='nextt_dynamic_js' name='nextt_dynamic_js' rows='10' cols='100' type='textarea'>".get_option('nextt_dynamic_js')."</textarea>";    
    }

    function nextt_dynamic_js_footer_cb() {
        echo "<textarea id='nextt_dynamic_footer_js' name='nextt_dynamic_footer_js' rows='10' cols='100' type='textarea'>".get_option('nextt_dynamic_footer_js')."</textarea>";    
    }

    function enable_nextt_dynamic_css_cb() {
        echo '<input name="enable_nextt_dynamic_css" id="enable_nextt_dynamic_css" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'enable_nextt_dynamic_css' ), false ) . ' />';
    }

    function enable_nextt_dynamic_js_cb() {
        echo '<input name="enable_nextt_dynamic_js" id="enable_nextt_dynamic_js" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'enable_nextt_dynamic_js' ), false ) . ' />';

    }

    function enable_nextt_dynamic_js_footer_cb() {
        echo '<input name="enable_nextt_dynamic_footer_js" id="enable_nextt_dynamic_footer_js" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'enable_nextt_dynamic_footer_js' ), false ) . ' />';

    }

    function nextt_dynamic_head_section_cb() {
        echo '<p class="nextt_dynamic_code">Nextt Core\'s implentation of dynamic code insertion.</p>';
    }



}