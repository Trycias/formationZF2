<?php
namespace Application\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceAbstractFactory implements AbstractFactoryInterface
{
	protected $regexp = "/^Application\\\\Service\\\\([a-zA-Z]+)Doctrine$/";

//name : cannonique sans slash et minuscule
//$reqName : avec les slash
	public function canCreateServiceWithName(ServiceLocatorInterface $sl, $name, $reqName){
		return preg_match($this->regexp, $reqName);
	}
	public function createServiceWithName(ServiceLocatorInterface $sl, $name, $reqName){

		//var_dump($sl)=> montre tous ce qui est accessible via l'annuaire
		$em = $sl->get('Doctrine\ORM\EntityManager'); 
		$class = $reqName.'Service';
		return new $class($em);
	}
}