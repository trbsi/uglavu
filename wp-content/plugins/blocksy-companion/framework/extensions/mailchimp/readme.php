<h1><?php echo __('Instructions', 'blc'); ?></h1>

<p>
	<?php echo __('After installing and activating the Mailchimp extension you will have two possibilities to show your subscribe form:', 'blc') ?>
</p>

<ol>
	<li>
		<b>
			<?php echo __('Mailchimp Widget', 'blc') ?>
		</b>
		<i>
		<?php
			echo sprintf(
				__('Navigate to %s and place the widget in any widget area you want.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Appearance ➝ Widgets', 'blc')
				)
			);
		?>
		</i>
	</li>

	<li>
		<b>
			<?php echo __('Mailchimp Block', 'blc') ?>
		</b>
		<i>
		<?php
			echo sprintf(
				__('Navigate to %s and customize the form and more.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ Single Posts', 'blc')
				)
			);
		?>
		</i>
	</li>
</ol>


