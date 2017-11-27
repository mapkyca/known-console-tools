<?php

namespace ConsolePlugins\UserCreate {

    class Main extends \Idno\Common\ConsolePlugin {

	public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {

	    $username = $input->getArgument('username');
	    $password = $input->getArgument('password');
	    $email = $input->getArgument('email');
	    $name = $input->getArgument('name');
	    $isadmin = $input->getArgument('isadmin') == 'yes';

	    if (empty($name))
		$name = $username; // Validate and use username if name missing

	    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		throw new \Exception("Email $email is not a valid email address.");

	    $user = new \Idno\Entities\User();
	    $user->email = $email;
	    $user->handle = strtolower(trim($username)); // Trim the handle and set it to lowercase
	    $user->setPassword($password);
	    $user->notifications['email'] = 'all';
	    $user->setTitle($name);
	    if ($isadmin)
		$user->setAdmin (true);
	    
	    \Idno\Core\Idno::site()->triggerEvent('site/newuser', array('user' => $user)); // Event hook for new user
	    
	    if ($user->save())
		$output->writeln("New user created as: " . $user->getUUID());
	}

	public function getCommand() {
	    return 'dev-create-user';
	}

	public function getDescription() {
	    return 'Create a new user';
	}

	public function getParameters() {
	    return [
		new \Symfony\Component\Console\Input\InputArgument('username', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'Username to create'),
		new \Symfony\Component\Console\Input\InputArgument('password', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'The password'),
		new \Symfony\Component\Console\Input\InputArgument('email', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'The email address'),
		new \Symfony\Component\Console\Input\InputArgument('name', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'The name of the user - if missing, username is used'),
		new \Symfony\Component\Console\Input\InputArgument('isadmin', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Is this an admin user, "yes" if so.', 'no'),
	    ];
	}

    }

}