<?php

class PostType {

  public function __construct() {

  }

  public function addPostType( $args ) {
    $settings = $args['settings'];
    $key = $args['key'];
    $name = $args['name'];
    if ( post_type_exists( $key ) ) {
      return;
    }
    $args = array(
      'label' => $name,
      'description' => $settings['description'],
      'labels' => array(

      ),
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_ui' => true,
      'show_in_nav_menus' => true,
      'show_in_menu' => true,
      'show_in_admin_bar' => true,
      'menu_position' => 80,
      'menu_icon' => 'dashicons-video-alt',
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

    register_post_type( $key, $args );
  }

}
