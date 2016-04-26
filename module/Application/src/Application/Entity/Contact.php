<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\Collection;
/* voir la doc dans 
http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/
http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/basic-mapping.html
*/

/**
* @ORM\Entity
* @ORM\Table(name="contact")
*/
class Contact 
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;
	/** @ORM\Column(length=40) */
	protected $prenom;
	/** @ORM\Column(length=40) */
	protected $nom;
	/** @ORM\Column(length=80, nullable=true) */
	protected $email;
	/** @ORM\Column(length=20, nullable=true) */
	protected $telephone;
	/**
	 * dans le target entity on met le nom de la classe
	 * FQCN : Full Qualified Class Name
	 * @ORM\ManyToOne(targetEntity="Application\Entity\Societe") 
	 */
	protected $societe;

	/**
	 * coté principal
	 * @ORM\ManyToMany(targetEntity="Application\Entity\Groupe", mappedBy="contacts") 
	 */
	protected $groupes;

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
     * @return Contact
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Contact
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Contact
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
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Contact
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set societe
     *
     * @param \Application\Entity\Societe $societe
     *
     * @return Contact
     */
    public function setSociete(\Application\Entity\Societe $societe = null)
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * Get societe
     *
     * @return \Application\Entity\Societe
     */
    public function getSociete()
    {
        return $this->societe;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add groupe
     *
     * @param Collection $groupe
     *
     * @return Contact
     */
    public function addGroupes(Collection $groupes)
    {
        foreach ($groupes as $groupe ) {
            $groupe->addContact($this);
            $this->groupes->add($groupe);
        }

        return $this;
    }

    /**
     * Remove groupe
     *
     * @param \Application\Entity\Groupe $groupe
     */
    public function removeGroupes(Collection $groupes)
    {
        foreach ($groupes as $groupe) {
           $groupe->removeContact($this);
           $this->groupes->removeElement($groupe);
        }
        $this->groupes->removeElement($groupe);
    }

    /**
     * Add groupe
     *
     * @param \Application\Entity\Groupe $groupe
     *
     * @return Contact
     */
    public function addGroupe(\Application\Entity\Groupe $groupe)
    {
        $this->groupes[] = $groupe;

        return $this;
    }

    /**
     * Remove groupe
     *
     * @param \Application\Entity\Groupe $groupe
     */
    public function removeGroupe(\Application\Entity\Groupe $groupe)
    {
        $this->groupes->removeElement($groupe);
    }

    /**
     * Get groupes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupes()
    {
        return $this->groupes;
    }
}
