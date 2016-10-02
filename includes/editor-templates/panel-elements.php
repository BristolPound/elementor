<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<script type="text/template" id="tmpl-wroter-panel-elements">
	<div id="wroter-panel-elements-search-area"></div>
	<div id="wroter-panel-elements-wrapper"></div>
</script>

<script type="text/template" id="tmpl-wroter-panel-elements-category">
	<div class="panel-elements-category-title">{{{ title }}}</div>
	<div class="panel-elements-category-items"></div>
</script>

<script type="text/template" id="tmpl-wroter-panel-element-search">
	<input id="wroter-panel-elements-search-input" placeholder="<?php _e( 'Search Widget...', 'wroter' ); ?>" />
	<i class="fa fa-search"></i>
</script>

<script type="text/template" id="tmpl-wroter-element-library-element">
	<div class="wroter-element">
		<div class="icon">
			<i class="eicon-{{ icon }}"></i>
		</div>
		<div class="wroter-element-title-wrapper">
			<div class="title">{{{ title }}}</div>
		</div>
	</div>
</script>
