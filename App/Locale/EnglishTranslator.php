<?php
/**
 * English translator.
 *
 * @version 1.8
 * @author MPI
 * */
class EnglishTranslator extends Translator {
    private $data = array (
                    Translator::F_UNKNOWN => "Unknown failure exception.",
                    Translator::F_MISSING_CONFIG_DB => "Empty config data for connect to db.",
                    Translator::F_UNABLE_CONNECT_DB => "Unnable to connect to db server.",
                    Translator::F_UNABLE_SET_DB_CHARSET => "Unable to set db charset.",
                    Translator::F_UNABLE_SAVE_WARNING => "Unable to save warning to db.",
                    Translator::W_UNKNOWN => "Unknown warning exception.",
                    Translator::W_CLASS_NOT_FOUND => "Missing required class.",
                    Translator::W_ACTION_IS_NOT_CALLABLE => "Requested action is not callable.",
                    Translator::W_INVALID_ROUTE => "Invalid route name.",
                    Translator::W_INVALID_SQL_SELECT => "Incorrect SQL select query.",
                    Translator::W_INVALID_SQL_ACTION => "Incorrect SQL action query.",
                    Translator::W_UNABLE_VERIFY_RESULT => "Unable to verify result.",
                    Translator::W_UNABLE_COMPLETE_TRANSACTION => "Unable to complete transaction.",
                    Translator::W_ROUTER_ROUTE_INVALID => "Invalid route in router.",
                    Translator::W_ROUTER_ROUTE_ACTION_INVALID => "Invalid route action in route.",
                    Translator::W_INVALID_PARAMETERS => "List actualisation failed due to invalid parameters.",
                    Translator::W_PERMISSION_DENIED => "Permission denied.",
                    Translator::W_LOGIN_REQUIRED => "You need to login first.",
                    Translator::W_INVALID_TOKEN => "Invalid token.",
                    Translator::W_USER_NOT_FOUND => "User not found.",
                    Translator::W_RESPONSE_INVALID_FORMAT => "Invalid response format.",
                    Translator::W_RESPONSE_UNSUPPORTED_FORMAT => "Response format is not supported.",
                    Translator::N_UNKNOWN => "Unknow notice exception.",
                    Translator::N_LOGIN_FAILED => "Login failed. Please try it again.",
                    Translator::N_INVALID_PARAMETERS => "List actualisation failed due to invalid parameters.",
                    Translator::N_PASSWORD_INVALID_FORMAT => "Password format is incorrect.",
                    Translator::N_INPUT_INVALID_FORMAT => "Input format is invalid.",
                    Translator::N_SUCCESSFULLY_SAVED => "Succesfully saved.",
                    Translator::N_RENEW_EMAIL_ERROR => "Unable to send email with renew token. Password is still the same.",
                    Translator::N_RENEW_EMAIL_SENDED => "Email with instructions for renew password was sended to you.",
                    Translator::N_PASSWORD_CHANGED => "New password was saved. You can login now.",
                    Translator::N_USER_CREATE_EMAIL_ERROR => "Unable to send email with token for create new user.",
                    Translator::N_EMAIL_USED_ENTER_ANOTHER => "Email is used. Enter another email.",
                    Translator::N_USER_CREATE_EMAIL_SENDED => "Email with instructions for create user was sended.",
                    Translator::N_USER_ACTIVATED => "User account was created.",
                    Translator::N_NOTHING_TO_DISPLAY => "Nothing to display.",
                    Translator::N_FILE_IS_NOT_DELETABLE => "File was not deleted.",
                    Translator::PAGINATION_PAGE_SIZE => "Page size",
                    Translator::PAGINATION_DISPLAYED_ROWS => "Displayed rows",
                    Translator::PAGINATION_FOUND_ROWS => "Found rows",
                    Translator::PAGINATION_ACTUAL_PAGE => "Page",
                    Translator::BREADCRUMBS_BODY_INDEX => "Index",
                    Translator::BREADCRUMBS_BODY_INDEX_INDEX => "index",
                    Translator::SITE_TITLE => "PhoenixFramework",
                    Translator::SITE_TITLE_HIDDEN => "PhoenixFramework",
                    Translator::SITE_AUTHORS => "MPi",
                    Translator::SITE_DESCRIPTION => "PhoenixFramework",
                    Translator::SITE_KEYWORDS => "Phoenix,framework"
    );

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get value by given index.
     *
     * @param int $key
     *            Translator constant key
     * @return string
     */
    public function get($key) {
        return (key_exists($key, $this->data)) ? $this->data[$key] : Translator::DEFAULT_INVALID_KEY;
    }
}
?>