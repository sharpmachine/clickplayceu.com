<script type="text/javascript">
	function doClear(theText) {
		if (theText.value == theText.defaultValue) {
			theText.value = ""
		}
	}
</script>

<div id="search">
	<form method="get" id="search-form" action="<?php bloginfo('home'); ?>/">
		<input type="text" name="s" id="s" value="" onfocus="doClear(this)" />
		<input type="submit" id="search-submit" value="Search" />
	</form>
</div>