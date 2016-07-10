<?php

class ACFPT_PostType {

  public $key;
  public $name;
  public $args;
  public $settings;

  public function __construct() {
    $this->args = array(
      'description' => $this->settings['description'],
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_ui' => true,
      'show_in_nav_menus' => true,
      'show_in_menu' => true,
      'show_in_admin_bar' => true,
      'menu_position' => 80,
      'menu_icon' => 'dashicons-admin-tools',
      // 'capability_type' => 'post',
      // 'capabilities' => array(),
      // 'map_meta_cap' => false,
      'hierarchical' => false,
      'supports' => array('title', 'editor'),
      'register_meta_box_cb' => '',
      'taxonomies' => array(),
      'has_archive' => true,
      'permalink_epmask' => '',
      'rewrite' => true,
      'query_var' => true,
      'can_export' => true,
      'show_in_rest' => false,
      'rest_base' => '',
      'rest_controller_class' => '',
    );
  }

  public function addPostType( $args ) {

    //var_dump($args);

    if ( post_type_exists( $args['key'] ) ) {
      return;
    }

    $this->settings = $args['settings'];
    $this->key = $args['key'];
    $this->name = $args['name'];

    // set main display label
    $this->args['label'] = $this->name;

    $this->setLabels();
    //$this->setBooleanOptions();
    register_post_type( $this->key, $this->args );
  }

  public function setBooleanOptions() {
    $this->setBooleanOption( 'public' );
    $this->setBooleanOption( 'publicly_queryable' );
    $this->setBooleanOption( 'exclude_from_search' );
    $this->setBooleanOption( 'show_ui' );
    $this->setBooleanOption( 'show_in_nav_menus' );
    $this->setBooleanOption( 'show_in_menu' );
    $this->setBooleanOption( 'show_in_admin_bar' );
    $this->setBooleanOption( 'hierarchical' );
    $this->setBooleanOption( 'has_archive' );
    $this->setBooleanOption( 'rewrite' );
    $this->setBooleanOption( 'query_var' );
    $this->setBooleanOption( 'can_export' );
    $this->setBooleanOption( 'show_in_rest' );
  }

  public function setBooleanOption( $option ) {
    if( $this->settings[ $option ] ) {
      $this->args[ $option ] = true;
    } else {
      $this->args[ $option ] = false;
    }
  }

  public function setLabels() {
    $labels = array();
    if( $this->settings['lbl_name'] ) {
      $labels['name'] = $this->settings['lbl_name'];
    }
    if( $this->settings['lbl_name'] ) {
      $labels['singular_name'] = $this->settings['lbl_singular_name'];
    }
    if( $this->settings['lbl_add_new'] ) {
      $labels['add_new'] = $this->settings['lbl_add_new'];
    }
    if( $this->settings['lbl_add_new_item'] ) {
      $labels['add_new_item'] = $this->settings['lbl_add_new_item'];
    }
    if( $this->settings['lbl_edit_item'] ) {
      $labels['edit_item'] = $this->settings['lbl_edit_item'];
    }
    if( $this->settings['lbl_new_item'] ) {
      $labels['new_item'] = $this->settings['lbl_new_item'];
    }
    $this->args['labels'] = $labels;
  }

}
