<?php

class Smartcrawl_Onpage_Settings extends Smartcrawl_Settings_Admin {

	const PT_ARCHIVE_PREFIX = 'pt-archive-';
	private static $_instance;

	public static function get_instance() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Validate submitted options
	 *
	 * @param array $input Raw input
	 *
	 * @return array Validated input
	 */
	public function validate( $input ) {
		$result = array();

		// Setup
		if ( ! empty( $input['wds_onpage-setup'] ) ) {
			$result['wds_onpage-setup'] = true;
		}

		foreach ( array( 'main_blog_archive', 'search', 'bp_groups', 'bp_profile' ) as $type ) {
			// Meta robots
			if ( ! empty( $input["meta_robots-noindex-$type"] ) ) {
				$result["meta_robots-noindex-$type"] = true;
			}
			if ( ! empty( $input["meta_robots-nofollow-$type"] ) ) {
				$result["meta_robots-nofollow-$type"] = true;
			}
			if ( ! empty( $input["meta_robots-$type-subsequent_pages"] ) ) {
				$result["meta_robots-$type-subsequent_pages"] = true;
			}
		}

		$tax_options = $this->_get_tax_options( '' );
		foreach ( $tax_options as $option => $_tax ) {
			$rbts = $this->get_robots_options_for( $option );
			if ( ! empty( $rbts ) && is_array( $rbts ) ) {
				foreach ( array_keys( $rbts ) as $item ) {
					if ( ! empty( $input[ $item ] ) ) {
						$result[ $item ] = true;
					}
				}
			}
		}
		$other_options = $this->_get_other_types_options( '' );
		foreach ( $other_options as $option => $_tax ) {
			$rbts = $this->get_robots_options_for( $option );
			if ( ! empty( $rbts ) && is_array( $rbts ) ) {
				foreach ( array_keys( $rbts ) as $item ) {
					if ( ! empty( $input[ $item ] ) ) {
						$result[ $item ] = true;
					}
				}
			}
		}

		$archive_post_types = smartcrawl_get_archive_post_types();
		foreach ( $archive_post_types as $archive_post_type ) {
			$archive_pt_robot_options = $this->get_robots_options_for( $archive_post_type );

			foreach ( array_keys( $archive_pt_robot_options ) as $archive_pt_robot_option ) {
				if ( ! empty( $input[ $archive_pt_robot_option ] ) ) {
					$result[ $archive_pt_robot_option ] = true;
				}
			}
		}

		// String values
		$strings = array(
			'home',
			'search',
			'404',
			'bp_groups',
			'bp_profile',
		);
		foreach ( get_post_types( array( 'public' => true ) ) as $pt ) {
			$strings[] = $pt;
			// Allow post types robots noindex/nofollow
			if ( ! empty( $input["meta_robots-noindex-{$pt}"] ) ) {
				$result["meta_robots-noindex-{$pt}"] = true;
			}
			if ( ! empty( $input["meta_robots-nofollow-{$pt}"] ) ) {
				$result["meta_robots-nofollow-{$pt}"] = true;
			}
		}
		$strings = array_merge( $strings, array_values( $tax_options ) );
		$strings = array_merge( $strings, array_values( $other_options ) );
		$strings = array_merge( $strings, $archive_post_types );

		foreach ( $strings as $str ) {
			if ( isset( $input["title-{$str}"] ) ) {
				$result["title-{$str}"] = smartcrawl_sanitize_preserve_macros( $input["title-{$str}"] );
			}
			if ( isset( $input["metadesc-{$str}"] ) ) {
				$result["metadesc-{$str}"] = smartcrawl_sanitize_preserve_macros( $input["metadesc-{$str}"] );
			}

			// OpenGraph
			if ( isset( $input["og-active-{$str}"] ) ) {
				$result["og-active-{$str}"] = (boolean) $input["og-active-{$str}"];
			}
			if ( isset( $input["og-title-{$str}"] ) ) {
				$result["og-title-{$str}"] = smartcrawl_sanitize_preserve_macros( $input["og-title-{$str}"] );
			}
			if ( isset( $input["og-description-{$str}"] ) ) {
				$result["og-description-{$str}"] = smartcrawl_sanitize_preserve_macros( $input["og-description-{$str}"] );
			}

			$result["og-images-{$str}"] = array();
			if ( ! empty( $input["og-images-{$str}"] ) && is_array( $input["og-images-{$str}"] ) ) {
				foreach ( $input["og-images-{$str}"] as $img ) {
					$result["og-images-{$str}"][] = is_numeric( $img ) ? intval( $img ) : esc_url( $img );
				}
			}
			$result["og-images-{$str}"] = array_values( array_filter( array_unique( $result["og-images-{$str}"] ) ) );
			if ( isset( $input["og-disable-first-image-{$str}"] ) ) {
				$result["og-disable-first-image-{$str}"] = (boolean) $input["og-disable-first-image-{$str}"];
			}

			// Twitter cards
			if ( isset( $input["twitter-active-{$str}"] ) ) {
				$result["twitter-active-{$str}"] = (boolean) $input["twitter-active-{$str}"];
			}
			if ( isset( $input["twitter-title-{$str}"] ) ) {
				$result["twitter-title-{$str}"] = smartcrawl_sanitize_preserve_macros( $input["twitter-title-{$str}"] );
			}
			if ( isset( $input["twitter-description-{$str}"] ) ) {
				$result["twitter-description-{$str}"] = smartcrawl_sanitize_preserve_macros( $input["twitter-description-{$str}"] );
			}

			$result["twitter-images-{$str}"] = array();
			if ( ! empty( $input["twitter-images-{$str}"] ) && is_array( $input["twitter-images-{$str}"] ) ) {
				foreach ( $input["twitter-images-{$str}"] as $img ) {
					$result["twitter-images-{$str}"][] = is_numeric( $img ) ? intval( $img ) : esc_url( $img );
				}
			}
			$result["twitter-images-{$str}"] = array_values( array_filter( array_unique( $result["twitter-images-{$str}"] ) ) );
			if ( isset( $input["twitter-disable-first-image-{$str}"] ) ) {
				$result["twitter-disable-first-image-{$str}"] = (boolean) $input["twitter-disable-first-image-{$str}"];
			}
		}

		$result['enable-author-archive'] = isset( $input['enable-author-archive'] )
			? (boolean) $input['enable-author-archive']
			: false;
		$result['enable-date-archive'] = isset( $input['enable-date-archive'] )
			? (boolean) $input['enable-date-archive']
			: false;

		if ( isset( $input['preset-separator'] ) ) {
			$result['preset-separator'] = sanitize_text_field( $input['preset-separator'] );
		}

		if ( isset( $input['separator'] ) ) {
			$result['separator'] = sanitize_text_field( $input['separator'] );
		}

		$result = $this->sanitize_and_include_char_lengths(
			$result,
			$input,
			'custom_title_char_lengths',
			'custom_title_min_length',
			'custom_title_max_length',
			SMARTCRAWL_TITLE_DEFAULT_MIN_LENGTH,
			SMARTCRAWL_TITLE_DEFAULT_MAX_LENGTH
		);

		$result = $this->sanitize_and_include_char_lengths(
			$result,
			$input,
			'custom_metadesc_char_lengths',
			'custom_metadesc_min_length',
			'custom_metadesc_max_length',
			SMARTCRAWL_METADESC_DEFAULT_MIN_LENGTH,
			SMARTCRAWL_METADESC_DEFAULT_MAX_LENGTH
		);

		return $result;
	}

