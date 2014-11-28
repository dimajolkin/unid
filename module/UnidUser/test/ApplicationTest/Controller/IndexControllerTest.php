<?php
namespace ApplicationTest\Controller;

use Application\Model\Data;
use Zend\EventManager\EventManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
       $dir = '../../TestConfig.php';
         file_exists($dir);

        $this->setApplicationConfig(
            array(
                'modules' => array(
                    'UnidUser',
                ),
                'module_listener_options' => array(
                    'config_glob_paths'    => array(
                        '../../../config/autoload/{,*.}{global,local}.php',
                    ),
                    'module_paths' => array(
                        'module',
                        'vendor',
                    ),
                ),
            )
        );
       parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {

        $data = new Data();

        $events = new EventManager();
        $events->attach('do', function($e) {
            $event  = $e->getName();
            $params = $e->getParams();
            printf(
                'Handled event "%s", with parameters %s',
                $event,
                json_encode($params)
            );

        });

        $params = array('foo' => 'bar', 'baz' => 'bat');
        $events->trigger('do', null, $params);

    }
}