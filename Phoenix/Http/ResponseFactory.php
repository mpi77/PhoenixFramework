<?php

namespace Phoenix\Http;

use \Exception;
use \Phoenix\Http\HtmlResponse;
use \Phoenix\Http\JsonResponse;
use \Phoenix\Http\XmlResponse;

/**
 * Response factory object.
 *
 * @version 1.1
 * @author MPI
 *        
 */
class ResponseFactory {
    const RESPONSE_UNKNOWN = 0;
    const RESPONSE_HTML = 1;
    const RESPONSE_JSON = 2;
    const RESPONSE_XML = 3;

    private function __construct() {
    }

    /**
     * Get new response object by given output format.
     * If is constant unknown then returns HtmlResponse object.
     *
     * @param integer $format
     *            [optional] constant from ResponseFactory class with preffix RESPONSE_*
     *            
     * @return (Html+Json+Xml)Response
     */
    public static final function createResponse($format = null) {
        switch ($format) {
            case self::RESPONSE_HTML :
                return new HtmlResponse();
                break;
            case self::RESPONSE_JSON :
                return new JsonResponse();
                break;
            case self::RESPONSE_XML :
                return new XmlResponse();
                break;
            default :
                return new HtmlResponse();
        }
    }

    /**
     * Is output fomat valid.
     *
     * @param integer $format
     *            constants from Response class with preffix RESPONSE_*
     *            
     * @return boolean
     */
    public static final function isValidResponseFormat($format) {
        if (!is_int($format)) {
            return false;
        }
        
        switch ($format) {
            case self::RESPONSE_HTML :
            case self::RESPONSE_JSON :
            case self::RESPONSE_XML :
                return true;
                break;
            default :
                return false;
        }
    }
}
?>
