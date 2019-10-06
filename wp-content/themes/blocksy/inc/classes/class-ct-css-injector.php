<?php
/**
 * CSS Injector
 * Helper object for including dynamic styles into head of the document,
 * with possibilities of extending it.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

defined( 'ABSPATH' ) || die( "Don't run this file directly!" );

/**
 * Object that is responsible for generating a call tree for dynamic CSS.
 */
class Blocksy_Css_Injector {
	/**
	 * Dynamic CSS for header.
	 *
	 * @var string $content CSS output.
	 */
	private $content = '';

	/**
	 * CSS selector to prefix each rule.
	 *
	 * @var string|null $css_selector_prefix actual prefix or null;
	 */
	private $css_selector_prefix = null;

	/**
	 * Temporary CSS attributes.
	 *
	 * @var array $attr Attributes.
	 */
	private $attr = array();

	/**
	 * Multiple Class
	 *
	 * @var array $tree Structure.
	 */
	private $tree = array();

	/**
	 * Keyword that allows skiping a certain CSS rule from getting in the output.
	 */
	public static function get_skip_rule_keyword() {
		return 'CT_CSS_SKIP_RULE';
	}

	/**
	 * Injector constructor.
	 */
	public function __construct() {
		$this->additional_symbols = array( '-', '%', 'px', 's' );
	}

	/**
	 * Prefix each selector.
	 *
	 * @param string $prefix Prefix for the CSS selectors.
	 */
	public function set_prefix( $prefix ) {
		$this->css_selector_prefix = $prefix;
	}

	/**
	 * Finish prefixing each selector.
	 */
	public function clear_prefix() {
		$this->css_selector_prefix = null;
	}

	/**
	 * Convert all to CSS and add to header.
	 */
	public function inject() {
		$this->build_css_structure();

		if ( empty( $this->content ) ) {
			return;
		}

		wp_add_inline_style(
			ct_get_handle_for_inline_css(),
			$this->content
		);
	}

	/**
	 * Parse each temporary structure and transform it into actual CSS.
	 */
	public function build_css_structure() {
		if ( count( $this->attr ) ) {
			$this->content .= "\n" . $this->convert_to_css();
		}

		if ( count( $this->tree ) ) {
			$this->content .= "\n" . $this->convert_tree_to_css();
		}

		$this->content = $this->css_minify( $this->content );

		return $this->content;
	}

	/**
	 * Prepare CSS before inserting.
	 *
	 * @param string $css CSS Structure.
	 */
	public function prepare_and_insert( $css ) {
		foreach ( $this->parse_media_blocks( $css ) as $media_block ) {
			$parts = explode( '{', $media_block );
			$media_query_selector = trim( $parts[0] );

			if ( ! isset( $this->attr[ $media_query_selector ] ) ) {
				$this->attr[ $media_query_selector ] = array();
			}

			$this->attr[ $media_query_selector ][] = trim(
				ltrim( rtrim( trim( $media_block ), '}' ), $media_query_selector . '{' )
			);
		}

		// Remove all media queries
		$css = trim( preg_replace( '/@media [^{]*{([^{}]|{[^{}]*})*}/', '', $css ) );

		$parts = explode( '}', $css );

		foreach ( $parts as $block ) {
			$block .= '}';

			// Get css path.
			preg_match( '#(.+?){#si', $block, $path );
			$path = ( isset( $path[1] ) ) ? trim( $path[1] ) : '';

			if ( ! $path ) {
				continue; }

			// Get structure.
			preg_match( '#{(.+?)}#si', $block, $structure );

			$structure = isset( $structure[1] ) ? trim( $structure[1] ) : '';

			if ( ! $structure ) {
				continue; }

			$sections = explode( ';', $structure );
			$result = [];

			foreach ( $sections as $line ) {
				$line = trim( $line );

				if ( $line ) {
					$result[] = $line;
				}
			}

			if ( count( $result ) ) {
				$this->put( $path, $result );
			}
		}
	}

