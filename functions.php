<?php
require_once get_stylesheet_directory() . '/inc/add-editor-styles.php';
require_once get_stylesheet_directory() . '/inc/add-wp-admin-cols.php';

######################################
# Modify WP's built in thumbnail sizes
add_action('after_setup_theme', function () {
	# Pass in the width/height of the largest image. Sizes will be registered for
	# thumbnail (25%), medium (50%), medium_large (75%) and large (the size you pass in)
	# Pass in additional sizes as last array with an optional 'crop' key
	sleek_register_image_sizes(1920, 1080, ['center', 'center']/*, [
		'portrait' => ['width' => 1080, 'height' => 1920],
		'square' => ['width' => 1920, 'height' => 1920],
	]*/);
});

###########################################
# Register custom post types and taxonomies
# NOTE: This can be an associative array if you need to override default post type config
$postTypes = [
	'movie',
	'director' => [
		'menu_icon' => 'dashicons-businessman',
		'description' => __('A list of famous film directors', 'sleek_child')
	]
];

add_action('init', function () use ($postTypes) {
	# Post types
#	sleek_register_post_types($postTypes, 'sleek_child');

	# Taxonomies
/*	sleek_register_taxonomies([
		'genre' => ['movie'],
		'country' => ['movie', 'director']
	], 'sleek_child'); */

	# Array of CPTs that should appear in search (on top of post/page)
	# NOTE: Run this function unless you want all your CPTs to appear in search
	# sleek_set_cpt_in_search(['movie']);
});

###################################################
# Create archive meta data pages for our post types
# NOTE: You can add more fields to these pages using the "${postType}_archive_meta" key
/* add_action('acf/init', function () use ($postTypes) {
	sleek_archive_meta_data($postTypes);
}); */

##############
# Register ACF
# Hide ACF from admin altogether (to prevent users from adding ACF from there)
add_filter('acf/settings/show_admin', '__return_false');

# Register fields
add_action('acf/init', function () {
	# Add an options page
/*	sleek_acf_add_options_page([
		'page_title' => __('Theme settings', 'sleek_child'),
		'menu_slug' => 'theme_settings',
		'post_id' => 'theme_settings' # NOTE: Use this id in get_field('my_field', 'theme_settings')
	]); */

	# Add some fields to the options page
/*	sleek_acf([
		'key' => 'theme_settings',
		'title' => __('Theme settings', 'sleek_child'),
		'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'theme_settings']]],
		'fields' => [
			'contact-form'
		]
	]); */

	# Add more fields to the archive options page for movies
/*	sleek_acf([
		'key' => 'archive_fields',
		'title' => __('Archive options', 'sleek_child'),
		'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'movie_archive_meta']]],
		'fields' => [
			'contact-form'
		]
	]); */

	# Add ACF to a flexible content field named "after-page-content"
	# NOTE: Render these fields using sleek_acf_render_modules('below_content')
/*	sleek_acf([
		'key' => 'modules',
		'title' => __('Modules', 'sleek_child'),
		'flexible' => true,
		'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]],
		'fields' => [
			'below_content' => [
				'attachments', 'child-pages', 'contact-form', 'counter', 'divider', 'featured-posts', 'gallery',
				'google-map', 'hubspot-cta', 'hubspot-form', 'instagram', 'latest-posts', 'next-post', 'page-menu',
				'share-page', 'sibling-pages', 'sticky-post', 'text-block', 'text-blocks', 'users', 'video'
			]
		]
	]); */

	# Add fixed ACF fields to the sidebar
/*	sleek_acf([
		'key' => 'page_options',
		'title' => __('Page options', 'sleek_child'),
		'position' => 'side',
		'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]],
		'fields' => [
			'redirect-url'
		]
	]); */

	# Add fixed, tabbed ACF fields below the editor
/*	sleek_acf([
		'key' => 'page_content',
		'title' => __('Page content', 'sleek_child'),
		'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]],
		'tab_placement' => 'left',
		'fields' => [
			# NOTE: Nested arrays create tabs
			__('Form', 'sleek_child') => [
				'contact-form'
			],
			__('Additional content', 'sleek_child') => [
				'text-block'
			]
		]
	]); */

	# Add a single field below the title
/*	sleek_acf([
		'key' => 'below_title',
		'title' => __('Subtitle'),
		'position' => 'acf_after_title',
		'layout' => 'seamless',
		'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]],
		'fields' => [
			'subtitle'
		]
	]); */
});

