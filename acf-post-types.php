<?php

/*
Plugin Name: ACF Post Types
Description: Registers post types using an ACF interface
Version: 0.9.2
*/

require('src/PostType.php');
new ACF_Post_Types;

class ACF_Post_Types {

  public function __construct() {
    add_action('init', array( $this, 'includeAcfFields' ));
    add_action('init', array( $this, 'addAcfPostType' ));
    add_action('init', array( $this, 'addRegisteredPostTypes' ));
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
    $ct->addPostType( $args );
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

    $ct->addPostType( $args );
  }

  public function getPostTypes() {
    return get_posts( array( 'post_type' => 'acf_post_type' ));
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
