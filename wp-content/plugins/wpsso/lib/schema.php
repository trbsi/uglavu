<?php
/**
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2012-2019 Jean-Sebastien Morisset (https://wpsso.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoSchemaCache' ) ) {
	require_once WPSSO_PLUGINDIR . 'lib/schema-cache.php';
}

if ( ! class_exists( 'WpssoSchemaGraph' ) ) {
	require_once WPSSO_PLUGINDIR . 'lib/schema-graph.php';
}

if ( ! class_exists( 'WpssoSchemaSingle' ) ) {
	require_once WPSSO_PLUGINDIR . 'lib/schema-single.php';
}

if ( ! class_exists( 'WpssoSchema' ) ) {

	class WpssoSchema {

		protected $p;

		protected $types_cache = null;		// Schema types array cache.

		protected static $units_cache = null;	// Schema unicodes array cache.

		public function __construct( &$plugin ) {

			$this->p =& $plugin;

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$this->p->util->add_plugin_filters( $this, array( 
				'plugin_image_sizes' => 1,
			), $prio = 5 );
		}

		public function filter_plugin_image_sizes( $sizes ) {

			$sizes[ 'schema_img' ] = array(		// Options prefix.
				'name'  => 'schema',
				'label' => _x( 'Schema Image', 'image size label', 'wpsso' ),
			);

			$sizes[ 'schema_article_img' ] = array(	// Options prefix.
				'name'   => 'schema-article',
				'label'  => _x( 'Schema Article Image', 'image size label', 'wpsso' ),
				'md_pre' => 'schema_img',
			);

			return $sizes;
		}

		/**
		 * https://schema.org/WebSite for Google
		 */
		public function filter_json_data_https_schema_org_website( $json_data, $mod, $mt_og, $page_type_id, $is_main ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$ret = self::get_schema_type_context( 'https://schema.org/WebSite', array(
				'url' => $mt_og[ 'og:url' ],
			) );

			foreach ( array(
				'name'          => SucomUtil::get_site_name( $this->p->options, $mod ),
				'alternateName' => SucomUtil::get_site_name_alt( $this->p->options, $mod ),
				'description'   => SucomUtil::get_site_description( $this->p->options, $mod ),
			) as $key => $value ) {
				if ( ! empty( $value ) ) {
					$ret[ $key ] = $value;
				}
			}

			/**
			 * Potential Action (SearchAction, OrderAction, etc.)
			 *
			 * The 'wpsso_json_prop_https_schema_org_potentialaction' filter may already
			 * be applied by the WPSSO JSON add-on, so do not re-apply it here.
			 *
			 * Hook the 'wpsso_json_ld_search_url' filter and return false if you wish to
			 * disable / skip the Potential Action property.
			 */
			$search_url = SucomUtil::esc_url_encode( get_bloginfo( 'url' ) ) . '?s={search_term_string}';
			$search_url = apply_filters( $this->p->lca . '_json_ld_search_url', $search_url );

			if ( ! empty( $search_url ) ) {

				/**
				 * Potential Action may already be defined by the WPSSO JSON
				 * 'wpsso_json_prop_https_schema_org_potentialaction' filter.
				 * Make sure it's an array - just in case. ;-)
				 */
				if ( ! isset( $ret[ 'potentialAction' ] ) || ! is_array( $ret[ 'potentialAction' ] ) ) {
					$ret[ 'potentialAction' ] = array();
				}

				$ret[ 'potentialAction' ][] = array(
					'@context'    => 'https://schema.org',
					'@type'       => 'SearchAction',
					'target'      => $search_url,
					'query-input' => 'required name=search_term_string',
				);

			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'skipping search action: search url is empty' );
			}

			return self::return_data_from_filter( $json_data, $ret, $is_main );
		}

		/**
		 * https://schema.org/Organization social markup for Google
		 */
		public function filter_json_data_https_schema_org_organization( $json_data, $mod, $mt_og, $page_type_id, $is_main ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! empty( $mod[ 'obj' ] ) ) {	// Just in case.

				/**
				 * Fallback to default organization ID of 'none'.
				 */
				$org_id = $mod[ 'obj' ]->get_options( $mod[ 'id' ], 'schema_organization_org_id',
					$filter_opts = true, $def_fallback = true );

			} else {
				$org_id = null;
			}

			if ( null === $org_id ) {
				if ( $mod[ 'is_home' ] ) {	// Static or index page.
					$org_id = 'site';
				} else {
					$org_id = 'none';
				}
			}

			if ( $org_id === 'none' ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: organization id is none' );
				}

				return $json_data;
			}

			/**
			 * Possibly inherit the schema type.
			 */
			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'possibly inherit the schema type' );
				$this->p->debug->log_arr( '$json_data', $json_data );
			}

			$ret = self::get_data_context( $json_data );	// Returns array() if no schema type found.

		 	/**
			 * $org_id can be 'none', 'site', or a number (including 0).
		 	 * $logo_key can be 'org_logo_url' or 'org_banner_url' (600x60px image) for Articles.
			 * Do not provide localized option names - the method will fetch the localized values.
			 */
			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'adding data for organization id = ' . $org_id );
			}

			WpssoSchemaSingle::add_organization_data( $ret, $mod, $org_id, 'org_logo_url', false );	// $list_element is false.

			return self::return_data_from_filter( $json_data, $ret, $is_main );
		}

		/**
		 * https://schema.org/LocalBusiness social markup for Google
		 */
		public function filter_json_data_https_schema_org_localbusiness( $json_data, $mod, $mt_og, $page_type_id, $is_main ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark( 'organization filter for local business' );	// Begin timer.
			}

			/**
			 * All local businesses are also organizations.
			 */
			$ret = $this->filter_json_data_https_schema_org_organization( $json_data, $mod, $mt_og, $page_type_id, $is_main );

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark( 'organization filter for local business' );	// End timer.
			}

			self::organization_to_localbusiness( $ret );

			return self::return_data_from_filter( $json_data, $ret, $is_main );
		}

		/**
		 * https://schema.org/Person social markup for Google
		 */
		public function filter_json_data_https_schema_org_person( $json_data, $mod, $mt_og, $page_type_id, $is_main ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! empty( $mod[ 'obj' ] ) ) {	// Just in case.

				/**
				 * Fallback to default person ID of 'none'.
				 */
				$user_id = $mod[ 'obj' ]->get_options( $mod[ 'id' ], 'schema_person_id',
					$filter_opts = true, $def_fallback = true );

			} else {
				$user_id = null;
			}

			if ( null === $user_id ) {

				if ( $mod[ 'is_home' ] ) {	// Static or index page.

					if ( empty( $this->p->options[ 'schema_home_person_id' ] ) ) {

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'exiting early: schema_home_person_id disabled for home page' );
						}

						return $json_data;	// Exit early.

					} else {

						$user_id = $this->p->options[ 'schema_home_person_id' ];

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'person / user_id for home page is ' . $user_id );
						}
					}

				} elseif ( $mod[ 'is_user' ] ) {

					$user_id = $mod[ 'id' ];
				} else {
					$user_id = false;
				}
			}

			if ( empty( $user_id ) || $user_id === 'none' ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: empty user_id' );
				}

				return $json_data;

			} else {
				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'user id is "' . $user_id . '"' );
				}
			}

			/**
			 * Possibly inherit the schema type.
			 */
			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'possibly inherit the schema type' );
				$this->p->debug->log_arr( '$json_data', $json_data );
			}

			$ret = self::get_data_context( $json_data );	// Returns array() if no schema type found.

		 	/**
			 * $user_id can be 'none' or a number (including 0).
			 */
			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'adding data for person id = ' . $user_id );
			}

			WpssoSchemaSingle::add_person_data( $ret, $mod, $user_id, $list_element = false );

			/**
			 * Override author's website url and use the og url instead.
			 */
			if ( $mod[ 'is_home' ] ) {
				$ret[ 'url' ] = $mt_og[ 'og:url' ];
			}

			return self::return_data_from_filter( $json_data, $ret, $is_main );
		}

		public function has_json_data_filter( array &$mod, $type_url = '' ) {

			$filter_name = $this->get_json_data_filter( $mod, $type_url );

			return ! empty( $filter_name ) && has_filter( $filter_name ) ? true : false;
		}

		public function get_json_data_filter( array &$mod, $type_url = '' ) {

			if ( empty( $type_url ) ) {
				$type_url = $this->get_mod_schema_type( $mod );
			}

			return $this->p->lca . '_json_data_' . SucomUtil::sanitize_hookname( $type_url );
		}

		/**
		 * Schema json scripts.
		 *
		 * $mt_og must be passed by reference to assign the schema:type internal meta tags.
		 */
		public function get_array( array &$mod, array &$mt_og, $crawler_name ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark( 'build json array' );	// Begin timer for json array.
			}

			$page_type_id  = $mt_og[ 'schema:type:id' ]  = $this->get_mod_schema_type( $mod, $get_schema_id = true );	// Example: article.tech.
			$page_type_url = $mt_og[ 'schema:type:url' ] = $this->get_schema_type_url( $page_type_id );	// Example: https://schema.org/TechArticle.
			$graph_context = 'https://schema.org';
			$graph_type    = 'graph';
			$json_scripts  = array();

			list(
				$mt_og[ 'schema:type:context' ],
				$mt_og[ 'schema:type:name' ],
			) = self::get_schema_type_parts( $page_type_url );		// Example: https://schema.org, TechArticle.

			$page_type_ids    = array();
			$page_type_added  = array();	// Prevent duplicate schema types.
			$site_org_type_id = false;	// Just in case.

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'head schema type id is ' . $page_type_id . ' (' . $page_type_url . ')' );
			}

			/**
			 * Include WebSite, Organization and/or Person markup on the home page.
			 * Note that the custom 'site_org_schema_type' may be a sub-type of
			 * organization, and may be filtered as a local.business.
			 */
			if ( $mod[ 'is_home' ] ) {	// Static or index home page.

				$site_org_type_id = $this->p->options[ 'site_org_schema_type' ];	// Organization or a sub-type of organization.

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'organization schema type id is ' . $site_org_type_id );
				}

				$page_type_ids[ 'website' ] = isset( $this->p->options[ 'schema_add_home_website' ] ) ?
					$this->p->options[ 'schema_add_home_website' ] : 1;

				$page_type_ids[ $site_org_type_id ] = isset( $this->p->options[ 'schema_add_home_organization' ] ) ?
					$this->p->options[ 'schema_add_home_organization' ] : 1;

				$page_type_ids[ 'person' ] = isset( $this->p->options[ 'schema_add_home_person' ] ) ?
					$this->p->options[ 'schema_add_home_person' ] : 0;
			}

			/**
			 * Could be an organization, website, or person, so include last to 
			 * re-enable (if disabled by default).
			 */
			if ( ! empty( $page_type_url ) ) {
				$page_type_ids[ $page_type_id ] = true;
			}

			/**
			 * Array (
			 *	[product] => true
			 *	[website] => true
			 *	[organization] => true
			 *	[person] => false
			 * )
			 */
			$page_type_ids = apply_filters( $this->p->lca . '_json_array_schema_page_type_ids', $page_type_ids, $mod );

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log_arr( 'page_type_ids', $page_type_ids );
			}

			foreach ( $page_type_ids as $type_id => $is_enabled ) {

				if ( ! $is_enabled ) {

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'skipping schema type id "' . $type_id . '" (disabled)' );
					}

					continue;

				} elseif ( ! empty( $page_type_added[ $type_id ] ) ) {	// Prevent duplicate schema types.

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'skipping schema type id "' . $type_id . '" (previously added)' );
					}

					continue;

				} else {
					$page_type_added[ $type_id ] = true;	// Prevent adding duplicate schema types.
				}

				if ( $this->p->debug->enabled ) {
					$this->p->debug->mark( 'schema type id ' . $type_id );	// Begin timer.
				}

				if ( $type_id === $page_type_id ) {	// This is the main entity.
					$is_main = true;
				} else {
					$is_main = false;	// Default for all other types.
				}

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'schema main entity is ' . ( $is_main ? 'true' : 'false' ) . ' for ' . $type_id );
				}

				$json_data = $this->get_json_data( $mod, $mt_og, $type_id, $is_main );

				/**
				 * The $json_data array will almost always be a single associative array,
				 * but the breadcrumblist filter may return an array of $json_data arrays.
				 */
				if ( isset( $json_data[ 0 ] ) && ! SucomUtil::is_assoc( $json_data ) ) {	// Multiple json arrays returned.

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'multiple json data arrays returned' );
					}

					$scripts_data = $json_data;

				} else {

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'single json data array returned' );
					}

					$scripts_data = array( $json_data );	// Single json script returned.
				}

				/**
				 * Add the json data to the @graph array.
				 */
				foreach ( $scripts_data as $json_data ) {

					if ( empty( $json_data ) || ! is_array( $json_data ) ) {	// Just in case.
						continue;
					}

					if ( empty( $json_data[ '@type' ] ) ) {

						$type_url  = $this->get_schema_type_url( $type_id );
						$json_data = self::get_schema_type_context( $type_url, $json_data );

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'added @type property is ' . $json_data[ '@type' ] );
						}

					} elseif ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'existing @type property is ' . print_r( $json_data[ '@type' ], true ) );	// @type can be an array.
					}

					WpssoSchemaGraph::add( $json_data );
				}

				if ( $this->p->debug->enabled ) {
					$this->p->debug->mark( 'schema type id ' . $type_id );	// End timer.
				}
			}

			$filter_name = $this->p->lca . '_json_prop_' . SucomUtil::sanitize_hookname( $graph_context . '/' . $graph_type );

			$graph_data = WpssoSchemaGraph::get( $graph_context );

			$graph_data = apply_filters( $filter_name, $graph_data, $mod, $mt_og, $page_type_id, $is_main );

			if ( ! empty( $graph_data[ '@graph' ] ) ) {	// Just in case.

				$graph_data = WpssoSchemaGraph::optimize( $graph_data );

				$json_scripts[][] = '<script type="application/ld+json">' .
					$this->p->util->json_format( $graph_data ) . '</script>' . "\n";
			}

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark( 'build json array' );	// End timer for json array.
			}

			return $json_scripts;
		}

		/**
		 * Get the JSON-LD data array.
		 */
		public function get_json_data( array &$mod, array &$mt_og, $page_type_id = false, $is_main = false, $use_cache = true ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( empty( $page_type_id ) ) {
				$page_type_id = $this->get_mod_schema_type( $mod, $get_schema_id = true );
			}

			$json_data         = null;
			$page_type_url     = $this->get_schema_type_url( $page_type_id );
			$filter_name       = SucomUtil::sanitize_hookname( $page_type_url );
			$child_family_urls = array();

			/**
			 * Returns an array of type ids with gparents, parents, child (in that order).
			 */
			foreach ( $this->get_schema_type_child_family( $page_type_id ) as $type_id ) {
				$child_family_urls[] = $this->get_schema_type_url( $type_id );
			}

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log_arr( 'page_type_id ' . $page_type_id . ' child_family_urls', $child_family_urls );
			}

			foreach ( $child_family_urls as $type_url ) {

				$type_filter_name = SucomUtil::sanitize_hookname( $type_url );
				$has_type_filter  = has_filter( $this->p->lca . '_json_data_' . $type_filter_name );	// Check only once.

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'type filter name is ' . $type_filter_name . ' and has filter is ' . 
						( $has_type_filter ? 'true' : 'false' ) );
				}

				/**
				 * Add website, organization, and person markup to home page.
				 */
				if ( $mod[ 'is_home' ] && ! $has_type_filter && method_exists( __CLASS__, 'filter_json_data_' . $type_filter_name ) ) {

					$json_data = call_user_func( array( __CLASS__, 'filter_json_data_' . $type_filter_name ),
						$json_data, $mod, $mt_og, $page_type_id, false );	// $is_main is always false for method.

				} elseif ( $has_type_filter ) {

					$json_data = apply_filters( $this->p->lca . '_json_data_' . $type_filter_name,
						$json_data, $mod, $mt_og, $page_type_id, $is_main );

				} else {

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'no filters registered for ' . $type_filter_name );
					}
				}
			}

			if ( isset( $json_data[ 0 ] ) && ! SucomUtil::is_assoc( $json_data ) ) {	// Multiple json arrays returned.

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'multiple json data arrays returned' );
				}

			} else {
				self::update_data_id( $json_data, $page_type_id );
			}

			return $json_data;
		}

		/**
		 * Return the schema type URL by default. Use $get_schema_id = true to return the schema type ID instead.
		 */
		public function get_mod_schema_type( array $mod, $get_schema_id = false, $use_mod_opts = true ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			static $local_cache = array();	// Cache for single page load.

			/**
			 * Optimize and cache post/term/user schema type values.
			 */
			if ( ! empty( $mod[ 'name' ] ) && ! empty( $mod[ 'id' ] ) ) {

				if ( isset( $local_cache[ $mod[ 'name' ] ][ $mod[ 'id' ] ][ $get_schema_id ][ $use_mod_opts ] ) ) {

					$value =& $local_cache[ $mod[ 'name' ] ][ $mod[ 'id' ] ][ $get_schema_id ][ $use_mod_opts ];

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'returning local cache value "' . $value . '"' );
					}

					return $value;

				} elseif ( is_object( $mod[ 'obj' ] ) && $use_mod_opts ) {	// Check for a column schema_type value in wp_cache.

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'checking for value from column wp_cache' );
					}

					$value = $mod[ 'obj' ]->get_column_wp_cache( $mod, $this->p->lca . '_schema_type' );	// Returns empty string if no value found.

					if ( ! empty( $value ) ) {

						if ( ! $get_schema_id && $value !== 'none' ) {	// Return the schema type url instead.

							$schema_types = $this->get_schema_types_array( $flatten = true );

							if ( ! empty( $schema_types[ $value ] ) ) {

								$value = $schema_types[ $value ];

							} else {

								if ( $this->p->debug->enabled ) {
									$this->p->debug->log( 'columns wp_cache value "' . $value . '" not in schema types' );
								}

								$value = '';
							}
						}

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'returning column wp_cache value "' . $value . '"' );
						}

						return $local_cache[ $mod[ 'name' ] ][ $mod[ 'id' ] ][ $get_schema_id ][ $use_mod_opts ] = $value;
					}
				}

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'no value found in local cache or column wp_cache' );
				}

			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'skipping cache check: mod name and/or id value is empty' );
			}

			$default_key  = apply_filters( $this->p->lca . '_schema_type_for_default', 'webpage', $mod );
			$schema_types = $this->get_schema_types_array( $flatten = true );
			$type_id      = null;

			/**
			 * Get custom schema type from post, term, or user meta.
			 */
			if ( $use_mod_opts ) {

				if ( ! empty( $mod[ 'obj' ] ) ) {	// Just in case.

					$type_id = $mod[ 'obj' ]->get_options( $mod[ 'id' ], 'schema_type' );	// Returns null if an index key is not found.

					if ( empty( $type_id ) ) {	// Must be a non-empty string.

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'custom type id from meta is empty' );
						}

					} elseif ( $type_id === 'none' ) {

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'custom type id is disabled with value none' );
						}

					} elseif ( empty( $schema_types[ $type_id ] ) ) {

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'custom type id "' . $type_id . '" not in schema types' );
						}

						$type_id = null;

					} elseif ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'custom type id "' . $type_id . '" from ' . $mod[ 'name' ] . ' meta' );
					}

				} elseif ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'skipping custom type id - mod object is empty' );
				}

			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'skipping custom type id - use_mod_opts is false' );
			}

			if ( empty( $type_id ) ) {
				$is_custom = false;
			} else {
				$is_custom = true;
			}

			if ( empty( $type_id ) ) {	// If no custom schema type, then use the default settings.

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'using plugin settings to determine schema type' );
				}

				if ( $mod[ 'is_home' ] ) {	// Static or index page.

					if ( $mod[ 'is_home_page' ] ) {

						$type_id = apply_filters( $this->p->lca . '_schema_type_for_home_page',
							$this->get_schema_type_id_for_name( 'home_page' ), $mod );

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'using schema type id "' . $type_id . '" for home page' );
						}

					} else {

						$type_id = apply_filters( $this->p->lca . '_schema_type_for_home_index',
							$this->get_schema_type_id_for_name( 'home_index' ), $mod );

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'using schema type id "' . $type_id . '" for home index' );
						}
					}

				} elseif ( $mod[ 'is_post' ] ) {

					if ( ! empty( $mod[ 'post_type' ] ) ) {

						if ( $mod[ 'is_post_type_archive' ] ) {

							$type_id = apply_filters( $this->p->lca . '_schema_type_for_post_type_archive_page',
								$this->get_schema_type_id_for_name( 'post_archive' ), $mod );

							if ( $this->p->debug->enabled ) {
								$this->p->debug->log( 'using schema type id "' . $type_id . '" for post_type_archive page' );
							}

						} elseif ( isset( $this->p->options[ 'schema_type_for_' . $mod[ 'post_type' ] ] ) ) {

							$type_id = $this->get_schema_type_id_for_name( $mod[ 'post_type' ] );

							if ( $this->p->debug->enabled ) {
								$this->p->debug->log( 'using schema type id "' . $type_id . '" from post type option value' );
							}

						} elseif ( ! empty( $schema_types[ $mod[ 'post_type' ] ] ) ) {

							$type_id = $mod[ 'post_type' ];

							if ( $this->p->debug->enabled ) {
								$this->p->debug->log( 'using schema type id "' . $type_id . '" from post type name' );
							}

						} else {	// Unknown post type.

							$type_id = apply_filters( $this->p->lca . '_schema_type_for_post_type_unknown_type', 
								$this->get_schema_type_id_for_name( 'page' ), $mod );

							if ( $this->p->debug->enabled ) {
								$this->p->debug->log( 'using "page" schema type for unknown post type ' . $mod[ 'post_type' ] );
							}
						}

					} else {	// Post objects without a post_type property.

						$type_id = apply_filters( $this->p->lca . '_schema_type_for_post_type_empty_type', 
							$this->get_schema_type_id_for_name( 'page' ), $mod );

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'using "page" schema type for empty post type' );
						}
					}

				} elseif ( $mod[ 'is_term' ] ) {

					if ( ! empty( $mod[ 'tax_slug' ] ) ) {

						$type_id = $this->get_schema_type_id_for_name( 'tax_' . $mod[ 'tax_slug' ] );

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'using schema type id "' . $type_id . '" from term option value' );
						}
					}

					if ( empty( $type_id ) ) {	// Just in case.
						$type_id = $this->get_schema_type_id_for_name( 'archive_page' );
					}

				} elseif ( $mod[ 'is_user' ] ) {

					$type_id = $this->get_schema_type_id_for_name( 'user_page' );

				} elseif ( SucomUtil::is_archive_page() ) {	// Just in case.

					$type_id = $this->get_schema_type_id_for_name( 'archive_page' );

				} elseif ( is_search() ) {

					$type_id = $this->get_schema_type_id_for_name( 'search_page' );

				} else {	// Everything else.

					$type_id = $default_key;

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'using default schema type id "' . $default_key . '"' );
					}
				}
			}

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'schema type id before filter is "' . $type_id . '"' );
			}

			$type_id = apply_filters( $this->p->lca . '_schema_type_id', $type_id, $mod, $is_custom );

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'schema type id after filter is "' . $type_id . '"' );
			}

			$get_value = false;

			if ( empty( $type_id ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'returning false: schema type id is empty' );
				}

			} elseif ( $type_id === 'none' ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'returning false: schema type id is disabled' );
				}

			} elseif ( ! isset( $schema_types[ $type_id ] ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'returning false: schema type id "' . $type_id . '" is unknown' );
				}

			} elseif ( ! $get_schema_id ) {	// False by default.

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'returning schema type url "' . $schema_types[ $type_id ] . '"' );
				}

				$get_value = $schema_types[ $type_id ];

			} else {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'returning schema type id "' . $type_id . '"' );
				}

				$get_value = $type_id;
			}

			/**
			 * Optimize and cache post/term/user schema type values.
			 */
			if ( ! empty( $mod[ 'name' ] ) && ! empty( $mod[ 'id' ] ) ) {
				$local_cache[ $mod[ 'name' ] ][ $mod[ 'id' ] ][ $get_schema_id ][ $use_mod_opts ] = $get_value;
			}

			return $get_value;
		}

		public function get_schema_types_select( $schema_types = null, $add_none = true ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( ! is_array( $schema_types ) ) {
				$schema_types = $this->get_schema_types_array( $flatten = false );
			}

			$schema_types = SucomUtil::array_flatten( $schema_types );

			$select = array();

			foreach ( $schema_types as $type_id => $type_url ) {

				$type_url = preg_replace( '/^.*\/\//', '', $type_url );

				$select[ $type_id ] = $type_id . ' | ' . $type_url;
			}

			if ( defined( 'SORT_STRING' ) ) {	// Just in case.
				asort( $select, SORT_STRING );
			} else {
				asort( $select );
			}

			if ( $add_none ) {
				return array_merge( array( 'none' => '[None]' ), $select );
			} else {
				return $select;
			}
		}

		/**
		 * By default, returns a one-dimensional (flat) array of schema types, otherwise returns a 
		 * multi-dimensional array of all schema types, including cross-references for sub-types with 
		 * multiple parent types.
		 *
		 * $read_cache is false when called from the WpssoOptionsUpgrade::options() method.
		 */
		public function get_schema_types_array( $flatten = true, $read_cache = true ) {

			if ( false === $read_cache ) {
				$this->types_cache[ 'filtered' ]  = null;
				$this->types_cache[ 'flattened' ] = null;
			}

			if ( ! isset( $this->types_cache[ 'filtered' ] ) ) {

				$cache_md5_pre  = $this->p->lca . '_t_';
				$cache_exp_secs = $this->get_types_cache_exp();

				if ( $cache_exp_secs > 0 ) {

					$cache_salt = __METHOD__;
					$cache_id   = $cache_md5_pre . md5( $cache_salt );

					if ( false === $read_cache ) {

						$this->types_cache = get_transient( $cache_id );	// Returns false when not found.

						if ( ! empty( $this->types_cache ) ) {
							if ( $this->p->debug->enabled ) {
								$this->p->debug->log( 'using schema types array from transient ' . $cache_id );
							}
						}
					}
				}

				if ( ! isset( $this->types_cache[ 'filtered' ] ) ) {	// Maybe from transient cache - re-check if filtered.

					if ( $this->p->debug->enabled ) {
						$this->p->debug->mark( 'create schema types array' );	// Begin timer.
					}

					if ( $this->p->debug->enabled ) {
						$this->p->debug->mark( 'filtering schema type array' );
					}

					$this->types_cache[ 'filtered' ] = (array) apply_filters( $this->p->lca . '_schema_types',
						$this->p->cf[ 'head' ][ 'schema_type' ] );

					if ( $this->p->debug->enabled ) {
						$this->p->debug->mark( 'creating tangible flat array' );
					}

					$this->types_cache[ 'flattened' ] = SucomUtil::array_flatten( $this->types_cache[ 'filtered' ] );

					ksort( $this->types_cache[ 'flattened' ] );

					if ( $this->p->debug->enabled ) {
						$this->p->debug->mark( 'creating parent index array' );
					}

					$this->types_cache[ 'parents' ] = SucomUtil::array_parent_index( $this->types_cache[ 'filtered' ] );

					ksort( $this->types_cache[ 'parents' ] );

					/**
					 * Add cross-references at the end to avoid duplicate parent index key errors.
					 */
					if ( $this->p->debug->enabled ) {
						$this->p->debug->mark( 'adding cross-references' );
					}

					$this->add_schema_type_xrefs( $this->types_cache[ 'filtered' ] );

					if ( $cache_exp_secs > 0 ) {

						set_transient( $cache_id, $this->types_cache, $cache_exp_secs );

						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'schema types array saved to transient cache for ' . $cache_exp_secs . ' seconds' );
						}
					}

					if ( $this->p->debug->enabled ) {
						$this->p->debug->mark( 'create schema types array' );	// End timer.
					}

				} elseif ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'schema types array already filtered' );
				}
			}

			if ( $flatten ) {
				return $this->types_cache[ 'flattened' ];
			} else {
				return $this->types_cache[ 'filtered' ];
			}
		}

		/**
		 * Add array cross-references for schema sub-types that exist under more than one type.
		 *
		 * For example, Thing > Place > LocalBusiness also exists under Thing > Organization > LocalBusiness.
		 */
		protected function add_schema_type_xrefs( &$schema_types ) {

			$thing =& $schema_types[ 'thing' ];	// Quick ref variable for the 'thing' array.

			/**
			 * Intangible > Audience
			 */
			$thing[ 'intangible' ][ 'audience' ][ 'audience.medical' ] =&
				$thing[ 'intangible' ][ 'enumeration' ][ 'medical.enumeration' ][ 'medical.audience' ];

			/**
			 * Intangible > ItemList
			 */
			$thing[ 'intangible' ][ 'item.list' ][ 'how.to.section' ] =&
				$thing[ 'intangible' ][ 'list.item' ][ 'how.to.section' ];

			$thing[ 'intangible' ][ 'item.list' ][ 'how.to.step' ] =&
				$thing[ 'intangible' ][ 'list.item' ][ 'how.to.step' ];

			/**
			 * Intangible > Enumeration
			 */
			$thing[ 'intangible' ][ 'enumeration' ][ 'specialty' ][ 'medical.specialty' ] =&
				$thing[ 'intangible' ][ 'enumeration' ][ 'medical.enumeration' ][ 'medical.specialty' ];

			/**
			 * Organization > Local Business
			 *
			 * https://schema.org/LocalBusiness is both an Organization and a Place.
			 */
			$thing[ 'organization' ][ 'local.business' ] =& 
				$thing[ 'place' ][ 'local.business' ];

			/**
			 * Organization > Medical Organization
			 */
			$thing[ 'organization' ][ 'medical.organization' ][ 'hospital' ] =& 
				$thing[ 'place' ][ 'local.business' ][ 'emergency.service' ][ 'hospital' ];

			/**
			 * Place > Accommodation
			 */
			$thing[ 'place' ][ 'accommodation' ][ 'house' ][ 'house.single.family' ] =&
				$thing[ 'place' ][ 'accommodation' ][ 'house' ][ 'residence.single.family' ];

			/**
			 * Place > Civic Structure
			 */
			$thing[ 'place' ][ 'civic.structure' ][ 'campground' ] =&
				$thing[ 'place' ][ 'local.business' ][ 'lodging.business' ][ 'campground' ];

			$thing[ 'place' ][ 'civic.structure' ][ 'fire.station' ] =&
				$thing[ 'place' ][ 'local.business' ][ 'emergency.service' ][ 'fire.station' ];

			$thing[ 'place' ][ 'civic.structure' ][ 'hospital' ] =&
				$thing[ 'place' ][ 'local.business' ][ 'emergency.service' ][ 'hospital' ];

			$thing[ 'place' ][ 'civic.structure' ][ 'movie.theatre' ] =&
				$thing[ 'place' ][ 'local.business' ][ 'entertainment.business' ][ 'movie.theatre' ];

			$thing[ 'place' ][ 'civic.structure' ][ 'police.station' ] =&
				$thing[ 'place' ][ 'local.business' ][ 'emergency.service' ][ 'police.station' ];

			$thing[ 'place' ][ 'civic.structure' ][ 'stadium.or.arena' ] =&
				$thing[ 'place' ][ 'local.business' ][ 'sports.activity.location' ][ 'stadium.or.arena' ];

			/**
			 * Place > Local Business
			 */
			$thing[ 'place' ][ 'local.business' ][ 'dentist.organization' ] =&
				$thing[ 'organization' ][ 'medical.organization' ][ 'dentist.organization' ];

			$thing[ 'place' ][ 'local.business' ][ 'store' ][ 'auto.parts.store' ] =& 
				$thing[ 'place' ][ 'local.business' ][ 'automotive.business' ][ 'auto.parts.store' ];

		}

		/**
		 * Returns an array of schema type ids with gparent, parent, child (in that order).
		 */
		public function get_schema_type_child_family( $child_id, &$child_family = array(), $use_cache = true ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			if ( $use_cache ) {

				$cache_md5_pre  = $this->p->lca . '_t_';
				$cache_exp_secs = $this->get_types_cache_exp();

				if ( $cache_exp_secs > 0 ) {

					$cache_salt   = __METHOD__ . '(child_id:' . $child_id . ')';
					$cache_id     = $cache_md5_pre . md5( $cache_salt );
					$child_family = get_transient( $cache_id );	// Returns false when not found.

					if ( ! empty( $child_family ) ) {
						return $child_family;
					}
				}
			}

			$schema_types = $this->get_schema_types_array( $flatten = true );

			if ( isset( $this->types_cache[ 'parents' ][ $child_id ] ) ) {

				$parent_id = $this->types_cache[ 'parents' ][ $child_id ];

				if ( isset( $schema_types[ $parent_id ] ) ) {
					if ( $parent_id !== $child_id )	{	// Prevent infinite loops.
						$this->get_schema_type_child_family( $parent_id, $child_family, false );
					}
				}
			}

			$child_family[] = $child_id;	// Add child after parents.

			if ( $use_cache ) {
				if ( $cache_exp_secs > 0 ) {
					set_transient( $cache_id, $child_family, $cache_exp_secs );
				}
			}

			return $child_family;
		}

		/**
		 * Returns an array of schema type ids with child, parent, gparent (in that order).
		 */
		public function get_schema_type_children( $type_id, &$children = array(), $use_cache = true ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'getting children for type id ' . $type_id );
			}

			if ( $use_cache ) {

				$cache_md5_pre  = $this->p->lca . '_t_';
				$cache_exp_secs = $this->get_types_cache_exp();

				if ( $cache_exp_secs > 0 ) {

					$cache_salt = __METHOD__ . '(type_id:' . $type_id . ')';
					$cache_id   = $cache_md5_pre . md5( $cache_salt );
					$children   = get_transient( $cache_id );	// Returns false when not found.

					if ( ! empty( $children ) ) {
						if ( $this->p->debug->enabled ) {
							$this->p->debug->log( 'returning children from transient cache' );
						}
						return $children;
					}
				}
			}

			$children[]   = $type_id;	// Add children before parents.
			$schema_types = $this->get_schema_types_array( $flatten = true );

			foreach ( $this->types_cache[ 'parents' ] as $child_id => $parent_id ) {
				if ( $parent_id === $type_id ) {
					$this->get_schema_type_children( $child_id, $children, false );
				}
			}

			if ( $use_cache ) {

				if ( $cache_exp_secs > 0 ) {

					set_transient( $cache_id, $children, $cache_exp_secs );

					if ( $this->p->debug->enabled ) {
						$this->p->debug->log( 'children saved to transient cache for ' . $cache_exp_secs . ' seconds' );
					}
				}
			}

			return $children;
		}

		/**
		 * Get the full schema type url from the array key.
		 */
		public function get_schema_type_url( $type_id, $default_id = false ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$schema_types = $this->get_schema_types_array( $flatten = true );

			if ( isset( $schema_types[ $type_id ] ) ) {

				return $schema_types[ $type_id ];

			} elseif ( false !== $default_id && isset( $schema_types[ $default_id ] ) ) {

				return $schema_types[ $default_id ];
			}

			return false;
		}

		/**
		 * Returns an array of schema type IDs for a given type URL.
		 */
		public function get_schema_type_url_ids( $type_url ) {

			$type_ids = array();

			$schema_types = $this->get_schema_types_array( $flatten = true );

			foreach ( $schema_types as $id => $url ) {
				if ( $url === $type_url ) {
					$type_ids[] = $id;
				}
			}

			return $type_ids;
		}

		/**
		 * Returns the first schema type ID for a given type URL.
		 */
		public function get_schema_type_url_id( $type_url, $default_id = false ) {

			$schema_types = $this->get_schema_types_array( $flatten = true );

			foreach ( $schema_types as $id => $url ) {
				if ( $url === $type_url ) {
					return $id;
				}
			}

			return $default_id;
		}

		public function get_schema_type_id_for_name( $type_name, $default_id = null ) {

			if ( $this->p->debug->enabled ) {

				$this->p->debug->log_args( array( 
					'type_name'  => $type_name,
					'default_id' => $default_id,
				) );
			}

			if ( empty( $type_name ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'exiting early: schema type name is empty' );
				}

				return $default_id;	// Just in case.
			}

			$schema_types = $this->get_schema_types_array( $flatten = true );

			$type_id = isset( $this->p->options[ 'schema_type_for_' . $type_name ] ) ?	// Just in case.
				$this->p->options[ 'schema_type_for_' . $type_name ] : $default_id;

			if ( empty( $type_id ) || $type_id === 'none' ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'schema type id for ' . $type_name . ' is empty or disabled' );
				}

				$type_id = $default_id;

			} elseif ( empty( $schema_types[ $type_id ] ) ) {

				if ( $this->p->debug->enabled ) {
					$this->p->debug->log( 'schema type id "' . $type_id . '" for ' . $type_name . ' not in schema types' );
				}

				$type_id = $default_id;

			} elseif ( $this->p->debug->enabled ) {
				$this->p->debug->log( 'schema type id for ' . $type_name . ' is ' . $type_id );
			}

			return $type_id;
		}

		public function get_children_css_class( $type_id, $class_names = 'hide_schema_type', $exclude_match = '' ) {

			if ( $this->p->debug->enabled ) {
				$this->p->debug->mark();
			}

			$class_prefix = empty( $class_names ) ? '' : SucomUtil::sanitize_hookname( $class_names ) . '_';

			foreach ( $this->get_schema_type_children( $type_id ) as $child ) {

				if ( ! empty( $exclude_match ) ) {
					if ( preg_match( $exclude_match, $child ) ) {
						continue;
					}
				}

				$class_names .= ' ' . $class_prefix . SucomUtil::sanitize_hookname( $child );
			}

			return trim( $class_names );
		}

		public function is_schema_type_child( $child_id, $member_id ) {

			static $local_cache = array();	// Cache for single page load.

			if ( isset( $local_cache[ $child_id ][ $member_id ] ) ) {
				return $local_cache[ $child_id ][ $member_id ];
			}

			if ( $child_id === $member_id ) {	// Optimize and check for obvious.
				$is_child = true;
			} else {
				$child_family = $this->get_schema_type_child_family( $child_id );
				$is_child     = in_array( $member_id, $child_family ) ? true : false;
			}

			return $local_cache[ $child_id ][ $member_id ] = $is_child;
		}

		public function count_schema_type_children( $type_id ) {

			return count( $this->get_schema_type_children( $type_id ) );
		}

		public function get_types_cache_exp() {

			static $cache_exp_secs = null;

			if ( ! isset( $cache_exp_secs ) ) {

				$cache_md5_pre    = $this->p->lca . '_t_';
				$cache_exp_filter = $this->p->cf[ 'wp' ][ 'transient' ][ $cache_md5_pre ][ 'filter' ];
				$cache_opt_key    = $this->p->cf[ 'wp' ][ 'transient' ][ $cache_md5_pre ][ 'opt_key' ];
				$cache_exp_secs   = isset( $this->p->options[ $cache_opt_key ] ) ? $this->p->options[ $cache_opt_key ] : MONTH_IN_SECONDS;
				$cache_exp_secs   = (int) apply_filters( $cache_exp_filter, $cache_exp_secs );
			}

			return $cache_exp_secs;
		}

		public static function get_schema_type_parts( $type_url ) {

			if ( preg_match( '/^(.+:\/\/.+)\/([^\/]+)$/', $type_url, $match ) ) {
				return array( $match[1], $match[2] );
			} else {
				return array( null, null );	// Return two elements.
			}
		}

		public static function get_schema_type_context( $type_url, array $json_data = array() ) {

			if ( preg_match( '/^(.+:\/\/.+)\/([^\/]+)$/', $type_url, $match ) ) {

				$context_value = $match[1];
				$type_value    = $match[2];

				/**
				 * Check for schema extension (example: https://health-lifesci.schema.org).
				 *
				 * $context_value = array(
				 *	"https://schema.org",
				 *	array(
				 *		"health-lifesci" => "https://health-lifesci.schema.org",
				 *	),
				 * );
				 *
				 */
				if ( preg_match( '/^(.+:\/\/)([^\.]+)\.([^\.]+\.[^\.]+)$/', $context_value, $ext ) ) {
					$context_value = array( 
						$ext[1] . $ext[3],
						array(
							$ext[2] => $ext[0],
						)
					);
				}

				$json_head = array(
					'@id'      => null,
					'@context' => null,
					'@type'    => null,
				);

				$json_values = array(
					'@context' => $context_value,
					'@type'    => $type_value,
				);

				$json_data = array_merge(
					$json_head,	// Keep @id, @context, and @type top-most.
					$json_data,
					$json_values
				);

				if ( empty( $json_data[ '@id' ] ) ) {
					unset( $json_data[ '@id' ] );
				}
			}

			return $json_data;
		}

		public static function get_data_context( $json_data ) {

			if ( false !== ( $type_url = self::get_data_type_url( $json_data ) ) ) {

				return self::get_schema_type_context( $type_url );
			}

			return array();
		}

		/**
		 * json_data can be null, so don't cast an array on the input argument. 
		 *
		 * The @context value can be an array if the schema type is an extension.
		 *
		 * @context = array(
		 *	"https://schema.org",
		 *	array(
		 *		"health-lifesci" => "https://health-lifesci.schema.org",
		 *	)
		 * )
		 */
		public static function get_data_type_url( $json_data ) {

			$type_url = false;

			if ( empty( $json_data[ '@type' ] ) ) {

				return false;	// Stop here.

			} elseif ( is_array( $json_data[ '@type' ] ) ) {

				$json_data[ '@type' ] = reset( $json_data[ '@type' ] );	// Use first @type element.

				$type_url = self::get_data_type_url( $json_data );

			} elseif ( strpos( $json_data[ '@type' ], '://' ) ) {	// @type is a complete url

				$type_url = $json_data[ '@type' ];

			} elseif ( ! empty(  $json_data[ '@context' ] ) ) {	// Just in case.

				if ( is_array( $json_data[ '@context' ] ) ) {	// Get the extension url.

					$context_url = self::get_context_extension_url( $json_data[ '@context' ] );

					if ( ! empty( $context_url ) ) {	// Just in case.
						$type_url = trailingslashit( $context_url ) . $json_data[ '@type' ];
					}

				} elseif ( is_string( $json_data[ '@context' ] ) ) {
					$type_url = trailingslashit( $json_data[ '@context' ] ) . $json_data[ '@type' ];
				}
			}

			$type_url = set_url_scheme( $type_url, 'https' );	// Just in case.

			return $type_url;
		}

		public static function get_context_extension_url( array $json_data ) {

			$type_url = false;
			$ext_data = array_reverse( $json_data );	// Read the array bottom-up.

			foreach ( $ext_data as $val ) {

				if ( is_array( $val ) ) {		// If it's an extension array, drill down and return that value.

					return self::get_context_extension_url( $val );

				} elseif ( is_string( $val ) ) {	// Set a backup value in case there is no extension array.

					$type_url = $val;
				}
			}

			return false;
		}

		/**
		 * Get the site organization array.
		 *
		 * $mixed = 'default' | 'current' | post ID | $mod array
		 */
		public static function get_site_organization( $mixed = 'current' ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			$social_accounts = apply_filters( $wpsso->lca . '_social_accounts', $wpsso->cf[ 'form' ][ 'social_accounts' ] );

			$org_sameas = array();

			foreach ( $social_accounts as $social_key => $social_label ) {

				$url = SucomUtil::get_key_value( $social_key, $wpsso->options, $mixed );	// Localized value.

				if ( empty( $url ) ) {
					continue;
				} elseif ( $social_key === 'tc_site' ) {	// Convert twitter name to url.
					$url = 'https://twitter.com/' . preg_replace( '/^@/', '', $url );
				}

				if ( false !== filter_var( $url, FILTER_VALIDATE_URL ) ) {
					$org_sameas[] = $url;
				}
			}

			/**
			 * Logo and banner image dimensions are localized as well.
			 *
			 * Example: 'schema_logo_url:width#fr_FR'.
			 */
			return array(
				'org_url'               => SucomUtil::get_site_url( $wpsso->options, $mixed ),
				'org_name'              => SucomUtil::get_site_name( $wpsso->options, $mixed ),
				'org_name_alt'          => SucomUtil::get_site_name_alt( $wpsso->options, $mixed ),
				'org_desc'              => SucomUtil::get_site_description( $wpsso->options, $mixed ),
				'org_logo_url'          => SucomUtil::get_key_value( 'schema_logo_url', $wpsso->options, $mixed ),
				'org_logo_url:width'    => SucomUtil::get_key_value( 'schema_logo_url:width', $wpsso->options, $mixed ),
				'org_logo_url:height'   => SucomUtil::get_key_value( 'schema_logo_url:height', $wpsso->options, $mixed ),
				'org_banner_url'        => SucomUtil::get_key_value( 'schema_banner_url', $wpsso->options, $mixed ),
				'org_banner_url:width'  => SucomUtil::get_key_value( 'schema_banner_url:width', $wpsso->options, $mixed ),
				'org_banner_url:height' => SucomUtil::get_key_value( 'schema_banner_url:height', $wpsso->options, $mixed ),
				'org_schema_type'       => $wpsso->options[ 'site_org_schema_type' ],
				'org_place_id'          => $wpsso->options[ 'site_place_id' ],
				'org_sameas'            => $org_sameas,
			);
		}

		/**
		 * $user_id is optional and takes precedence over the $mod post_author value.
		 */
		public static function add_author_coauthor_data( &$json_data, $mod, $user_id = false ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			$authors_added   = 0;
			$coauthors_added = 0;

			if ( empty( $user_id ) && isset( $mod[ 'post_author' ] ) ) {
				$user_id = $mod[ 'post_author' ];
			}

			if ( empty( $user_id ) || $user_id === 'none' ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'exiting early: empty user_id / post_author' );
				}

				return 0;
			}

			/**
			 * Single author.
			 */
			$authors_added += WpssoSchemaSingle::add_person_data( $json_data[ 'author' ], $mod, $user_id, $list_element = false );

			/**
			 * List of contributors / co-authors.
			 */
			if ( ! empty( $mod[ 'post_coauthors' ] ) ) {
				foreach ( $mod[ 'post_coauthors' ] as $author_id ) {
					$coauthors_added += WpssoSchemaSingle::add_person_data( $json_data[ 'contributor' ], $mod, $author_id, $list_element = true );
				}
			}

			foreach ( array( 'author', 'contributor' ) as $prop_name ) {
				if ( empty( $json_data[ $prop_name ] ) ) {
					unset( $json_data[ $prop_name ] );	// Prevent null assignment.
				}
			}

			return $authors_added + $coauthors_added;	// Return count of authors and coauthors added.
		}

		/**
		 * Pass a single or two dimension image array in $mt_list.
		 */
		public static function add_images_data_mt( &$json_data, &$mt_list, $mt_pre = 'og:image' ) {

			$images_added = 0;

			if ( isset( $mt_list[ 0 ] ) && is_array( $mt_list[ 0 ] ) ) {	// 2 dimensional array.

				foreach ( $mt_list as $og_single_image ) {

					$images_added += WpssoSchemaSingle::add_image_data_mt( $json_data,
						$og_single_image, $mt_pre, $list_element = true );
				}

			} elseif ( is_array( $mt_list ) ) {

				$images_added += WpssoSchemaSingle::add_image_data_mt( $json_data,
					$mt_list, $mt_pre, $list_element = true );
			}

			return $images_added;	// Return count of images added.
		}

		/**
		 * Deprecated on 2019/06/29.
		 */
		public static function add_og_single_image_data( &$json_data, $mt_single, $mt_pre = 'og:image', $list_element = true ) {

			return WpssoSchemaSingle::add_image_data_mt( $json_data, $mt_single, $mt_pre, $list_element );
		}

		/**
		 * Provide a single or two-dimension video array in $mt_list.
		 */
		public static function add_videos_data_mt( &$json_data, $mt_list, $mt_pre = 'og:video' ) {

			$videos_added = 0;

			if ( isset( $mt_list[ 0 ] ) && is_array( $mt_list[ 0 ] ) ) {	// 2 dimensional array.

				foreach ( $mt_list as $og_single_video ) {

					$videos_added += WpssoSchemaSingle::add_video_data_mt( $json_data,
						$og_single_video, $mt_pre, $list_element = true );
				}

			} elseif ( is_array( $mt_list ) ) {

				$videos_added += WpssoSchemaSingle::add_video_data_mt( $json_data,
					$mt_list, $mt_pre, $list_element = true );
			}

			return $videos_added;	// return count of videos added
		}

		public static function add_aggregate_offer_data( &$json_data, array $mod, array $mt_offers ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			$aggregate_added  = 0;
			$aggregate_prices = array();
			$aggregate_offers = array();
			$aggregate_common = array();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->log( 'adding ' . count( $mt_offers ) . ' offers as aggregateoffer' );
			}

			foreach ( $mt_offers as $offer_num => $mt_offer ) {

				if ( ! is_array( $mt_offer ) ) {	// Just in case.

					if ( $wpsso->debug->enabled ) {
						$wpsso->debug->log( 'skipping offer #' . $offer_num . ': not an array' );
					}

					continue;
				}

				$single_offer = WpssoSchemaSingle::get_offer_data( $mod, $mt_offer );

				if ( false === $single_offer ) {
					continue;
				}

				/**
				 * Make sure we have a price currency value.
				 */
				$price_currency = isset( $single_offer[ 'priceCurrency' ] ) ?
					$single_offer[ 'priceCurrency' ] : $wpsso->options[ 'plugin_def_currency' ];

				/**
				 * Keep track of the lowest and highest price by currency.
				 */
				if ( isset( $single_offer[ 'price' ] ) ) {	// Just in case.

					if ( ! isset( $aggregate_prices[ $price_currency ][ 'low' ] )
						|| $aggregate_prices[ $price_currency ][ 'low' ] > $single_offer[ 'price' ] ) {		// Save lower price.
						$aggregate_prices[ $price_currency ][ 'low' ] = $single_offer[ 'price' ];
					}

					if ( ! isset( $aggregate_prices[ $price_currency ][ 'high' ] )
						|| $aggregate_prices[ $price_currency ][ 'high' ] < $single_offer[ 'price' ] ) {	// Save higher price.
						$aggregate_prices[ $price_currency ][ 'high' ] = $single_offer[ 'price' ];
					}
				}

				/**
				 * Save common properties (by currency) to include in the AggregateOffer markup.
				 */
				if ( $offer_num === 0 ) {
					foreach ( preg_grep( '/^[^@]/', array_keys( $single_offer ) ) as $key ) {
						$aggregate_common[ $price_currency ][ $key ] = $single_offer[ $key ];
					}
				} elseif ( ! empty( $aggregate_common[ $price_currency ] ) ) {
					foreach ( $aggregate_common[ $price_currency ] as $key => $val ) {
						if ( ! isset( $single_offer[ $key ] ) ) {
							unset( $aggregate_common[ $price_currency ][ $key ] );
						} elseif ( $val !== $single_offer[ $key ] ) {
							unset( $aggregate_common[ $price_currency ][ $key ] );
						}
					}
				}

				/**
				 * Add the complete offer.
				 */
				$aggregate_offers[ $price_currency ][] = self::get_schema_type_context( 'https://schema.org/Offer', $single_offer );
			}

			/**
			 * Add aggregate offers grouped by currency.
			 */
			foreach ( $aggregate_offers as $price_currency => $currency_offers ) {

				if ( ( $offer_count = count( $currency_offers ) ) > 0 ) {

					$offer_group = array();

					foreach ( array( 'low', 'high' ) as $mark ) {
						if ( isset( $aggregate_prices[ $price_currency ][ $mark ] ) ) {
							$offer_group[ $mark . 'Price' ] = $aggregate_prices[ $price_currency ][ $mark ];
						}
					}

					$offer_group[ 'priceCurrency' ] = $price_currency;

					if ( ! empty( $aggregate_common[ $price_currency ] ) ) {
						foreach ( $aggregate_common[ $price_currency ] as $key => $val ) {
							$offer_group[ $key ] = $val;
						}
					}

					$offer_group[ 'offerCount' ] = $offer_count;
					$offer_group[ 'offers' ]     = $currency_offers;

					$json_data[ 'offers' ][] = self::get_schema_type_context( 'https://schema.org/AggregateOffer', $offer_group );

					$aggregate_added++;
				}
			}

			return $aggregate_added;
		}

		/**
		 * Deprecated on 2019/04/18. 
		 */
		public static function add_single_event_data( &$json_data, array $mod, $event_id = false, $list_element = false ) {
			return WpssoSchemaSingle::add_event_data( $json_data, $mod, $event_id, $list_element );
		}

		/**
		 * Deprecated on 2019/04/18. 
		 */
		public static function add_single_job_data( &$json_data, array $mod, $job_id = false, $list_element = false ) {
			return WpssoSchemaSingle::add_job_data( $json_data, $mod, $job_id, $list_element );
		}

		/**
		 * Deprecated on 2019/04/18. 
		 */
		public static function get_single_offer_data( array $mod, array $mt_offer ) {
			return WpssoSchemaSingle::get_offer_data( $mod, $mt_offer );
		}

		/**
		 * Deprecated on 2019/04/18. 
		 */
		public static function add_single_organization_data( &$json_data, $mod, $org_id = 'site', $logo_key = 'org_logo_url', $list_element = false ) {
			return WpssoSchemaSingle::add_organization_data( $json_data, $mod, $org_id, $logo_key, $list_element );
		}

		/**
		 * Deprecated on 2019/04/18. 
		 */
		public static function add_single_person_data( &$json_data, $mod, $user_id, $list_element = true ) {
			return WpssoSchemaSingle::add_person_data( $json_data, $mod, $user_id, $list_element );
		}

		/**
		 * Deprecated on 2019/04/18. 
		 */
		public static function add_single_place_data( &$json_data, $mod, $place_id = false, $list_element = false ) {
			return WpssoSchemaSingle::add_place_data( $json_data, $mod, $place_id, $list_element );
		}

		/**
		 * Modifies the $json_data directly (by reference) and does not return a value.
		 * Do not type-cast the $json_data argument as it may be false or an array.
		 */
		public static function organization_to_localbusiness( &$json_data ) {

			if ( ! is_array( $json_data ) ) {	// Just in case.
				return;
			}

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			/**
			 * Promote all location information up.
			 */
			if ( isset( $json_data[ 'location' ] ) ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'promoting location property array' );
				}

				$prop_added = self::add_data_itemprop_from_assoc( $json_data, $json_data[ 'location' ], 
					array_keys( $json_data[ 'location' ] ), $overwrite = false );

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'promoted ' . $prop_added . ' location keys' );
				}

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'removing the location property' );
				}

				unset( $json_data[ 'location' ] );

			} elseif ( $wpsso->debug->enabled ) {
				$wpsso->debug->log( 'no location property to promote' );
			}

			/**
			 * Google requires a local business to have an image.
			 * Check last as the location may have had an image that was promoted.
			 */
			if ( isset( $json_data[ 'logo' ] ) && empty( $json_data[ 'image' ] ) ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'adding logo from organization markup' );
				}

				$json_data[ 'image' ][] = $json_data[ 'logo' ];

			} elseif ( $wpsso->debug->enabled ) {
				$wpsso->debug->log( 'logo is missing from organization markup' );
			}
		}

		/**
		 * Return any 3rd party and custom post options for a given option type.
		 * 
		 * function wpsso_get_post_event_options( $post_id, $event_id = false ) {
		 * 	WpssoSchema::get_post_md_type_opts( $post_id, 'event', $event_id );
		 * }
		 */
		public static function get_post_md_type_opts( $post_id, $md_type, $type_id = false ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			if ( empty( $post_id ) ) {		// Just in case.
				return false;
			} elseif ( empty( $md_type ) ) {	// Just in case.
				return false;
			} elseif ( ! empty( $wpsso->post ) ) {	// Just in case.
				$mod = $wpsso->post->get_mod( $post_id );
			} else {
				return false;
			}

			$md_opts = apply_filters( $wpsso->lca . '_get_' . $md_type . '_options', false, $mod, $type_id );

			if ( ! empty( $md_opts ) ) {
				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log_arr( 'get_' . $md_type . '_options filters returned', $md_opts );
				}
			}

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->log( 'merging default, filter, and custom option values' );
			}

			self::merge_custom_mod_opts( $mod, $md_opts, array( $md_type => 'schema_' . $md_type ) );

			if ( has_filter( $wpsso->lca . '_get_' . $md_type . '_place_id' ) ) {	// Skip if no filters.

				if ( ! isset( $md_opts[ $md_type . '_place_id' ] ) ) {
					$md_opts[ $md_type . '_place_id' ] = null;		// Return null by default.
				}

				$md_opts[ $md_type . '_place_id' ] = apply_filters( $wpsso->lca . '_get_' . $md_type . '_place_id',
					$md_opts[ $md_type . '_place_id' ], $mod, $type_id );

				if ( $md_opts[ $md_type . '_place_id' ] === null ) {	// Unset if still null.
					unset( $md_opts[ $md_type . '_place_id' ] );
				}
			}

			return $md_opts;
		}

		public static function merge_custom_mod_opts( array $mod, &$opts, array $opts_md_pre ) {

			if ( is_object( $mod[ 'obj' ] ) ) {	// Just in case.

				$md_defs = (array) $mod[ 'obj' ]->get_defaults( $mod[ 'id' ] );

				$md_opts = (array) $mod[ 'obj' ]->get_options( $mod[ 'id' ] );

				foreach ( $opts_md_pre as $opt_key => $md_pre ) {

					$md_defs = SucomUtil::preg_grep_keys( '/^' . $md_pre . '_/', $md_defs, false, $opt_key . '_' );

					$md_opts = SucomUtil::preg_grep_keys( '/^' . $md_pre . '_/', $md_opts, false, $opt_key . '_' );
	
					/**
					 * Merge defaults, values from filters, and custom values (in that order).
					 */
					if ( is_array( $opts ) ) {
						$opts = array_merge( $md_defs, $opts, $md_opts );
					} else {
						$opts = array_merge( $md_defs, $md_opts );
					}
				}
			}
		}

		/**
		 * Add ISO formatted date options to the options array (passed by reference).
		 *
		 * $opts_md_pre = array( 
		 *	'event_start_date'        => 'schema_event_start',        // Prefix for date, time, timezone, iso.
		 *	'event_end_date'          => 'schema_event_end',          // Prefix for date, time, timezone, iso.
		 *	'event_offers_start_date' => 'schema_event_offers_start', // Prefix for date, time, timezone, iso.
		 *	'event_offers_end_date'   => 'schema_event_offers_end',   // Prefix for date, time, timezone, iso.
		 * );
		 */
		public static function add_mod_opts_date_iso( array $mod, &$opts, array $opts_md_pre ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			foreach ( $opts_md_pre as $opt_pre => $md_pre ) {

				$date_iso = self::get_mod_date_iso( $mod, $md_pre );

				if ( ! is_array( $opts ) ) {	// Just in case.
					$opts = array();
				}

				$opts[ $opt_pre . '_iso' ] = $date_iso;
			}
		}

		public static function get_mod_date_iso( array $mod, $md_pre ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			if ( ! is_string( $md_pre ) ) {	// Just in case.
				return '';
			}

			$md_opts = $mod[ 'obj' ]->get_options( $mod[ 'id' ] );

			return self::get_opts_date_iso( $md_opts, $md_pre );
		}

		public static function get_opts_date_iso( array $opts, $md_pre ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			if ( ! is_string( $md_pre ) ) {	// Just in case.
				return '';
			}

			$md_date     = empty( $opts[ $md_pre . '_date' ] ) || $opts[ $md_pre . '_date' ] === 'none' ? '' : $opts[ $md_pre . '_date' ];
			$md_time     = empty( $opts[ $md_pre . '_time' ] ) || $opts[ $md_pre . '_time' ] === 'none' ? '' : $opts[ $md_pre . '_time' ];
			$md_timezone = empty( $opts[ $md_pre . '_timezone' ] ) || $opts[ $md_pre . '_timezone' ] === 'none' ? '' : $opts[ $md_pre . '_timezone' ];
				
			if ( empty( $md_date ) && empty( $md_time ) ) {		// No date or time.

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'exiting early: ' . $md_pre . ' date and time are empty' );
				}

				return '';	// Nothing to do.

			}
			
			if ( ! empty( $md_date ) && empty( $md_time ) ) {	// Date with no time.

				$md_time = '00:00';

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( $md_pre . ' time is empty: using time ' . $md_time );
				}

			}
			
			if ( empty( $md_date ) && ! empty( $md_time ) ) {	// Time with no date.

				$md_date = gmdate( 'Y-m-d', time() );

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( $md_pre . ' date is empty: using date ' . $md_date );
				}
			}

			if ( empty( $md_timezone ) ) {				// No timezone.

				$md_timezone = get_option( 'timezone_string' );

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( $md_pre . ' timezone is empty: using timezone ' . $md_timezone );
				}
			}

			return date_format( date_create( $md_date . ' ' . $md_time . ' ' . $md_timezone ), 'c' );
		}

		/**
		 * Example $names array:
		 *
		 * array(
		 * 	'prepTime'  => 'schema_recipe_prep',
		 * 	'cookTime'  => 'schema_recipe_cook',
		 * 	'totalTime' => 'schema_recipe_total',
		 * );
		 */
		public static function add_data_time_from_assoc( array &$json_data, array $assoc, array $names ) {

			foreach ( $names as $prop_name => $key_name ) {

				$t = array();

				foreach ( array( 'days', 'hours', 'mins', 'secs' ) as $time_incr ) {
					$t[ $time_incr ] = empty( $assoc[ $key_name . '_' . $time_incr ] ) ?	// 0 or empty string.
						0 : (int) $assoc[ $key_name . '_' . $time_incr ];		// Define as 0 by default.
				}

				if ( $t[ 'days' ] . $t[ 'hours' ] . $t[ 'mins' ] . $t[ 'secs' ] > 0 ) {
					$json_data[ $prop_name ] = 'P' . $t[ 'days' ] . 'DT' . $t[ 'hours' ] . 'H' . $t[ 'mins' ] . 'M' . $t[ 'secs' ] . 'S';
				}
			}
		}

		/**
		 * Deprecated on 2019/03/30.
		 */
		public static function add_data_quant_from_assoc( array &$json_data, array $assoc, array $names ) {

			return self::add_data_unit_from_assoc( $json_data, $assoc, $names );
		}

		/**
		 * Deprecated on 2019/08/01.
		 */
		public static function add_data_unitcode_from_assoc( array &$json_data, array $assoc, array $names ) {

			return self::add_data_unit_from_assoc( $json_data, $assoc, $names );
		}

		/**
		 * QuantitativeValue (width, height, length, depth, weight).
		 *
		 * unitCodes from http://wiki.goodrelations-vocabulary.org/Documentation/UN/CEFACT_Common_Codes.
		 *
		 * Example $names array:
		 *
		 * array(
		 * 	'depth'  => 'product:depth:value',
		 * 	'height' => 'product:height:value',
		 * 	'length' => 'product:length:value',
		 * 	'size'   => 'product:size',
		 * 	'volume' => 'product:volume:value',
		 * 	'weight' => 'product:weight:value',
		 * 	'width'  => 'product:width:value',
		 * );
		 */
		public static function add_data_unit_from_assoc( array &$json_data, array $assoc, array $names ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			if ( null === self::$units_cache ) {
				self::$units_cache = apply_filters( $wpsso->lca . '_schema_units', $wpsso->cf[ 'head' ][ 'schema_units' ] );
			}

			if ( ! is_array( self::$units_cache ) ) {	// Just in case.
				return;
			}

			foreach ( $names as $idx => $key_name ) {

				/**
				 * Make sure the property name we need (width, height, weight, etc.) is configured.
				 */
				if ( empty( self::$units_cache[ $idx ] ) || ! is_array( self::$units_cache[ $idx ] ) ) {
					continue;
				}

				/**
				 * Exclude empty string values.
				 */
				if ( ! isset( $assoc[ $key_name ] ) || $assoc[ $key_name ] === '' ) {
					continue;
				}

				/**
				 * Example array:
				 *
				 *	self::$units_cache[ 'depth' ] = array(
				 *		'depth' => array(
				 *			'@context' => 'https://schema.org',
				 *			'@type'    => 'QuantitativeValue',
				 *			'name'     => 'Depth',
				 *			'unitText' => 'cm',
				 *			'unitCode' => 'CMT',
				 *		),
				 *	),
				 */
				foreach ( self::$units_cache[ $idx ] as $prop_name => $prop_data ) {

					$prop_data[ 'value' ] = $assoc[ $key_name ];

					$json_data[ $prop_name ][] = $prop_data;
				}
			}
		}

		/**
		 * Deprecated on 2019/08/01.
		 */
		public static function get_data_unitcode_text( $idx ) {

			return self::get_data_unit_text( $idx );
		}

		public static function get_data_unit_text( $idx ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			static $local_cache = array();

			if ( isset( $local_cache[ $idx ] ) ) {
				return $local_cache[ $idx ];
			}

			if ( null === self::$units_cache ) {
				self::$units_cache = apply_filters( $wpsso->lca . '_schema_units', $wpsso->cf[ 'head' ][ 'schema_units' ] );
			}

			if ( empty( self::$units_cache[ $idx ] ) || ! is_array( self::$units_cache[ $idx ] ) ) {
				return $local_cache[ $idx ] = '';
			}

			/**
			 * Example array:
			 *
			 *	self::$units_cache[ 'depth' ] = array(
			 *		'depth' => array(
			 *			'@context' => 'https://schema.org',
			 *			'@type'    => 'QuantitativeValue',
			 *			'name'     => 'Depth',
			 *			'unitText' => 'cm',
			 *			'unitCode' => 'CMT',
			 *		),
			 *	),
			 */
			foreach ( self::$units_cache[ $idx ] as $prop_name => $prop_data ) {

				if ( isset( $prop_data[ 'unitText' ] ) ) {	// Return the first match.
					return $local_cache[ $idx ] = $prop_data[ 'unitText' ];
				}
			}

			return $local_cache[ $idx ] = '';
		}

		/**
		 * Returns the number of Schema properties added to $json_data.
		 *
		 * Example usage:
		 *
		 *	WpssoSchema::add_data_itemprop_from_assoc( $ret, $mt_og, array(
		 *		'datePublished' => 'article:published_time',
		 *		'dateModified'  => 'article:modified_time',
		 *	) );
		 *
		 *	WpssoSchema::add_data_itemprop_from_assoc( $ret, $org_opts, array(
		 *		'url'           => 'org_url',
		 *		'name'          => 'org_name',
		 *		'alternateName' => 'org_name_alt',
		 *		'description'   => 'org_desc',
		 *		'email'         => 'org_email',
		 *		'telephone'     => 'org_phone',
		 *	) );
		 *
		 */
		public static function add_data_itemprop_from_assoc( array &$json_data, array $assoc, array $names, $overwrite = true ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			$is_assoc   = SucomUtil::is_assoc( $names );
			$prop_added = 0;

			foreach ( $names as $prop_name => $key_name ) {

				if ( ! $is_assoc ) {
					$prop_name = $key_name;
				}

				if ( isset( $assoc[ $key_name ] ) && $assoc[ $key_name ] !== '' ) {	// Exclude empty strings.

					if ( isset( $json_data[ $prop_name ] ) && empty( $overwrite ) ) {

						if ( $wpsso->debug->enabled ) {
							$wpsso->debug->log( 'skipping ' . $prop_name . ': itemprop exists and overwrite is false' );
						}

					} else {

						if ( is_string( $assoc[ $key_name ] ) && false !== filter_var( $assoc[ $key_name ], FILTER_VALIDATE_URL ) ) {
							$json_data[ $prop_name ] = SucomUtil::esc_url_encode( $assoc[ $key_name ] );
						} else {
							$json_data[ $prop_name ] = $assoc[ $key_name ];
						}

						if ( $wpsso->debug->enabled ) {
							$wpsso->debug->log( 'assigned ' . $key_name . ' value to itemprop ' . $prop_name . ' = ' . 
								print_r( $json_data[ $prop_name ], true ) );
						}

						$prop_added++;
					}
				}
			}

			return $prop_added;
		}

		/**
		 * Example usage:
		 *
		 *	$offer = WpssoSchema::get_data_itemprop_from_assoc( $mt_offer, array( 
		 *		'url'             => 'product:url',
		 *		'name'            => 'product:title',
		 *		'description'     => 'product:description',
		 *		'category'        => 'product:category',
		 *		'mpn'             => 'product:mfr_part_no',
		 *		'itemCondition'   => 'product:condition',
		 *		'availability'    => 'product:availability',
		 *		'price'           => 'product:price:amount',
		 *		'priceCurrency'   => 'product:price:currency',
		 *		'priceValidUntil' => 'product:sale_price_dates:end',
		 *	) );
		 */
		public static function get_data_itemprop_from_assoc( array $assoc, array $names, $exclude = array( '' ) ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			$json_data = array();

			foreach ( $names as $prop_name => $key_name ) {

				if ( isset( $assoc[ $key_name ] ) && ! in_array( $assoc[ $key_name ], $exclude, true ) ) {	// $strict is true.

					$json_data[ $prop_name ] = $assoc[ $key_name ];

					if ( $wpsso->debug->enabled ) {
						$wpsso->debug->log( 'assigned ' . $key_name . ' value to itemprop ' . 
							$prop_name . ' = ' . print_r( $json_data[ $prop_name ], true ) );
					}
				}
			}
			return empty( $json_data ) ? false : $json_data;
		}

		/**
		 * If we have a GTIN number, try to improve the assigned property name.
		 */
		public static function check_gtin_prop_value( &$json_data ) {

			if ( ! empty( $json_data[ 'gtin' ] ) ) {

				/**
				 * The value may come from a custom field, so trim it, just in case.
				 */
				$json_data[ 'gtin' ] = trim( $json_data[ 'gtin' ] );

				$gtin_len = strlen( $json_data[ 'gtin' ] );

				switch ( $gtin_len ) {

					case 14:
					case 13:
					case 12:
					case 8:

						if ( empty( $json_data[ 'gtin' . $gtin_len ] ) ) {
							$json_data[ 'gtin' . $gtin_len ] = $json_data[ 'gtin' ];
						}

						break;
				}
			}
		}

		/**
		 * Example usage:
		 *
		 *	WpssoSchema::check_itemprop_content_map( $offer, 'itemCondition', 'product:condition' );
		 *
		 *	WpssoSchema::check_itemprop_content_map( $offer, 'availability', 'product:availability' );
		 */
		public static function check_itemprop_content_map( &$json_data, $prop_name, $map_name ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			if ( ! is_array( $json_data ) ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'nothing to do - json_data is not an array' );
				}

			} elseif ( empty( $json_data[ $prop_name ] ) ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'item property name "' . $prop_name . '" value is empty' );
				}

			} elseif ( empty( $wpsso->cf[ 'head' ][ 'og_content_map' ][ $map_name ] ) ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'og_content_map name "' . $map_name . '" is unknown' );
				}

			} else {

				$content_map = $wpsso->cf[ 'head' ][ 'og_content_map' ][ $map_name ];

				if ( empty( $content_map[ $json_data [ $prop_name ] ] ) ) {

					if ( $wpsso->debug->enabled ) {
						$wpsso->debug->log( 'unsetting invalid item property name "' . $prop_name . '" value "' . $json_data[ $prop_name ] . '"' );
					}

					unset( $json_data[ $prop_name ] );

				} else {

					if ( $wpsso->debug->enabled ) {
						$wpsso->debug->log( 'item property name "' . $prop_name . '" value "' . $json_data[ $prop_name ] . '" is valid' );
					}
				}
			}
		}

		public static function update_data_id( &$json_data, $type_id, $type_url = false ) {

			$wpsso =& Wpsso::get_instance();

			if ( $wpsso->debug->enabled ) {
				$wpsso->debug->mark();
			}

			if ( empty( $type_id ) ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'exiting early: type_id value is empty and required' );
				}

				return;
			}

			if ( false !== filter_var( $type_id, FILTER_VALIDATE_URL ) ) {

				if ( $wpsso->debug->enabled ) {

					$wpsso->debug->log( 'provided type_id is a valid url' );

					if ( empty( $json_data[ '@id' ] ) ) {
						$wpsso->debug->log( 'previous @id property is empty' );
					} else {
						$wpsso->debug->log( 'previous @id property is ' . $json_data[ '@id' ] );
					}
				}

				unset( $json_data[ '@id' ] );	// Just in case.

				$json_data = array( '@id' => $type_id ) + $json_data;	// Make @id the first value in the array.

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'new @id property is ' . $json_data[ '@id' ] );
				}

				return;	// Stop here.
			}

			$id_separator = '/';
			$id_anchor    = '#id' . $id_separator;
			$type_id      = preg_replace( '/^#id\//', '', $type_id );	// Just in case.

			if ( ! empty( $type_url ) ) {

				$default_id = $type_url . $id_anchor . $type_id;

			} elseif ( ! empty( $json_data[ 'url' ] ) ) {

				$default_id = $json_data[ 'url' ] . $id_anchor . $type_id;

			} else {
				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'exiting early: json_data url is empty and required' );
				}

				return;
			}


			/**
			 * The combined url and schema type create a unique @id string.
			 */
			if ( empty( $json_data[ '@id' ] ) ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'previous @id property is empty' );
				}

				unset( $json_data[ '@id' ] );	// Just in case.

				$json_data = array( '@id' => $default_id ) + $json_data;

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'new @id property is ' . $json_data[ '@id' ] );
				}

			/**
			 * Filters may return an @id as a way to signal a change to the schema type.
			 */
			} elseif ( $json_data[ '@id' ] !== $default_id ) {

				if ( $wpsso->debug->enabled ) {
					$wpsso->debug->log( 'previous @id property is ' . $json_data[ '@id' ] );
				}

				if ( false !== ( $id_pos = strpos( $json_data[ '@id' ], $id_anchor ) ) ) {

					$id_str = substr( $json_data[ '@id' ], $id_pos + strlen( $id_anchor ) );

					if ( preg_match_all( '/([^\/]+)/', $id_str, $all_matches, PREG_SET_ORDER ) ) {

						$has_type_id = false;

						foreach ( $all_matches as $match ) {

							if ( $match[1] === $type_id ) {
								$has_type_id = true;		// Found the original type id.
							}

							$page_type_added[ $match[ 1 ] ] = true;	// Prevent duplicate schema types.
						}

						if ( ! $has_type_id ) {

							$json_data[ '@id' ] .= $id_separator . $type_id;	// Append the original type id.

							if ( $wpsso->debug->enabled ) {
								$wpsso->debug->log( 'modified @id is ' . $json_data[ '@id' ] );
							}
						}
					}
				}
			}
		}

		/**
		 * Sanitation used by filters to return their data.
		 */
		public static function return_data_from_filter( $json_data, $merge_data, $is_main = false ) {

			if ( ! $is_main || ! empty( $merge_data[ 'mainEntity' ] ) ) {

				unset( $json_data[ 'mainEntity' ] );
				unset( $json_data[ 'mainEntityOfPage' ] );

			} else {
				if ( ! isset( $merge_data[ 'mainEntityOfPage' ] ) ) {
					if ( ! empty( $merge_data[ 'url' ] ) ) {
						$merge_data[ 'mainEntityOfPage' ] = $merge_data[ 'url' ];
					}
				}
			}

			if ( empty( $merge_data ) ) {	// Just in case - nothing to merge.

				return $json_data;

			} elseif ( null === $json_data ) {	// Just in case - nothing to merge.

				return $merge_data;

			} elseif ( is_array( $json_data ) ) {

				$json_head = array(
					'@id'              => null,
					'@context'         => null,
					'@type'            => null,
					'mainEntityOfPage' => null,
				);

				$json_data = array_merge( $json_head, $json_data, $merge_data );

				foreach ( $json_head as $prop_name => $prop_val ) {
					if ( empty( $json_data[ $prop_name ] ) ) {
						unset( $json_data[ $prop_name ] );
					}
				}

				return $json_data;

			} else {
				return $json_data;
			}
		}
	}
}
