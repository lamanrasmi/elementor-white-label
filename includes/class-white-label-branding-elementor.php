<?php

/**
 * Elementor White Label Branding Final Class
 *
 * @link       http://www.ozanwp.com
 * @since      1.0.0
 *
 * @package    Elementor_WL_Branding
 * @subpackage Elementor_WL_Branding/includes
 * @author     Ozan Canakli <ozan@ozanwp.com>
 */

final class Elementor_WL_Branding {


		/**
		 * Settings Array
		 *
		 * @since 1.0.0
		 */
		public static $settings = array();


		/**
		 * Enable white labeling setting form after re-activating the plugin
		 *
		 * @since 1.0.0
		 */
		public static function ewl_plugin_activation() {
			$settings = get_site_option( 'elwlbranding_settings' );

			update_site_option( 'elwlbranding_settings', $settings );
			add_option('elwl_do_activation_redirect', true);
		}


		/**
		 * Render branding styles.
		 *
		 * @since 1.0.0
		 */
	    static public function branding_styles()
	    {
			if ( ! is_user_logged_in() ) {
				return;
			}
	        //$branding = self::get_branding();
	        echo '<style id="elementor-wl-branding">';
			include ELEMENTOR_WL_BRANDING_DIR . 'assets/css/styles.css.php';
			echo '</style>';
		}




		/**
		 * Add Elementor White Label to wp-admin settings menu.
		 *
		 * @since 1.0.0
		 */
		public static function add_menu()
		{
			if ( is_main_site() || ! is_multisite() ) {

				if ( current_user_can( 'update_plugins' ) ) {

					$title = esc_html__( 'White Label Branding', 'el-wl-branding' );
					$cap   = 'update_plugins';
					$slug  = 'el-wl-branding';
					$func  = 'Elementor_WL_Branding::admin_settings';

					add_submenu_page( 'elementor', $title, $title, $cap, $slug, $func );
				}
			}
		}

		/**
		 * Elementor White Label admin settings
		 *
		 * @since 1.0.0
		 */
		public static function admin_settings() {
			include ELEMENTOR_WL_BRANDING_DIR . '/includes/admin-settings.php';
		}


		/**
		* Load the plugin text domain for translation.
		*
		* @since    1.0.0
		*/
		static public function load_plugin_textdomain()
	    {

			load_plugin_textdomain(
				'el-wl-branding',
				false,
				dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
			);
		}


		/**
		 * Initialization Hooks
		 *
		 * @since 1.0.0
		 */
		public static function init_hooks() {

			add_filter( 'gettext', __CLASS__ . '::change_elementor_text', 500, 3 );

			if ( ! is_admin() ) {
				return;
			}

			
			add_filter( 'all_plugins', __CLASS__ . '::update_branding' );
			add_filter( 'plugin_row_meta', __CLASS__ . '::plugin_row_meta', 500, 2 );

			if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
				add_filter( 'plugin_action_links_' . ELEMENTOR_PRO_PLUGIN_BASE, __CLASS__ . '::plugin_action_links', 500 );
			}


