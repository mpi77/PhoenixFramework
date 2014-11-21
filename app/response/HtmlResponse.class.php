<?php

/**
 * Html response object.
 * 
 * @version 1.4
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
            if(!is_null($e)){
                System::makeExceptionCont();
            }
            
            // make content
            include $this->templateFile;
            
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
}
?>
