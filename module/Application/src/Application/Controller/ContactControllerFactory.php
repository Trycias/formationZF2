<?php
namespace Application\Controller;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class ContactControllerFactory implements FactoryInterface {
	public function createService (ServiceLocatorInterface $cm){
		$sm = $cm->getServiceLocator();
        $contactService = $sm->get('Application\Service\Contact');
        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
        $logger = $sm->get('Log\App');
//         var_dump($sm);
        $conf = $sm->get('config');
        return new ContactController($contactService, $entityManager, $logger, $conf);
	}
}