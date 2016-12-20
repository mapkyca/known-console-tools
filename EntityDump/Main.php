<?php

namespace ConsolePlugins\EntityDump {
    class Main extends \Idno\Common\ConsolePlugin {
        public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
            
	    if (!empty($input->getArgument('username'))) {
		
		$output->writeln("Retrieving entity as ".$input->getArgument('username').':');
		$output->writeln("");
		
		if ($user = \Idno\Entities\User::getByHandle($input->getArgument('username'))) {
		    \Idno\Core\Idno::site()->session()->logUserOn($user);
		} else 
		    throw new \RuntimeException("User " . $input->getArgument('username') . " could not be found.");
	    } else {
		$output->writeln("Retrieving entity as PUBLIC:");
		$output->writeln("");
	    }
	    
            $entity = \Idno\Common\Entity::getByID($input->getArgument('id'));
            if (!$entity) $entity = \Idno\Common\Entity::getByUUID ($input->getArgument('id'));
            if (!$entity) $entity = \Idno\Common\Entity::getByShortURL($input->getArgument('id'));
            if (!$entity) throw new \RuntimeException("Error: Could not retrieve entity " . $input->getArgument('id'));
            
            $output->writeln(print_r($entity, true));
        }

        public function getCommand() {
            return 'dev-dump-entity';
        }

        public function getDescription() {
            return 'Dump an entity via its entity/UUID';
        }

        public function getParameters() {
            return [
                new \Symfony\Component\Console\Input\InputArgument('id', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'Entity ID or UUID'),
		new \Symfony\Component\Console\Input\InputArgument('username', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'User to use to retrieve data', ''),
            ];
        }

    }
}