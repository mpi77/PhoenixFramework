<?php

namespace App\Locale\Lang\Cz;

use \Phoenix\Locale\IModuleTranslator;
use \App\Locale\Def\ExceptionDefinition as ED;

/**
 * Exception translator.
 *
 * @version 1.3
 * @author MPI
 *        
 */
class ExceptionTranslator implements IModuleTranslator {
    
    /**
     * Maps def::constants to strings.
     *
     * @var array
     */
    private static $data = array (
                    ED::F_UNKNOWN => "Neznámá kritická chyba.",
                    ED::F_MISSING_CONFIG_DB => "Nebyly zadány parametry pro spojení s databází.",
                    ED::F_UNABLE_CONNECT_DB => "Nepovedlo se spojit s databází.",
                    ED::F_UNABLE_SET_DB_CHARSET => "Nepovedlo se nastavit kódování spojení s databází.",
                    ED::F_UNABLE_SAVE_WARNING => "Nepovedlo se uložit chybu do databáze.",
                    ED::F_RESPONSE_HEADERS_SENT => "Nepovedlo se odeslat hlavičky ve správném pořadí.",
                    ED::F_RESPONSE_INVALID_HTTP_CODE => "Nepodařilo se nastavit správný kód odpovědi.",
                    ED::F_URL_PARSE_ERROR => "Nepodařilo se vytvořit url adresu.",
                    ED::W_UNKNOWN => "Neznámá chyba.",
                    ED::W_CLASS_NOT_FOUND => "Požadovaná třída nebyla nalezena.",
                    ED::W_ACTION_IS_NOT_CALLABLE => "Zadanou akci nelze spustit.",
                    ED::W_INVALID_PARAMETERS => "Zadané parametry nejsou platné.",
                    ED::W_PERMISSION_DENIED => "Nemáte potřebné oprávnění k provedení této akce.",
                    ED::W_INVALID_TOKEN => "Token není platný.",
                    ED::W_DB_INVALID_SQL_SELECT => "Nesprávný databázový (select) dotaz.",
                    ED::W_DB_INVALID_SQL_ACTION => "Nesprávný databázový (action) dotaz.",
                    ED::W_DB_UNABLE_VERIFY_RESULT => "Nepodařilo se ověřit správný výsledek akce.",
                    ED::W_DB_UNABLE_BEGIN_TRANSACTION => "Nepodařilo se započít transakci.",
                    ED::W_DB_UNABLE_COMMIT_TRANSACTION => "Nepodařilo se potvrdit transakci.",
                    ED::W_DB_UNABLE_ROLLBACK_TRANSACTION => "Nepodařilo se ukončit transakci.",
                    ED::W_ROUTER_INVALID_ROUTE => "Neznámá cesta.",
                    ED::W_ROUTER_INVALID_ROUTE_ACTION => "Neznámá akce.",
                    ED::W_RESPONSE_INVALID_FORMAT => "Neplatný formát odpovědi.",
                    ED::W_RESPONSE_UNSUPPORTED_FORMAT => "Neznámý formát odpovědi.",
                    ED::W_URL_UNSUPPORTED_FORMAT => "Neznámý formát URL.",
                    ED::N_UNKNOWN => "Neznámé upozornění." 
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