<?php
return [
	[
		'name' => 'contact-form-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title to display above the form.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'contact-form-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the form.', 'sleek_child'),
		'type' => 'wysiwyg'
	],
	[
		'name' => 'contact-form-id',
		'label' => __('Form', 'sleek_child'),
		'instructions' => __('Select a Contact Form 7 form from the dropdown. Please note that this module requires the Contact Form 7 plug-in: https://wordpress.org/plugins/contact-form-7/', 'sleek_child'),
		'type' => 'post_object',
		'return_format' => 'id',
		'post_type' => ['wpcf7_contact_form'],
		'required' => true
	]
];
