<h1><?php echo __('Instructions', 'blc'); ?></h1>

<p>
	<?php echo __('After installing and activating the Instagram extension you will have two possibilities to show your feed:', 'blc') ?>
</p>

<ol>
	<li>
		<b>
			<?php echo __('Instagram Widget', 'blc') ?>
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
			<?php echo __('Instagram Block', 'blc') ?>
		</b>
		<i>
		<?php
			echo sprintf(
				__('Navigate to %s and customize the location, number of images and more.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ Instagram Extension', 'blc')
				)
			);
		?>
		</i>
	</li>
</ol>

