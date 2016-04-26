<?php
namespace Application\Service;

use Application\Entity\Contact;
use Application\Form\ContactForm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineModule\Stdlib\Hydrator\Strategy\DisallowRemoveByValue;
 class ContactDoctrineService implements ContactServiceInterface 
 {
 	/**
 	 * @var Entity Manager
 	 */
 	protected $em;

	/**
	 * @param EntityManager $em
	 */
 	public function __construct(EntityManager $em) {
 		$this->em = $em;
 	}

 	public function  getRepository()
	{
		return $this->em->getRepository(Contact::class);
	}
 	public function findAll(){
 		return $this->getRepository()->findAll();
 	}
 	public function save(ContactForm $cf, $data){
 		$cf->setData($data);
 		if($cf->isValid()){
			$dataFiltrees = $cf->getData();
			//var_dump($dataFiltrees);
			$contact = new Contact();
			//todo recuperer doctrineObject dnas HydratorManager
			//todo $contactForm->setInputFilter();
			$hydrator = new DoctrineObject($this->em);
			$hydrator->addStrategy('groupes', new DisallowRemoveByValue());
			$hydrator->hydrate($dataFiltrees, $contact);
			var_dump($contact);
			$this->em->persist($contact);
			$this->em->flush();
			return $contact;
		}
		return null;

 	}
 }