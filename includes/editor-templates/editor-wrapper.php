<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo __( 'Wroter', 'wroter' ) . ' | ' . get_the_title(); ?></title>
	<?php wp_head(); ?>
</head>
<body class="wroter-editor-active">
<div id="wroter-editor-wrapper">
	<div id="wroter-preview">
		<div id="wroter-loading">
			<div class="wroter-loader-wrapper">
				<div class="wroter-loader">
					<div class="wroter-loader-box"></div>
					<div class="wroter-loader-box"></div>
					<div class="wroter-loader-box"></div>
					<div class="wroter-loader-box"></div>
				</div>
				<div class="wroter-loading-title"><?php _e( 'Loading', 'wroter' ) ?></div>
			</div>
		</div>
		<div id="wroter-preview-responsive-wrapper" class="wroter-device-desktop wroter-device-rotate-portrait">
			<?php
			// IFrame will be create here by the Javascript later.
			?>
		</div>
	</div>
	<div id="wroter-panel"></div>
</div>
<?php wp_footer(); ?>
</body>
</html>
