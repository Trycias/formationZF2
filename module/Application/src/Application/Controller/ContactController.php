<?php

namespace Application\Controller;

use Application\Entity\Contact;
use Application\Form\ContactForm;
use Application\Service\ContactServiceInterface;
use CsvView\Model\CsvModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineModule\Stdlib\Hydrator\Strategy\DisallowRemoveByValue;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Request;
use Zend\Stdlib\Response;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractActionController {
	/**
	 *
	 * @var Request
	 */
	protected $request;
	/**
	 *
	 * @var Response
	 */
	protected $response;
	/**
	 * on peut utiliser un proxy pour le rendre optionnel (eazy loading)...
	 * ou le getLocateur
	 * 
	 * @var ConstactServiceInterface
	 */
	protected $contactService;
	/**
	 * acces à l'entité manager
	 * 
	 * @var EntityManagerInterface
	 */
	protected $entityManager;
	/**
	 *
	 * @var LogWriterManager
	 */
	protected $logger;
	/**
	 *
	 * @var array
	 */
	protected $conf;
	// il faut tout injecter comme le service ici ..
	// à retrouver et à faire partout !!
	public function __construct(ContactServiceInterface $service, EntityManagerInterface $doctrine, \Zend\Log\Logger $logger, $conf) {
		$this->contactService = $service;
		$this->entityManager = $doctrine;
		$this->conf = $conf;
		$this->logger = $logger;
		$this->logger->notice ( "Le Logger est accessible" );
	}
	public function addAction() {
		// todo mettre le form dans le service manager
		$contactForm = new ContactForm ( $this->entityManager );
		
		if ($this->request->isPost ()) {
			$data = $this->request->getPost ();
			$contact = $this->contactService->save ( $contactForm, $data );
		}
		
		return new ViewModel ( array (
				'contactForm' => $contactForm 
		) );
	}
	public function listAction() {
		if (isset ( $this->conf ['toto'] )) {
			echo 'utilisation des "conf"';
			var_dump ( $this->conf ['toto'] );
		}
		return new ViewModel ( array (
				'contacts' => $this->contactService->findAll () 
		) );
	}
	public function csvAction() {
		return new CsvModel ( array (
				array (
						"nom",
						"prenom" 
				),
				array (
						"nom2",
						"prenom2" 
				) 
		), array (
				'filename' => 'contact.csv' 
		) );
	}
}