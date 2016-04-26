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
     * valeur par défaut. a remplacer par les valeur du fichier de config
     */
	protected $delimiter = ';';
    /**
     * valeur par défaut. a remplacer par les valeur du fichier de config
     */
    protected $enclosure = '"';
    protected $retourLigne = '\n';

    /**
     * Serialize to CSV
     *
     * @return string
     */
    public function serialize()
    {
        $encloseAll = false; 
        $nullToMysqlNull = false ;
        $delimiter_esc = preg_quote($this->delimiter, '/');
        $enclosure_esc = preg_quote($this->enclosure, '/');
    
        $output = array();
        $lignes = $this->getVariables();
        if ($lignes instanceof Traversable) {
            $lignes = ArrayUtils::iteratorToArray($lignes);
        }
        
        foreach ( $lignes as $ligne ) {
            if ($ligne === null && $nullToMysqlNull) {
                $output[] = 'NULL';
                continue;
            }
            $line = array();
            foreach ($ligne as $datas) {
	            if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $datas) ) 
	            {
	                $line[] = $this->enclosure
	                				.str_replace($this->enclosure, $this->enclosure . $this->enclosure, $datas) 
	                				.$this->enclosure;
	            }
	            else {
	                $line[] = $datas;
	            }
            }
//             var_dump($line);
            $donnees = implode($line, $this->delimiter).$this->delimiter.$this->retourLigne;
//             var_dump($donnees);
            
            $output[] = $donnees;
    
        }
//             var_dump($output);
        
        return $output;
    }
}
