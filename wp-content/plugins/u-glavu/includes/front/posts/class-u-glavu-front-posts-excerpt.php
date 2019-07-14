<?php 

class U_Glavu_Front_Posts_Excerpt 
{
	public function __construct(U_Glavu_Loader $loader) 
	{
		/* remove the default filter */
		remove_filter('get_the_excerpt', 'wp_trim_excerpt');
		 
		/* now, add your own filter */
		$loader->add_filter('get_the_excerpt', $this, 'lt_html_excerpt');
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