	private function sanitize_and_include_char_lengths( $result, $input, $toggle_name, $min_field_name, $max_field_name, $default_min, $default_max ) {
		$result[ $toggle_name ] = ! empty( $input[ $toggle_name ] );
		$custom_title_min_length = (int) smartcrawl_get_array_value( $input, $min_field_name );
		if ( $custom_title_min_length > 0 ) {
			$result[ $min_field_name ] = $custom_title_min_length;
		} else {
			$result[ $min_field_name ] = $default_min;
			add_settings_error( $this->option_name, 'min-limit-invalid', __( 'Min length invalid' ) );
		}
		$custom_title_max_length = (int) smartcrawl_get_array_value( $input, $max_field_name );
		if ( $custom_title_max_length ) {
			$result[ $max_field_name ] = $custom_title_max_length;
		} else {
			$result[ $max_field_name ] = $default_max;
			add_settings_error( $this->option_name, 'max-limit-invalid', __( 'Max length invalid' ) );
		}

		return $result;
	}

	/**
	 * Spawn taxonomy options and names, indexed by taxonomy option names
	 *
	 * @param string $pfx Prefix options with this
	 *
	 * @return array
	 */
	protected function _get_tax_options( $pfx = '' ) {
		$pfx = ! empty( $pfx ) ? rtrim( $pfx, '_' ) . '_' : $pfx;
		$opts = array();
		foreach ( get_taxonomies( array( '_builtin' => false ), 'objects' ) as $taxonomy ) {
			$name = $pfx . str_replace( '-', '_', $taxonomy->name );
			$opts[ $name ] = $taxonomy->name;
		}

		return $opts;
	}

