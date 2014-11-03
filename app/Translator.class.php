<?php

/**
 * Root translator object.
 * 
 * @version 1.4
 * @author MPI
 * */
abstract class Translator{
	const DEFAULT_INVALID_KEY = ""; // default value for invalid key
	
	const LANG_EN = 1;
	const LANG_CZ = 2;
	
	private static $language = array(
			self::LANG_EN => "English",
			self::LANG_CZ => "Čeština"
	);
	
	public function __construct(){
	}
	
	public static function getLanguage($lang_id){
		return (empty($lang_id) ? self::$language : (array_key_exists($lang_id, self::$language) ? self::$language[$key] : self::$language[self::LANG_EN]));
	}

	/**
	 * Get string or string pattern from object.
	 *
	 * @all translators must contain a get method
	 */
	public abstract function get($key);

	/**
	 * Get name of this class.
	 *
	 * @all views must contain a getName method
	 */
	public abstract function getName();
	
	/*
	 * Common translation keys follow
	 * 
	 * */
	const SITE_TITLE = 1;
	const SITE_TITLE_HIDDEN = 2;
	const SITE_DESCRIPTION = 3;
	const SITE_KEYWORDS = 4;
	const SITE_AUTHORS = 5;
	
	const FAILURE_UNKNOWN = 100;
	const FAILURE_MISSING_CONFIG_DB = 101;
	const FAILURE_UNABLE_CONNECT_DB = 102;
	const FAILURE_UNABLE_SET_DB_CHARSET = 103;
	const FAILURE_UNABLE_SAVE_WARNING = 104;
	
	const WARNING_UNKNOWN = 200;
	const WARNING_CLASS_NOT_FOUND = 201;
	const WARNING_ACTION_IS_NOT_CALLABLE = 202;
	const WARNING_INVALID_ROUTE = 203;
	const WARNING_INVALID_SQL_SELECT = 204;
	const WARNING_INVALID_SQL_ACTION = 205;
	const WARNING_UNABLE_VERIFY_RESULT = 206;
	const WARNING_UNABLE_COMPLETE_TRANSACTION = 207;
	const WARNING_ROUTER_ROUTE_INVALID = 208;
	const WARNING_ROUTER_ROUTE_ACTION_INVALID = 209;
	
	const NOTICE_UNKNOWN = 300;
	const NOTICE_LOGIN_FAILED = 301;
	const NOTICE_INVALID_PARAMETERS = 302;
	const NOTICE_PERMISSION_DENIED = 303;
	const NOTICE_PASSWORD_INVALID_FORMAT = 304;
	const NOTICE_INPUT_INVALID_FORMAT = 305;
	const NOTICE_SUCCESSFULLY_SAVED = 306;
	const NOTICE_LOGIN_REQUIRED = 307;
	const NOTICE_RENEW_EMAIL_ERROR = 308;
	const NOTICE_RENEW_EMAIL_SENDED = 309;
	const NOTICE_INVALID_TOKEN = 310;
	const NOTICE_PASSWORD_CHANGED = 311;
	const NOTICE_USER_NOT_FOUND = 312;
	const NOTICE_USER_CREATE_EMAIL_ERROR = 313;
	const NOTICE_EMAIL_USED_ENTER_ANOTHER = 314;
	const NOTICE_USER_CREATE_EMAIL_SENDED = 315;
	const NOTICE_USER_ACTIVATED = 316;
	const NOTICE_NOTHING_TO_DISPLAY = 317;
	const NOTICE_FILE_IS_NOT_DELETABLE = 318;
	
	const LOG_USER_LOGIN = 500;
	const LOG_USER_LOGOUT = 501;
	const LOG_USER_ACTIVATION = 502;
	const LOG_USER_PASSWORD_CHANGED = 503;
	const LOG_USER_ACCOUNT_DATA_CHANGED = 504;
	const LOG_USER_REQUEST = 505;
	
	const PAGINATION_PAGE_SIZE = 900;
	const PAGINATION_DISPLAYED_ROWS = 901;
	const PAGINATION_FOUND_ROWS = 902;
	const PAGINATION_ACTUAL_PAGE = 903;
	
	const PAGE_NAME_INDEX = 1000;
	const PAGE_NAME_INDEX_UNLOG = 1001;
	const PAGE_NAME_USER_LOG_LIST = 1002;
	const PAGE_NAME_USER_LIST = 1003;
	const PAGE_NAME_USER_CREATE = 1004;
	const PAGE_NAME_USER_RENEW = 1005;
	const PAGE_NAME_USER_SET_PASSWORD = 1006;
	const PAGE_NAME_USER_LOGIN = 1007;
	const PAGE_NAME_USER_EDIT = 1008;
	const PAGE_NAME_USER_REQUEST = 1009;

	const MENU_HOME = 1100;
	const MENU_LOGIN = 1101;
	const MENU_LOGOUT = 1102;
	const MENU_ADD = 1103;
	const MENU_LIST = 1104;
	const MENU_USERS = 1105;
	const MENU_USER_MY_ACCOUNT = 1106;
	const MENU_USER_ACCESS_DATA = 1107;
	const MENU_USER_LOG = 1108;
	
	const BTN_SEND = 2000;
	
	const BREADCRUMBS_BODY_INDEX = 3000;
	const BREADCRUMBS_BODY_INDEX_INDEX = 3001;
}
?>
