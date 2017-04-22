<?php

namespace ConsolePlugins\GetValue {
    class Main extends \Idno\Common\ConsolePlugin {
        public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
	    
            if (!empty($input->getArgument('username'))) {
		
		$output->writeln("Retrieving value from entity as ".$input->getArgument('username').':');
		$output->writeln("");
		
		if ($user = \Idno\Entities\User::getByHandle($input->getArgument('username'))) {
		    \Idno\Core\Idno::site()->session()->logUserOn($user);
		} else 
		    throw new \RuntimeException("User " . $input->getArgument('username') . " could not be found.");
	    } else {
		$output->writeln("Modifying entity as PUBLIC:");
		$output->writeln("");
	    }
	    
            $entity = \Idno\Common\Entity::getByID($input->getArgument('id'));
            if (!$entity) $entity = \Idno\Common\Entity::getByUUID ($input->getArgument('id'));
            if (!$entity) $entity = \Idno\Common\Entity::getByShortURL($input->getArgument('id'));
            if (!$entity) throw new \RuntimeException("Error: Could not retrieve entity " . $input->getArgument('id'));
	    
	    $field = $input->getArgument('field');
	    
	    $output->writeln("$field = " . print_r($entity->$field, true));
	    
		
        }

        public function getCommand() {
            return 'dev-show-value';
        }

        public function getDescription() {
            return 'Retrieve a specific value from an entity';
        }

        public function getParameters() {
            return [
		new \Symfony\Component\Console\Input\InputArgument('id', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'The entity ID or UUID'),
		new \Symfony\Component\Console\Input\InputArgument('field', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'The field to modify, e.g. access'),
		new \Symfony\Component\Console\Input\InputArgument('username', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'User to use', ''),
            ];
        }

    }
}