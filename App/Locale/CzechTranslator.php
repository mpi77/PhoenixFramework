<?php
/**
 * Czech translator.
 *
 * @version 1.8
 * @author MPI
 * */
class CzechTranslator extends Translator {
    private $data = array (
                    Translator::F_UNKNOWN => "Neznámá kritická chyba.",
                    Translator::F_MISSING_CONFIG_DB => "Nebyly zadány parametry pro spojení s databází.",
                    Translator::F_UNABLE_CONNECT_DB => "Nepovedlo se spojit s databází.",
                    Translator::F_UNABLE_SET_DB_CHARSET => "Nepovedlo se nastavit kódování spojení s databází.",
                    Translator::F_UNABLE_SAVE_WARNING => "Nepovedlo se uložit chybu do databáze.",
                    Translator::W_UNKNOWN => "Neznámá chyba.",
                    Translator::W_CLASS_NOT_FOUND => "Požadovaná třída nebyla nalezena.",
                    Translator::W_ACTION_IS_NOT_CALLABLE => "Zadanou akci nelze volat.",
                    Translator::W_INVALID_ROUTE => "Neznámá cesta.",
                    Translator::W_INVALID_SQL_SELECT => "Nesprávný SQL select dotaz.",
                    Translator::W_INVALID_SQL_ACTION => "Nesprávný SQL action dotaz.",
                    Translator::W_UNABLE_VERIFY_RESULT => "Akce se nezdařila.",
                    Translator::W_UNABLE_COMPLETE_TRANSACTION => "Transakce se nezdařila.",
                    Translator::W_ROUTER_ROUTE_INVALID => "Neplatný objekt cesty v routeru.",
                    Translator::W_ROUTER_ROUTE_ACTION_INVALID => "Neplatná akce v objektu cesty routeru.",
                    Translator::W_INVALID_PARAMETERS => "Zadali jste špatné parametry.",
                    Translator::W_PERMISSION_DENIED => "Nemáte potřebné oprávnění k provedení této akce.",
                    Translator::W_LOGIN_REQUIRED => "K provedení požadované akce se musíte přihlásit.",
                    Translator::W_INVALID_TOKEN => "Zadali jste neplatný token.",
                    Translator::W_USER_NOT_FOUND => "Uživatel nenalezen.",
                    Translator::W_RESPONSE_INVALID_FORMAT => "Neznámý formát požadované odpovědi.",
                    Translator::W_RESPONSE_UNSUPPORTED_FORMAT => "Formát odpovědi není podporován.",
                    Translator::N_UNKNOWN => "Neznámé upozornění.",
                    Translator::N_LOGIN_FAILED => "Přihlášení selhalo. Zkuste to prosím znovu.",
                    Translator::N_INVALID_PARAMETERS => "Zadali jste špatné parametry.",
                    Translator::N_PASSWORD_INVALID_FORMAT => "Heslo se nepodařilo nastavit. Zadaná hesla nesplňují požadované vlastnosti.",
                    Translator::N_INPUT_INVALID_FORMAT => "Údaje se nepodařilo uložit, nesplňují požadované vlastnosti.",
                    Translator::N_SUCCESSFULLY_SAVED => "Změny úspěšně uloženy.",
                    Translator::N_RENEW_EMAIL_ERROR => "Nepodařilo se odeslat email s kódem pro obnovu hesla. Nadále platí současné heslo.",
                    Translator::N_RENEW_EMAIL_SENDED => "Na email vám byl zaslán odkaz pro obnovu hesla. Na provedení změny máte 24 hodin.",
                    Translator::N_PASSWORD_CHANGED => "Nastavili jste nové heslo k vašemu účtu. Nyní se můžete přihlásit.",
                    Translator::N_USER_CREATE_EMAIL_ERROR => "Nepodařilo se odeslat email s kódem pro vytvoření nového uživatelského účtu.",
                    Translator::N_EMAIL_USED_ENTER_ANOTHER => "Zadaný email je již používán. Zadejte jiný.",
                    Translator::N_USER_CREATE_EMAIL_SENDED => "Na zadaný email byl odeslán email s instrukcemi pro aktivaci účtu.",
                    Translator::N_USER_ACTIVATED => "Aktivovali jste váš nový účet. Nyní se můžete přihlásit.",
                    Translator::N_NOTHING_TO_DISPLAY => "Nebylo nalezeno nic ke zobrazení.",
                    Translator::N_FILE_IS_NOT_DELETABLE => "Požadovaný soubor nebylo možné smazat.",
                    Translator::PAGINATION_PAGE_SIZE => "Velikost stránky",
                    Translator::PAGINATION_DISPLAYED_ROWS => "Zobrazeno řádků",
                    Translator::PAGINATION_FOUND_ROWS => "Nalezeno řádků",
                    Translator::PAGINATION_ACTUAL_PAGE => "Aktuální stránka",
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