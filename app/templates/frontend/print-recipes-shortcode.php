<?php
    if($search == "true"):
?>
    <section class="keto-recipe-search keto-clearfix">
    	<form action="" method="get" class="keto-recipe-form">
    		<div class="keto-fields-wrap keto-5-search-fields">
    			<div class="keto-field-wrap keto-field-wrap-select">
    				<span class="keto-browse-select">
    					<span class="keto-field-title">Browse</span>
    					<span class="keto-browse-select-block keto-clearfix">
    						<span class="keto-tax-column">
    							<span class="keto-tax-column-title">Categories</span>
    							<div class="keto-tax-scrollable">
    								<?php
    								if (!empty($fetch_categories)) {
    								    
    								    $onclick = 'onclick="return false;"';
    								    
    								    $categories = array();
    								    
    								    if(!empty($options['categories']) && $options['categories'] != 'all'){
    								        $categories = explode('|', $options['categories']);
    								    }
    								    
    								    
    									foreach ($fetch_categories as $category) {
    									    $disable = '';
    									    $checked = 'checked';
    									    
    									    if(!empty($options['categories']) && $options['categories'] == 'all' || !isset($options['categories']) || empty($options['categories'])){
    									        $onclick = '';
    									        $checked = '';
    									    }
    									    
    									    if(!empty($options['categories']) && $options['categories'] != 'all'){
        									    if(!in_array($category->slug, $categories)){
        									        $disable = 'disabled';
        									        $checked = '';
        									    }   
    									    }
    								?>
    										<label for="<?php echo $category->slug; ?>" class="keto-label <?php echo $disable; ?>">
    										    <input type="checkbox" id="<?php echo $category->slug; ?>" name="categories[]" value="<?php echo $category->slug; ?>" <?php echo $onclick; ?> <?php echo $checked; ?> />&nbsp;<?php echo esc_html_e($category->name); ?>
    										</label>
    								<?php
    									}
    								}
    								?>
    							</div>
    						</span>
    						<span class="keto-tax-column">
    							<span class="keto-tax-column-title">Cuisines</span>
    							<div class="keto-tax-scrollable">
    								<?php
    								if (!empty($fetch_cuisines)) {
    								    
    								    $onclick = 'onclick="return false;"';
    								    
    								    $cuisines = array();
    								    
    								    if(!empty($options['cuisines']) && $options['cuisines'] != 'all'){
    								        $cuisines = explode('|', $options['cuisines']);
    								    }
    								    
    									foreach ($fetch_cuisines as $cuisine) {
    									    
    									    $disable = '';
    									    $checked = 'checked';
    									    
    									    if(!empty($options['cuisines']) && $options['cuisines'] == 'all' || !isset($options['cuisines']) || empty($options['cuisines'])){
    									        $onclick = '';
    									        $checked = '';
    									    }
    									    
    									    if(!empty($options['cuisines']) && $options['cuisines'] != 'all'){
        									    if(!in_array($cuisine->slug, $cuisines)){
        									        $disable = 'disabled';
        									        $checked = '';
        									    }   
    									    }
    								?>
    										<label for="<?php echo $cuisine->slug; ?>" class="keto-label <?php echo $disable; ?>">
    										    <input type="checkbox" id="<?php echo $cuisine->slug; ?>" name="cuisines[]" value="<?php echo $cuisine->slug; ?>" <?php echo $onclick; ?> <?php echo $checked; ?> />&nbsp;<?php echo esc_html_e($cuisine->name); ?>
    										</label>
    								<?php
    									}
    								}
    								?>
    							</div>
    						</span>
    						<span class="keto-tax-column">
    							<span class="keto-tax-column-title">Tags</span>
    							<div class="keto-tax-scrollable">
    								
    								<?php
    								if (!empty($fetch_flags)) {
    								    
    								    $onclick = 'onclick="return false;"';
    								    
    								    $flags = array();
    								    
    								    if(!empty($options['flags']) && $options['flags'] != 'all'){
    								        $flags = explode('|', $options['flags']);
    								    }
    									foreach ($fetch_flags as $flag) {
    									    $disable = '';
    									    $checked = 'checked';
    									    
    									    if(!empty($options['flags']) && $options['flags'] == 'all' || !isset($options['flags']) || empty($options['flags'])){
    									        $onclick = '';
    									        $checked = '';
    									    }
    									    
    									    if(!empty($options['flags']) && $options['flags'] != 'all'){
        									    if(!in_array($flag->slug, $flags)){
        									        $disable = 'disabled';
        									        $checked = '';
        									    }   
    									    }
    								?>
    								    <label for="<?php echo $flag->slug; ?>" class="keto-label <?php echo $disable; ?>">
    									    <input type="checkbox" id="<?php echo $flag->slug; ?>" name="flags[]" value="<?php echo $flag->slug; ?>" <?php echo $onclick; ?> <?php echo $checked; ?> />&nbsp;&#35;<?php echo esc_html_e($flag->name); ?>
    									</label>
    								<?php
    									}
    								}
    								?>
    							</div>
    						</span>
    					</span>
    				</span>
    			</div>
    			<input class="keto-browse-search" type="text" name="keto_search_s" value="" placeholder="Find a recipe...">
    			<a href="javascript:void(0);" class="keto-browse-search-button">
    				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search align-middle me-2">
    					<circle cx="11" cy="11" r="8"></circle>
    					<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    				</svg>
    			</a>
    		</div>
    		<span class="keto-sortby-wrap">
    			<select class="keto-sortby-select" name="keto_browse_sort_by">
    				<option value="date_desc" selected="">Newest first</option>
    				<option value="date_asc">Oldest first</option>
    				<option value="title_asc">Alphabetical (A-Z)</option>
    				<option value="title_desc">Alphabetical (Z-A)</option>
    			</select>
    		</span>
    	</form>
    </section>
<?php
    endif;
?>
<div id="keto-recipe-container">
    <?php
      include_once( 'partials/recipes-cards.php');
    ?>
</div>

