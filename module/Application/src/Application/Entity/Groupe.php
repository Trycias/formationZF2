<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="groupe")
*/
class Groupe 
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;
	/** @ORM\Column(length=40) */
	protected $nom;

    /**
     * coté secondaiere
     * @ORM\ManyToMany(targetEntity="Application\Entity\Contact", inversedBy="groupes") 
     */
    protected $contacts;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set id
     *
     * @param string $id
     *
     * @return Groupe
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Groupe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add contact
     *
     * @param \Application\Entity\Contact $contact
     *
     * @return Groupe
     */
    public function addContact(\Application\Entity\Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \Application\Entity\Contact $contact
     */
    public function removeContact(\Application\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}
