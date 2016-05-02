<?php

/*
Plugin Name: ACF Content Type
Description: Registers content types using an ACF interface
*/

require('src/ContentType.php');
new ACF_Content_Type;

class ACF_Content_Type {

  public function __construct() {
    add_action('init', array( $this, 'addAcfContentType' ));
    add_action('init', array( $this, 'addRegisteredContentTypes' ));
  }

  public function addAcfContentType() {
    $ct = new ContentType;
    $args = array(
      'key' => 'acf_content_type',
      'name' => 'Content Type',
    );
    $ct->addContentType( $args );
  }

  public function addRegisteredContentTypes() {
    $cts = $this->getContentTypes();
    foreach( $cts as $ctPost ) {
      $this->registerContentType( $ctPost );
    }
  }

  public function registerContentType( $ctPost ) {
    $ct = new ContentType;
    $fields = get_fields( $ctPost->ID );

    $args = array(
      'key' => $fields['key'],
      'name' => $ctPost->post_title,
      'settings' => $fields,
    );

    $ct->addContentType( $args );
  }

  public function getContentTypes() {
    return get_posts( array( 'post_type' => 'acf_content_type' ));
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
