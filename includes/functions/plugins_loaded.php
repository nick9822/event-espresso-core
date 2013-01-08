<?php if (!defined('EVENT_ESPRESSO_VERSION')) exit('No direct script access allowed');
/**
 * 		define all event espresso db table names plus directory and url paths
 *
 * 		@access public
 * 		@return void
 */
function espresso_define_tables_and_paths() {

	global $wpdb;

	define( 'DS', DIRECTORY_SEPARATOR );
	define( 'PS', PATH_SEPARATOR );
	
	// add ESPRESSO directories to include_path
	set_include_path(
		dirname( espresso_main_file() ) . DS . 'includes' . DS . 'core' . DS . PS .
		dirname( espresso_main_file() ) . DS . 'includes' . DS . 'models' . DS . PS .
		dirname( espresso_main_file() ) . DS . 'includes' . DS . 'classes' . DS . PS .
		dirname( espresso_main_file() ) . DS . 'includes' . DS . 'functions' . DS . PS .
		dirname( espresso_main_file() ) . DS . 'gateways' . DS . PS .
		get_include_path()
	);
	
	// Define all plugin database tables
	define("EVENTS_ANSWER_TABLE", $wpdb->prefix . "events_answer");
	define("EVENTS_ATTENDEE_TABLE", $wpdb->prefix . "events_attendee");
	define("EVENTS_ATTENDEE_COST_TABLE", $wpdb->prefix . "events_attendee_cost");
	define("EVENTS_CATEGORY_TABLE", $wpdb->prefix . "events_category_detail");
	define("EVENTS_CATEGORY_REL_TABLE", $wpdb->prefix . "events_category_rel");
	define("EVENTS_DETAIL_TABLE", $wpdb->prefix . "events_detail");
	define("EVENTS_DISCOUNT_CODES_TABLE", $wpdb->prefix . "events_discount_codes");
	define("EVENTS_DISCOUNT_REL_TABLE", $wpdb->prefix . "events_discount_rel");
	define("EVENTS_EMAIL_TABLE", $wpdb->prefix . "events_email");
	define("EVENTS_LOCALE_TABLE", $wpdb->prefix . "events_locale");
	define("EVENTS_LOCALE_REL_TABLE", $wpdb->prefix . "events_locale_rel");
	define("EVENTS_MULTI_EVENT_REGISTRATION_ID_GROUP_TABLE", $wpdb->prefix . "events_multi_event_registration_id_group");
	define("EVENTS_PERSONNEL_TABLE", $wpdb->prefix . "events_personnel");
	define("EVENTS_PERSONNEL_REL_TABLE", $wpdb->prefix . "events_personnel_rel");
	define("ESP_PRICE_TABLE", $wpdb->prefix . "esp_price");
	define("ESP_PRICE_TYPE", $wpdb->prefix . "esp_price_type");
	define("ESP_DATETIME", $wpdb->prefix . "esp_datetime");
	define("ESP_STATUS_TABLE", $wpdb->prefix . "esp_status");
	define("EVENTS_QST_GROUP_TABLE", $wpdb->prefix . "events_qst_group");
	define("EVENTS_QST_GROUP_REL_TABLE", $wpdb->prefix . "events_qst_group_rel");
	define("EVENTS_QUESTION_TABLE", $wpdb->prefix . "events_question");
	define("EVENTS_START_END_TABLE", $wpdb->prefix . "events_start_end");
	define("EVENTS_VENUE_TABLE", $wpdb->prefix . "events_venue");
	define("EVENTS_VENUE_REL_TABLE", $wpdb->prefix . "events_venue_rel");
	// End table definitions
	
	define("EVENTS_PRICES_TABLE", $wpdb->prefix . "events_prices"); // <<<<<<<<<<<<<<<<<<<<<<<<<<<<  ADDED BACK IN UNTIL PRICE TABLE CHANGES ARE COMPLETE

	define('EVENT_ESPRESSO_POWERED_BY', 'Event Espresso - ' . EVENT_ESPRESSO_VERSION);

	//Define the plugin directory and path
	$main_file = espresso_main_file();
	define("EVENT_ESPRESSO_PLUGINPATH", DS . plugin_basename($main_file) . DS);
	define("EVENT_ESPRESSO_PLUGINFULLPATH", plugin_dir_path($main_file));
	define("EVENT_ESPRESSO_PLUGINFULLURL", plugin_dir_url($main_file));

	//Define the includes directory
	define("EVENT_ESPRESSO_INCLUDES_DIR", EVENT_ESPRESSO_PLUGINFULLPATH . 'includes' . DS );
	define( 'EE_CORE', EVENT_ESPRESSO_INCLUDES_DIR . 'core' . DS );


	//Define directory structure for uploads
	//Create the paths
	$uploads = wp_upload_dir();

	//Define the uploads directory and url
	define("EVENT_ESPRESSO_UPLOAD_DIR", $uploads['basedir'] . DS . 'espresso' . DS);
	define("EVENT_ESPRESSO_UPLOAD_URL", $uploads['baseurl'] . DS . 'espresso' . DS);

	//Define the templates dirrectory and url
	define("EVENT_ESPRESSO_TEMPLATE_DIR", $uploads['basedir'] . DS . 'espresso' . DS . 'templates' . DS);
	define("EVENT_ESPRESSO_TEMPLATE_URL", $uploads['baseurl'] . DS . 'espresso' . DS . 'templates' . DS);

	//Define the gateway directory and url
	define("EVENT_ESPRESSO_GATEWAY_DIR", $uploads['basedir'] . DS . 'espresso' . DS . 'gateways' . DS);
	define("EVENT_ESPRESSO_GATEWAY_URL", $uploads['baseurl'] . DS . 'espresso' . DS . 'gateways' . DS);
	

	
}






