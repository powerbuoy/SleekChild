<?php
require_once get_stylesheet_directory() . '/inc/add-editor-styles.php';

######################################
# Modify WP's built in thumbnail sizes
add_action('after_setup_theme', function () {
	# (this prevents user's from overriding them inside the  admin - remove if you _want_ users to override your sizes)
	# Also note that all sizes should maintain the same aspect ratio otherwise WP will not add a srcset attribute
	update_option('thumbnail_size_w', 600);
	update_option('thumbnail_size_h', 338);
	update_option('thumbnail_crop', 1);

	update_option('medium_size_w', 900);
	update_option('medium_size_h', 506);
	update_option('medium_crop', 1);

	update_option('medium_large_size_w', 1200);
	update_option('medium_large_size_h', 675);
	update_option('medium_large_crop', 1);

	update_option('large_size_w', 1800);
	update_option('large_size_h', 1013);
	update_option('large_crop', 1);

	# Now set the sizes again so we can specify our own crop (note that if you only use this (and remove the above) users can still change the size in the admin)
	add_image_size('thumbnail', 600, 338, ['center', 'center']);
	add_image_size('medium', 900, 506, ['center', 'center']);
	add_image_size('medium_large', 1200, 675, ['center', 'center']);
	add_image_size('large', 1800, 1013, ['center', 'center']);

	# Add our own sizes if needed (you should probably add thumbnail, medium and large version of all your custom sizes so srcset works for them too)
#	add_image_size('thumbnail_portrait', 338, 600, ['center', 'center']);
#	add_image_size('medium_portrait', 506, 900, ['center', 'center']);
#	add_image_size('medium_large_portrait', 675, 1200, ['center', 'center']);
#	add_image_size('large_portrait', 1013, 1800, ['center', 'center']);

#	add_image_size('thumbnail_square', 600, 600, ['center', 'center']);
#	add_image_size('medium_square', 900, 900, ['center', 'center']);
#	add_image_size('medium_large_square', 1200, 1200, ['center', 'center']);
#	add_image_size('large_square', 1800, 1800, ['center', 'center']);
});

# Also add our own sizes to the image-size dropdown in the admin if you want
/* add_filter('image_size_names_choose', function ($sizes) {
	return array_merge($sizes, [
		'medium_portrait' => __('Thumbnail (portrait)', 'sleek_child'),
		'medium_square' => __('Thumbnail (square)', 'sleek_child')
	]);
}); */

###########################################
# Register custom post types and taxonomies
$postTypes = ['movie', 'director'];

add_action('init', function () use ($postTypes) {
	# Post types
#	sleek_register_post_types($postTypes, 'sleek_child');

	# Taxonomies
/*	sleek_register_taxonomies([
		'genre' => ['movie'],
		'country' => ['movie', 'director']
	], 'sleek_child'); */

	# Array of CPTs that should appear in search (on top of post/page)
	# (run this function unless you want all your CPTs to appear)
	# sleek_set_cpt_in_search(['movie']);
});

# Add meta data (title, description, image) to CPTs
/* add_action('admin_menu', function () use ($postTypes) {
	sleek_register_post_type_meta_data($postTypes); # Pass in more fields as second argument (, ['subtitle' => 'text'])
}); */

############################
# Disable certain post types
add_filter('template_redirect', function () {
	global $wp_query;

	# Attachments (NOTE: Add custom post types here as needed (is_singular('office') etc...))
	if (is_attachment()) {
		status_header(404);
		$wp_query->set_404();
	}
});

##############
# Register ACF
# Hide ACF from admin altogether (to prevent users from adding ACF from there)
add_filter('acf/settings/show_admin', '__return_false');

# Register fields
add_action('acf/init', function () {
	# ACF in post types
/*	sleek_register_acf([
		'page' => ['page-meta', 'redirect-url', 'text-content'],
		'movie' => ['redirect-url']
	], 'sleek_child'); */

	# ACF in module containers
/*	sleek_register_acf_modules([
		'page' => [
			'below-content' => ['video', 'buttons', 'text-content'],
			'above-content' => ['video']
		],
		'movie' => [
			'above-content' => ['video', 'buttons', 'text-content'],
			'next-to-content' => ['video']
		]
	], 'sleek_child'); */

	# ACF in options pages
/*	sleek_register_acf_options([
		# Option page called "Theme settings"
		'theme-settings' => ['page-meta', 'redirect-url']
	], 'sleek_child'); */
});

#####################
# Register CSS and JS
# (automatically adds dist/all.css and dist/all.js which are generated by Gulp)
add_action('wp_enqueue_scripts', function () {
	sleek_register_assets(); # Pass in more as array: ['https://fonts.googleapis.com/css?family=Lato:300,900|Roboto:900']
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

##############################################################
# Add more options to Appearance -> Customize -> Theme Options
# (then use your options with get_theme_mod('option_name') any way you like)
/* add_action('customize_register', function ($wpCustomize) {
	sleek_register_theme_options($wpCustomize, [
		'hubspot_portal_id' => 'text'
	], 'sleek_child');
});

add_action('wp_head', function () {
	# HubSpot tracking code
	if ($hsId = get_theme_mod('hubspot_portal_id')) {
		echo '<!-- Start of Async HubSpot Analytics Code -->
			<script type="text/javascript">
				(function(d,s,i,r) {
				if (d.getElementById(i)){return;}
				var n=d.createElement(s),e=d.getElementsByTagName(s)[0];
				n.id=i;n.src=\'//js.hs-analytics.net/analytics/\'+(Math.ceil(new Date()/r)*r)+\'/' . $hsId . '.js\';
				e.parentNode.insertBefore(n, e);
				})(document,"script","hs-analytics",300000);
			</script>
			<!-- End of Async HubSpot Analytics Code -->';
	}
}); */

##########################
# Add more fields to users
/* add_filter('user_contactmethods', function () {
	$fields['job_title'] = __('Job title', 'sleek_child');
	$fields['tel'] = __('Telephone', 'sleek_child');
	$fields['facebook'] = __('Facebook', 'sleek_child');
	$fields['twitter'] = __('Twitter', 'sleek_child');
	$fields['instagram'] = __('Instagram', 'sleek_child');
	$fields['linkedin'] = __('LinkedIn', 'sleek_child');
	$fields['googleplus'] = __('Google+', 'sleek_child');
	$fields['stackoverflow'] = __('StackOverflow', 'sleek_child');
	$fields['github'] = __('GitHub', 'sleek_child');

	return $fields;
}); */

#################
# Shorter excerpt
add_filter('excerpt_length', function () {
	return 25;
});

add_filter('excerpt_more', function () {
	return ' /../';
});

###############################
# Add custom fields to rest API
# Add more post types as needed
add_action('rest_api_init', function () {
	register_rest_field(['page', 'post'], 'custom_fields', ['get_callback' => function () {
		return get_post_custom($post['id']);
	}]);
});

##########################################################
# Add a 'post_type' argument to get_terms() if you need it
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
# (put your mo/po-files in your-theme/languages/)
add_action('after_setup_theme', function () {
	load_child_theme_textdomain('sleek_child', get_stylesheet_directory() . '/languages');

	# If you want to override parent theme translations, add them to languages/sleek/lang_Code.po and uncomment this:
	# load_theme_textdomain('sleek', get_stylesheet_directory() . '/languages/sleek');
});
