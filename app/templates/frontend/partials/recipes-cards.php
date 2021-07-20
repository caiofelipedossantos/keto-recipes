<?php
if ($fetched_recipes->have_posts()) :
?>
	<section id="keto-recipe-list" class="keto-clearfix keto-recipe-grid keto-recipe-loader keto-columns-3">
		<?php
		while ($fetched_recipes->have_posts()) :
			$fetched_recipes->the_post();
		?>
			<article class="keto-recipe has-post-thumbnail keto-recipe-card keto-recipe-card-modern-centered">
				<a href="<?php echo the_permalink(); ?>" class="keto-recipe-card-image" style="background-image:url('<?php echo get_the_post_thumbnail_url($fetched_recipes->ID, 'full') ?>');"></a>
				<span class="keto-recipe-card-content">
					<span class="keto-rating" data-recipe-id="<?php echo $fetched_recipes->ID ?>"></span>
					<a href="<?php echo the_permalink(); ?>" class="keto-recipe-card-title"><?php echo the_title(); ?></a>
					<span class="keto-recipe-card-author">By <strong><?php echo get_the_author_meta('display_name', $fetched_recipes->ID); ?></strong></span>
					<span class="keto-recipe-card-sep"></span>
					<span class="keto-recipe-card-excerpt"><?php echo wp_strip_all_tags(get_field("excerpt", $fetched_recipes->ID)); ?></span>
				</span>
			</article>
		<?php
		endwhile;
		wp_reset_postdata();
		?>
	</section>
<?php
else :
?>
	<section id="keto-recipe-list" class="keto-clearfix keto-recipe-grid keto-recipe-loader keto-columns-1">
		<p class="keto-recipe-empty">
			<?php echo esc_html_e('Sorry, no recipes found!', Keto_Recipes::PLUGIN_ID) ?>
		</p>
	</section>
<?php
endif;
?>