/**
 * 		Automagically load non-singleton class files - no need to include or require
 * 		ONLY woks with class objects created via  "new"  ie: $object = new SomeClassName();
* 		directory path can be designated by substituting underscores for directory separators
* 		ie: new admin_transactions_TransactionsInit() would load the file located at : includes/core/admin/transactions/EE_TransactionsInit.class.php
 *
 * 		@access 		public
* 		@param		$class		path and name of the class file to be loaded
 * 		@return 		void
 */
function espresso_autoload() {
	function __autoload( $class_name ) {
		$include_path = dirname(espresso_main_file()) . '/includes/classes/';
		if ( file_exists( $include_path . $class_name . '.class.php' )) {
			require_once( $include_path . $class_name . '.class.php' );
		}
	}
}



function espresso_display_exception( $excptn ) {
	echo '
<style type="text/css">
body { 
	width:100%; height:100%; padding:1px; margin:0; background:#f8f8f8;
}
#error_msg {
	width:60%; height:auto; padding:2em 4em; margin:4em auto; 
	background:#fff; border:2px solid #D54E21; border-radius:3px;
	color: #666; font-size:18px;
}
</style>';
	echo '<div id="error_msg">';
	echo 'Error : ' . $excptn->getMessage();
	echo '</div>';
	die();
}




/**
 * 		get WP user id for currently logged in user 
 *
 * 		@access public
 * 		@return void
 */
function espresso_get_user_id() {
	global $current_user, $espresso_wp_user;
	$espresso_wp_user = 1;
	$espresso_wp_user = apply_filters('filter_hook_espresso_get_user_id', $espresso_wp_user);
	return $espresso_wp_user;
}




/**
 * 		load EE organization options and begin EE logging
 *
 * 		@access public
 * 		@return void
 */
function espresso_load_org_options() {
	global $org_options, $espresso_wp_user;
	$org_options = get_user_meta($espresso_wp_user, 'events_organization_settings', true);
	//require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Log.class.php');
	require_once( 'EE_Log.class.php' );
	do_action('action_hook_espresso_debug_file');
	$req_vars = '';
	foreach ( $_REQUEST as $k => $v ){
		$req_vars .= "\n" . $k . ' = ' . (is_array($v))?print_r($v,true):$v;
	}
	do_action('action_hook_espresso_log', '', '', '$_REQUEST = ' . $req_vars );	
}





/**
 * 		load and instantiate EE_Session class
 *
 * 		@access public
 * 		@return void
 */
function espresso_EE_Session() {
	global $EE_Session;
	//require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Session.class.php');
	require_once( 'EE_Session.class.php' );
	// instantiate !!!
	$EE_Session = EE_Session::instance();
	if (!empty($_POST['clear_cart'])) {
		espresso_clear_session();
	}
}





/**
 * 		Clear EE_Session data
 *
 * 		@access public
 * 		@return void
 */
