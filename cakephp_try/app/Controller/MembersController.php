<?php
App::uses('Controller', 'AppController');

class MembersController extends AppController { 
    
    public function beforeFilter() {
        parent::beforeFilter();
         
        $this->Auth->allow('add');
    }
    
  
        public function add(){
 
    //check if it is a post request
    //this way, we won't have to do if(!empty($this->request->data))
        if ($this->request->is('post')){        //its just we use if(isset($_Post[''])){} in core php
            //save new user
            if ($this->Member->save($this->request->data)){           //to check and to insert record in databse  Member here is a datatable name

                //set flash to user screen
                $this->Session->setFlash('User was added.');        //to show message after succesfull submission
                //redirect to user list
                $this->redirect(array('action' => 'index'));        //to redirect url after submission

            }else{
                //if save failed
                $this->Session->setFlash('Unable to add user. Please, try again.');     //to show if insert was not succesful

            }
        }
    }
 
    public function index() {
        //to retrieve all users, need just one line
        $this->set('users', $this->Member->find('all'));         //User here is a datatable name, its a fetch query for fetching all records from table User
    }
    
}

?>