<?php
class ContactsController extends AppController {

	/**
	 * Main index action
	 */
	public function index() {
		// form posted
		if ($this->request->is('post')) {
			// create
			$this->Contact->create();
                        
			// attempt to save
			if ($this->Contact->save($this->request->data)) {
				$this->Session->setFlash('Your message has been submitted');
				$this->redirect(array('action' => 'index'));
			}
                        else
                        {
                            $this->Session->setFlash('Your message has not submitted');
                        }
		}
	}
        
        //used to show pages without login
        
        public function beforeFilter() {
            parent::beforeFilter();

            $this->Auth->allow('index');
        }
}
?>