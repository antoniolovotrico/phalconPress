<?php
use Phalcon\Mvc\Controller;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;


class SessionController extends Controller
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
        var_dump($session->exists());
    }

    public function startAction()
    {  
        if (true === $this->request->isPost()) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            
            $user = Users::findFirst(
                [
                    "(email = :email:) " .
                    "AND password = :password: " ,
                    // ."AND active = 'Y'",
                    'bind' => [
                        'email'    => $email,
                        'password' => $password,
                    ]
                ]
            );
            $session = new Manager();
            $files = new Stream(
                [
                    'savePath' => '/tmp',
                ]
            );
            $session->setAdapter($files);

            if (null !== $user){
                $session->start();
                $session->set('user', $user);
                return $this->dispatcher->forward(
                             [
                                 'controller' => 'post',
                                 'action'     => 'index'
                             ]
                         );
            }

            // if (null !== $user && session_status() === PHP_SESSION_NONE) {
            //     session_start();
            //     $_SESSION["user"] = $user;
            //     // $_SESSION["name"] = $user->name;
            //     // $_SESSION["id"] = $user->id;
            //     // $this->view->setVar($aaa);

            //     return $this->dispatcher->forward(
            //         [
            //             'controller' => 'post',
            //             'action'     => 'index'
            //         ]
            //     );
            // } else if (null !== $user && session_status() === PHP_SESSION_ACTIVE && $_SESSION["user"] = $user){
            //     return $this->dispatcher->forward(
            //         [
            //             'controller' => 'post',
            //             'action'     => 'index'
            //         ]
            //     );
            // }

            $this->flash->error(
                'Wrong email/password'
            );
        }

        return $this->dispatcher->forward(
            [
                'controller' => 'session',
                'action'     => 'index',
            ]
        );
    }

    public function quitAction()
    {  
        
            $session = new Manager();
            $files = new Stream(
                [
                    'savePath' => '/tmp',
                ]
            );
            $session->setAdapter($files);

            
                $session->start();
                $session->destroy();
                // return $this->dispatcher->forward(
                //              [
                //                  'controller' => 'index',
                //                  'action'     => 'index'
                //              ]
                //          );
                $this->response->redirect('/');
            }
}