	/**
	 * Add new line in CSS structure.
	 *
	 * @param string|array $key CSS class, id, tag.
	 * @param string|array $value CSS syntax.
	 */
	public function put( $key, $value ) {
		if (is_string($value) && trim($value) === '') {
			return;
		}

		if ($this->css_selector_prefix) {
			if (is_array($key)) {
				$new_key = [];

				foreach ($key as $nested_key) {
					$new_key[] = $this->css_selector_prefix . ' ' . $nested_key;
				}

				$key = $new_key;
			} else {
				$key = $this->css_selector_prefix . ' ' . $key;
			}
		}

		if (is_array($key)) {
			$key = implode(",\n", $key);
		}

		if (! isset($this->attr[$key])) {
			$this->attr[$key] = [];
		}

		$rules = [];

		// Convert string to array.
		if ( ! is_array( $value ) ) {
			$rules = explode( ';', $value );
		} else {
			/**
			 * Support nested rules.
			 */
			foreach ( $value as $maybe_rule ) {
				$current_rules = explode( ';', $maybe_rule );

				foreach ( $current_rules as $current_rule ) {
					$rules[] = $current_rule;
				}
			}
		}

		foreach ( $rules as $line ) {
			$line = trim( $line );

			if ( $line ) {
				if ( ! in_array( $line, $this->attr[ $key ], true ) ) {
					$this->attr[ $key ][] = $line;
				}
			}
		}

		$this->attr[ $key ] = $this->remove_dublication(
			$this->attr[ $key ]
		);
	}

	/**
	 * Repeat the same css-code for more classes.
	 *
	 * @param array $keys An array of selectors.
	 * @param string $value The CSS value for each selector.
	 */
	public function multi_put( $keys, $value ) {
		if ( ! is_array( $keys ) ) {
			return;
		}

		if ( ! count( $keys ) ) {
			return;
		}

		foreach ( $keys as $name ) {
			$this->put( $name, $value );
		}
	}

	/**
	 * Add a set of rules inside a nested block.
	 *
	 * @param string $parent Block name.
	 * @param array $child Block contents.
	 */
	public function point( $parent, $child ) {
		$parent = trim( $parent );
		$child = trim( $child );

		if ( ! isset( $this->tree[ $parent ] ) ) {
			$this->tree[ $parent ] = [];
		}

		if ( ! isset( $this->tree[ $parent ][ $child ] ) ) {
			$this->tree[ $parent ][ $child ] = [];
		}

		$this->in =& $this->tree[ $parent ][ $child ];

		return $this;
	}

	/**
	 * Create a namespace
	 *
	 * @param string $parent Block name.
	 * @param string $childs Block name.
	 * @param string $rules Block name.
	 */
	public function namespaces( $parent, $childs, $rules ) {
		if ( is_string( $childs ) ) {
			$childs = [ $childs ];
		}

		if ( is_string( $rules ) ) {
			$rules = [ $rules ];
		}

		$parent = trim( $parent );

		foreach ( $childs as $child ) {
			$child = trim( $child );

			if ( ! isset( $this->tree[ $parent ] ) ) {
				$this->tree[ $parent ] = [];
			}

			if ( ! isset( $this->tree[ $parent ][ $child ] ) ) {
				$this->tree[ $parent ][ $child ] = [];
			}

			$this->tree[ $parent ][ $child ] = array_merge(
				$this->tree[ $parent ][ $child ],
				$rules
			);
		}
	}

	/**
	 * Merge selectors that have the same CSS. This has the effect of increasing
	 * the weight of the selectors.
	 */
	private function merge_class_with_the_same_css() {
		return;

		$new_names = [];
		$used = [];

		foreach ( $this->attr as $key => $values ) {
			if ( isset( $used[ $key ] ) ) {
				continue;
			}

			foreach ( $this->attr as $sub_key => $sub_values ) {
				if ( $sub_key !== $key && $values === $sub_values ) {
					$used[ $sub_key ] = 1;
					$new_names[ $key ][] = $sub_key;
					$used[ $key ] = 1;
				}
			}
		}

		// Merge classes.
		foreach ( $new_names as $parent => $childs ) {
			$class_name = $parent . ",\n" . join( ",\n", $childs );
			$this->attr[ $class_name ] = $this->attr[ $parent ];

			// Remove CSS from main structure.
			if ( isset( $this->attr[ $parent ] ) ) {
				unset( $this->attr[ $parent ] );
			}

			// Remove all childs css.
			foreach ( $childs as $child_class ) {
				if ( isset( $this->attr[ $child_class ] ) ) {
					unset( $this->attr[ $child_class ] );
				}
			}
		}
	}

