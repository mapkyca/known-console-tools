<?php

namespace ConsolePlugins\ShowACL {
    class Main extends \Idno\Common\ConsolePlugin {
        public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
            
	    
	    $acl = $input->getArgument('permission');
	    
	    if (!empty($input->getArgument('username'))) {
		
		$output->writeln("Available $acl access groups for ".$input->getArgument('username').':');
		$output->writeln("");
		
		if ($user = \Idno\Entities\User::getByHandle($input->getArgument('username'))) {
		    \Idno\Core\Idno::site()->session()->logUserOn($user);
		} else 
		    throw new \RuntimeException("User " . $input->getArgument('username') . " could not be found.");
	    }
	    
	    if ($groups = \Idno\Core\Idno::site()->session()->currentUser()->getXAccessGroupIDs($acl)) {
		$n = 1;
		foreach ($groups as $group) {
		    $output->writeln(" $n * $group");
		    $n++;
		}
	    } else {
		throw new \RuntimeException("Could not retrieve access group IDs");
	    }
	    
        }

        public function getCommand() {
            return 'dev-show-acl';
        }

        public function getDescription() {
            return 'Show the acl for a given user';
        }

        public function getParameters() {
            return [
		new \Symfony\Component\Console\Input\InputArgument('username', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'User to use to retrieve data'),
		new \Symfony\Component\Console\Input\InputArgument('permission', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Which ACL permission to return (read, write, admin)', 'read'),
            ];
        }

    }
}