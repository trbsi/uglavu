<?php

namespace Blocksy;

class DemoInstallPluginsInstaller {
	public function import() {
		Plugin::instance()->demo->start_streaming();

		if (! current_user_can('edit_theme_options')) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'complete',
				'error' => false,
			]);
			exit;
		}

		if (! isset($_REQUEST['plugins']) || !$_REQUEST['plugins']) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'complete',
				'error' => false,
			]);
			exit;
		}

		$plugins = explode(':', $_REQUEST['plugins']);

		$plugins_manager = Plugin::instance()->demo->get_plugins_manager();

		foreach ($plugins as $single_plugin) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'install_plugin',
				'name' => $single_plugin
			]);

			$plugins_manager->prepare_install($single_plugin);

			Plugin::instance()->demo->emit_sse_message([
				'action' => 'activate_plugin',
				'name' => $single_plugin
			]);

			$plugins_manager->plugin_activation($single_plugin);
		}

		Plugin::instance()->demo->emit_sse_message([
			'action' => 'complete',
			'error' => false,
		]);

		exit;
	}
}

