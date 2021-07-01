<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class CategoryController extends Controller
{

    public function indexAction()
    {
        $this->view->categories = Categories::find();
    }

    public function newAction()
    {
        
    }

    public function createAction()
    {
        $category = new Categories();
        $category->assign(
            $this->request->getPost(),
            [
                'title',
                'body',
            ]
            );

                 // Store and check for errors
        $success = $category->save();

         // passing the result to the view
         $this->view->success = $success;

         if ($success) {
             $message = "Thanks for registering!";
         } else {
             $message = "Sorry, the following problems were generated:<br>"
                      . implode('<br>', $category->getMessages());
         }

        $this->response->redirect('category');
        $this->view->disable();



    }

}