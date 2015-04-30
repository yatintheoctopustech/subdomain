<?php
App::uses('AppModel', 'Model');

class User extends AppModel {       //User is a tablename from database User first letter is always capital
 
    public $name = 'User';          //User is a tablename using from database where its name should be users if we change user to user1 then it will show error that no user1s table exist in database            
    
    public function beforeSave($options = array())
    {
        if(!$this->id)      // to check if it is for inserting or updating to check it we can use any condition or argument or can use any hidden field for specific form
        {
            $total_Users = $this->find('count', array('conditions'=>array('User.username' => $this->data['User']['username'])));       //for counting no. of rows
    //        pr($total_Users);
    //        die();
            if($total_Users > 0)
            {
                $this->error = __('User Email Already Exist');

                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            //do nothing
        }
    }
}
?>