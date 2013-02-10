
<?php 
	if(isset($user_info)) {
		echo '<div style="margin: 25px 0px">Currently logged in as ' . $user_info['username'] . ' (' . $user_info['Group']['name'] . ')</div>';
	}
?>

<h2>Login</h2>

<?php
	echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login')));
	echo $this->Form->input('User.username');
	echo $this->Form->input('User.password');
	echo $this->Form->end('Login');
?>