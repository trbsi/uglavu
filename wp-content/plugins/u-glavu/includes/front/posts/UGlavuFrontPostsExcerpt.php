<?php

namespace UGlavu\Includes\Front;

use UGlavu\Includes\UGlavuLoader;

class UGlavuFrontPostsExcerpt
{
    private $loader;

	public function __construct(UGlavuLoader $loader)
	{
	    $this->loader = $loader;
	}

	public function run()
    {
        /* remove the default filter */
        remove_filter('get_the_excerpt', 'wp_trim_excerpt');

        /* now, add your own filter */
        $this->loader->add_filter('get_the_excerpt', $this, 'lt_html_excerpt');
    }

	/**
	 * @see https://wpwhatnot.com/allow-html-excerpts/
	 */
	public function lt_html_excerpt($text) { // Fakes an excerpt if needed
	    global $post;
	    if ( '' == $text ) {
	        $text = get_the_content('');
	        $text = apply_filters('the_content', $text);
	        $text = str_replace('\]\]\>', ']]&gt;', $text);
	        /*just add all the tags you want to appear in the excerpt --
	        be sure there are no white spaces in the string of allowed tags */
	        $text = strip_tags($text,'<p><br><b><a><em><strong>');
	    }

	    return $text;
	}
}