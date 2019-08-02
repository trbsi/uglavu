const locations = {
	post: 'single_blog_posts',
	page: 'single_pages',
	home: 'home',
	product: 'woocomerrce_single',
	product_archives: 'woocomerrce_posts_test'
}

wp.customize.bind('ready', () => {
	wp.customize.previewer.bind('location-change', location => {
		if (!location) return

		return

		if (
			Object.values(wp.customize.section._value).find(s => s.expanded())
		) {
			return
		}

		if (location === 'home') {
			console.log('home!!')

			/*
			Object.values(wp.customize.section._value)
				.filter(s => s.expanded())
				.map(s => s.expanded(false))
                */
			return
		}

		wp.customize.section(locations[location]).expanded(true)
	})
})
