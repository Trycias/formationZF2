<?php
namespace Application\Service;

use Application\Form\ContactForm;

interface ContactServiceInterface {
	public function findAll();
	public function save (ContactForm $cf, $data);
}