function espresso_clear_session() {
	global $EE_Session;
	$EE_Session->reset_data( 
			array(
						'cart',
						'gateway_data', 
						'transaction', 
						'registration',
						'primary_attendee',
						'tax_totals',
						'taxes',
						'billing_info',
						'txn_results'
					));
																
	$EE_Session->set_session_data(
			array(
						'_events_in_cart' => array(),
						'_cart_grand_total_qty' => 0,
						'_cart_grand_total_amount' => 0
					),
					'session_data'
	);

}
add_action( 'action_hook_espresso_before_event_list', 'espresso_clear_session' );





/**
 * 		print_r EE_Session object at bottom of page after everything else has happened
 *
 * 		@access public
 * 		@return void
 */
function espresso_printr_session() {
	$user = wp_get_current_user();
	$wp_user_id = isset( $user->data->ID ) ? $user->data->ID : NULL;
	if ( isset( $_REQUEST['ee_session'] ) && $wp_user_id <= 1 ) {	
		global $EE_Session;
		echo '<pre style="height:auto;border:2px solid lightblue;">';
		echo print_r( $EE_Session, TRUE );
		echo '</pre><br /><span style="font-size:10px;font-weight:normal;">';
		echo __FILE__ . '<br />line no: ' . __LINE__ . '</span>';	
	}
}
add_action( 'shutdown', 'espresso_printr_session' );





/**
 * 		Event Espresso Initialization
 *
 * 		@access public
 * 		@return void
 */
function espresso_init() {

	//Globals used throughout the site
	global $espresso_premium, $is_UI_request, $is_ajax_request;
	// is this request for UI or backend 
	$is_UI_request = ( ! isset( $_REQUEST['noheader'] ) || $_REQUEST['noheader'] != 'true' ) ? TRUE : FALSE;
	$is_ajax_request = ( isset( $_REQUEST['espresso_ajax'] ) && $_REQUEST['espresso_ajax'] == 1 ) ? TRUE : FALSE;

	do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, 'is_UI_request = ' . $is_UI_request );

	//Set the default time zone
	//If the default time zone is set up in the WP Settings, then we will use that as the default.
	if (get_option('timezone_string') != '') {
		date_default_timezone_set(get_option('timezone_string'));
	}

	//Wordpress function for setting the locale.
	//print get_locale();
	//setlocale(LC_ALL, get_locale());
	setlocale(LC_TIME, get_locale());

	//Get language files
	load_plugin_textdomain('event_espresso', false, dirname(plugin_basename(__FILE__)) . '/languages/');

	//Core function files			
//	require_once EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Event_Object.class.php';
//	require_once EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Event.class.php';
//	require_once EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Attendee.class.php';
//	require_once EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Venue.class.php';
	
	$espresso_premium = apply_filters('filter_hook_espresso_systems_check', false);
	
	require_once(EVENT_ESPRESSO_INCLUDES_DIR . "functions/main.php");
//	require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'functions/pricing.php');
	require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'functions/time_date.php');

	require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'functions/actions.php');
	require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'functions/filters.php');


	do_action('action_hook_espresso_coupon_codes');
}





/**
 * 		perform system check and load additional files
 *
 * 		@access public
 * 		@return void
 */
function espresso_systems_check( $check = FALSE ) {
	do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, '' );
	if (file_exists(EVENT_ESPRESSO_INCLUDES_DIR . 'admin-files/misc_functions.php')) {
		require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'admin-files/misc_functions.php');
		$check = espresso_system_check();
	}

	//These files need to be above the core function files
	if (file_exists(EVENT_ESPRESSO_INCLUDES_DIR . 'admin-files/addons_includes.php')) {
		require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'admin-files/addons_includes.php');
	}
	return $check;
}
add_filter('filter_hook_espresso_systems_check', 'espresso_systems_check');





/**
 * 		Handles exporting of csv files
 *
 * 		@access public
 * 		@return void
 */
function espresso_check_for_export() {
	do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, '' );
	if (isset($_REQUEST['export'])) {
		if (file_exists(EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Export.class.php')) {
			require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Export.class.php');
			$EE_Export = EE_Export::instance();
			$EE_Export->export();
		}
	}
}





/**
 * 		Handles importing of csv files
 *
 * 		@access public
 * 		@return void
 */
function espresso_check_for_import() {
	do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, '' );
	if (isset($_REQUEST['import'])) {
		if (file_exists(EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Import.class.php')) {
			require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Import.class.php');
			$EE_Import = EE_Import::instance();
			$EE_Import->import();
		}
	}
}





