<?php

namespace UGlavu\Includes\Admin\Posts\Listing;

use UGlavu\Includes\UGlavuLoader;

/**
 * @see  https://rudrastyh.com/wordpress/date-range-filter.html
 */
class UGlavuAdminPostsFilter {

    private $loader;

	function __construct(UGlavuLoader $loader)
    {
        $this->loader = $loader;
        $this->run();
	}

	public function run()
    {
        // if you do not want to remove default "by month filter", remove/comment this line
        add_filter( 'months_dropdown_results', '__return_empty_array' );

        // include CSS/JS, in our case jQuery UI datepicker
        $this->loader->add_action( 'admin_enqueue_scripts', $this, 'jqueryui' );

        // HTML of the filter
        $this->loader->add_action( 'restrict_manage_posts', $this, 'form' );

        // the function that filters posts
        $this->loader->add_action( 'pre_get_posts', $this, 'filterQuery' );
    }
 
	/*
	 * Add jQuery UI CSS and the datepicker script
	 * Everything else should be already included in /wp-admin/ like jquery, jquery-ui-core etc
	 * If you use WooCommerce, you can skip this function completely
	 */
	function jqueryui()
    {
		wp_enqueue_style( 'jquery-ui', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
	}
 
	/*
	 * Two input fields with CSS/JS
	 * If you would like to move CSS and JavaScript to the external file - welcome.
	 */
	public function form()
    {
 
		$from = ( isset( $_GET['filterDateFrom'] ) && $_GET['filterDateFrom'] ) ? $_GET['filterDateFrom'] : '';
		$to = ( isset( $_GET['filterDateTo'] ) && $_GET['filterDateTo'] ) ? $_GET['filterDateTo'] : '';
 
		echo '<style>
		input[name="filterDateFrom"], input[name="filterDateTo"]{
			line-height: 28px;
			height: 28px;
			margin: 0;
			width:125px;
		}
		</style>
 
		<input type="text" name="filterDateFrom" placeholder="Date From" value="' . $from . '" />
		<input type="text" name="filterDateTo" placeholder="Date To" value="' . $to . '" />
 
		<script>
		jQuery( function($) {
			var from = $(\'input[name="filterDateFrom"]\'),
			    to = $(\'input[name="filterDateTo"]\');
 
			$( \'input[name="filterDateFrom"], input[name="filterDateTo"]\' ).datepicker();
			// by default, the dates look like this "April 3, 2017" but you can use any strtotime()-acceptable date format
    			// to make it 2017-04-03, add this - datepicker({dateFormat : "yy-mm-dd"});
 
 
    			// the rest part of the script prevents from choosing incorrect date interval
    			from.on( \'change\', function() {
				to.datepicker( \'option\', \'minDate\', from.val() );
			});
 
			to.on( \'change\', function() {
				from.datepicker( \'option\', \'maxDate\', to.val() );
			});
 
		});
		</script>';
 
	}
 
	/*
	 * The main function that actually filters the posts
	 */
	public function filterQuery($admin_query )
    {
		global $pagenow;
 
		if (
			is_admin()
			&& $admin_query->is_main_query()
			// by default filter will be added to all post types, you can operate with $_GET['post_type'] to restrict it for some types
			&& in_array( $pagenow, array( 'edit.php', 'upload.php' ) )
			&& ( ! empty( $_GET['filterDateFrom'] ) || ! empty( $_GET['filterDateTo'] ) )
		) {
 
			$admin_query->set(
				'date_query', // I love date_query appeared in WordPress 3.7!
				array(
					'after' => date('Y-m-d 00:00:00', strtotime($_GET['filterDateFrom'])), // any strtotime()-acceptable format!
					'before' => date('Y-m-d 23:59:59', strtotime($_GET['filterDateTo'])),
					'inclusive' => true, // include the selected days as well
					'column'    => 'post_date' // 'post_modified', 'post_date_gmt', 'post_modified_gmt'
				)
			);
 
		}
 
		return $admin_query;
 
	}
 
}