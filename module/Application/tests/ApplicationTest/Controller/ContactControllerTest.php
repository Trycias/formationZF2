<?php

namespace ApplicationTest\Controller;

use Application\Entity\Contact;
use Application\Service\ContactServiceInterface;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Description of ContactControllerTest
 *
 * @author tech
 */
class ContactControllerTest extends AbstractHttpControllerTestCase {
    protected function setUp() {
        $this->setApplicationConfig(require 'config/application.config.php');
    }
    
    public function testListActionIsAccessible() {
        //accès à l'url
        $this->dispatch('/application/contact/list');
    //echo $this->getResponse()->getContent();
       $this->assertResponseStatusCode(200);
    }
    public function testListActionContent() {
        //accès à l'url
        $this->dispatch('/application/contact/list');
        $this->assertQueryCount('li.contact', 6);
    }
    public function testListActionContentWithMock(){
        $service = $this->prophesize(ContactServiceInterface::class);
        $service->findAll()->shouldBeCalledTimes(1)->willReturn(array(
                (new Contact())->setId(1)->setPrenom('Jean')->setNom('Nom1'),
                (new Contact())->setId(2)->setPrenom('Paul')->setNom('Nom2'),
                ));

        $sm = $this->getApplicationServiceLocator();
        $sm->setAllowOverride(true);
        $sm->setService('Application\Service\Contact', $service->reveal());
        $this->dispatch('/application/contact/list');
        $this->assertQueryCount('li.contact', 2);
    }
}
