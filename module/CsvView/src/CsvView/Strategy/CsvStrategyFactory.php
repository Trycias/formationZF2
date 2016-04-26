<?php

namespace CsvView\Strategy;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class CsvStrategyFactory implements \Zend\ServiceManager\FactoryInterface {
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $renderer = $serviceLocator->get('ViewCsvRenderer');
        return new CsvStrategy($renderer);
    }

}