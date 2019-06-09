<?php
/**
 * Header options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [

	'header_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			[
				'has_top_bar' => [
					'label' => __( 'Top Bar', 'blocksy' ),
					'type' => 'ct-panel',
					'switch' => true,
					'value' => 'yes',
					'wrapperAttr' => [ 'data-label' => 'heading-label' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						blocksy_rand_md5() => [
							'title' => __( 'General', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								blocksy_get_options('general/header-top-bar-area', [
									'number' => '1',
									'default_section' => 'header_menu',
								]),

								[
									blocksy_rand_md5() => [
										'type' => 'ct-divider',
										'attr' => [ 'data-type' => 'small' ],
									],
								],

								blocksy_get_options('general/header-top-bar-area', [
									'number' => '2',
									'default_section' => 'disabled',
								]),

								[
									blocksy_rand_md5() => [
										'type' => 'ct-divider',
										'attr' => [ 'data-type' => 'small' ],
									],

									'topBarHeight' => [
										'label' => __( 'Container Height', 'blocksy' ),
										'type' => 'ct-slider',
										'value' => 40,
										'responsive' => true,
										'setting' => [ 'transport' => 'postMessage' ],
									],

									'top_bar_container' => [
										'label' => __( 'Container Width', 'blocksy' ),
										'type' => 'ct-radio',
										'value' => 'fixed',
										'view' => 'text',
										'design' => 'block',
										'setting' => [ 'transport' => 'postMessage' ],
										'choices' => [
											'fixed' => __( 'Fixed', 'blocksy' ),
											'fluid' => __( 'Fluid', 'blocksy' ),
										],
									],

									blocksy_rand_md5() => [
										'type' => 'ct-divider',
										'attr' => [ 'data-type' => 'small' ],
									],

									'top_bar_stacking' => [
										'label' => __( 'Stack Sections on', 'blocksy' ),
										'type' => 'ct-visibility',
										'design' => 'block',
										'setting' => [ 'transport' => 'postMessage' ],
										'allow_empty' => true,
										'value' => [
											'tablet' => false,
											'mobile' => true,
										],

										'choices' => blocksy_ordered_keys([
											'tablet' => __( 'Tablet', 'blocksy' ),
											'mobile' => __( 'Mobile', 'blocksy' ),
										]),
									],

									blocksy_rand_md5() => [
										'type' => 'ct-divider',
										'attr' => [ 'data-type' => 'small' ],
									],

									'top_bar_visibility' => [
										'label' => __( 'Visibility', 'blocksy' ),
										'type' => 'ct-visibility',
										'design' => 'block',
										'setting' => [ 'transport' => 'postMessage' ],
										'value' => [
											'desktop' => true,
											'tablet' => true,
											'mobile' => false,
										],

										'choices' => blocksy_ordered_keys([
											'desktop' => __( 'Desktop', 'blocksy' ),
											'tablet' => __( 'Tablet', 'blocksy' ),
											'mobile' => __( 'Mobile', 'blocksy' ),
										]),
									],
								],
							],
						],

						blocksy_rand_md5() => [
							'title' => __( 'Design', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'topBarFontColor' => [
									'label' => __( 'Font Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'default' => [
											'color' => 'rgba(255, 255, 255, 0.8)',
										],

										'hover' => [
											'color' => 'var(--paletteColor1)',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

								'topBarBackground' => [
									'label' => __( 'Background Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'default' => [
											'color' => '#29333d',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],
									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [
										'any' => [
											'header_top_bar_section_1' => 'header_menu',
											'header_top_bar_section_2' => 'header_menu',
										],
									],
									'options' => [

										'topBarMenuItemsSpacing' => [
											'label' => __( 'Menu Items Spacing', 'blocksy' ),
											'type' => 'ct-slider',
											'min' => 5,
											'max' => 80,
											'responsive' => true,
											'value' => [
												'mobile' => 20,
												'tablet' => 20,
												'desktop' => 20,
											],
											'setting' => [ 'transport' => 'postMessage' ],
										],

									],
								],

							],
						],

					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'General Options', 'blocksy' ),
				],

				blocksy_rand_md5() => [
					'title' => __( 'General', 'blocksy' ),
					'type' => 'tab',
					'options' => [

						'header_type' => [
							'label' => false,
							'type' => 'ct-image-picker',
							'value' => 'type-1',
							'attr' => [ 'data-type' => 'background' ],
							'setting' => [ 'transport' => 'postMessage' ],
							'switchDeviceOnChange' => 'desktop',
							'choices' => [

								'type-1' => [
									'src'   => blocksy_image_picker_url( 'header-type-1.svg' ),
									'title' => __( 'Type 1', 'blocksy' ),
								],

								'type-2' => [
									'src'   => blocksy_image_picker_url( 'header-type-2.svg' ),
									'title' => __( 'Type 2', 'blocksy' ),
								],

							],
						],

					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blocksy' ),
					'type' => 'tab',
					'options' => [

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'header_type' => 'type-1' ],
							'options' => [

								'header_container' => [
									'label' => __( 'Container Width', 'blocksy' ),
									'type' => 'ct-radio',
									'value' => 'fixed',
									'view' => 'text',
									'design' => 'block',
									'setting' => [ 'transport' => 'postMessage' ],
									'choices' => [
										'fixed' => __( 'Fixed', 'blocksy' ),
										'fluid' => __( 'Fluid', 'blocksy' ),
									],
								],

								'headerHeight' => [
									'label' => __( 'Container Height', 'blocksy' ),
									'type' => 'ct-slider',
									'value' => [
										'desktop' => '120px',
										'tablet' => '35px',
										'mobile' => '35px',
									],
									'responsive' => [
										'desktop' => true,
										'tablet' => false,
										'mobile' => false,
									],
									'units' => blocksy_units_config([
										[
											'unit' => 'px',
											'min' => 0,
											'max' => 400,
										],
									]),
									'setting' => [ 'transport' => 'postMessage' ],
								],

							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'header_type' => 'type-2' ],
							'options' => [

								'headerLogoContainerHeight' => [
									'label' => __( 'Logo Container Height', 'blocksy' ),
									'type' => 'ct-slider',
									'value' => [
										'desktop' => '110px',
										'tablet' => '35px',
										'mobile' => '35px',
									],
									'responsive' => [
										'desktop' => true,
										'tablet' => false,
										'mobile' => false,
									],
									'units' => blocksy_units_config([
										[
											'unit' => 'px',
											'min' => 0,
											'max' => 500,
										],
									]),
									'setting' => [ 'transport' => 'postMessage' ],
								],

							],
						],

						'headerBackground' => [
							'label' => __( 'Background Color', 'blocksy' ),
							'type'  => 'ct-color-picker',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
							'value' => [
								'default' => [
									'color' => '#ffffff',
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy' ),
									'id' => 'default',
								],
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'header_type' => 'type-2' ],
							'options' => [

								blocksy_rand_md5() => [
									'type' => 'ct-divider',
									'attr' => [ 'data-type' => 'small' ],
								],

								'navSectionHeight' => [
									'label' => __( 'Menu Container Height', 'blocksy' ),
									'type' => 'ct-slider',
									'value' => '60px',
									'responsive' => [
										'desktop' => true,
										'tablet' => false,
										'mobile' => false,
									],
									'units' => blocksy_units_config([
										[
											'unit' => 'px',
											'min' => 0,
											'max' => 200,
										],
									]),
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'navSectionBackground' => [
									'label' => __( 'Menu Container Background Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],

									'value' => [
										'default' => [
											'color' => Blocksy_Css_Injector::get_skip_rule_keyword(),
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],
									],
								],
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'header_type' => 'type-2' ],
							'options' => [

								'headerTopBorder' => [
									'label' => __( 'Top Border', 'blocksy' ),
									'type' => 'ct-border',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'width' => 1,
										'style' => 'dashed',
										'color' => [
											'color' => 'rgba(44,62,80,0.2)',
										],
									]
								],

								'headerTopBorderFull' => [
									'label' => __( 'Top Border Full Width', 'blocksy' ),
									'type' => 'ct-switch',
									'value' => 'no',
									'setting' => [ 'transport' => 'postMessage' ],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-divider',
									'attr' => [ 'data-type' => 'small' ],
								],

							],
						],

						'headerBottomBorder' => [
							'label' => __( 'Bottom Border', 'blocksy' ),
							'type' => 'ct-border',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
							'value' => [
								'width' => 1,
								'style' => 'none',
								'color' => [
									'color' => 'rgba(44,62,80,0.2)',
								],
							]
						],

						'headerBottomBorderContainer' => [
							'label' => __( 'Bottom Border Full Width', 'blocksy' ),
							'type' => 'ct-switch',
							'value' => 'no',
							'setting' => [ 'transport' => 'postMessage' ],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						'headerShadow' => [
							'label' => __( 'Shadow Color', 'blocksy' ),
							'type'  => 'ct-color-picker',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
							'value' => [
								'default' => [
									'color' => 'rgba(210, 213, 218, 0.15)',
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy' ),
									'id' => 'default',
								],
							],
						],

					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Mobile Devices Options', 'blocksy' ),
				],

				blocksy_rand_md5() => [
					'title' => __( 'General', 'blocksy' ),
					'type' => 'tab',
					'options' => [

						'mobile_header_type' => [
							'label' => false,
							'type' => 'ct-image-picker',
							'value' => 'type-1',
							'attr' => [ 'data-type' => 'background' ],
							'setting' => [ 'transport' => 'postMessage' ],
							'switchDeviceOnChange' => 'tablet',
							'choices' => [

								'type-1' => [
									'src'   => blocksy_image_picker_url( 'header-mobile-type-1.svg' ),
									'title' => __( 'Type 1', 'blocksy' ),
								],

								'type-2' => [
									'src'   => blocksy_image_picker_url( 'header-mobile-type-2.svg' ),
									'title' => __( 'Type 2', 'blocksy' ),
								],

							],
						],

					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blocksy' ),
					'type' => 'tab',
					'options' => [

						'mobileHeaderBackground' => [
							'label' => __( 'Background Color', 'blocksy' ),
							'type'  => 'ct-color-picker',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
							'value' => [
								'default' => [
									'color' => 'var(--paletteColor5)',
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy' ),
									'id' => 'default',
								],
							],
						],

						'mobileHeaderHeight' => [
							'label' => __( 'Container Height', 'blocksy' ),
							'type' => 'ct-slider',
							'value' => [
								'desktop' => '70px',
								'tablet' => '70px',
								'mobile' => '70px',
							],
							'responsive' => [
								'desktop' => false,
								'tablet' => true,
								'mobile' => true,
							],
							'units' => blocksy_units_config([
								[
									'unit' => 'px',
									'min' => 0,
									'max' => 400,
								],
							]),
							'setting' => [ 'transport' => 'postMessage' ],
						],
					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Header Elements', 'blocksy' ),
				],

				'header_logo_panel' => [
					'label' => __( 'Logo', 'blocksy' ),
					'type' => 'ct-panel',
					'switch' => false,
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						'custom_logo' => [
							'label' => false,
							'type' => 'ct-image-uploader',
							'value' => '',
							'inline_value' => true,
							'attr' => [ 'data-height' => 'small' ],
							'setting' => [ 'transport' => 'postMessage' ],
							'selective_refresh' => [
								'selector' => '.site-branding',
								'render_callback' => 'blocksy_output_site_branding',
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						'has_retina_logo' => [
							'label' => __( 'Retina Logo', 'blocksy' ),
							'type' => 'ct-switch',
							'value' => 'no',
							'desc' => __( 'Set up a different logo for retina devices.', 'blocksy' ),
							'setting' => [ 'transport' => 'postMessage' ],
							'selective_refresh' => [
								'selector' => '.site-branding',
								'render_callback' => 'blocksy_output_site_branding',
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'has_retina_logo' => 'yes' ],
							'options' => [

								'retina_header_logo' => [
									'label' => false,
									'type' => 'ct-image-uploader',
									'value' => [ 'attachment_id' => null ],
									'attr' => [ 'data-height' => 'small' ],
									'setting' => [ 'transport' => 'postMessage' ],
									'selective_refresh' => [
										'selector' => '.site-branding',
										'render_callback' => 'blocksy_output_site_branding',
									],
								],

							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						'has_mobile_logo' => [
							'label' => __( 'Mobile Logo', 'blocksy' ),
							'type' => 'ct-switch',
							'value' => 'no',
							'switchDeviceOnChange' => 'tablet',
							'desc' => __( 'Set up a different logo for mobile devices.', 'blocksy' ),
							'setting' => [ 'transport' => 'postMessage' ],
							'selective_refresh' => [
								'selector' => '.header-mobile .site-branding',
								'render_callback' => 'blocksy_output_site_branding_mobile',
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-condition',
							'condition' => [ 'has_mobile_logo' => 'yes' ],
							'options' => [

								'mobile_header_logo' => [
									'label' => false,
									'type' => 'ct-image-uploader',
									'value' => [ 'attachment_id' => null ],
									'switchDeviceOnChange' => 'tablet',
									'attr' => [ 'data-height' => 'small' ],
									'setting' => [ 'transport' => 'postMessage' ],
									'selective_refresh' => [
										'selector' => '.header-mobile .site-branding',
										'render_callback' => 'blocksy_output_site_branding_mobile',
									],
								],

							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						'logoMaxHeight' => [
							'label' => __( 'Maximum Height', 'blocksy' ),
							'type' => 'ct-slider',
							'min' => 0,
							'max' => 300,
							'value' => 50,
							'responsive' => true,
							'setting' => [ 'transport' => 'postMessage' ],
						],
					],
				],

				'main_menu_panel' => [
					'label' => __( 'Menu', 'blocksy' ),
					'type' => 'ct-panel',
					'switch' => false,
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						blocksy_rand_md5() => [
							'type' => 'ct-title',
							'label' => __( 'Top Level Options', 'blocksy' ),
						],

						blocksy_rand_md5() => [
							'title' => __( 'General', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'header_menu_type' => [
									'label' => false,
									'type' => 'ct-image-picker',
									'value' => 'type-1',
									'attr' => [ 'data-type' => 'background' ],
									'setting' => [ 'transport' => 'postMessage' ],
									'switchDeviceOnChange' => 'desktop',
									'choices' => [

										'type-1' => [
											'src'   => blocksy_image_picker_url( 'menu-type-1.svg' ),
											'title' => __( 'Type 1', 'blocksy' ),
										],

										'type-2' => [
											'src'   => blocksy_image_picker_url( 'menu-type-2.svg' ),
											'title' => __( 'Type 2', 'blocksy' ),
										],

										'type-3' => [
											'src'   => blocksy_image_picker_url( 'menu-type-3.svg' ),
											'title' => __( 'Type 3', 'blocksy' ),
										],

										'type-4' => [
											'src'   => blocksy_image_picker_url( 'menu-type-4.svg' ),
											'title' => __( 'Type 4', 'blocksy' ),
										],
									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'header_type' => 'type-1' ],
									'options' => [

										'menu_alignment' => [
											'label' => __( 'Menu Alignment', 'blocksy' ),
											'type' => 'ct-radio',
											'value' => 'right',
											'setting' => [ 'transport' => 'postMessage' ],
											'view' => 'text',
											'attr' => [ 'data-type' => 'alignment' ],
											'choices' => [
												'left' => '',
												'center' => '',
												'right' => '',
											],
										],

									],
								],

								'headerMenuItemsSpacing' => [
									'label' => __( 'Items Spacing', 'blocksy' ),
									'type' => 'ct-slider',
									'value' => 25,
									'min' => 5,
									'max' => 80,
									'setting' => [ 'transport' => 'postMessage' ],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'header_menu_type' => 'type-1' ],
									'options' => [

										'menu_items_divider' => [
											'label' => __('Items Divider', 'blocksy'),
											'type' => 'ct-radio',
											'value' => 'default',
											'view' => 'radio',
											'inline' => true,
											'design' => 'block',
											'setting' => [ 'transport' => 'postMessage' ],
											'choices' => [
												'default' => __( 'Default', 'blocksy' ),
												'dot' => __( 'Dot', 'blocksy' ),
												'dash' => __( 'Dash', 'blocksy' ),
											],
										],

									],
								],

							],
						],

						blocksy_rand_md5() => [
							'title' => __( 'Design', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'primaryMenuFont' => [
									'type' => 'ct-typography',
									'label' => __( 'Font', 'blocksy' ),
									'value' => blocksy_typography_default_values([
										'size' => '12px',
										'variation' => 'n7',
										'line-height' => '1.3',
										'text-transform' => 'uppercase',
									]),
									'typography_responsive' => [
										'desktop' => true,
										'tablet' => false,
										'mobile' => false,
									],
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'menuFontColor' => [
									'label' => __( 'Font Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],

									'value' => [
										'default' => [
											'color' => 'var(--paletteColor3)',
										],

										'hover' => [
											'color' => 'var(--paletteColor1)',
										],

										'active' => [
											'color' => '#ffffff',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Active Text', 'blocksy' ),
											'id' => 'active',
											'condition' => [
												'header_menu_type' => 'type-3'
											]
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-title',
							'label' => __( 'Dropdown Options', 'blocksy' ),
						],

						blocksy_rand_md5() => [
							'title' => __( 'General', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'dropdown_animation' => [
									'label' => __('Entrance animation', 'blocksy'),
									'type' => 'ct-radio',
									'value' => 'type-1',
									'view' => 'radio',
									'design' => 'block',
									'attr' => [ 'data-columns' => '2' ],
									'setting' => [ 'transport' => 'postMessage' ],
									'choices' => [
										'type-1' => __( 'Default', 'blocksy' ),
										'type-3' => __( 'Inner Reveal', 'blocksy' ),
										'type-2' => __( 'Opacity', 'blocksy' ),
										'type-4' => __( 'Simple', 'blocksy' ),
									],
								],

								'dropdownTopOffset' => [
									'label' => __( 'Dropdown Top Offset', 'blocksy' ),
									'type' => 'ct-slider',
									'value' => 15,
									'min' => 0,
									'max' => 100,
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'dropdownMenuWidth' => [
									'label' => __( 'Dropdown Width', 'blocksy' ),
									'type' => 'ct-slider',
									'value' => 200,
									'min' => 100,
									'max' => 300,
									'setting' => [ 'transport' => 'postMessage' ],
								],

							],
						],

						blocksy_rand_md5() => [
							'title' => __( 'Design', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'primaryMenuDropdownFont' => [
									'type' => 'ct-typography',
									'label' => __( 'Font', 'blocksy' ),
									'value' => blocksy_typography_default_values([
										'size' => '12px',
										'variation' => 'n5',
										'line-height' => '1.6',
									]),
									'typography_responsive' => [
										'desktop' => true,
										'tablet' => false,
										'mobile' => false,
									],
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'dropdownFontColor' => [
									'label' => __( 'Font Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],

									'value' => [
										'default' => [
											'color' => '#ffffff',
										],

										'hover' => [
											'color' => 'var(--paletteColor1)',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

								'dropDownBackground' => [
									'label' => __( 'Background Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],

									'value' => [
										'default' => [
											'color' => '#29333C',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],
									],
								],

								'dropDownDivider' => [
									'label' => __( 'Items Divider', 'blocksy' ),
									'type' => 'ct-border',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'width' => 1,
										'style' => 'dashed',
										'color' => [
											'color' => 'rgba(255, 255, 255, 0.1)',
										],
									]
								],

							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-title',
							'label' => __( 'Mobile Menu Options', 'blocksy' ),
						],

						blocksy_rand_md5() => [
							'title' => __( 'General', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'mobile_menu_trigger_type' => [
									'label' => __( 'Trigger Icon Type', 'blocksy' ),
									'type' => 'ct-image-picker',
									'value' => 'type-1',
									'attr' => [
										'data-type' => 'background',
										'data-columns' => '3',
									],
									'switchDeviceOnChange' => 'tablet',
									'setting' => [ 'transport' => 'postMessage' ],
									'choices' => [

										'type-1' => [
											'src'   => blocksy_image_picker_file( 'trigger-1' ),
											'title' => __( 'Type 1', 'blocksy' ),
										],

										'type-2' => [
											'src'   => blocksy_image_picker_file( 'trigger-2' ),
											'title' => __( 'Type 2', 'blocksy' ),
										],

										'type-3' => [
											'src'   => blocksy_image_picker_file( 'trigger-3' ),
											'title' => __( 'Type 3', 'blocksy' ),
										],
									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-divider',
									'attr' => [ 'data-type' => 'small' ],
								],

								'mobile_menu_modal_behavior' => [
									'label' => __('Open Menu in:', 'blocksy'),
									'type' => 'ct-radio',
									'value' => 'modal',
									'view' => 'radio',
									'inline' => true,
									'design' => 'block',
									'setting' => [ 'transport' => 'postMessage' ],
									'choices' => [
										'modal' => __( 'Modal', 'blocksy' ),
										'offcanvas' => __( 'Off-Canvas', 'blocksy' ),
									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'mobile_menu_modal_behavior' => 'offcanvas' ],
									'options' => [

										'offCanvasWidth' => [
											'label' => __( 'Off Canvas Width', 'blocksy' ),
											'type' => 'ct-slider',
											'value' => [
												'mobile' => '250px',
												'tablet' => '280px',
												'desktop' => '280px',
											],
											'units' => blocksy_units_config([
												[
													'unit' => 'px',
													'min' => 200,
													'max' => 400,
												],
											]),
											'responsive' => true,
											'setting' => [ 'transport' => 'postMessage' ],
										],

									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-divider',
									'attr' => [ 'data-type' => 'small' ],
								],

								'has_mobile_menu_logo' => [
									'label' => __( 'Mobile Menu Logo', 'blocksy' ),
									'type' => 'ct-switch',
									'value' => 'no',
									'setting' => [ 'transport' => 'postMessage' ],
									'selective_refresh' => [
										'selector' => '.ct-bag-container .site-branding',
										'render_callback' => 'blocksy_output_mobile_menu_site_branding',
									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'has_mobile_menu_logo' => 'yes' ],
									'options' => [

										'mobile_menu_logo' => [
											'label' => false,
											'type' => 'ct-image-uploader',
											'value' => [ 'attachment_id' => null ],
											'attr' => [ 'data-height' => 'small' ],
											'setting' => [ 'transport' => 'postMessage' ],
											'selective_refresh' => [
												'selector' => '.ct-bag-container .site-branding',
												'render_callback' => 'blocksy_output_mobile_menu_site_branding',
											],
										],

										blocksy_rand_md5() => [
											'type' => 'ct-divider',
											'attr' => [ 'data-type' => 'small' ],
										],

										'has_mobile_menu_retina_logo' => [
											'label' => __( 'Retina Logo', 'blocksy' ),
											'type' => 'ct-switch',
											'value' => 'no',
											'desc' => __( 'Set up a different logo for retina devices.', 'blocksy' ),
											'setting' => [ 'transport' => 'postMessage' ],
											'selective_refresh' => [
												'selector' => '.ct-bag-container .site-branding',
												'render_callback' => 'blocksy_output_mobile_menu_site_branding',
											],
										],

										blocksy_rand_md5() => [
											'type' => 'ct-condition',
											'condition' => [ 'has_mobile_menu_retina_logo' => 'yes' ],
											'options' => [

												'mobile_menu_retina_logo' => [
													'label' => false,
													'type' => 'ct-image-uploader',
													'value' => [ 'attachment_id' => null ],
													'attr' => [ 'data-height' => 'small' ],
													'setting' => [ 'transport' => 'postMessage' ],
													'selective_refresh' => [
														'selector' => '.ct-bag-container .site-branding',
														'render_callback' => 'blocksy_output_mobile_menu_site_branding',
													],
												],

											],
										],

										blocksy_rand_md5() => [
											'type' => 'ct-divider',
											'attr' => [ 'data-type' => 'small' ],
										],

										'mobileMenulogoMaxHeight' => [
											'label' => __( 'Logo Maximum Height', 'blocksy' ),
											'type' => 'ct-slider',
											'min' => 0,
											'max' => 300,
											'value' => 50,
											'setting' => [ 'transport' => 'postMessage' ],
										],

									],
								],

							],
						],

						blocksy_rand_md5() => [
							'title' => __( 'Design', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'mobileMenuFont' => [
									'type' => 'ct-typography',
									'label' => __( 'Font', 'blocksy' ),
									'value' => blocksy_typography_default_values([
										'size' => [
											'desktop' => '30px',
											'tablet'  => '30px',
											'mobile'  => '23px' 
										],
										'variation' => 'n7',
									]),
									'typography_responsive' => [
										'desktop' => false,
										'tablet' => true,
										'mobile' => true,
									],
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'mobileMenuLinkColor' => [
									'label' => __( 'Font Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'default' => [
											'color' => '#ffffff',
										],

										'hover' => [
											'color' => 'var(--paletteColor1)',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

								'mobileMenuIconColor' => [
									'label' => __( 'Trigger Icon Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'default' => [
											'color' => 'var(--paletteColor3)',
										],

										'hover' => [
											'color' => 'var(--paletteColor1)',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

								'mobileMenuBackground' => [
									'label' => __( 'Background Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'default' => [
											'color' => 'rgba(18, 21, 25, 0.98)',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],
									],
								],

							],
						],

					],
				],

				'search_icon_panel' => [
					'label' => __( 'Search', 'blocksy' ),
					'type' => 'ct-panel',
					'switch' => false,
					'value' => 'yes',
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						'searchHeaderIconColor' => [
							'label' => __( 'Icon Color', 'blocksy' ),
							'type'  => 'ct-color-picker',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],

							'value' => [
								'default' => [
									'color' => 'var(--paletteColor3)',
								],

								'hover' => [
									'color' => 'var(--paletteColor1)',
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy' ),
									'id' => 'default',
								],

								[
									'title' => __( 'Hover', 'blocksy' ),
									'id' => 'hover',
								],
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-title',
							'label' => __( 'Search Results', 'blocksy' ),
							'variation' => 'small',
						],

						'searchHeaderLinkColor' => [
							'label' => __( 'Link Color', 'blocksy' ),
							'type'  => 'ct-color-picker',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],

							'value' => [
								'default' => [
									'color' => 'var(--paletteColor5)',
								],

								'hover' => [
									'color' => 'var(--paletteColor1)',
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy' ),
									'id' => 'default',
								],

								[
									'title' => __( 'Hover', 'blocksy' ),
									'id' => 'hover',
								],
							],
						],

						'searchHeaderBackground' => [
							'label' => __( 'Modal Background Color', 'blocksy' ),
							'type'  => 'ct-color-picker',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],

							'value' => [
								'default' => [
									'color' => 'rgba(18, 21, 25, 0.98)',
								],
							],

							'pickers' => [
								[
									'title' => __( 'Initial', 'blocksy' ),
									'id' => 'default',
								],
							],
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						'search_enable_live_results' => [
							'label' => __( 'Enable live results', 'blocksy' ),
							'type' => 'ct-switch',
							'value' => 'yes',
						],

						blocksy_rand_md5() => [
							'type' => 'ct-divider',
							'attr' => [ 'data-type' => 'small' ],
						],

						'header_search_visibility' => [
							'label' => __( 'Visibility', 'blocksy' ),
							'type' => 'ct-visibility',
							'design' => 'block',
							'setting' => [ 'transport' => 'postMessage' ],
							'allow_empty' => true,
							'value' => [
								'desktop' => true,
								'tablet' => true,
								'mobile' => false,
							],

							'choices' => blocksy_ordered_keys([
								'desktop' => __( 'Desktop', 'blocksy' ),
								'tablet' => __( 'Tablet', 'blocksy' ),
								'mobile' => __( 'Mobile', 'blocksy' ),
							]),
						],

					],
				],

				'cart_icon_panel' => [
					'label' => __( 'Shopping Cart', 'blocksy' ),
					'type' => class_exists( 'WooCommerce' ) ? 'ct-panel' : 'hidden',
					'value' => 'no',
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						blocksy_rand_md5() => [
							'title' => __( 'General', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'mini_cart_type' => [
									'label' => false,
									'type' => 'ct-image-picker',
									'value' => 'type-1',
									'attr' => [
										'data-type' => 'background',
										'data-columns' => '3',
									],
									'setting' => [ 'transport' => 'postMessage' ],
									'choices' => [

										'type-1' => [
											'src'   => blocksy_image_picker_file( 'cart-1' ),
											'title' => __( 'Type 1', 'blocksy' ),
										],

										'type-2' => [
											'src'   => blocksy_image_picker_file( 'cart-2' ),
											'title' => __( 'Type 2', 'blocksy' ),
										],

										'type-3' => [
											'src'   => blocksy_image_picker_file( 'cart-3' ),
											'title' => __( 'Type 3', 'blocksy' ),
										],
									],
								],

								'has_cart_badge' => [
									'label' => __( 'Cart Badge', 'blocksy' ),
									'type' => 'ct-switch',
									'value' => 'yes',
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'header_cart_visibility' => [
									'label' => __( 'Visibility', 'blocksy' ),
									'type' => 'ct-visibility',
									'design' => 'block',
									'setting' => [ 'transport' => 'postMessage' ],
									'allow_empty' => true,
									'value' => [
										'desktop' => true,
										'tablet' => true,
										'mobile' => false,
									],

									'choices' => blocksy_ordered_keys([
										'desktop' => __( 'Desktop', 'blocksy' ),
										'tablet' => __( 'Tablet', 'blocksy' ),
										'mobile' => __( 'Mobile', 'blocksy' ),
									]),
								],

							],
						],

						blocksy_rand_md5() => [
							'title' => __( 'Design', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'cartHeaderIconColor' => [
									'label' => __( 'Icon Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],

									'value' => [
										'default' => [
											'color' => 'var(--paletteColor3)',
										],

										'hover' => [
											'color' => 'var(--paletteColor1)',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

								'cartBadgeColor' => [
									'label' => __( 'Badge Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'background' => [
											'color' => 'var(--paletteColor1)',
										],

										'text' => [
											'color' => '#ffffff',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Background', 'blocksy' ),
											'id' => 'background',
										],

										[
											'title' => __( 'Text', 'blocksy' ),
											'id' => 'text',
										],
									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-title',
									'label' => __( 'Dropdowns Styles', 'blocksy' ),
									'attr' => [ 'data-type' => 'small' ],
								],

								'cartFontColor' => [
									'label' => __( 'Font Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'default' => [
											'color' => '#ffffff',
										],

										'hover' => [
											'color' => 'var(--paletteColor1)',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

								'cartDropDownBackground' => [
									'label' => __( 'Background Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],

									'value' => [
										'default' => [
											'color' => '#29333C',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],
									],
								],

							],
						],

					],
				],

				'header_button_panel' => [
					'label' => __( 'CTA Button', 'blocksy' ),
					'type' => 'ct-panel',
					'switch' => false,
					'value' => 'yes',
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						blocksy_rand_md5() => [
							'title' => __( 'General', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'header_button_type' => [
									'label' => false,
									'type' => 'ct-image-picker',
									'value' => 'type-1',
									'attr' => [ 'data-type' => 'background' ],
									'setting' => [ 'transport' => 'postMessage' ],
									'choices' => [

										'type-1' => [
											'src'   => blocksy_image_picker_file( 'button-1' ),
											'title' => __( 'Type 1', 'blocksy' ),
										],

										'type-2' => [
											'src'   => blocksy_image_picker_file( 'button-2' ),
											'title' => __( 'Type 2', 'blocksy' ),
										],

									],
								],

								'header_button_size' => [
									'label' => __('Button Size', 'blocksy'),
									'type' => 'ct-radio',
									'value' => 'medium',
									'view' => 'radio',
									'inline' => true,
									'design' => 'block',
									'setting' => [ 'transport' => 'postMessage' ],
									'choices' => [
										'small' => __( 'Small', 'blocksy' ),
										'medium' => __( 'Medium', 'blocksy' ),
										'large' => __( 'Large', 'blocksy' ),
									],
								],

								'header_button_text' => [
									'label' => __( 'Button Text', 'blocksy' ),
									'type' => 'text',
									'design' => 'block',
									'value' => __( 'Download', 'blocksy' ),
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'header_button_link' => [
									'label' => __( 'Button URL', 'blocksy' ),
									'type' => 'text',
									'design' => 'block',
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'header_button_target' => [
									'label' => __( 'Open in new tab', 'blocksy' ),
									'type'  => 'ct-switch',
									'value' => 'no',
									'setting' => [ 'transport' => 'postMessage' ],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-divider',
									'attr' => [ 'data-type' => 'small' ],
								],

								'header_button_visibility' => [
									'label' => __( 'Visibility', 'blocksy' ),
									'type' => 'ct-visibility',
									'design' => 'block',
									'setting' => [ 'transport' => 'postMessage' ],
									'allow_empty' => true,
									'value' => [
										'desktop' => false,
										'tablet' => false,
										'mobile' => false,
									],

									'choices' => blocksy_ordered_keys([
										'desktop' => __( 'Desktop', 'blocksy' ),
										'tablet' => __( 'Tablet', 'blocksy' ),
										'mobile' => __( 'Mobile', 'blocksy' ),
									]),
								],

							],
						],

						blocksy_rand_md5() => [
							'title' => __( 'Design', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'headerButtonFont' => [
									'label' => __( 'Font Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'default' => [
											'color' => '#ffffff',
										],

										'hover' => [
											'color' => '#ffffff',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

								'headerButtonBackground' => [
									'label' => __( 'Background Color', 'blocksy' ),
									'type'  => 'ct-color-picker',
									'design' => 'inline',
									'setting' => [ 'transport' => 'postMessage' ],
									'value' => [
										'default' => [
											'color' => 'var(--paletteColor1)',
										],

										'hover' => [
											'color' => 'var(--paletteColor2)',
										],
									],

									'pickers' => [
										[
											'title' => __( 'Initial', 'blocksy' ),
											'id' => 'default',
										],

										[
											'title' => __( 'Hover', 'blocksy' ),
											'id' => 'hover',
										],
									],
								],

								'headerButtonRadius' => [
									'label' => __( 'Corner Radius', 'blocksy' ),
									'type' => 'ct-number',
									'design' => 'inline',
									'value' => 5,
									'min' => 0,
									'max' => 100,
									'setting' => [ 'transport' => 'postMessage' ],
								],

							],
						],

					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

			],

			blocksy_get_options('general/transparent-header'),

		],
	],
];
