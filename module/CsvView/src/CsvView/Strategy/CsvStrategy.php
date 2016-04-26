<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace CsvView\Strategy;

use CsvView\Model;
use CsvView\Model\CsvModel;
use CsvView\Renderer\CsvRenderer;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\View\ViewEvent;

class CsvStrategy extends AbstractListenerAggregate
{
    /**
     * Character set for associated content-type
     *
     * @var string
     */
    protected $charset = 'utf-8';

    /**
     * Multibyte character sets that will trigger a binary content-transfer-encoding
     *
     * @var array
     */
    protected $multibyteCharsets = [
        'UTF-16',
        'UTF-32',
    ];

    /**
     * @var CsvRenderer
     */
    protected $renderer;

    /**
     * Constructor
     *
     * @param  CsvRenderer $renderer
     */
    public function __construct(CsvRenderer $renderer) {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1) {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, [$this, 'selectRenderer'], $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, [$this, 'injectResponse'], $priority);
    }

    /**
     * Set the content-type character set
     *
     * @param  string $charset
     * @return CsvStrategy
     */
    public function setCharset($charset) {
        $this->charset = (string) $charset;
        return $this;
    }

    /**
     * Retrieve the current character set
     *
     * @return string
     */
    public function getCharset() {
        return $this->charset;
    }

    /**
     * Detect if we should use the JsonRenderer based on model type and/or
     * Accept header
     *
     * @param  ViewEvent $e
     * @return null|CsvRenderer
     */
    public function selectRenderer(ViewEvent $e) {
        $model = $e->getModel();

        if (!$model instanceof CsvModel) {
            return;
        }

        return $this->renderer;
    }

    /**
     * Inject the response with the JSON payload and appropriate Content-Type header
     *
     * @param  ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e) {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            // Discovered renderer is not ours; do nothing
            return;
        }
        
        $result   = $e->getResult();
        if (!is_string($result)) {
            // We don't have a string, and thus, no JSON
            return;
        }
        $opt = $e->getModel()->getOptions();
        $filename = isset($opt['filename']) ?$opt['filename'] : 'export.csv'; 
        // Populate response
        $response = $e->getResponse();
        $result = $this->utf8ToCsvEncode($result);
        $response->setContent($result);
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'text/csv');
        $headers->addHeaderLine('Content-Disposition', "attachment; filename=\"".$filename."\"");
        $headers->addHeaderLine('Accept-Ranges', 'bytes');
        $headers->addHeaderLine('Content-Length', strlen($result));


        if (in_array(strtoupper($this->charset), $this->multibyteCharsets)) {
            $headers->addHeaderLine('content-transfer-encoding', 'BINARY');
        }
    }
    
    
    private function utf8ToCsvEncode($str){
        return iconv("UTF-8", "Windows-1252", $str);
    }
}
