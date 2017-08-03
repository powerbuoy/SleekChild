<?php
	global $post;

	$rows = get_posts([
		'post_type' => ($data['latest-posts-post-type'] ? $data['latest-posts-post-type'] : 'any'),
		'numberposts' => $data['latest-posts-limit']
	]);
?>

<?php if ($rows) : ?>
	<section id="latest-posts">

		<?php if ($data['latest-posts-title'] or $data['latest-posts-description']) : ?>
			<header>

				<?php if ($data['latest-posts-title']) : ?>
					<h2><?php echo $data['latest-posts-title'] ?></h2>
				<?php endif ?>

				<?php echo $data['latest-posts-description'] ?>

			</header>
		<?php endif ?>

		<?php foreach ($rows as $post) : setup_postdata($post) ?>
			<?php # TODO: If redirect-url is set - open links in new windows ?>
			<article>

				<?php if (has_post_thumbnail()) : ?>
					<figure>
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('large') ?>
						</a>
					</figure>
				<?php endif ?>

				<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>

				<?php the_excerpt() ?>

				<?php sleek_get_template_part('acf/buttons/default', ['data' => ['buttons' => get_field('buttons')]]) ?>

				<a href="<?php the_permalink() ?>"><?php _e('Read more', 'sleek_child') ?></a>

			</article>
		<?php endforeach; wp_reset_postdata() ?>

	</section>
<?php endif ?>