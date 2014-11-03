<?php
/**
 * English translator.
 *
 * @version 1.3
 * @author MPI
 * */
class EnglishTranslator extends Translator {
    private $data = array (
                    Translator::FAILURE_UNKNOWN => "Unknown failure exception.",
                    Translator::FAILURE_MISSING_CONFIG_DB => "Empty config data for connect to db.",
                    Translator::FAILURE_UNABLE_CONNECT_DB => "Unnable to connect to db server.",
                    Translator::FAILURE_UNABLE_SET_DB_CHARSET => "Unable to set db charset.",
                    Translator::FAILURE_UNABLE_SAVE_WARNING => "Unable to save warning to db.",
                    Translator::WARNING_UNKNOWN => "Unknown warning exception.",
                    Translator::WARNING_CLASS_NOT_FOUND => "Missing required class.",
                    Translator::WARNING_ACTION_IS_NOT_CALLABLE => "Requested action is not callable.",
                    Translator::WARNING_INVALID_ROUTE => "Invalid route name.",
                    Translator::WARNING_INVALID_SQL_SELECT => "Incorrect SQL select query.",
                    Translator::WARNING_INVALID_SQL_ACTION => "Incorrect SQL action query.",
                    Translator::WARNING_UNABLE_VERIFY_RESULT => "Unable to verify result.",
                    Translator::WARNING_UNABLE_COMPLETE_TRANSACTION => "Unable to complete transaction.",
                    Translator::WARNING_ROUTER_ROUTE_INVALID => "Invalid route in router.",
                    Translator::WARNING_ROUTER_ROUTE_ACTION_INVALID => "Invalid route action in route.",
                    Translator::NOTICE_UNKNOWN => "Unknow notice exception.",
                    Translator::NOTICE_LOGIN_FAILED => "Login failed. Please try it again.",
                    Translator::NOTICE_INVALID_PARAMETERS => "List actualisation failed due to invalid parameters.",
                    Translator::NOTICE_PERMISSION_DENIED => "Permission denied.",
                    Translator::NOTICE_PASSWORD_INVALID_FORMAT => "Password format is incorrect.",
                    Translator::NOTICE_INPUT_INVALID_FORMAT => "Input format is invalid.",
                    Translator::NOTICE_SUCCESSFULLY_SAVED => "Succesfully saved.",
                    Translator::NOTICE_LOGIN_REQUIRED => "You need to login first.",
                    Translator::NOTICE_RENEW_EMAIL_ERROR => "Unable to send email with renew token. Password is still the same.",
                    Translator::NOTICE_RENEW_EMAIL_SENDED => "Email with instructions for renew password was sended to you.",
                    Translator::NOTICE_INVALID_TOKEN => "Invalid token.",
                    Translator::NOTICE_PASSWORD_CHANGED => "New password was saved. You can login now.",
                    Translator::NOTICE_USER_NOT_FOUND => "User not found.",
                    Translator::NOTICE_USER_CREATE_EMAIL_ERROR => "Unable to send email with token for create new user.",
                    Translator::NOTICE_EMAIL_USED_ENTER_ANOTHER => "Email is used. Enter another email.",
                    Translator::NOTICE_USER_CREATE_EMAIL_SENDED => "Email with instructions for create user was sended.",
                    Translator::NOTICE_USER_ACTIVATED => "User account was created.",
                    Translator::NOTICE_NOTHING_TO_DISPLAY => "Nothing to display.",
                    Translator::NOTICE_FILE_IS_NOT_DELETABLE => "File was not deleted.",
                    Translator::PAGINATION_PAGE_SIZE => "Page size",
                    Translator::PAGINATION_DISPLAYED_ROWS => "Displayed rows",
                    Translator::PAGINATION_FOUND_ROWS => "Found rows",
                    Translator::PAGINATION_ACTUAL_PAGE => "Page",
                    Translator::BREADCRUMBS_BODY_INDEX => "Index",
                    Translator::BREADCRUMBS_BODY_INDEX_INDEX => "index" 
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

    /**
     * Get name of this class.
     *
     * @return string
     */
    public function getName() {
        return get_class($this);
    }
}
?>