#####################
# Register CSS and JS
# (automatically adds dist/all.css and dist/all.js which are generated by Gulp)
add_action('wp_enqueue_scripts', function () {
	sleek_register_assets(); # Pass in more as array: ['https://fonts.googleapis.com/css?family=Lato:300,900|Roboto:900', 'https://cdn.jsdelivr.net/npm/vue@latest/dist/vue.js']

	# Add more JS config here (under the "sleek"-handle (but using your own variable name "SLEEK_CHILD_CONFIG"))
	wp_localize_script('sleek', 'SLEEK_CHILD_CONFIG', [
		'COOKIE_CONSENT' => __('We use cookies to bring you the best possible experience when browsing our site. <a href="https://cookiesandyou.com/" target="_blank">Read more about cookies</a> | <a href="#" class="close">Accept</a>', 'sleek')
	]);
});

###################
# Register sidebars
/* add_action('init', function () {
	sleek_register_sidebars([
		'header' => __('Header', 'sleek_child'),
		'footer' => __('Footer', 'sleek_child'),
		'aside' => [
			'name' => __('Aside', 'sleek_child'),
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		]
	]);
}); */

###################
# Add menu location
/* add_action('after_setup_theme', function () {
	register_nav_menu('header', __('Header menu', 'sleek_child'));
}); */

########################
# Add more theme options
/* add_action('customize_register', function ($wpCustomize) {
	# The hubspot_portal_id is used by the HS-modules
	sleek_register_theme_options($wpCustomize, [
		'hubspot_portal_id' => 'text'
	], 'sleek_child');
});

# Use the new theme options
add_action('wp_head', function () {
	if ($hspid = get_theme_mod('hubspot_portal_id')) {
		echo '<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/' . $hspid . '.js"></script>';
	}
}); */

##########################
# Add more fields to users
/* add_filter('user_contactmethods', function ($fields) {
	$fields['tagline'] = __('Tagline', 'sleek_child');
	$fields['phone'] = __('Telephone', 'sleek_child');
	$fields['facebook'] = __('Facebook', 'sleek_child');
	$fields['twitter'] = __('Twitter', 'sleek_child');
	$fields['instagram'] = __('Instagram', 'sleek_child');
	$fields['linkedin'] = __('LinkedIn', 'sleek_child');
	$fields['googleplus'] = __('Google+', 'sleek_child');
	$fields['stackoverflow'] = __('StackOverflow', 'sleek_child');
	$fields['github'] = __('GitHub', 'sleek_child');

	return $fields;
}); */

################
# Modify excerpt
add_filter('excerpt_length', function () {
	return 25;
});

add_filter('excerpt_more', function () {
	return ' /../';
});

###############################
# Add custom fields to rest API
# NOTE: Add more post types and fields as needed
add_action('rest_api_init', function () {
	register_rest_field(['page', 'post'], 'custom_fields', ['get_callback' => function ($post) {
		return get_post_custom($post['id']);
	}]);
});

##########################################################
# Add a "post_type" argument to get_terms() if you need it
# add_filter('terms_clauses', 'sleek_terms_clauses', 10, 3);

####################################################
# Enable search inside custom fields (including ACF)
# require_once get_template_directory() . '/inc/include-postmeta-in-search.php';

##################################
# Require login on the entire site
/* add_action('init', function () {
	if (!is_admin() and !sleek_is_login_page() and !is_user_logged_in()) {
		auth_redirect();
	}
}); */

########################
# Set up for translation
# NOTE: Put your mo/po-files in the /languages directory
add_action('after_setup_theme', function () {
	load_child_theme_textdomain('sleek_child', get_stylesheet_directory() . '/languages');

	# If you want to override parent theme translations, add them to languages/sleek/lang_Code.po and uncomment this:
	# load_theme_textdomain('sleek', get_stylesheet_directory() . '/languages/sleek');
});
