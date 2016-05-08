<?php

class ACFPT_PostType {

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
      'label' => $name . 's',
      'description' => $settings['description'],
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

    $this->addLabels( $args, $settings );
    register_post_type( $key, $args );
  }

  public function addLabels( &$args, $settings ) {
    $labels = array();
    if( $settings['lbl_name'] ) {
      $labels['name'] = $settings['lbl_name'];
    }
    if( $settings['lbl_name'] ) {
      $labels['singular_name'] = $settings['lbl_singular_name'];
    }
    if( $settings['lbl_add_new'] ) {
      $labels['add_new'] = $settings['lbl_add_new'];
    }
    if( $settings['lbl_add_new_item'] ) {
      $labels['add_new_item'] = $settings['lbl_add_new_item'];
    }
    if( $settings['lbl_edit_item'] ) {
      $labels['edit_item'] = $settings['lbl_edit_item'];
    }
    if( $settings['lbl_new_item'] ) {
      $labels['new_item'] = $settings['lbl_new_item'];
    }
    $args['labels'] = $labels;
  }

}
