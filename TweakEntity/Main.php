<?php

namespace ConsolePlugins\TweakEntity {
    class Main extends \Idno\Common\ConsolePlugin {
        public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
            if (!empty($input->getArgument('username'))) {
		
		$output->writeln("Modifying entity as ".$input->getArgument('username').':');
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
	    if (!$entity) $entity = \Idno\Common\Entity::getBySlug($input->getArgument('id'));
            if (!$entity) throw new \RuntimeException("Error: Could not retrieve entity " . $input->getArgument('id'));
	    
	    $field = $input->getArgument('field');
	    $value = $input->getArgument('value');
	    
	    $entity->$field = $value;
	    
	    if ($entity->save())
		$output->writeln("Entity ".$entity->getUUID()." field $field set to $value");
	    else
		throw new \RuntimeException("Error: Entity could not be saved");
		
        }

        public function getCommand() {
            return 'dev-tweak-entity';
        }

        public function getDescription() {
            return 'Set a value for a field entity';
        }

        public function getParameters() {
            return [
		new \Symfony\Component\Console\Input\InputArgument('id', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'The entity ID or UUID'),
		new \Symfony\Component\Console\Input\InputArgument('field', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'The field to modify, e.g. access'),
		new \Symfony\Component\Console\Input\InputArgument('value', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'The new value, e.g. PUBLIC'),
		new \Symfony\Component\Console\Input\InputArgument('username', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'User to use', ''),
            ];
        }

    }
}