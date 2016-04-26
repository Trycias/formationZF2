<?php
namespace ApplicationTest\Entity;

use Application\Entity\Contact;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
require_once __DIR__.'/../../../src/Application/Entity/Contact.php';
/**
 * Description of ContactTest
 *
 * @author tech
 */
class ContactTest extends PHPUnit_Framework_TestCase
{
    

    /**
     *
     * @var Contact
     */
    protected $contact;
    public function testInitValuesAreNull() {
        $this->assertNull($this->contact->getId());
        $this->assertNull($this->contact->getNom());
        $this->assertNull($this->contact->getPrenom());
        $this->assertNull($this->contact->getEmail());
        $this->assertInstanceOf(ArrayCollection::class, $this->contact->getGroupes());
        $this->assertEmpty($this->contact->getGroupes());
    }
    
    public function testGetSetId() {
        $this->contact->setId(1);
        $this->assertEquals(1, $this->contact->getId());
    }
    
    protected function setUp() {
        $this->contact = new Contact();
    }
}
