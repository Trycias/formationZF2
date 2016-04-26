<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace CsvView\Renderer;

use ArrayAccess;
use CsvView\Model\CsvModel;
use Zend\View\Exception;
use Zend\View\Model\ModelInterface as Model;
use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\View\Resolver\ResolverInterface as Resolver;

/**
 * JSON renderer
 */
class CsvRenderer implements Renderer {
	/**
	 * Whether or not to merge child models with no capture-to value set
	 * 
	 * @var bool
	 */
	protected $mergeUnnamedChildren = false;
	
	/**
	 *
	 * @var Resolver
	 */
	protected $resolver;
	
	/**
	 * Return the template engine object, if any
	 *
	 * If using a third-party template engine, such as Smarty, patTemplate,
	 * phplib, etc, return the template engine object. Useful for calling
	 * methods on these objects, such as for setting filters, modifiers, etc.
	 *
	 * @return mixed
	 */
	public function getEngine() {
		return $this;
	}
	
	/**
	 * Set the resolver used to map a template name to a resource the renderer may consume.
	 *
	 * @todo Determine use case for resolvers when rendering JSON
	 * @param Resolver $resolver        	
	 * @return Renderer
	 */
	public function setResolver(Resolver $resolver) {
		$this->resolver = $resolver;
	}
	
	/**
	 * Should we merge unnamed children?
	 *
	 * @return bool
	 */
	public function mergeUnnamedChildren() {
		return $this->mergeUnnamedChildren;
	}
	
	/**
	 * Renders values as CSV
	 *
	 * @todo Determine what use case exists for accepting both $nameOrModel and $values
	 * @param string|Model $nameOrModel
	 *        	The script/resource process, or a view model
	 * @param null|array|ArrayAccess $values
	 *        	Values to use during rendering
	 * @throws Exception\DomainException
	 * @return string The script output.
	 */
	public function render($nameOrModel, $values = null) {
		// Serialize variables in view model
		if ($nameOrModel instanceof Model) {
			$values = $nameOrModel->serialize();
			return $values;
		}
        // use case 3: Both $nameOrModel and $values are populated
        throw new Exception\DomainException(sprintf(
            '%s: Do not know how to handle operation when both $nameOrModel and $values are populated',
            __METHOD__
        ));
    }

}