			if ( isset( $_REQUEST['page'] ) && 'el-wl-branding' == $_REQUEST['page'] ) {
				if ( ! current_user_can('update_plugins') ) {
					return;
				}

				self::save_settings();
			}
		}


		/**
		 * Redirect settings page when plugin activated
		 *
		 * @since 1.0.1
		 */
		public static function elwl_activation_redirect() {
		    if (get_option('elwl_do_activation_redirect', false)) {
		        delete_option('elwl_do_activation_redirect');
		        if(!isset($_GET['activate-multi']))
		        {
		            exit( wp_redirect( admin_url( 'admin.php?page=el-wl-branding' ) ) );
		        }
		    }
		}


		/**
		 * Get settings.
		 *
		 * @since 1.0.0
		 */
		public static function get_settings() {
			$default_settings = array(
				'plugin_name'               => '',
				'plugin_desc'               => '',
				'plugin_author'             => '',
				'plugin_uri'                => '',
				'admin_label'               => 'Elementor',
				'edit_with_elementor'       => 'Edit with Elementor',
				'elementor_skin_color'      => '',
				'elementor_update_btn_color'=> '',
				'hide_elementor_logo'      => 'off',
			);

			$settings = self::get_option( 'elwlbranding_settings', true );

			if ( ! is_array( $settings ) || empty( $settings ) ) {
				return $default_settings;
			}

			if ( is_array( $settings ) && ! empty( $settings ) ) {
				return array_merge( $default_settings, $settings );
			}
		}

		/**
		 * Change Elementor admin menu label.
		 *
		 * @since 1.0.0
		 */
		public static function change_elementor_text( $changed_text, $text, $domain ) {

			$settings = self::get_settings();

			$admin_label = $settings['admin_label'];

			$admin_label = trim( $admin_label ) == '' ? 'Elementor' : trim( $admin_label );

			if ( is_admin() && $text === 'Elementor' ) {
				$changed_text = $admin_label;
			}

			$edit_with_elementor = $settings['edit_with_elementor'];

			if ( $text === 'Edit with Elementor' ) {
				$changed_text = $edit_with_elementor;
			}

			return $changed_text;
		}


		/**
		 * Renders the update message.
		 *
		 * @since 1.0.0
		 */
		public static function render_update_message() {
			if ( ! empty( $_POST ) ) {
				echo '<div class="success"><p>' . esc_html__( 'Settings updated!', 'el-wl-branding' ) . '</p></div>';
			}
		}


		/**
		 * Renders the action for a form.
		 *
		 * @since 1.0.0
		 */
		public static function get_form_action( $type = '' ) {
			return admin_url( '/admin.php?page=el-wl-branding' . $type );
		}

		/**
		 * Returns an option from the database for the admin settings page.
		 *
		 * @since 1.0.0
		 */
		public static function get_option( $key, $network_override = true ) {
			if ( is_network_admin() ) {
				$value = get_site_option( $key );
			}
				elseif ( ! $network_override && is_multisite() ) {
					$value = get_site_option( $key );
				}
				elseif ( $network_override && is_multisite() ) {
					$value = get_option( $key );
					$value = ( false === $value || ( is_array( $value ) && in_array( 'disabled', $value ) ) ) ? get_site_option( $key ) : $value;
				}
				else {
				$value = get_option( $key );
			}

			return $value;
		}

		/**
		 * Set the branding data to plugin.
		 *
		 * @since 1.0.0
		 */
		public static function update_branding( $all_plugins ) {
			$settings = self::get_settings();

				if ( defined( 'ELEMENTOR_PLUGIN_BASE' ) ) {
					$all_plugins[ELEMENTOR_PLUGIN_BASE]['Name']        = ! empty( $settings['plugin_name'] )     ? $settings['plugin_name']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Name'];
					$all_plugins[ELEMENTOR_PLUGIN_BASE]['PluginURI']   = ! empty( $settings['plugin_uri'] )      ? $settings['plugin_uri']       : $all_plugins[ELEMENTOR_PLUGIN_BASE]['PluginURI'];
					$all_plugins[ELEMENTOR_PLUGIN_BASE]['Description'] = ! empty( $settings['plugin_desc'] )     ? $settings['plugin_desc']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Description'];
					$all_plugins[ELEMENTOR_PLUGIN_BASE]['Author']      = ! empty( $settings['plugin_author'] )   ? $settings['plugin_author']    : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Author'];
					$all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorURI']   = ! empty( $settings['plugin_uri'] )      ? $settings['plugin_uri']       : $all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorURI'];
					$all_plugins[ELEMENTOR_PLUGIN_BASE]['Title']       = ! empty( $settings['plugin_name'] )     ? $settings['plugin_name']      : $all_plugins[ELEMENTOR_PLUGIN_BASE]['Title'];
					$all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorName']  = ! empty( $settings['plugin_author'] )   ? $settings['plugin_author']    : $all_plugins[ELEMENTOR_PLUGIN_BASE]['AuthorName'];
				}

				return $all_plugins;
		}

		/**
		 * Saves the white label settings.
		 *
		 * @since 1.0.0
		 */
		private static function save_settings() {
			if ( ! isset( $_POST['el_wl_branding-settings-nonce'] ) || ! wp_verify_nonce( $_POST['el_wl_branding-settings-nonce'], 'el_wl_branding-settings' ) ) {
				return;
			}

			$settings = self::get_settings();

			if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) ) {
				$settings['plugin_pro_name'] = isset( $_POST['elwlbranding_plugin_pro_name'] ) ? sanitize_text_field( $_POST['elwlbranding_plugin_pro_name'] ) : '';
			}
			$settings['plugin_name']                = isset( $_POST['elwlbranding_plugin_name'] ) ? sanitize_text_field( $_POST['elwlbranding_plugin_name'] ) : '';
			$settings['plugin_desc']                = isset( $_POST['elwlbranding_plugin_desc'] ) ? esc_textarea( $_POST['elwlbranding_plugin_desc'] ) : '';
			$settings['plugin_author']              = isset( $_POST['elwlbranding_plugin_author'] ) ? sanitize_text_field( $_POST['elwlbranding_plugin_author'] ) : '';
			$settings['plugin_uri']                 = isset( $_POST['elwlbranding_plugin_uri'] ) ? esc_url( $_POST['elwlbranding_plugin_uri'] ) : '';
			$settings['admin_label']                = isset( $_POST['elwlbranding_admin_label'] ) ? sanitize_text_field( $_POST['elwlbranding_admin_label'] ) : '';
			$settings['edit_with_elementor']        = isset( $_POST['elwlbranding_edit_with_elementor'] ) ? sanitize_text_field( $_POST['elwlbranding_edit_with_elementor'] ) : '';
			$settings['elementor_skin_color']       = isset( $_POST['elwlbranding_skin_color'] ) ? sanitize_text_field( $_POST['elwlbranding_skin_color'] ) : '';
			$settings['elementor_update_btn_color'] = isset( $_POST['elwlbranding_update_button_color'] ) ? sanitize_text_field( $_POST['elwlbranding_update_button_color'] ) : '';
			$settings['hide_elementor_logo']        = isset( $_POST['elwlbranding_hide_logo'] ) ? 'on' : 'off';


			update_site_option( 'elwlbranding_settings', $settings );
		}

		/**
		 * Plugin row meta.
		 *
		 * @since 1.0.0
		 */
		public static function plugin_row_meta( $plugin_meta, $plugin_file ) {

			if ( defined( 'ELEMENTOR_PLUGIN_BASE' ) && ELEMENTOR_PLUGIN_BASE === $plugin_file ) {
				$plugin_meta = array( $plugin_meta[0], $plugin_meta[1] );
			}

			if ( defined( 'ELEMENTOR_PRO_PLUGIN_BASE' ) && ELEMENTOR_PRO_PLUGIN_BASE === $plugin_file ) {
				$plugin_meta = array( $plugin_meta[0], $plugin_meta[1], $plugin_meta[2] );
			}

			return $plugin_meta;
		}

		/**
		 * Plugin Action Links.
		 *
		 * @since 1.0.0
		 */
		public static function plugin_action_links( $links ) {

			unset( $links['active_license'] );

			return $links;
		}

		/**
		 * Color picker for admin page
		 *
		 * @since 1.0.0
		 */
		public static function elwl_enqueue_color_picker( $hook_suffix ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

		}

		/**
		 * Adding WordPress plugin action links.
		 *
		 * @since 1.0.0
		 */
		public static function ewl_plugin_actions_links( $links ) {

			return array_merge(
				array(
					'settings' => '<a href="' . admin_url( 'admin.php?page=el-wl-branding' ) . '">' . esc_html__( 'Settings', 'el-wl-branding' ) . '</a>',
				),
				$links
			);

		}

	



}

