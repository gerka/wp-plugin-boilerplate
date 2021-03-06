<?php
/**
 *	@package {{plugin_namespace}}\Taxonomy
 *	@version 1.0.0
 *	2018-09-22
 */

namespace {{plugin_namespace}}\Taxonomy;

if ( ! defined('ABSPATH') ) {
	die('FU!');
}


use {{plugin_namespace}}\Core;

abstract class Taxonomy extends Core\PluginComponent {

	protected $taxonomy_slug;

	abstract function register_taxonomy();



	/**
	 *	Register Posttype for Taxonomy
	 *
	 *	@param PostType $post_type
	 *	@return Taxonomy
	 */
	public function add_post_type( PostType\PostType $post_type ) {
		register_taxonomy_for_object_type( $this->get_slug(), $post_type->get_slug() );
		return $this;
	}

	/**
	 *	@return string
	 */
	public function get_slug() {
		return $this->taxonomy_slug;
	}

	/**
	 *	@inheritdoc
	 */
	public function activate() {
		// register post types, taxonomies
		$this->register_taxonomy();

		// flush rewrite rules
		flush_rewrite_rules();

		return array(
			'success'	=> true,
			'messages'	=> array(),
		);
	}

	/**
	 *	@inheritdoc
	 */
	public function deactivate() {

		// flush rewrite rules
		flush_rewrite_rules();

		return array(
			'success'	=> true,
			'messages'	=> array(),
		);
	}

	/**
	 *	@inheritdoc
	 */
	public static function uninstall() {

		$deleted_terms = 0;

		$terms = get_terms( array(
			'taxonomy' 		=> $this->taxonomy_slug,
			'hide_empty'	=> false,
		));

		foreach ( $terms as $term ) {

			wp_delete_term( $term->term_id, $this->taxonomy_slug );

			$deleted_terms ++;

		}


		return array(
			'success'	=> true,
			'messages'	=> array(
				sprintf( _n( 'Deleted %d Term',  'Deleted %d Terms', $deleted_terms, '{{plugin_slug}}' ), $deleted_terms ),
			),
		);
	}

	/**
	 *	@inheritdoc
	 */
	public function upgrade( $new_version, $old_version ) {

		return array(
			'success'	=> true,
			'messages'	=> array(),
		);

	}


}
