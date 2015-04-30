<h2>Add New User</h2>
 
<!-- link to add new users page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'List Users', array( 'action' => 'index' ) ); ?>
</div>
 

<!--------------------------------HTML form in cakephp starts here------------------------------------------->

<?php 

//this is our add form, name the fields same as database column names

    echo $this->Form->create('Member', array('type' => 'post', 'action' => '', 'class' => 'user_form', 'id' => 'user_form_id' ));       //member here is a controller attribute value
 
    echo $this->Form->input('firstname', array('class' => 'user_firstname', 'id' => 'user_fisrtname_id', 'required' => 'required' ));
    echo $this->Form->input('lastname', array('class' => 'user_lastname', 'id' => 'user_lastname_id', 'readonly' => 'readonly'));
    //echo $this->Form->input('email');
    echo $this->Form->input('username', array('class' => 'user_username', 'id' => 'user_username_id', 'type' => 'email'));
    echo $this->Form->input('password', array('type'=>'password', 'class' => 'user_password'));
     
echo $this->Form->submit('Submit', array('class' => 'user_submit', 'id' => 'user_submit_id'));

//Note:  field name should be same as datatable column names

?>

<!--------------------------------HTML form in cakephp ends here------------------------------------------->