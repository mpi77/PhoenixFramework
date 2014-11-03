<?php
/**
 * Czech translator.
 *
 * @version 1.3
 * @author MPI
 * */
class CzechTranslator extends Translator {
    private $data = array (
                    Translator::FAILURE_UNKNOWN => "Neznámá kritická chyba.",
                    Translator::FAILURE_MISSING_CONFIG_DB => "Nebyly zadány parametry pro spojení s databází.",
                    Translator::FAILURE_UNABLE_CONNECT_DB => "Nepovedlo se spojit s databází.",
                    Translator::FAILURE_UNABLE_SET_DB_CHARSET => "Nepovedlo se nastavit kódování spojení s databází.",
                    Translator::FAILURE_UNABLE_SAVE_WARNING => "Nepovedlo se uložit chybu do databáze.",
                    Translator::WARNING_UNKNOWN => "Neznámá chyba.",
                    Translator::WARNING_CLASS_NOT_FOUND => "Požadovaná třída nebyla nalezena.",
                    Translator::WARNING_ACTION_IS_NOT_CALLABLE => "Zadanou akci nelze volat.",
                    Translator::WARNING_INVALID_ROUTE => "Neznámá cesta.",
                    Translator::WARNING_INVALID_SQL_SELECT => "Nesprávný SQL select dotaz.",
                    Translator::WARNING_INVALID_SQL_ACTION => "Nesprávný SQL action dotaz.",
                    Translator::WARNING_UNABLE_VERIFY_RESULT => "Akce se nezdařila.",
                    Translator::WARNING_UNABLE_COMPLETE_TRANSACTION => "Transakce se nezdařila.",
                    Translator::WARNING_ROUTER_ROUTE_INVALID => "Neplatný objekt cesty v routeru.",
                    Translator::WARNING_ROUTER_ROUTE_ACTION_INVALID => "Neplatná akce v objektu cesty routeru.",
                    Translator::NOTICE_UNKNOWN => "Neznámé upozornění.",
                    Translator::NOTICE_LOGIN_FAILED => "Přihlášení selhalo. Zkuste to prosím znovu.",
                    Translator::NOTICE_INVALID_PARAMETERS => "Nepodařilo se obnovit seznam. Zadali jste špatné parametry.",
                    Translator::NOTICE_PERMISSION_DENIED => "Nemáte potřebné oprávnění k provedení této akce.",
                    Translator::NOTICE_PASSWORD_INVALID_FORMAT => "Heslo se nepodařilo nastavit. Zadaná hesla nesplňují požadované vlastnosti.",
                    Translator::NOTICE_INPUT_INVALID_FORMAT => "Údaje se nepodařilo uložit, nesplňují požadované vlastnosti.",
                    Translator::NOTICE_SUCCESSFULLY_SAVED => "Změny úspěšně uloženy.",
                    Translator::NOTICE_LOGIN_REQUIRED => "K provedení požadované akce se musíte přihlásit.",
                    Translator::NOTICE_RENEW_EMAIL_ERROR => "Nepodařilo se odeslat email s kódem pro obnovu hesla. Nadále platí současné heslo.",
                    Translator::NOTICE_RENEW_EMAIL_SENDED => "Na email vám byl zaslán odkaz pro obnovu hesla. Na provedení změny máte 24 hodin.",
                    Translator::NOTICE_INVALID_TOKEN => "Zadali jste neplatný token.",
                    Translator::NOTICE_PASSWORD_CHANGED => "Nastavili jste nové heslo k vašemu účtu. Nyní se můžete přihlásit.",
                    Translator::NOTICE_USER_NOT_FOUND => "Uživatel nenalezen.",
                    Translator::NOTICE_USER_CREATE_EMAIL_ERROR => "Nepodařilo se odeslat email s kódem pro vytvoření nového uživatelského účtu.",
                    Translator::NOTICE_EMAIL_USED_ENTER_ANOTHER => "Zadaný email je již používán. Zadejte jiný.",
                    Translator::NOTICE_USER_CREATE_EMAIL_SENDED => "Na zadaný email byl odeslán email s instrukcemi pro aktivaci účtu.",
                    Translator::NOTICE_USER_ACTIVATED => "Aktivovali jste váš nový účet. Nyní se můžete přihlásit.",
                    Translator::NOTICE_NOTHING_TO_DISPLAY => "Nebylo nalezeno nic ke zobrazení.",
                    Translator::NOTICE_FILE_IS_NOT_DELETABLE => "Požadovaný soubor nebylo možné smazat.",
                    Translator::PAGINATION_PAGE_SIZE => "Velikost stránky",
                    Translator::PAGINATION_DISPLAYED_ROWS => "Zobrazeno řádků",
                    Translator::PAGINATION_FOUND_ROWS => "Nalezeno řádků",
                    Translator::PAGINATION_ACTUAL_PAGE => "Aktuální stránka",
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