	/**
	 * Spawns a set of robots options for a given type
	 *
	 * @param string $type Archives type to generate the robots options for
	 * @param bool $include_subsequent_pages_option Whether to include the subsequent pages option.
	 *
	 * @return array Generated meta robots option array
	 */
	public static function get_robots_options_for( $type, $include_subsequent_pages_option = true, $context = '' ) {
		$options = array(
			"meta_robots-noindex-{$type}"  => array(
				'label'            => sprintf( '%s %s', esc_html__( 'Index', 'wds' ), $context ),
				'description'      => esc_html__( 'Disabling indexing means that this content will not be indexed and searchable in search engines.', 'wds' ),
				'inverted'         => true,
				'html_description' => self::sitemap_notice( $type ),
			),
			"meta_robots-nofollow-{$type}" => array(
				'label'       => sprintf( '%s %s', esc_html__( 'Follow', 'wds' ), $context ),
				'description' => esc_html__( 'Disabling following means search engines will not follow and crawl links it finds in this content.', 'wds' ),
				'inverted'    => true,
			),
		);

		if ( $include_subsequent_pages_option ) {
			$options["meta_robots-{$type}-subsequent_pages"] = array(
				'label'       => esc_html__( 'Apply to all pages except the first', 'wds' ),
				'description' => esc_html__( 'If you select this option, the first page will be left alone, but the indexing settings will be applied to subsequent pages.', 'wds' ),
			);
		}

		return $options;
	}

	private static function sitemap_notice( $type ) {
		$sitemap_enabled = Smartcrawl_Sitemap_Utils::sitemap_enabled();
		if ( ! $sitemap_enabled ) {
			return '';
		}

		$message = smartcrawl_format_link(
			esc_html__( 'You might want to exclude this type from the %s as well.', 'wds' ),
			Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_SITEMAP ),
			esc_html__( 'sitemap', 'wds' )
		);
		$options = Smartcrawl_Settings::get_options();
		$indexed = empty( $options["meta_robots-noindex-{$type}"] );
		$class = 'sui-notice-info';
		if ( $indexed ) {
			$class .= ' hidden';
		}

