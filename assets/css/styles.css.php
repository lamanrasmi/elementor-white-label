
<?php 

	$settings = self::get_settings();

	if ( isset( $settings['elementor_skin_color'] ) && ! empty( $settings['elementor_skin_color'] ) ) : ?>

	div.elementor-panel #elementor-panel-header,
	div.elementor-add-new-section .elementor-add-section-button,
	div#elementor-mode-switcher:hover,
	div.elementor-template-library-template-remote.elementor-template-library-pro-template .elementor-template-library-template-body:before,
	#elementor-panel-inner #elementor-mode-switcher:hover, html body.elementor-editor-preview #elementor-mode-switcher,
	body #nprogress .bar {
		background-color: <?php echo $settings['elementor_skin_color']; ?>;
	}
	div.elementor-panel .elementor-panel-navigation .elementor-panel-navigation-tab.elementor-active,
	div.elementor-templates-modal__header .elementor-template-library-menu-item.elementor-active {
		border-bottom-color: <?php echo $settings['elementor_skin_color']; ?>;
	}
	div.elementor-panel .elementor-control-type-gallery .elementor-control-gallery-clear,
	div.elementor-panel .elementor-element:hover .icon,
	div.elementor-panel .elementor-element:hover .title,
	div.elementor-panel a,
	div.elementor-panel a:hover {
		color: <?php echo $settings['elementor_skin_color']; ?>;
	}
	body #nprogress .peg {
		-webkit-box-shadow: 0 0 10px <?php echo $settings['elementor_skin_color']; ?>, 0 0 5px <?php echo $settings['elementor_skin_color']; ?>;
		box-shadow: 0 0 10px <?php echo $settings['elementor_skin_color']; ?>, 0 0 5px <?php echo $settings['elementor_skin_color']; ?>;
	}

<?php endif; ?>

<?php if ( isset( $settings['elementor_update_btn_color'] ) && ! empty( $settings['elementor_update_btn_color'] ) ) : ?>
	div .elementor-button.elementor-button-success:not([disabled]) {
		background-color: <?php echo $settings['elementor_update_btn_color']; ?>;
	}
<?php endif; ?>

<?php if ( 'on' == $settings['hide_elementor_logo'] ) : ?>
	#elementor-panel #elementor-panel-header-title img {
		width: 0;
	}
<?php endif; ?>	

