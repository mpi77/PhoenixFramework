<?php

namespace Phoenix\Http;

use \Phoenix\Core\Config;
use \Phoenix\Utils\System;
use \Phoenix\Http\Response;
use \Phoenix\Exceptions\NoticeException;
use \Phoenix\Exceptions\WarningException;

/**
 * Html response object.
 *
 * @version 1.10
 * @author MPI
 *        
 * @todo TemplateData
 */
final class HtmlResponse extends Response {
    private $template_data;
    private $template_file;

    /**
     * HtmlResponse constructor.
     *
     * @param string $template_file            
     * @param TemplateData $template_data            
     * @param Exception $e            
     */
    public function __construct($template_file = null, TemplateData $template_data = null, Exception $e = null) {
        parent::__construct(Response::CONTENT_TYPE_HTML, Response::CHARSET_HTML, $e);
        $this->setTemplateData($template_data);
        $this->setTemplateFile($template_file);
    }

    /**
     * Send this response object to output.
     */
    public function send() {
        $e = $this->getException();
        $tpd = $this->template_data;
        if (is_null($e) || $e instanceof NoticeException || $e instanceof WarningException) {
            // send header
            $this->sendHeader();
            
            $templates_path = Config::get(Config::KEY_DIR_APP) . "/Templates/";
            
            // include Master header template
            include $templates_path . "MasterHeaderTemplate.php";
            
            // make exception box
            if (!is_null($e)) {
                echo $this->getExceptionBox();
            }
            
            // make content (only for null or Notice exception)
            if ((is_null($e) || $e instanceof NoticeException) && !empty($this->template_file) && is_file($this->template_file)) {
                include $this->template_file;
            }
            
            // include Master footer template
            include $templates_path . "MasterFooterTemplate.php";
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
     * @param TemplateData $template_data            
     */
    public function setTemplateData(TemplateData $template_data = null) {
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
            switch (get_class($this->getException())) {
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
