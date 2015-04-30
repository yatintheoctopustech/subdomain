<?php
class Member extends AppModel {       //User is a tablename from database User first letter is always capital
 
    public $name = 'Member';          //User is a tablename using from database where its name should be users if we change user to user1 then it will show error that no user1s table exist in database
     
}
?>