/**
 * 		Test if current page pertains to event registrationand load appropriate files
 *
 * 		@access public
 * 		@return void
 */
function espresso_load_reg_page_files() {

	global $org_options, $current_ee_page;
	
	$current_ee_page = isset( $current_ee_page ) ? $current_ee_page : $org_options['event_page_id'];
	
	do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, '$current_ee_page = ' . $current_ee_page );

	$reg_pages = array(
		$org_options['event_page_id']	 => 'event_page_id',
		$org_options['return_url']	 => 'return_url',
		$org_options['cancel_return'] => 'cancel_return',
		$org_options['notify_url']	 => 'notify_url'
	);
	
	if ( isset( $reg_pages[ $current_ee_page ] )) {
		switch( $reg_pages[ $current_ee_page ] ){
		
			case 'event_page_id' :

					$load_SPCO = FALSE;
					
					$e_reg_pages = array( 
									'register', 
									'process_reg_step_1', 
									'process_reg_step_2', 
									'process_reg_step_3', 
									'event_queue'
							);
					$load_SPCO = isset( $_REQUEST['e_reg'] ) && ( in_array( $_REQUEST['e_reg'], $e_reg_pages )) ? TRUE : $load_SPCO;
						
					$e_reg_ajax_actions = array( 
									'espresso_process_registration_step_1', 
									'espresso_process_registration_step_2', 
									'espresso_process_registration_step_3'
							);
					$load_SPCO = isset( $_REQUEST['action'] ) && ( in_array( $_REQUEST['action'], $e_reg_ajax_actions )) ? TRUE : $load_SPCO;
							
					if ( $load_SPCO ) {
						require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'classes/EE_Single_Page_Checkout.class.php');
						global $Single_Page_Checkout;
						$Single_Page_Checkout = EE_Single_Page_Checkout::instance();	
						//Process email confirmations
						require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'functions/email.php');
						define("ESPRESSO_REG_PAGE_FILES_LOADED", "true");
					}

				break;
			
			case 'return_url' :
					require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'functions/pricing.php');
					require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'process-registration/thank_you_page.php');
					event_espresso_require_gateway('PaymentGateway.php');
				break;
			
			case 'cancel_return' :
				break;
			
			case 'notify_url' :
				break;
		}

	}
	

}
add_action('action_hook_espresso_load_reg_page_files', 'espresso_load_reg_page_files');





/**
 * 		used by EE and EE addons during plugin activation
 *
 * 		@access public
 * 		@return void
 */
function event_espresso_run_install($table_name, $table_version, $sql, $engine = '') {

	do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, '' );
	global $wpdb;

	$wp_table_name = $wpdb->prefix . $table_name;

	if ($wpdb->get_var("SHOW TABLES LIKE '" . $wp_table_name . "'") != $wp_table_name) {

		$sql_create_table = "CREATE TABLE " . $wp_table_name . " ( " . $sql . " ) " . $engine . " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql_create_table);

		//create option for table version
		$option_name = $table_name . '_tbl_version';
		$newvalue = $table_version;
		if (get_option($option_name)) {
			update_option($option_name, $newvalue);
		} else {
			$deprecated = '';
			$autoload = 'no';
			add_option($option_name, $newvalue, $deprecated, $autoload);
		}
		//create option for table name
		$option_name = $table_name . '_tbl';
		$newvalue = $wp_table_name;
		if (get_option($option_name)) {
			update_option($option_name, $newvalue);
		} else {
			$deprecated = '';
			$autoload = 'no';
			add_option($option_name, $newvalue, $deprecated, $autoload);
		}
	}

	// Code here with new database upgrade info/table Must change version number to work.

	$installed_ver = get_option($table_name . '_tbl_version');
	if ($installed_ver != $table_version) {
		$sql_create_table = "CREATE TABLE " . $wp_table_name . " ( " . $sql . " ) ;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql_create_table);
		update_option($table_name . '_tbl_version', $table_version);
	}
}





/**
 * 		loads and instantiates files and objects for EE admin pages
 *
 * 		@access public
 * 		@return void
 */
