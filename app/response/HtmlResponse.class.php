<?php

/**
 * Html response object.
 * 
 * @version 1.0
 * @author MPI
 * */
abstract class HtmlResponse extends Response {
    private $templateData;

    public function __construct(TemplateData $tpd = null, Exception $e = null) {
        parent::__construct(Response::CONTENT_TYPE_HTML, Response::CHARSET_HTML, $e);
    }

    /**
     * Send this response object to output.
     *
     * @todo
     *
     */
    public function send() {
        $this->sendHeader();
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
}
?>