	/**
	 * Convert this->attr to a CSS string.
	 */
	private function convert_to_css() {
		$css = '';

		$this->merge_class_with_the_same_css();

		foreach ( $this->attr as $key => $values ) {
			$section = '';

			$section .= $key . " {\n";

			$content = '';

			foreach ( $values as $line ) {
				$line = trim( $line );

				if ( ! $this->is_empty_style( $line ) ) {
					if ( strpos( $key, '@media' ) === false ) {
						$line = str_replace( ';', '', $line );
					}

					$content .= "    {$line}";

					if ( strpos( $key, '@media' ) === false ) {
						$content .= ";\n";
					}
				}
			}

			// CSS is not empty.
			if ( $content ) {
				$section .= $content;
			} else {
				continue;
			}

			$section .= "}\n\n";
			$css .= $section;
		}

		// Erase structure.
		$this->attr = array();

		return $css;
	}

	/**
	 * Convert this->tree to a CSS string.
	 */
	private function convert_tree_to_css() {
		$css = '';

		foreach ( $this->tree as $parent => $child ) {
			$css .= trim( $parent ) . " {\n";

			foreach ( $child as $child_name => $rows ) {
				$css .= '    ' . trim( $child_name ) . " {\n";

				foreach ( $rows as $element ) {
					$element = trim( $element );
					$end = $element[ strlen( $element ) - 1 ];

					if ( ',' === $end ) {
						$css .= "        {$element}\n";
					} else {
						$css .= "        {$element};\n";
					}
				}

				$css .= "    }\n";
			}

			$css .= "}\n\n";
		}

		// Erase structure.
		$this->tree = array();

		return $css;
	}

	/**
	 * Check if a CSS rule is empty.
	 *
	 * @param string $line Single rule.
	 */
	private function is_empty_style( $line ) {
		$parts = explode( ':', $line );

		if ( count( $parts ) <= 1 ) {
			return false;
		}
		if ( ! isset( $parts[1] ) ) {
			return true;
		}

		$parts[1] = str_replace( $this->additional_symbols, '', $parts[1] );

		return strlen( trim( $parts[1] ) ) === 0;
	}

	/**
	 * Very rudimentary CSS minifier.
	 *
	 * @param string $minify CSS to be minified.
	 */
	private function css_minify( $minify ) {
		if ( ! defined( 'WP_DEBUG' ) ) {
			return $minify;
		}
		if ( ! WP_DEBUG ) {
			return $minify;
		}

		/* remove comments */
		$minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $minify );

		/* remove tabs, spaces, newlines, etc. */
		$minify = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $minify );
		/* remove space after colons */
		$minify = str_replace( ': ', ':', $minify );

		return $minify;
	}

	/**
	 * Find each @media block in a CSS blob.
	 *
	 * @param string $css CSS string in which we look for @media block.
	 */
	private function parse_media_blocks( $css ) {
		$media_blocks = array();

		$start = 0;

		while ( strpos( $css, '@media', $start ) !== false ) {
			$start = strpos( $css, '@media', $start );
			// stack to manage brackets
			$s = array();

			// get the first opening bracket
			$i = strpos( $css, '{', $start );

			// if $i is false, then there is probably a css syntax error
			if ( false !== $i ) {
				// push bracket onto stack
				array_push( $s, $css[ $i ] );

				// move past first bracket
				$i++;

				while ( ! empty( $s ) ) {
					// if the character is an opening bracket,
					// push it onto the stack, otherwise pop the stack
					if ( '{' === $css[ $i ] ) {
						array_push( $s, '{' );
					} elseif ( '}' === $css[ $i ] ) {
						array_pop( $s );
					}

					$i++;
				}

				// cut the media block out of the css and store
				$media_blocks[] = substr( $css, $start, ( $i + 1 ) - $start );

				// set the new $start to the end of the block
				$start = $i;
			}
		}

		return $media_blocks;
	}

	/**
	 * Remove dublications of CSS rules.
	 * Input: array( 'color: red', 'color: blue' )
	 * Output: array( 'color: blue' )
	 * Return the last rule.
	 *
	 * @param array $rules CSS Rules.
	 * @return array
	 */
	protected function remove_dublication( $rules ) {
		$result = array();
		$dublication = array();

		for ( $i = count( $rules ) - 1; $i >= 0; $i-- ) {
			$line = $rules[ $i ];

			if ( strpos( $line, self::get_skip_rule_keyword() ) !== false ) {
				continue;
			}

			$position = strpos( $line, ':' );
			$key = substr( $line, 0, $position );

			/**
			 * Skip redundant variables
			 * --a: var(--a)
			 */
			if (strpos($key, '--') === 0) {
				if (strpos(explode(':', $line)[1], $key) !== false) {
					continue;
				}
			}

			if ( ! in_array( $key, $dublication, true ) ) {
				$result[] = $line;
				$dublication[] = $key;
			}
		}

		krsort( $result );

		return $result;
	}
}

