<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2012-2019 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoMetaItem' ) ) {

	class WpssoMetaItem {

		private $p;

		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			add_action( 'add_head_attributes', array( $this, 'add_head_attributes' ), -1000 );

			if ( ! empty( $this->p->options[ 'plugin_head_attr_filter_name' ] ) ) {

				$filter_name = $this->p->options[ 'plugin_head_attr_filter_name' ];
				$filter_prio = $this->p->options[ 'plugin_head_attr_filter_prio' ];

				add_filter( $filter_name, array( $this, 'filter_head_attributes' ), $filter_prio, 1 );
			}
		}

		public function add_head_attributes() {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->is_head_attributes_enabled() ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: head attributes disabled' );
				}

				return;
			}

			if ( ! empty( $this->p->options[ 'plugin_head_attr_filter_name' ] ) ) {	// Just in case.

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'calling filter ' . $this->p->options[ 'plugin_head_attr_filter_name' ] );
				}

				echo apply_filters( $this->p->options[ 'plugin_head_attr_filter_name' ], '' );

			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'plugin_head_attr_filter_name is empty' );
			}
		}

		public function filter_head_attributes( $head_attr = '' ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! $this->is_head_attributes_enabled() ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: head attributes disabled' );
				}

				return $head_attr;
			}

			$use_post = apply_filters( $this->p->lca . '_use_post', false );	// Used by woocommerce with is_shop().

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'required call to get_page_mod()' );
			}

			$mod           = $this->p->util->get_page_mod( $use_post );
			$page_type_id  = $this->p->schema->get_mod_schema_type( $mod, $get_schema_id = true );
			$page_type_url = $this->p->schema->get_schema_type_url( $page_type_id );

			if ( empty( $page_type_url ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: schema head type value is empty' );
				}

				return $head_attr;
			}

			/**
			 * Fix incorrect itemscope values
			 */
			if ( false !== strpos( $head_attr, 'itemscope="itemscope"' ) ) {
				$head_attr = preg_replace( '/ *itemscope="itemscope"/', ' itemscope', $head_attr );
			} elseif ( false === strpos( $head_attr, 'itemscope' ) ) {
				$head_attr .= ' itemscope';
			}

			/**
			 * Replace existing itemtype values.
			 */
			if ( false !== strpos( $head_attr, 'itemtype="' ) ) {
				$head_attr = preg_replace( '/ *itemtype="[^"]+"/', ' itemtype="' . $page_type_url . '"', $head_attr );
			} else {
				$head_attr .= ' itemtype="' . $page_type_url . '"';
			}

			$head_attr = trim( $head_attr );

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'returning head attributes "' . $head_attr . '"' );
			}

			return $head_attr;
		}

		public function is_head_attributes_enabled() {

			if ( empty( $this->p->options[ 'plugin_head_attr_filter_name' ] ) ||
				$this->p->options[ 'plugin_head_attr_filter_name' ] === 'none' ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'head attributes disabled for empty option name' );
				}

				return false;
			}

			if ( SucomUtil::is_amp() ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'head attributes disabled for amp endpoint' );
				}

				return false;
			}

			if ( ! apply_filters( $this->p->lca . '_add_schema_head_attributes', true ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'head attributes disabled by filters' );
				}

				return false;
			}

			return true;
		}

		public function get_array( array $mod, array $mt_og = array(), $crawler_name = false ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			/**
			 * Returns false when the wpsso-schema-json-ld add-on is active.
			 */
			if ( ! apply_filters( $this->p->lca . '_add_schema_meta_array', true ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: schema meta array disabled' );
				}

				return array();	// Empty array.
			}

			$mt_item       = array();
			$size_name     = $this->p->lca . '-schema';	// Default image size name.
			$max_nums      = $this->p->util->get_max_nums( $mod, 'schema' );
			$page_type_id  = $this->p->schema->get_mod_schema_type( $mod, $get_schema_id = true );
			$page_type_url = $this->p->schema->get_schema_type_url( $page_type_id );

			self::add_mt_item_from_assoc( $mt_item, $mt_og, array(
				'url'  => 'og:url',
				'name' => 'og:title',
			) );

			if ( ! empty( $this->p->options[ 'add_meta_itemprop_description' ] ) ) {

				$mt_item[ 'description' ] = $this->p->page->get_description( $this->p->options[ 'schema_desc_max_len' ],
					$dots = '...', $mod, $read_cache = true, $add_hashtags = false, $do_encode = true,
						$md_key = array( 'schema_desc', 'seo_desc', 'og_desc' ) );
			}

			switch ( $page_type_url ) {

				case 'https://schema.org/BlogPosting':

					$size_name = $this->p->lca . '-schema-article';	// BlogPosting is a sub-type of Article.

					// No break - add date published and modified.

				case 'https://schema.org/WebPage':

					self::add_mt_item_from_assoc( $mt_item, $mt_og, array(
						'datePublished' => 'article:published_time',
						'dateModified'  => 'article:modified_time',
					) );

					if ( empty( $this->p->options[ 'add_link_itemprop_thumbnailurl' ] ) ) {

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'skipping thumbnail: link itemprop thumbnail is disabled' );
						}

					} else {

						$mt_item[ 'thumbnailurl' ] = $this->p->og->get_thumbnail_url( $this->p->lca .
							'-thumbnail', $mod, $md_pre = 'schema' );

						if ( empty( $mt_item[ 'thumbnailurl' ] ) ) {
							unset( $mt_item[ 'thumbnailurl' ] );
						}
					}

					break;
			}

			if ( class_exists( 'WpssoNoScript' ) && WpssoNoScript::is_enabled( $crawler_name ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'skipping images: noscript is enabled for ' . $crawler_name );
				}

			} elseif ( empty( $this->p->options[ 'add_link_itemprop_image' ] ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'skipping images: meta itemprop image is disabled' );
				}

			} else {	// Add single image meta tags (no width or height).

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'getting images for ' . $page_type_url );
				}

				$og_images = $this->p->og->get_all_images( $max_nums[ 'schema_img_max' ],
					$size_name, $mod, true, $md_pre = 'schema' );

				if ( empty( $og_images ) && $mod[ 'is_post' ] ) {
					$og_images = $this->p->media->get_default_images( 1, $size_name, true );
				}

				/**
				 * WpssoHead::get_single_mt() will make sure
				 * this URL is added as a link itemprop tag and
				 * not a meta itemprop tag.
				 */
				foreach ( $og_images as $og_single_image ) {
					$mt_item[ 'image' ][] = SucomUtil::get_mt_media_url( $og_single_image );
				}
			}

			return (array) apply_filters( $this->p->lca . '_schema_meta_itemprop', $mt_item, $mod, $mt_og, $page_type_id );
		}

		public static function add_mt_item_from_assoc( array &$mt_item, array &$assoc, array $names ) {

			foreach ( $names as $prop_name => $key_name ) {
				if ( ! empty( $assoc[ $key_name ] ) && $assoc[ $key_name ] !== WPSSO_UNDEF ) {
					$mt_item[ $prop_name ] = $assoc[ $key_name ];
				}
			}
		}
	}
}
