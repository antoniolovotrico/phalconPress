<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

class PostController extends Controller
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
        $session->get('user');
        
        // var_dump(session_status());
        // if (session_status() === PHP_SESSION_NONE) {
            if ($session->exists() === false) {
            
            return $this->dispatcher->forward(
                [
                    'controller' => 'session',
                    'action'     => 'index'
                ]
            );
            // session_start();

            // $user = $_SESSION['user'];
            // var_dump($user->id);
            // var_dump($user->countPosts());
            // foreach ($user->getPosts() as $post) {
            //     var_dump($post->title);
            // }

            // $this->view->posts = Posts::find();
        }
         
        
        $session->start();
        $user = $session->get('user');
        // var_dump($user->id);
        // var_dump($user->countPosts());
        // foreach ($user->getPosts() as $post) {
        //     var_dump($post->title);
        // }
       
        // $this->view->posts = Posts::find(["id = $id"]);
        // $this->view->posts = Posts::find();
        $this->view->posts = $user->getPosts();
    }

    public function newAction()
    {
        $this->view->categories = Categories::find();
    }

    public function createAction()
    {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        // $session->start();
        $user = $session->get('user');
        $post = new Posts();
        $post->id = $user->id;
            $post->assign(
                $this->request->getPost(),
                [
                    'title',
                    'body',
                    'category_id',
                    'id'
                ]
                );
                

                    // Store and check for errors
            $success = $post->save();

            // passing the result to the view
            $this->view->success = $success;

            if ($success) {
                $message = "Thanks for registering!";
            } else {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $post->getMessages());
            }
            return $this->dispatcher->forward(
                [
                    'controller' => 'post',
                    'action'     => 'index'
                ]
            );

            // $this->response->redirect('post');
            // $this->view->disable();
        // }
    }
    public function deleteAction($post_id)
    {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );
        $session->setAdapter($files);
        $session->start();
        $posToDelete = Posts::find($post_id);
        
        $posToDelete->delete();

        // $this->response->redirect('post');
        return $this->dispatcher->forward(
            [
                'controller' => 'post',
                'action'     => 'index'
            ]
        );
        
    }

}