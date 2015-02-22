<?php

namespace App\Locale\Cz;

use \Phoenix\Locale\IModuleTranslator;

/**
 * Exception translator.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class ExceptionTranslator implements IModuleTranslator {
    
    /* failure exceptions */
    const F_UNKNOWN = 100;
    const F_MISSING_CONFIG_DB = 101;
    const F_UNABLE_CONNECT_DB = 102;
    const F_UNABLE_SET_DB_CHARSET = 103;
    const F_UNABLE_SAVE_WARNING = 104;
    
    /* warning exceptions */
    const W_UNKNOWN = 200;
    const W_CLASS_NOT_FOUND = 201;
    const W_ACTION_IS_NOT_CALLABLE = 202;
    const W_INVALID_PARAMETERS = 203;
    const W_PERMISSION_DENIED = 204;
    const W_INVALID_TOKEN = 205;
    const W_DB_INVALID_SQL_SELECT = 240;
    const W_DB_INVALID_SQL_ACTION = 241;
    const W_DB_UNABLE_VERIFY_RESULT = 242;
    const W_DB_UNABLE_BEGIN_TRANSACTION = 243;
    const W_DB_UNABLE_COMMIT_TRANSACTION = 244;
    const W_DB_UNABLE_ROLLBACK_TRANSACTION = 245;
    const W_ROUTER_INVALID_ROUTE = 250;
    const W_ROUTER_INVALID_ROUTE_ACTION = 251;
    const W_RESPONSE_INVALID_FORMAT = 260;
    const W_RESPONSE_UNSUPPORTED_FORMAT = 261;
    
    /* notice exceptions */
    const N_UNKNOWN = 500;
    
    /**
     * Maps self::constants to strings.
     *
     * @var array
     */
    private static $data = array (
                    self::F_UNKNOWN => "Neznámá kritická chyba.",
                    self::F_MISSING_CONFIG_DB => "Nebyly zadány parametry pro spojení s databází.",
                    self::F_UNABLE_CONNECT_DB => "Nepovedlo se spojit s databází.",
                    self::F_UNABLE_SET_DB_CHARSET => "Nepovedlo se nastavit kódování spojení s databází.",
                    self::F_UNABLE_SAVE_WARNING => "Nepovedlo se uložit chybu do databáze.",
                    self::W_UNKNOWN => "Neznámá chyba.",
                    self::W_CLASS_NOT_FOUND => "Požadovaná třída nebyla nalezena.",
                    self::W_ACTION_IS_NOT_CALLABLE => "Zadanou akci nelze spustit.",
                    self::W_INVALID_PARAMETERS => "Zadané parametry nejsou platné.",
                    self::W_PERMISSION_DENIED => "Nemáte potřebné oprávnění k provedení této akce.",
                    self::W_INVALID_TOKEN => "Token není platný.",
                    self::W_DB_INVALID_SQL_SELECT => "Nesprávný databázový (select) dotaz.",
                    self::W_DB_INVALID_SQL_ACTION => "Nesprávný databázový (action) dotaz.",
                    self::W_DB_UNABLE_VERIFY_RESULT => "Nepodařilo se ověřit správný výsledek akce.",
                    self::W_DB_UNABLE_BEGIN_TRANSACTION => "Nepodařilo se započít transakci.",
                    self::W_DB_UNABLE_COMMIT_TRANSACTION => "Nepodařilo se potvrdit transakci.",
                    self::W_DB_UNABLE_ROLLBACK_TRANSACTION => "Nepodařilo se ukončit transakci.",
                    self::W_ROUTER_INVALID_ROUTE => "Neznámá cesta.",
                    self::W_ROUTER_INVALID_ROUTE_ACTION => "Neznámá akce.",
                    self::W_RESPONSE_INVALID_FORMAT => "Neplatný formát odpovědi.",
                    self::W_RESPONSE_UNSUPPORTED_FORMAT => "Neznámý formát odpovědi.",
                    self::N_UNKNOWN => "Neznámé upozornění." 
    );

    /**
     * ExceptionTranslator constructor.
     */
    private function __construct() {
    }

    /**
     * Get translated message for given key.
     *
     * @param integer $key            
     * @return string
     */
    public static function get($key) {
        return (is_int($key) && key_exists($key, self::$data)) ? self::$data[$key] : IModuleTranslator::DEFAULT_VALUE;
    }
}
?>