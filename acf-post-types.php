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
    // add_action('init', array( $this, 'includeAcfFields' ));
    add_action('init', array( $this, 'addAcfPostType' ));
    add_action('init', array( $this, 'addRegisteredPostTypes' ));
    add_action('acf/save_post', array( $this, 'afterSavePostType' ), 20);
  }

  // flush rewrite rules for new CPT
  public function afterSavePostType( $postID ) {
    if( empty($_POST['acf'])) {
      return;
    }

    $postTypeKey = get_field('key');
    if ( post_type_exists( $postTypeKey ) ) {
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

    // var_dump( $fields );

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




/*

TO DO

add remaining label options

process description during CPT register

set capabilities and test using them, they didn't work before
process list of capabilities in textarea

process permalink_epmask

process register meta callback

process taxonies textarea and use options in CPT

process supports list of checkboxes

add REST settings during register CPT
test using REST options

*/
