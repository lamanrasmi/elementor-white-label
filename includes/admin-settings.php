<?php
/**
 * Admin Settings.
 */

$settings = self::get_settings();

?>
<style type="text/css">
		.elwl-wrap {
			max-width         : 800px;
			margin            : auto;
			padding           : 2em 0;

		}
		.elwl-section-title{
			-webkit-box-shadow: 0 0 8px rgba(0,0,0,.1);
			box-shadow        : 0 0 8px rgba(0,0,0,.1);
			padding           : 13px;
			background-image  : -webkit-linear-gradient(225deg,#ef295a,#434363);
			background-image  : -o-linear-gradient(225deg,#ef295a,#434363);
			background-image  : linear-gradient(-135deg,#ef295a,#434363);
		}
		.settings {
			padding           : 20px 50px 30px;
		}
		.elwl-plugin-title {
			text-transform    : uppercase;
			font-size         : 15px;
			color             : #fff;
			text-align        : center;
		}
		.success {
			border-left-color: #46b450;
			background       : #fff;
			border-left      : 4px solid #46b450;
			box-shadow       : 0 1px 1px 0 rgba(0,0,0,.1);
			margin           : 5px 15px 2px;
			padding          : 1px 12px;
			margin: 0 !important;
			    margin-bottom: 10px !important;
			    box-sizing: border-box;
		}
		.notice-info,
		.notice {
			display: none;
		}
		#el_wl_branding-settings-form {
			background: #fff;
		}
</style>

<div class="wrap">

	<div class="elwl-wrap">

		<?php self::render_update_message(); ?>

		<div class="elwl-section-title">
			<h2 class="elwl-plugin-title"> <?php esc_html_e( 'White Label Branding for Elementor Page Builder', 'el-wl-branding' ); ?></h2>
		</div>

		<form method="post" id="el_wl_branding-settings-form" class="settings" action="<?php echo self::get_form_action(); ?>">

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Plugin Name', 'el-wl-branding' ); ?>
						</th>
						<td>
							<input id=elwlbranding_plugin_name" name="elwlbranding_plugin_name" type="text" class="regular-text" value="<?php esc_attr_e( $settings['plugin_name'] ); ?>" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e('Plugin Description', 'el-wl-branding'); ?>
						</th>
						<td>
							<textarea id="elwlbranding_plugin_desc" name="elwlbranding_plugin_desc" style="width: 25em;"><?php echo $settings['plugin_desc']; ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e('Developer / Agency', 'el-wl-branding'); ?>
						</th>
						<td>
							<input id="elwlbranding_plugin_author" name="elwlbranding_plugin_author" type="text" class="regular-text" value="<?php echo $settings['plugin_author']; ?>" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e('Website URL', 'el-wl-branding'); ?>
						</th>
						<td>
							<input id="elwlbranding_plugin_uri" name="elwlbranding_plugin_uri" type="text" class="regular-text" value="<?php echo esc_url( $settings['plugin_uri'] ); ?>" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e('Menu Label', 'el-wl-branding'); ?>
						</th>
						<td>
							<input id="elwlbranding_admin_label" name="elwlbranding_admin_label" type="text" class="regular-text" value="<?php echo $settings['admin_label']; ?>" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e('Edit with Elementor Text', 'el-wl-branding'); ?>
						</th>
						<td>
							<input id="elwlbranding_edit_with_elementor" name="elwlbranding_edit_with_elementor" type="text" class="regular-text" value="<?php echo $settings['edit_with_elementor']; ?>" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e('Skin Color', 'el-wl-branding'); ?>
						</th>
						<td>
							<input id="elwlbranding_skin_color" name="elwlbranding_skin_color" type="text" class="color-field" value="<?php echo $settings['elementor_skin_color']; ?>" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e('Update Button Color', 'el-wl-branding'); ?>
						</th>
						<td>
							<input id="elwlbranding_update_button_color" name="elwlbranding_update_button_color" type="text" class="color-field" value="<?php echo $settings['elementor_update_btn_color']; ?>" />
						</td>
					</tr>


					<tr valign="top">
						<th scope="row" valign="top">
							<label for="elwlbranding_hide_logo"><?php esc_html_e('Hide Elementor Logo on Editing Screen', 'el-wl-branding'); ?></label>
						</th>
						<td>
							<input id="elwlbranding_hide_logo" name="elwlbranding_hide_logo" type="checkbox" class="" value="off" <?php echo isset( $settings['hide_elementor_logo'] ) && 'on' == $settings['hide_elementor_logo'] ? ' checked="checked" ' : ''; ?> />
						</td>
					</tr>

				</tbody>
			</table>
			<?php submit_button('Save Settings', 'button-primary button-hero'); ?>
			<?php wp_nonce_field( 'el_wl_branding-settings', 'el_wl_branding-settings-nonce' ); ?>

		</form>
	</div>


</div>

<script>
	jQuery(document).ready(function($){
	    $('.color-field').wpColorPicker();
	});
</script>
