<form id="search" method="get" action="<?php echo home_url(); ?>">
	<div>
		<input type="text" name="s" value="<?php if (get_search_query() == '') echo 'Search...'; the_search_query(); ?>" onclick="if(this.value=='Search...')this.value='';" onblur="if(this.value=='')this.value='Search...';" class="field" />
	</div>
	<div class="search-btn">
		<input type="submit" value="" />
	</div>
</form>