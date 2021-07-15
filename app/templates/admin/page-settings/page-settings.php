<!-- Our admin page content should all be inside .wrap -->
<div class="wrap">
	<!-- Print the page title -->
	<h2><?php echo esc_html($page_title); ?></h2>
	<!-- Here are our tabs -->
	<nav class="nav-tab-wrapper">
		<?php
		foreach ($tabs as $tab) {
		?>
			<a href="?page=<?php echo esc_html($slug); ?>" class="nav-tab <?php if ($active === $tab['tab']) : ?>nav-tab-active<?php endif; ?>"><?php echo esc_html($tab['title']); ?></a>
		<?php
		}
		?>
	</nav>

	<div class="tab-content">
		<?php switch ($active):
			default:
		?>
				<form id="keto_recipes" method="post" action="options.php">
					<?php
					settings_fields($settings_name);
					do_settings_sections($settings_name);
					submit_button();
					?>
				</form>
		<?php
				break;
		endswitch; ?>
	</div>
</div><!-- .wrap -->
