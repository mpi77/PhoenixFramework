<?php

/**
 * Html response object.
 * 
 * @version 1.7
 * @author MPI
 * */
final class HtmlResponse extends Response {
    private $templateData;
    private $templateFile;

    public function __construct($templateFile = null, TemplateData $templateData = null, Exception $e = null) {
        parent::__construct(Response::CONTENT_TYPE_HTML, Response::CHARSET_HTML, $e);
        $this->setTemplateData($templateData);
        $this->setTemplateFile($templateFile);
    }

    /**
     * Send this response object to output.
     *
     * @todo
     *
     */
    public function send() {
        $e = $this->getException();
        $tpd = $this->templateData;
        if (is_null($e) || $e instanceof NoticeException || $e instanceof WarningException) {
            // send header
            $this->sendHeader();
            
            // include Master header template
            include 'gui/template/MasterHeaderTemplate.php';
            
            // make exception box
            if (!is_null($e)) {
                echo $this->getExceptionBox();
            }
            
            // make content (only for null or Notice exception)
            if ((is_null($e) || $e instanceof NoticeException) && !empty($this->templateFile) && is_file($this->templateFile)) {
                include $this->templateFile;
            }
            
            // include Master footer template
            include 'gui/template/MasterFooterTemplate.php';
        } else {
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        }
    }

    /**
     * Get string representation of this response class.
     *
     * @todo
     *
     */
    public function __toString() {
    }

    /**
     * Set response templateData.
     *
     * @param TemplateData $templateData            
     */
    public function setTemplateData(TemplateData $templateData = null) {
        if (!is_null($templateData)) {
            $this->templateData = $templateData;
        }
    }

    /**
     * Set response templateFile.
     *
     * @param string $templateFile            
     */
    public function setTemplateFile($templateFile) {
        $this->templateFile = $templateFile;
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
