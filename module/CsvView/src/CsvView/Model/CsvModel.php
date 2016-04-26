<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace CsvView\Model;

use Traversable;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Helper\Json;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;



class CsvModel extends ViewModel
{
	/**
	 * JSON probably won't need to be captured into a
	 * a parent container by default.
	 *
	 * @var string
	 */
	protected $captureTo = null;
	
	 
	/**
	 * JSON is usually terminal
	 *
	 * @var bool
	 */
	protected $terminate = true;
	
	/**
	 * valeur par défaut. a remplacer par les valeur du fichier de config
	 */
	protected $delimiter = ';';
	/**
	 * valeur par défaut. a remplacer par les valeur du fichier de config
	 */
	protected $enclosure = '"';
	protected $retourLigne = "\n";
	

        /**
     * Serialize to CSV
     *
     * @return string
     */
    public function serialize()
    {
         $encloseAll = false; $nullToMysqlNull = false ;
        $delimiter_esc = preg_quote($this->delimiter, '/');
        $enclosure_esc = preg_quote($this->enclosure, '/');
    
        $output = array();
        $lignes = $this->getVariables();
        if ($lignes instanceof Traversable) {
            $lignes = ArrayUtils::iteratorToArray($lignes);
        }
        
        //pour chaque ligne on ajoute un caractére de fin de ligne
        //pour chaque cellule, on encapsule de guillemet et on sépare avec le séparateur
        foreach ($lignes as $ligne) {
        	$donnees = array();
        	foreach ($ligne as $donnee) {
        		$donnees[] =  $this->enclosure.$donnee.$this->enclosure.$this->delimiter;
        	}
        	$output[] = implode($donnees);
        }
        return implode($output, $this->retourLigne);
    }
}