		return Smartcrawl_Simple_Renderer::load( 'notice', array(
			'class'   => $class,
			'message' => $message,
		) );
	}

	/**
	 * Spawn taxonomy options and names, indexed by taxonomy option names
	 *
	 * @param string $pfx Prefix options with this
	 *
	 * @return array
	 */
	protected function _get_other_types_options( $pfx = '' ) {
		$pfx = ! empty( $pfx ) ? rtrim( $pfx, '_' ) . '_' : $pfx;
		$opts = array();
		$other_types = array(
			'category',
			'post_tag',
			'author',
			'date',
		);
		foreach ( $other_types as $value ) {
			$name = $pfx . $value;
			$opts[ $name ] = $value;
		}

		return $opts;
	}

	protected function _get_other_types_options_context( $pfx = '' ) {
		$context_strings = array();
		foreach ( $this->_get_other_types_options( '' ) as $option ) {
			$context = '';

			if ( in_array( $option, array( 'category', 'post_tag' ), true ) ) {
				$tax_object = get_taxonomy( $option );
				$context = strtolower( $tax_object->label );
			} elseif ( 'author' === $option ) {
				$context = esc_html__( 'author archives' );
			} elseif ( 'date' === $option ) {
				$context = esc_html__( 'date archives' );
			}

			$context_strings[ $pfx . $option ] = $context;
		}

		return $context_strings;
	}

	public function init() {
		$this->option_name = 'wds_onpage_options';
		$this->name = Smartcrawl_Settings::COMP_ONPAGE;
		$this->slug = Smartcrawl_Settings::TAB_ONPAGE;
		$this->action_url = admin_url( 'options.php' );
		$this->page_title = __( 'SmartCrawl Wizard: Title & Meta', 'wds' );

		add_action( 'wp_ajax_wds-onpage-preview', array( $this, 'json_create_preview' ) );
		add_action( 'wp_ajax_wds-onpage-save-static-home', array( $this, 'json_save_static_homepage_meta' ) );

		parent::init();

	}

	public function get_title() {
		return __( 'Title & Meta', 'wds' );
	}

	/**
	 * Preview building handler
	 */
	public function json_create_preview() {
		$data = $this->get_request_data();

		$src_type = ! empty( $data['type'] ) ? sanitize_text_field( $data['type'] ) : false;
		$src_title = ! empty( $data['title'] ) ? smartcrawl_sanitize_preserve_macros( $data['title'] ) : false;
		$src_meta = ! empty( $data['description'] ) ? smartcrawl_sanitize_preserve_macros( $data['description'] ) : false;

		$updated = false;

		$link = home_url();
		$title = get_bloginfo( 'name' );
		$description = get_bloginfo( 'description' );

		$warnings = array();
		$resolver = Smartcrawl_Endpoint_Resolver::resolve();

		switch ( $src_type ) {
			case 'search-page':
				set_query_var( 's', 'Example search phrase' );
				$resolver->set_location( Smartcrawl_Endpoint_Resolver::L_SEARCH );
				break;

			case 'author-archive':
				set_query_var( 'author', get_current_user_id() );
				$resolver->set_location( Smartcrawl_Endpoint_Resolver::L_AUTHOR_ARCHIVE );
				break;

			case 'date-archive':
				set_query_var( 'monthnum', 3 );
				set_query_var( 'year', 2018 );
				$resolver->set_location( Smartcrawl_Endpoint_Resolver::L_DATE_ARCHIVE );
				break;

			case 'homepage':
				$resolver->set_location( Smartcrawl_Endpoint_Resolver::L_BLOG_HOME );
				break;

			case '404-page':
				$resolver->set_location( Smartcrawl_Endpoint_Resolver::L_404 );
				break;

			case 'static-homepage':
				$front_page = get_post( (int) get_option( 'page_on_front' ) );
				$resolver->simulate( Smartcrawl_Endpoint_Resolver::L_SINGULAR, is_a( $front_page, 'WP_Post' ) ? $front_page : null );

				if ( empty( trim( $src_title ) ) ) {
					$src_title = Smartcrawl_Meta_Value_Helper::get()->get_title();
				}
				if ( empty( trim( $src_meta ) ) ) {
					$src_meta = Smartcrawl_Meta_Value_Helper::get()->get_description();
				}

				$title = Smartcrawl_Replacement_Helper::replace( $src_title, $front_page );
				$description = Smartcrawl_Replacement_Helper::replace( $src_meta, $front_page );
				$link = get_home_url();
				$updated = true;

				$resolver->stop_simulation();
				break;

			case 'bp-group':
				$group = $this->_get_random_bp_group();
				if ( ! empty( $group ) ) {
					$title = Smartcrawl_Replacement_Helper::replace( $src_title, $group );
					$description = Smartcrawl_Replacement_Helper::replace( $src_meta, $group );
					$link = bp_get_group_permalink( $group );
				}
				$updated = true;
				break;

			case 'bp-profile':
				$bp_profile_args = array(
					'bp_user_full_name' => bp_get_loggedin_user_fullname(),
					'bp_user_username'  => bp_get_loggedin_user_username(),
				);

				$title = Smartcrawl_Replacement_Helper::replace( $src_title, $bp_profile_args );
				$description = Smartcrawl_Replacement_Helper::replace( $src_meta, $bp_profile_args );
				$link = bp_loggedin_user_domain();
				$updated = true;
				break;

			default:
				break;
		}

		// Custom post type?
		if ( ! $updated ) {
			foreach ( get_post_types( array( 'public' => true ) ) as $type ) {
				if ( $type !== $src_type ) {
					continue;
				}

				$updated = true;
				$post = $this->_get_random_post( $type );
				if ( ! empty( $post ) ) {
					$title = Smartcrawl_Replacement_Helper::replace( $src_title, $post );
					$description = Smartcrawl_Replacement_Helper::replace( $src_meta, $post );
					$link = get_permalink( $post->ID );
				}
			}
		}

		if ( ! $updated ) {
			$archive_post_type_prefix = self::PT_ARCHIVE_PREFIX;
			foreach ( smartcrawl_get_archive_post_types() as $archive_post_type ) {
				if ( $archive_post_type !== $src_type ) {
					continue;
				}

				$updated = true;
				$archive_pt = str_replace( $archive_post_type_prefix, '', $archive_post_type );

				$title = Smartcrawl_Replacement_Helper::replace( $src_title, get_post_type_object( $archive_pt ) );
				$description = Smartcrawl_Replacement_Helper::replace( $src_meta, get_post_type_object( $archive_pt ) );
				$link = get_post_type_archive_link( $archive_pt );
			}
		}

		// Custom taxonomy?
		if ( ! $updated ) {
			foreach ( get_taxonomies() as $tax ) {
				if ( $tax !== $src_type ) {
					continue;
				}

				$updated = true;
				$term = $this->_get_random_term( $tax );
				if ( ! empty( $term ) ) {
					$title = Smartcrawl_Replacement_Helper::replace( $src_title, $term );
					$description = Smartcrawl_Replacement_Helper::replace( $src_meta, $term );
					$link = get_term_link( $term->term_id, $tax );
				}
			}
		}

		if ( ! $updated ) {
			$title = Smartcrawl_Replacement_Helper::replace( $src_title );
			$description = Smartcrawl_Replacement_Helper::replace( $src_meta );
			$updated = true;
		}

		// TODO: use mb functions for length?
		if ( strlen( $title ) > smartcrawl_title_max_length() ) {
			$warnings['title'] = __( 'Your title seems to be a bit on the long side, consider trimming it', 'wds' );
		}
		if ( strlen( $description ) > smartcrawl_metadesc_max_length() ) {
			$warnings['description'] = __( 'Your description seems to be a bit on the long side, consider trimming it', 'wds' );
		}

		wp_send_json( array(
			'status'   => $updated,
			'markup'   => $this->_load( 'onpage/onpage-preview', array(
				'link'        => $link,
				'title'       => $title,
				'description' => $description,
			) ),
			'warnings' => $warnings,
		) );
	}

	public function json_save_static_homepage_meta() {
		$request_data = $this->get_request_data();
		$front_page = get_post( (int) get_option( 'page_on_front' ) );

		$title = smartcrawl_get_array_value( $request_data, array( 'wds_onpage_options', 'title-static-home' ) );
		if ( $title ) {
			update_post_meta( $front_page->ID, '_wds_title', smartcrawl_sanitize_preserve_macros( $title ) );
		} else {
			delete_post_meta( $front_page->ID, '_wds_title' );
		}

		$description = smartcrawl_get_array_value( $request_data, array(
			'wds_onpage_options',
			'metadesc-static-home',
		) );
		if ( $description ) {
			update_post_meta( $front_page->ID, '_wds_metadesc', smartcrawl_sanitize_preserve_macros( $description ) );
		} else {
			delete_post_meta( $front_page->ID, '_wds_metadesc' );
		}

		$metabox = Smartcrawl_Metabox::get();
		$metabox->save_opengraph_meta(
			$front_page->ID,
			stripslashes_deep( $request_data['wds-opengraph'] )
		);
		$metabox->save_twitter_post_meta(
			$front_page->ID,
			stripslashes_deep( $request_data['wds-twitter'] )
		);
		$metabox->save_robots_meta( $front_page, $request_data );

		wp_send_json( array( 'success' => true ) );
	}

	private function _get_random_bp_group() {
		$groups = groups_get_groups( array(
			'orderby'  => 'random',
			'per_page' => 1,
		) );

		$total = isset( $groups['total'] ) ? $groups['total'] : 0;
		$groups = isset( $groups['groups'] ) ? $groups['groups'] : array();

		return $total > 0 ? $groups[0] : null;
	}

	/**
	 * Randomly spawns a post of certain post type
	 *
	 * @param string $type Post type
	 *
	 * @return WP_Post
	 */
	private function _get_random_post( $type = 'post' ) {
		$args = array(
			'posts_per_page' => 1,
			'post_type'      => $type,
			'orderby'        => 'random',
		);
		if ( 'attachment' === $type ) {
			$args['post_status'] = 'any';
		}
		$q = new WP_Query( $args );

		return ! empty( $q->post )
			? $q->post
			: null;
	}

	/**
	 * Spawn a random taxonomy term for a tax type
	 *
	 * @param string $type Taxonomy type
	 *
	 * @return WP_Term
	 */
	private function _get_random_term( $type = 'category' ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $type,
				'hide_empty' => 0,
			)
		);
		if ( empty( $terms ) ) {
			return null;
		}

		shuffle( $terms );

		return $terms[0];
	}

	/**
	 * Add admin settings page
	 */
	public function options_page() {
		parent::options_page();

		$smartcrawl_options = Smartcrawl_Settings::get_options();

		$arguments = array(
			'meta_robots_main_blog_archive' => self::get_robots_options_for( 'main_blog_archive', true, esc_html__( 'this website' ) ),
		);

		foreach ( $this->_get_tax_options( 'meta_robots_' ) as $option => $tax ) {
			$tax = str_replace( '-', '_', $tax );
			$tax_object = get_taxonomy( $tax );
			if ( empty( $arguments[ $option ] ) ) {
				$tax_label = empty( $tax_object->label ) ? '' : $tax_object->label;
				$arguments[ $option ] = self::get_robots_options_for( $tax, true, strtolower( $tax_label ) );
			}
		}

		foreach ( $this->_get_other_types_options( 'meta_robots_' ) as $option => $value ) {
			$context_strings = $this->_get_other_types_options_context( 'meta_robots_' );
			if ( empty( $arguments[ $option ] ) ) {
				$arguments[ $option ] = self::get_robots_options_for( $value, true, smartcrawl_get_array_value( $context_strings, $option ) );
			}
		}

		$archive_post_types = smartcrawl_get_archive_post_type_labels();
		foreach ( $archive_post_types as $archive_post_type => $archive_post_type_label ) {
			$pt_archive_context = sprintf( esc_html__( '%s archive' ), strtolower( $archive_post_type_label ) );
			$arguments['archive_post_type_robots'][ $archive_post_type ] = self::get_robots_options_for( $archive_post_type, true, $pt_archive_context );
		}
		$arguments['archive_post_types'] = $archive_post_types;

		$arguments['meta_robots_search'] = self::get_robots_options_for(
			'search',
			false,
			esc_html__( 'search page' )
		);

		// Allow for post type options
		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $post_type ) {
			/**
			 * @var $post_type WP_Post_Type
			 */
			$arguments['post_robots'][ $post_type->name ] = self::get_robots_options_for( $post_type->name, false, strtolower( $post_type->label ) );
		}

		$arguments['radio_options'] = array(
			__( 'No', 'wds' ),
			__( 'Yes', 'wds' ),
		);

		$arguments['engines'] = array(
			'ping-google' => __( 'Google', 'wds' ),
			'ping-bing'   => __( 'Bing', 'wds' ),
		);

		$arguments['separators'] = smartcrawl_get_separators();

		$is_sitewide = is_multisite() && smartcrawl_is_switch_active( 'SMARTCRAWL_SITEWIDE' );
		$static_homepage = 'page' === get_option( 'show_on_front' );
		$front_page = get_post( (int) get_option( 'page_on_front' ) );
		$show_static_home_settings = ! $is_sitewide && $static_homepage && $front_page;

		$arguments['front_page'] = $front_page;
		$arguments['front_page_notice'] = $this->static_frontpage_notice( $front_page );
		$arguments['show_static_home_settings'] = $show_static_home_settings;
		$default_tab = $show_static_home_settings ? 'tab_static_homepage' : 'tab_homepage';

		$arguments['active_tab'] = $this->_get_active_tab( $default_tab );

		$arguments['meta_robots_bp_groups'] = self::get_robots_options_for(
			'bp_groups',
			false,
			esc_html__( 'BuddyPress groups' )
		);

		$arguments['meta_robots_bp_profile'] = self::get_robots_options_for(
			'bp_profile',
			false,
			esc_html__( 'BuddyPress profile' )
		);

		wp_enqueue_script( Smartcrawl_Controller_Assets::ONPAGE_JS );
		$this->_render_page( 'onpage/onpage-settings', $arguments );
	}

	private function static_frontpage_notice( $front_page ) {
		ob_start();
		esc_html_e( 'Your homepage is set to a static page, Homepage. You can edit your homepage meta from here, as well as in the WordPress editor for that page.', 'wds' );
		if ( $front_page ) {
			?>
			<br/>
			<a type="button"
			   href="<?php echo esc_attr( get_edit_post_link( $front_page ) ); ?>"
			   class="sui-button" style="margin-top: 10px">
				<?php esc_html_e( 'Go To Homepage', 'wds' ); ?></a>
			<?php
		}

		return $this->_load( 'notice', array(
			'message' => ob_get_clean(),
			'class'   => 'sui-notice-info',
		) );
	}

	public static function get_singular_macros( $post_type = '' ) {
		$singular_macros = array(
			'%%id%%'               => __( 'Post/page ID', 'wds' ),
			'%%title%%'            => __( 'Title of the post/page', 'wds' ),
			'%%excerpt%%'          => __( 'Post/page excerpt (or auto-generated if it does not exist)', 'wds' ),
			'%%excerpt_only%%'     => __( 'Post/page excerpt (without auto-generation)', 'wds' ),
			'%%modified%%'         => __( 'Post/page modified time', 'wds' ),
			'%%date%%'             => __( 'Date of the post/page', 'wds' ),
			'%%name%%'             => __( "Post/page author's 'nicename'", 'wds' ),
			'%%userid%%'           => __( "Post/page author's userid", 'wds' ),
			'%%user_description%%' => __( "Post/page author's description", 'wds' ),
		);

		if ( empty( $post_type ) || $post_type === 'attachment' ) {
			$singular_macros['%%caption%%'] = __( 'Attachment caption', 'wds' );
		}

		if ( empty( $post_type ) || $post_type === 'post' ) {
			$singular_macros['%%category%%'] = __( 'Post categories (comma separated)', 'wds' );
			$singular_macros['%%tag%%'] = __( 'Current tag/tags', 'wds' );
		}

		return $singular_macros;
	}

	/**
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	public static function get_term_macros( $taxonomy = '' ) {
		$term_macros = array(
			'%%id%%'               => __( 'Term ID', 'wds' ),
			'%%term_title%%'       => __( 'Term name', 'wds' ),
			'%%term_description%%' => __( 'Term description', 'wds' ),
		);

		if ( empty( $taxonomy ) || $taxonomy === 'category' ) {
			$term_macros['%%category%%'] = __( 'Category name', 'wds' );
			$term_macros['%%category_description%%'] = __( 'Category description', 'wds' );
		}

		if ( empty( $taxonomy ) || $taxonomy === 'post_tag' ) {
			$term_macros['%%tag%%'] = __( 'Tag name', 'wds' );
			$term_macros['%%tag_description%%'] = __( 'Tag description', 'wds' );
		}

		return $term_macros;
	}

	public static function get_general_macros() {
		return array(
			'%%sep%%'              => __( 'Separator', 'wds' ),
			'%%sitename%%'         => __( "Site's name", 'wds' ),
			'%%sitedesc%%'         => __( "Site's tagline / description", 'wds' ),
			'%%page%%'             => __( 'Current page number (i.e. page 2 of 4)', 'wds' ),
			'%%pagetotal%%'        => __( 'Current page total', 'wds' ),
			'%%pagenumber%%'       => __( 'Current page number', 'wds' ),
			'%%spell_pagenumber%%' => __( 'Current page number, spelled out as numeral in English', 'wds' ),
			'%%spell_pagetotal%%'  => __( 'Current page total, spelled out as numeral in English', 'wds' ),
			'%%spell_page%%'       => __( 'Current page number, spelled out as numeral in English', 'wds' ),
			'%%currenttime%%'      => __( 'Current time', 'wds' ),
			'%%currentdate%%'      => __( 'Current date', 'wds' ),
			'%%currentmonth%%'     => __( 'Current month', 'wds' ),
			'%%currentyear%%'      => __( 'Current year', 'wds' ),
		);
	}

	public static function get_bp_profile_macros() {
		$bp_macros = array(
			'%%bp_user_username%%'  => __( 'BuddyPress username', 'wds' ),
			'%%bp_user_full_name%%' => __( "BuddyPress user's full name", 'wds' ),
		);

		return $bp_macros;
	}

	public static function get_bp_group_macros() {
		$bp_macros = array(
			'%%bp_group_name%%'        => __( 'BuddyPress group name', 'wds' ),
			'%%bp_group_description%%' => __( 'BuddyPress group description', 'wds' ),
		);

		return $bp_macros;
	}

	public static function get_pt_archive_macros() {
		return array(
			'%%pt_plural%%' => __( 'Post type label plural' ),
			'%%pt_single%%' => __( 'Post type label singular' ),
		);
	}

	public static function get_search_macros() {
		return array(
			'%%searchphrase%%' => __( 'Current search phrase', 'wds' ),
		);
	}

	public static function get_author_macros() {
		return array(
			'%%name%%'             => __( "Author's 'nicename'", 'wds' ),
			'%%userid%%'           => __( "Author's userid", 'wds' ),
			'%%user_description%%' => __( "Author's description", 'wds' ),
		);
	}

	public static function get_date_macros() {
		return array(
			'%%date%%' => __( 'Date of the archive', 'wds' ),
		);
	}

	/**
	 * Default settings
	 */
	public function defaults() {

		if ( is_multisite() && SMARTCRAWL_SITEWIDE ) {
			$this->options = get_site_option( $this->option_name );
		} else {
			$this->options = get_option( $this->option_name );
		}

		if ( empty( $this->options['title-home'] ) ) {
			$this->options['title-home'] = '%%sitename%%';
		}

		if ( empty( $this->options['metadesc-home'] ) ) {
			$this->options['metadesc-home'] = '%%sitedesc%%';
		}

		if ( empty( $this->options['onpage-stylesheet'] ) ) {
			$this->options['onpage-stylesheet'] = 0;
		}

		if ( empty( $this->options['onpage-dashboard-widget'] ) ) {
			$this->options['onpage-dashboard-widget'] = 1;
		}

		if ( empty( $this->options['onpage-disable-automatic-regeneration'] ) ) {
			$this->options['onpage-disable-automatic-regeneration'] = 0;
		}

		foreach ( get_post_types( array( 'public' => true ) ) as $posttype ) {
			if ( in_array( $posttype, array( 'revision', 'nav_menu_item' ), true ) ) {
				continue;
			}
			if ( preg_match( '/^upfront_/', $posttype ) ) {
				continue;
			}

			$type_obj = get_post_type_object( $posttype );
			if ( ! is_object( $type_obj ) ) {
				continue;
			}

			if ( empty( $this->options[ 'title-' . $posttype ] ) ) {
				$this->options[ 'title-' . $posttype ] = '%%title%% %%sep%% %%sitename%%';
			}

			if ( empty( $this->options[ 'metadesc-' . $posttype ] ) ) {
				$this->options[ 'metadesc-' . $posttype ] = '%%excerpt%%';
			}
		}

		foreach ( smartcrawl_get_archive_post_types() as $archive_post_type ) {
			if ( empty( $this->options[ 'title-' . $archive_post_type ] ) ) {
				$this->options[ 'title-' . $archive_post_type ] = '%%pt_plural%% %%sep%% %%sitename%%';
			}
		}

		foreach ( get_taxonomies( array( '_builtin' => false ), 'objects' ) as $taxonomy ) {
			if ( empty( $this->options[ 'title-' . $taxonomy->name ] ) ) {
				$this->options[ 'title-' . $taxonomy->name ] = '';
			}

			if ( empty( $this->options[ 'metadesc-' . $taxonomy->name ] ) ) {
				$this->options[ 'metadesc-' . $taxonomy->name ] = '';
			}
		}

		$other_types = array(
			'category'   => array(
				'title' => '%%category%% %%sep%% %%sitename%%',
				'desc'  => '%%category_description%%',
			),
			'post_tag'   => array(
				'title' => '%%tag%% %%sep%% %%sitename%%',
				'desc'  => '%%tag_description%%',
			),
			'author'     => array(
				'title' => '%%name%% %%sep%% %%sitename%%',
				'desc'  => '%%user_description%%',
			),
			'date'       => array(
				'title' => '%%currentdate%% %%sep%% %%sitename%%',
				'desc'  => '',
			),
			'search'     => array(
				'title' => '%%searchphrase%% %%sep%% %%sitename%%',
				'desc'  => '',
			),
			'404'        => array(
				'title' => 'Page not found %%sep%% %%sitename%%',
				'desc'  => '',
			),
			'bp_groups'  => array(
				'title' => '%%bp_group_name%% %%sep%% %%sitename%%',
				'desc'  => '%%bp_group_description%%',
			),
			'bp_profile' => array(
				'title' => '%%bp_user_username%% %%sep%% %%sitename%%',
				'desc'  => '%%bp_user_full_name%%',
			),
		);

		foreach ( $other_types as $key => $value ) {
			if ( empty( $this->options[ 'title-' . $key ] ) ) {
				$this->options[ 'title-' . $key ] = $value['title'];
			}

			if ( empty( $this->options[ 'metadesc-' . $key ] ) ) {
				$this->options[ 'metadesc-' . $key ] = $value['desc'];
			}
		}

		if ( ! isset( $this->options['preset-separator'] ) ) {
			$this->options['preset-separator'] = 'pipe';
		}

		if ( ! isset( $this->options['separator'] ) ) {
			$this->options['separator'] = '';
		}

		if ( ! isset( $this->options['enable-author-archive'] ) ) {
			$this->options['enable-author-archive'] = true;
		}

		if ( ! isset( $this->options['enable-date-archive'] ) ) {
			$this->options['enable-date-archive'] = true;
		}

		if ( is_multisite() && SMARTCRAWL_SITEWIDE ) {
			update_site_option( $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}

	}

	/**
	 * @return array
	 */
	private function get_request_data() {
		return isset( $_POST['_wds_nonce'] ) && wp_verify_nonce( $_POST['_wds_nonce'], 'wds-onpage-nonce' ) ? $_POST : array();
	}
}