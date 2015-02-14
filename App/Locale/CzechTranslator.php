<?php

namespace App\Locale;

use \Phoenix\Locale\Translator as T;
use \App\AppTranslator as AT;

/**
 * Czech translator.
 *
 * @version 1.10
 * @author MPI
 *        
 */
class CzechTranslator extends AT {
    private static $info = array (
                    T::INFO_LANGUAGE_NAME => "čeština",
                    T::INFO_CLASS_NAME => __CLASS__ 
    );
    
    /**
     * Maps AppTranslator::constant to string.
     *
     * @var array
     */
    private $data = array (
                    AT::F_UNKNOWN => "Neznámá kritická chyba.",
                    AT::F_MISSING_CONFIG_DB => "Nebyly zadány parametry pro spojení s databází.",
                    AT::F_UNABLE_CONNECT_DB => "Nepovedlo se spojit s databází.",
                    AT::F_UNABLE_SET_DB_CHARSET => "Nepovedlo se nastavit kódování spojení s databází.",
                    AT::F_UNABLE_SAVE_WARNING => "Nepovedlo se uložit chybu do databáze.",
                    AT::W_UNKNOWN => "Neznámá chyba.",
                    AT::W_CLASS_NOT_FOUND => "Požadovaná třída nebyla nalezena.",
                    AT::W_ACTION_IS_NOT_CALLABLE => "Zadanou akci nelze spustit.",
                    AT::W_INVALID_PARAMETERS => "Zadané parametry nejsou platné.",
                    AT::W_PERMISSION_DENIED => "Nemáte potřebné oprávnění k provedení této akce.",
                    AT::W_INVALID_TOKEN => "Token není platný.",
                    AT::W_DB_INVALID_SQL_SELECT => "Nesprávný databázový (select) dotaz.",
                    AT::W_DB_INVALID_SQL_ACTION => "Nesprávný databázový (action) dotaz.",
                    AT::W_DB_UNABLE_VERIFY_RESULT => "Nepodařilo se ověřit správný výsledek akce.",
                    AT::W_DB_UNABLE_BEGIN_TRANSACTION => "Nepodařilo se započít transakci.",
                    AT::W_DB_UNABLE_COMMIT_TRANSACTION => "Nepodařilo se potvrdit transakci.",
                    AT::W_DB_UNABLE_ROLLBACK_TRANSACTION => "Nepodařilo se ukončit transakci.",
                    AT::W_ROUTER_INVALID_ROUTE => "Neznámá cesta.",
                    AT::W_ROUTER_INVALID_ROUTE_ACTION => "Neznámá akce.",
                    AT::W_RESPONSE_INVALID_FORMAT => "Neplatný formát odpovědi.",
                    AT::W_RESPONSE_UNSUPPORTED_FORMAT => "Neznámý formát odpovědi.",
                    AT::N_UNKNOWN => "Neznámé upozornění." 
    );

    /**
     * CzechTranslator constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get translated message for given key.
     *
     * @param integer $key            
     * @return string
     */
    public function get($key) {
        return (is_int($key) && key_exists($key, $this->data)) ? $this->data[$key] : T::DEFAULT_VALUE;
    }

    /**
     * Get language info.
     *
     * @return array
     */
    public static function langInfo() {
        return self::$info;
    }
}
?>