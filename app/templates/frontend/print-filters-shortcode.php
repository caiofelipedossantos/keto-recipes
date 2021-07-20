<div class="keto-recipe-info keto-clearfix">
	<?php
	if ($fetch_categories) {
	?>
		<span class="keto-taxonomy keto-category">
			<strong class="keto-meta-title">Category</strong>
			<?php
			if (!empty($fetch_categories)) {
				foreach ($fetch_categories as $category) {
			?>
					<a href="<?php echo get_term_link($category->term_id, 'recipe_cat'); ?>" rel="tag"><?php echo esc_html_e($category->name); ?></a>,&nbsp;
			<?php
				}
			} else {
				echo esc_html_e('Sorry, no categories found!', Keto_Recipes::PLUGIN_ID);
			}
			?>
		</span>
	<?php
	}
	if ($fetch_cuisines) {
	?>
		<span class="keto-taxonomy keto-cuisine">
			<strong class="keto-meta-title">Cuisine</strong>
			<?php
			if (!empty($fetch_cuisines)) {
				foreach ($fetch_cuisines as $cuisines) {
			?>
					<a href="<?php echo get_term_link($cuisines->term_id, 'recipe_cuisine'); ?>" rel="tag"><?php echo esc_html_e($cuisines->name); ?></a>,&nbsp;
			<?php
				}
			} else {
				echo esc_html_e('Sorry, no cuisines found!', Keto_Recipes::PLUGIN_ID);
			}
			?>
		</span>
	<?php
	}
	if ($fetch_flags) {
	?>
		<span class="keto-tags">
			<strong class="keto-meta-title">Flag</strong>
			<?php
			if (!empty($fetch_flags)) {
				foreach ($fetch_flags as $flag) {
			?>
					<a href="<?php echo get_term_link($flag->term_id, 'recipe_flag'); ?>" rel="tag">&#35;<?php echo esc_html_e($flag->name); ?></a>,&nbsp;
			<?php
				}
			} else {
				echo esc_html_e('Sorry, no flags found!', Keto_Recipes::PLUGIN_ID);
			}
			?>
		</span>
	<?php
	}
	?>
</div>