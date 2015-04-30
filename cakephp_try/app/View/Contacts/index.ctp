<h2>Contact</h2>
<?php 
echo $this->Form->create('Contact', array('type'=>'file'));
echo $this->Form->input('name');
echo $this->Form->input('email');
echo $this->Form->input('message');
echo $this->Form->input('filename',array('type' => 'file'));
echo $this->Form->input('filename2',array('type' => 'file'));
echo $this->Form->end('Submit');
?>