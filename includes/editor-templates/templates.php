<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<script type="text/template" id="tmpl-wroter-template-library-header">
	<div id="wroter-template-library-header-logo-area"></div>
	<div id="wroter-template-library-header-menu-area"></div>
	<div id="wroter-template-library-header-items-area">
		<div id="wroter-template-library-header-close-modal" class="wroter-template-library-header-item" title="<?php _e( 'Close', 'wroter' ); ?>">
			<i class="eicon-close" title="<?php _e( 'Close', 'wroter' ); ?>"></i>
		</div>
		<div id="wroter-template-library-header-tools"></div>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-header-logo">
	<i class="eicon-wroter-square"></i><span><?php _e( 'Library', 'wroter' ); ?></span>
</script>

<script type="text/template" id="tmpl-wroter-template-library-header-save">
	<i class="eicon-save" title="<?php _e( 'Save Template', 'wroter' ); ?>"></i>
</script>

<script type="text/template" id="tmpl-wroter-template-library-header-menu">
	<div id="wroter-template-library-menu-pre-made-templates" class="wroter-template-library-menu-item" data-template-source="remote"><?php _e( 'Predesigned Templates', 'wroter' ); ?></div>
	<div id="wroter-template-library-menu-my-templates" class="wroter-template-library-menu-item" data-template-source="local"><?php _e( 'My Templates', 'wroter' ); ?></div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-header-preview">
	<div id="wroter-template-library-header-preview-insert-wrapper" class="wroter-template-library-header-item">
		<button id="wroter-template-library-header-preview-insert" class="wroter-template-library-template-insert wroter-button wroter-button-success">
			<i class="eicon-file-download"></i><span class="wroter-button-title"><?php _e( 'Insert', 'wroter' ); ?></span>
		</button>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-header-back">
	<i class="eicon-"></i><span><?php _e( 'Back To library', 'wroter' ); ?></span>
</script>

<script type="text/template" id="tmpl-wroter-template-library-loading">
	<div class="wroter-loader-wrapper">
		<div class="wroter-loader">
			<div class="wroter-loader-box"></div>
			<div class="wroter-loader-box"></div>
			<div class="wroter-loader-box"></div>
			<div class="wroter-loader-box"></div>
		</div>
		<div class="wroter-loading-title"><?php _e( 'Loading', 'wroter' ) ?></div>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-templates">
	<div id="wroter-template-library-templates-container"></div>
	<div id="wroter-template-library-footer-banner">
		<i class="eicon-nerd"></i>
		<div class="wroter-excerpt"><?php echo __( 'Stay tuned! More awesome templates coming real soon.', 'wroter' ); ?></div>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-template-remote">
	<div class="wroter-template-library-template-body">
		<div class="wroter-template-library-template-screenshot" style="background-image: url({{ thumbnail }});"></div>
		<div class="wroter-template-library-template-controls">
			<div class="wroter-template-library-template-preview">
				<i class="fa fa-search-plus"></i>
			</div>
			<button class="wroter-template-library-template-insert wroter-button wroter-button-success">
				<i class="eicon-file-download"></i>
				<?php _e( 'Insert', 'wroter' ); ?>
			</button>
		</div>
	</div>
	<div class="wroter-template-library-template-name">{{{ title }}}</div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-template-local">
	<div class="wroter-template-library-template-icon">
		<i class="fa fa-{{ 'section' === type ? 'columns' : 'file-text-o' }}"></i>
	</div>
	<div class="wroter-template-library-template-name">{{{ title }}}</div>
	<div class="wroter-template-library-template-type">{{{ wroter.translate( type ) }}}</div>
	<div class="wroter-template-library-template-controls">
		<button class="wroter-template-library-template-insert wroter-button wroter-button-success">
			<i class="eicon-file-download"></i><span class="wroter-button-title"><?php _e( 'Insert', 'wroter' ); ?></span>
		</button>
		<div class="wroter-template-library-template-export">
			<a href="{{ export_link }}">
				<i class="fa fa-sign-out"></i><span class="wroter-template-library-template-control-title"><?php echo __( 'Export', 'wroter' ); ?></span>
			</a>
		</div>
		<div class="wroter-template-library-template-delete">
			<i class="fa fa-trash-o"></i><span class="wroter-template-library-template-control-title"><?php echo __( 'Delete', 'wroter' ); ?></span>
		</div>
		<div class="wroter-template-library-template-preview">
			<i class="eicon-zoom-in"></i><span class="wroter-template-library-template-control-title"><?php echo __( 'Preview', 'wroter' ); ?></span>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-save-template">
	<div class="wroter-template-library-blank-title">{{{ wroter.translate( 'save_your_template', [ wroter.translate( sectionID ? 'section' : 'page' ) ] ) }}}</div>
	<div class="wroter-template-library-blank-excerpt"><?php _e( 'Your designs will be available for export and reuse on any page or website', 'wroter' ); ?></div>
	<form id="wroter-template-library-save-template-form">
		<input id="wroter-template-library-save-template-name" name="title" placeholder="<?php _e( 'Enter Template Name', 'wroter' ); ?>" required>
		<button id="wroter-template-library-save-template-submit" class="wroter-button wroter-button-success">
			<span class="wroter-state-icon">
				<i class="fa fa-spin fa-circle-o-notch "></i>
			</span>
			<?php _e( 'Save', 'wroter' ); ?>
		</button>
	</form>
	<div class="wroter-template-library-blank-footer">
		<?php _e( 'What is Library?', 'wroter' ); ?>
		<a class="wroter-template-library-blank-footer-link" href="https://go.wroter.com/docs-library/" target="_blank"><?php _e( 'Read our tutorial on using Library templates.', 'wroter' ); ?></a>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-import">
	<form id="wroter-template-library-import-form">
		<input type="file" name="file" />
		<input type="submit">
	</form>
</script>

<script type="text/template" id="tmpl-wroter-template-library-templates-empty">
	<div id="wroter-template-library-templates-empty-icon">
		<i class="eicon-nerd"></i>
	</div>
	<div class="wroter-template-library-blank-title"><?php _e( 'Haven’t Saved Templates Yet?', 'wroter' ); ?></div>
	<div class="wroter-template-library-blank-excerpt"><?php _e( 'This is where your templates should be. Design it. Save it. Reuse it.', 'wroter' ); ?></div>
	<div class="wroter-template-library-blank-footer">
		<?php _e( 'What is Library?', 'wroter' ); ?>
		<a class="wroter-template-library-blank-footer-link" href="https://go.wroter.com/docs-library/" target="_blank"><?php _e( 'Read our tutorial on using Library templates.', 'wroter' ); ?></a>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-template-library-preview">
	<iframe></iframe>
</script>
