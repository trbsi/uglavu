<?php

namespace Blocksy;

class GoogleAnalytics {
	public function __construct() {
		add_filter(
			'blocksy_misc_end_section_customizer_options',
			[$this, 'generate_google_analytics_opts']
		);

		if (is_admin()) return;

		add_action('print_footer_scripts', function () {
			if (is_admin()) return;

			if (class_exists('BlocksyExtensionCookiesConsent')) {
				if (\BlocksyExtensionCookiesConsent::should_display_notification()) {
					return;
				}
			}

			$analytics_id = get_theme_mod('analytics_id', '');

			if (empty($analytics_id)) return;

			?>

			<!-- Google Analytics -->
			<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create', '<?php echo $analytics_id ?>', 'auto');
			ga('send', 'pageview');
			<?php if (get_theme_mod('ip_anonymization', 'no') === 'yes') { ?>
			ga('set', 'anonymizeIp', true);
			<?php } ?>
			</script>
			<!-- End Google Analytics -->

			<?php
		});
	}

	public function generate_google_analytics_opts($options) {
		$options['google_analytics'] = [
			'title' => __('Google Analytics', 'blc'),
			'container' => [ 'priority' => 7 ],
			'options' => [

				'integrations_section_options' => [
					'type' => 'ct-options',
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [
						blocksy_rand_md5() => [
							'label' => __( 'Google Analytics', 'blc' ),
							'type' => 'ct-title',
						],

						'analytics_id' => [
							'label' => __( 'Tracking ID', 'blc' ),
							'type' => 'text',
							'design' => 'inline',
							'value' => '',
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'ip_anonymization' => [
							'label' => __( 'IP Anonymization', 'blc' ),
							'type' => 'ct-switch',
							'value' => 'no',
							'desc' => __( 'Enable Google Analytics IP anonymization feature <a href="https://developers.google.com/analytics/devguides/collection/gtagjs/ip-anonymization">(more info)</a>.', 'blc' ),
							'setting' => [ 'transport' => 'postMessage' ],
						],
					],
				],

			]
		];

		return $options;
	}
}
