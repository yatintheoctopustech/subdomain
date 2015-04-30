<?php
App::uses('Controller', 'AppController');

class UsersController extends AppController {          //User is a tablename and in controller we always write class name in camel structure as there we write UsersController we suffix here Controller on table name
     
    public function hello_user(){                   //hello_user is a page name here we use public function then page name we have to call under user directory
  
        $user = $this->User->findById(1);              //Its basically a select query for fetching only one record from database whose id is 1. $user is a variable here User is a Model Name which is defined Model directory findById is a type of where condition in select query
     
        $this->set('user', $user);                     //here is user is a variable which is to be used in view page and $this->set() is always used to assign variable of this page to view page.
 
    }
    
//<!----------------------------checking for login----------------------------------------//
    
    //public function beforeFilter() is used to allow thos pages which doesnot required login
    
     public function beforeFilter() {
        parent::beforeFilter();
         
        $this->Auth->allow('login', 'add');
    }
     
    
    //it is used to display profile page after succesful login
    
    public function profile($id=null) {
        $mySessionVars = $this->Session->read('Auth');          //used to get session array
        //pr( $mySessionVars );                                   //used to print_r($mySessionVars)
        $user_id = $this->Session->read('Auth.User.User.id');   //used to get user id from session
        echo "Hello".$user_id;                                  //to print user id with hello
        
        $this->loadModel('Member'); //or you can load it in beforeFilter()
        $data=$this->Member->query('SELECT * FROM members ORDER by id desc');
//        pr($data);
//        die();
    }
     
    
    //its a login page function from where user can login
    
    public function login() {
        if($this->request->is('post')) {
            //debug($this->data);
            //debug($this->Auth->login());
            $encrypt_password = $this -> encryptPassword($this->data['User']['password']);
            $user_session = $this->User->find('first', array('conditions'=>array('User.username' => $this->data['User']['username'], 'User.password' => $encrypt_password)));     // for fetching first record only
            
            $totalUsers = $this->User->find('count', array('conditions'=>array('User.username' => $this->data['User']['username'], 'User.password' => $encrypt_password)));       //for counting no. of rows
                        
            if ($totalUsers>0) {       //to check if user exist
                $this->Auth->login($user_session);          //to store user record in session
                $this->Session->setFlash(__('Login Successfully'));     //to show message on successful login
                    if($user_session['User']['user_type'] == "A")
                    {
                        $this->redirect(array("controller" => "users", "action" => "edit", 'admin'=>true));     //to redirect to user edit page
                    }
                    else
                    {
                        $this->redirect(array("controller" => "users", "action" => "profile"));     //to redirect to user profile page
                    }
            } else {
                $this->Session->setFlash(__('Invalid username or password'));           //to show message if login credentials are wrong
            }
        }
    }
     
    public function logout() {
        $this->redirect($this->Auth->logout());         // to redirect user after logout
    }

//<!----------------------------checking for login----------------------------------------//
    
    
    public function add(){
 
    //check if it is a post request
    //this way, we won't have to do if(!empty($this->request->data))
        if ($this->request->is('post')){        //its just we use if(isset($_Post[''])){} in core php
        //echo "No ";
        $this->request->data['User']['password'] = $this -> encryptPassword($this->request->data['User']['password']);      //to encrypt password
//        pr($this->request->data['User']['password'] );
//        die();
            //save new user
            if ($this->User->save($this->request->data)){           //to check and to insert record in databse and User here is a datatable name

                //set flash to user screen
                $this->Session->setFlash('User was added.');        //to show message after succesfull submission
                //redirect to user list
                $this->redirect(array('action' => 'login'));        //to redirect url after submission

            }else{
                    //if save failed
                    $this->Session->setFlash($this->User->error);     //to show if insert was not succesful
            }
        }
    }
    
    public function admin_index() {
        //to retrieve all users, need just one line
        $this->set('users', $this->User->find('all'));         //User here is a datatable name, its a fetch query for fetching all records from table User
    }
    
    public function admin_edit() {
        //get the id of the user to be edited
        $id = $this->request->params['pass'][0];        //[0] index is used to give the array index for which value to be get from url e.g. suppose this link http://localhost/projects/cakephp_try/users/edit/4/hello for [0] it will give 4 output and for [1] it will give hello output

        //set the user id
        $this->User->id = $id;

        //check if a user with this id really exists
        if( $this->User->exists() ){                    //to check if this user id exists

            if( $this->request->is( 'post' ) || $this->request->is( 'put' ) ){
                //save user
                if( $this->User->save( $this->request->data ) ){

                    //set to user's screen
                    $this->Session->setFlash('User was edited.');

                    //redirect to user's list
                    $this->redirect(array('action' => 'index'));

                }else{
                    $this->Session->setFlash('Unable to edit user. Please, try again.');
                }

            }else{

                //we will read the user data
                //so it will fill up our html form automatically
                $this->request->data = $this->User->read();
            }

        }else{
            //if not found, we will tell the user that user does not exist
            $this->Session->setFlash('The user you are trying to edit does not exist.');
            $this->redirect(array('action' => 'index'));

            //or, since it we are using php5, we can throw an exception
            //it looks like this
            //throw new NotFoundException('The user you are trying to edit does not exist.');
        }


    }
    
    
    public function delete() {
    $id = $this->request->params['pass'][0];
     
    //the request must be a post request 
    //that's why we use postLink method on our view for deleting user
    if( $this->request->is('get') ){
     
        $this->Session->setFlash('Delete method is not allowed.');
        $this->redirect(array('action' => 'index'));
         
        //since we are using php5, we can also throw an exception like:
        //throw new MethodNotAllowedException();
    }else{
     
        if( !$id ) {
            $this->Session->setFlash('Invalid id for user');
            $this->redirect(array('action'=>'index'));
             
        }else{
            //delete user
            if( $this->User->delete( $id ) ){
                //set to screen
                $this->Session->setFlash('User was deleted.');
                //redirect to users's list
                $this->redirect(array('action'=>'index'));
                 
            }else{  
                //if unable to delete
                $this->Session->setFlash('Unable to delete user.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }
}
}
?>