<?php

namespace Phoenix\Http;

use \Exception;
use \Phoenix\Core\Config;
use \Phoenix\Http\Response;
use \Phoenix\Utils\System;
use \Phoenix\Utils\TemplateData;
use \Phoenix\Exceptions\NoticeException;
use \Phoenix\Exceptions\WarningException;

/**
 * Html response object.
 *
 * @version 1.12
 * @author MPI
 *        
 */
final class HtmlResponse extends Response {
    const CONTENT_TYPE_HTML = "text/html";
    const CHARSET_HTML = "utf-8";
    const HEADER_TEMPLATE_FILE = "MasterHeaderTemplate.php";
    const FOOTER_TEMPLATE_FILE = "MasterFooterTemplate.php";
    
    /**
     *
     * @var Phoenix\Utils\TemplateData
     */
    private $template_data;
    /**
     *
     * @var string
     */
    private $template_file;

    /**
     * HtmlResponse constructor.
     *
     * @param string $template_file
     *            [optional] default null
     * @param Phoenix\Utils\TemplateData $template_data
     *            [optional] default null
     * @param Exception $e
     *            [optional] default null
     */
    public function __construct($template_file = null, TemplateData $template_data = null, Exception $e = null) {
        parent::__construct(self::CONTENT_TYPE_HTML, self::CHARSET_HTML, $e);
        $this->setTemplateData($template_data);
        $this->setTemplateFile($template_file);
    }

    /**
     * Send this response object to output.
     */
    public function send() {
        $e = $this->getException();
        $tpd = $this->template_data; // variable $tpd is accessible in each template file
        if (is_null($e) || $e instanceof NoticeException || $e instanceof WarningException) {
            // send header
            $this->sendHeader();
            
            $templates_path = Config::get(Config::KEY_DIR_APP_TEMPLATES);
            
            // include Master header template
            if (!empty($templates_path) && is_file($templates_path . self::HEADER_TEMPLATE_FILE)) {
                include $templates_path . self::HEADER_TEMPLATE_FILE;
            }
            
            // make exception box
            if (!is_null($e)) {
                echo $this->getExceptionBox();
            }
            
            // make content (only for null or Notice exception)
            if ((is_null($e) || $e instanceof NoticeException) && !empty($this->template_file) && is_file($this->template_file)) {
                include $this->template_file;
            }
            
            // include Master footer template
            if (!empty($templates_path) && is_file($templates_path . self::FOOTER_TEMPLATE_FILE)) {
                include $templates_path . self::FOOTER_TEMPLATE_FILE;
            }
        } else {
            System::redirect(Config::get(Config::KEY_SITE_FQDN) . Config::get(Config::KEY_SHUTDOWN_PAGE));
        }
    }

    /**
     * Get string representation of this response class.
     *
     * @return string
     */
    public function __toString() {
        return sprintf("HtmlResponse{template_file=%s}", $this->template_file);
    }

    /**
     * Set response template data.
     *
     * @param Phoenix\Utils\TemplateData $template_data            
     */
    public function setTemplateData(TemplateData $template_data) {
        if (!is_null($template_data)) {
            $this->template_data = $template_data;
        }
    }

    /**
     * Set response template file.
     *
     * @param string $template_file            
     */
    public function setTemplateFile($template_file) {
        $this->template_file = $template_file;
    }

    /**
     * Get exception container (div).
     *
     * @return string
     */
    private function getExceptionBox() {
        $r = "";
        if (!is_null($this->getException())) {
            $class = "alert-success";
            $icon = "fa-info";
            $s = get_class($this->getException());
            $s = substr($s, strrpos($s, "\\") + 1);
            switch ($s) {
                case "NoticeException" :
                    $class = "alert-info";
                    $icon = "fa-info";
                    break;
                case "WarningException" :
                    $class = "alert-warning";
                    $icon = "fa-warning";
                    break;
                case "FailureException" :
                    $class = "alert-error";
                    $icon = "fa-bolt";
                    break;
                default :
                    $class = "alert-error";
                    $icon = "fa-bolt";
                    break;
            }
            $r = sprintf("<div id=\"exception\" class=\"alert %s\"><i class=\"fa %s\"></i>&nbsp;<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>%s</strong></div>", $class, $icon, $this->getException()->__toString());
        }
        return $r;
    }
}
?>
