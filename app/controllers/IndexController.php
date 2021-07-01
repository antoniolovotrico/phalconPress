<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

class IndexController extends Controller
{
    public function indexAction()
    {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        $session->start();
        $user = $session->get('user');
        if ($user === null) {
            $session->destroy();
        } 
        
        $this->view->users = Users::find();
    }
}