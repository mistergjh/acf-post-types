<?php

/*
  Plugin Name: ACF Post Types
  Plugin URI: http://goldhat.ca/plugins/acf-post-types/
  Description: Registers post types using an ACF interface
  Version: 1.1.0
  Author: Joel Milne, GoldHat Group
  Author URI: http://goldhat.ca
  Text Domain: acf-post-types
  License: GPLv2 or later
*/

require('src/PostType.php');
new ACF_Post_Types;

class ACF_Post_Types {

  public function __construct() {
    add_action('init', array( $this, 'includeAcfFields' ));
    add_action('init', array( $this, 'addAcfPostType' ));
    add_action('init', array( $this, 'addRegisteredPostTypes' ));
    add_action('acf/save_post', array( $this, 'afterSavePostType' ), 20);
  }

  // flush rewrite rules for new CPT
  public function afterSavePostType( $postID ) {
    if( empty($_POST['acf'])) {
      return;
    }
    flush_rewrite_rules();
  }

  public function includeAcfFields() {
    require('assets/acf/fields.php');
  }

  public function addAcfPostType() {
    $ct = new ACFPT_PostType;
    $args = array(
      'key' => 'acf_post_type',
      'name' => 'Post Type',
    );
    $ct->add( $args );
  }

  public function addRegisteredPostTypes() {
    $cts = $this->getPostTypes();
    foreach( $cts as $ctPost ) {
      $this->registerPostType( $ctPost );
    }
  }

  public function registerPostType( $ctPost ) {
    $ct = new ACFPT_PostType;
    $fields = get_fields( $ctPost->ID );
    $args = array(
      'key' => $fields['key'],
      'name' => $ctPost->post_title,
      'settings' => $fields,
    );
    $ct->add( $args );
  }

  public function getPostTypes() {
    return get_posts( array( 'post_type' => 'acf_post_type', 'posts_per_page' => 250 ));
  }

  public function unregisterPostType( $post_type ) {
    global $wp_post_types;
    if ( isset( $wp_post_types[ $post_type ] ) ) {
      unset( $wp_post_types[ $post_type ] );
      return true;
    }
    return false;
  }

}
