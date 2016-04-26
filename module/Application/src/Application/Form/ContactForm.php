<?php 
namespace Application\Form;

use Zend\Form\Form;
use Doctrine\ORM\EntityManager;

class ContactForm extends Form {
	 public function __construct(EntityManager $em)
     {
         // we want to ignore the name passed
         parent::__construct('contact');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'prenom',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Prénom',
             ),
         ));
         $this->add(array(
             'name' => 'nom',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Nom',
             ),
         ));
         $this->add(array(
             'name' => 'email',
             'type' => 'Email',
             'options' => array(
                 'label' => 'Email',
             ),
         ));
         $this->add(array(
             'name' => 'telephone',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Téléphone',
             ),
         ));

        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'societe',
                'options' => array(
                    'object_manager'     => $em,
                    'target_class'       => \Application\Entity\Societe::class,
                    'property'           => 'nom',
                    'display_empty_item' => true,
                    'empty_item_label'   => '-Pas de societe-',
                ),
            )
        );

		$this->add(
		    array(
		        'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
		        'name' => 'groupes',
		        'options' => array(
		            'object_manager'     => $em,
		            'target_class'       => \Application\Entity\Groupe::class,
		            'property'           => 'nom',
		            'display_empty_item' => true,
		            'empty_item_label'   => '-Pas de groupe-',
		        ),
                'attributes' => array(
                 'multiple' => 'multiple',
             ),
		    )
		);

         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Valider',
                 'id' => 'submitbutton',
             ),
         ));
     }
}