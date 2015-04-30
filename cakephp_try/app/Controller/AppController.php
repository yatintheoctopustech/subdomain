<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('AuthComponent', 'Controller/Component');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    //public $components = array('DebugKit.Toolbar','Auth' => array('authenticate' => array('Form' => array('fields' => array('username' => 'username')))),'Session'); 
    
    
//<!----------------------------checking for login----------------------------------------//    
    
    public $components = array(
        'Session',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password'
                    ),

                )
            ),
            'loginRedirect' => array('controller' => 'users', 'action' => 'profile'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'logout'),
            'authError' => 'Por favor, Faça o login para acessar a Área Restrita',
            'loginError' => 'Login ou Senha incorreto!',
            'autoRedirect' => false,
        )
    );
    
//<!----------------------------checking for login----------------------------------------//
    
    public function encryptPassword($sPassword = null) {
        return AuthComponent::password($sPassword);
    }
    
    public function beforeRender() {
        
        $this->loadModel('wp_posts');         //Model name from which databale record to be fetch
        $this->wp_posts->setDatasource('test');
        $data=$this->wp_posts->query('SELECT * FROM wp_posts ORDER by id desc limit 0,4');           //Memeber here is a model name same as above line  then over naormal fetch query
//        pr($data);
//        die();
        $this->set('data', $data);
   }
}
