<?php

function blc_output_read_progress_bar() {
	if (! BlocksyExtensionReadProgress::should_enable_progress_bar()) {
		return '';
	}

	return '<div class="ct-read-progress-bar"></div>';
}

