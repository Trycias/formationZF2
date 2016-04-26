<?php
namespace CsvView;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        $configContent = scandir(__DIR__.'/config');
  //      $configFiles = array_filter($configContent, function($fileName) {
//            var_dump($fileName);
//            if(strrpos($fileName, '.config.php') >0) {
//                return true;
//            }
  //      });
    //    var_dump($configFiles);
        
        
    $configFiles =array_filter($configContent, function($fileName) {
            return preg_match("/\\.config\\.php$/", $fileName);
    });
    $config = array();
    foreach ($configFiles as $configFile) {
       $config =  \Zend\Stdlib\ArrayUtils::merge($config, include __DIR__.'/config/'.$configFile);
    }
    //var_dump($config);
    return $config;
        }

}