function espresso_admin_pages() {

	//echo '<h3>'. __CLASS__ . '->' . __FUNCTION__ . ' <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h3>';
	do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, '');

	define( 'EE_CORE_ADMIN', EE_CORE . 'admin' . DS );
	define( 'EE_CORE_ADMIN_URL', EVENT_ESPRESSO_PLUGINFULLURL . 'includes' . DS . 'core' . DS . 'admin' . DS );
	define( 'WP_AJAX_URL', get_bloginfo('url') . '/wp-admin/admin-ajax.php' );
	define( 'JQPLOT_URL', EVENT_ESPRESSO_PLUGINFULLURL . 'scripts/jqplot/' );
	
	global $is_UI_request, $is_ajax_request;
	
//	echo '<h4>$is_UI_request : ' . $is_UI_request . '  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h4>';
//	echo '<h4>$is_ajax_request : ' . $is_ajax_request . '  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h4>';

	// load admin page factory files
	require_once( EE_CORE_ADMIN . 'EE_Admin_Page_Init.core.php' );
	require_once( EE_CORE_ADMIN . DS . 'EE_Admin_Page.core.php' ); 

	$load_admin = TRUE;
	// grab page request
	$page_request = ! empty( $_REQUEST['page'] ) ? sanitize_key( $_REQUEST['page'] ) : FALSE;
	//echo '<h4>$page_request : ' . $page_request . '  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h4>';
	do_action('action_hook_espresso_log', 'admin page request = ' . $page_request, '$is_UI_request = ' . $is_UI_request, '$is_ajax_request = ' . $is_ajax_request );

	// are we just doing some backend processing or runnning the whole shebang?
	if ( $page_request && ! $is_UI_request ) {
		//echo '<h4>load admin page : ' . $page_request . '  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h4>';
		do_action('action_hook_espresso_load_reg_page_files');
		// if the page_request doesn't load here for some reason then load the entire admin
		$load_admin = ! espresso_load_admin_page( $page_request, $page_request ) ? TRUE : FALSE;
	} 
	
	if ( $load_admin && ! $is_ajax_request ) {
		//echo '<h4>load all admin pages  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h4>';
		// start with an empty array
		$admin_pages = array();
		// folders we don't want
		$exclude = array();
		// grab everything in the  admin core directory
		if ( $admin_screens = glob( EE_CORE_ADMIN . '*' )) {	
			foreach( $admin_screens as $admin_screen ) {
				// files and anything in the exclude array need not apply
				if ( is_dir( $admin_screen ) && ! in_array( $admin_screen, $exclude )) {
					// these folders represent the different EE admin pages
					$admin_pages[] = basename( $admin_screen );
				}
			}
		}
		// allow addons to insert their data into the admin pages array
		$admin_pages = apply_filters( 'filter_hook_espresso_admin_pages_array', $admin_pages );	
		//echo '<pre style="height:auto;border:2px solid #FF6600;">' . print_r( $admin_pages, TRUE ) . '</pre>';

		// if it's' an admin page then initialize it
		if ( ! in_array( $page_request, $admin_pages )) {
			$page_request = FALSE;
		}

		// now loop thru all of our admin pages
		foreach ( $admin_pages as $admin_page ) {
			espresso_load_admin_page( $admin_page, $page_request );
		}
		
	} else {
		// frontend AJAX request, prolly for SPCO
		do_action('action_hook_espresso_load_reg_page_files');
	}
	
}




/**
 * 		loads and instantiates files and objects for a single EE admin page
 *
 * 		@access public
 * 		@param string	$admin_page
 * 		@return void
 */
function espresso_load_admin_page( $admin_page, $page_request ) {
	
//	echo '<h3>'. __CLASS__ . '->' . __FUNCTION__ . ' <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h3>';

	$admin_page = strtolower( $admin_page );
	$page_name = ucwords(  str_replace( '_', ' ', $admin_page ));
	$class_name = str_replace( ' ', '_', $page_name );
	
	// find, load and instantiate admin page init file
	$path_to_init = EE_CORE_ADMIN . $admin_page . DS . $class_name . '_Admin_Page_Init.core.php';		
	if ( file_exists( $path_to_init )) {
		//echo '<h2>$path_to_init : ' . $path_to_init . '  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h2>';		
		require_once( $path_to_init );
		$page_class =  $class_name . '_Admin_Page_Init';
		$a = new ReflectionClass( $page_class );
		$a->newInstance( $admin_page, $page_name, $class_name, $page_request );	
		return TRUE;					
	} else {
		return FALSE;
	}
}

