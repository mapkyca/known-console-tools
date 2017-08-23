<?php

namespace ConsolePlugins\EntityList {
    
    class Main extends \Idno\Common\ConsolePlugin {
	
        public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
            
	    $types = false;
	    if (!empty($input->getArgument('types')) && $input->getArgument('types')!='all') {
		$types = explode(',', $input->getArgument('types'));
	    }
	    
	    if (!empty($input->getArgument('username'))) {
		
		if ($user = \Idno\Entities\User::getByHandle($input->getArgument('username'))) {
		    \Idno\Core\Idno::site()->session()->logUserOn($user);
		} else 
		    throw new \RuntimeException("User " . $input->getArgument('username') . " could not be found.");
	    } 
	    
	    $limit = (int)$input->getArgument('limit');
	    $offset = (int)$input->getArgument('offset');
	    
	    $search = [];
	    if (!empty($input->getArgument('search'))) {
		$values = explode(',', $input->getArgument('search'));
		
		if (!empty($values)) {
		    
		    $output->writeln("Applying search filters:");
		    
		    foreach($values as $value) {
			$bits = explode('=', $value);
			if (count($bits) == 2) {
			    $search[trim($bits[0])] = trim($bits[1]);
			    $output->writeln("\t$value");
			}
		    }
		    
		    $output->writeln("");
		}
		
	    }
	    
	    if ($objects = \Idno\Common\Entity::getFromX($types, $search, [], $limit, $offset)) {
		foreach ($objects as $object) {
		    $output->writeln(" * " . $object->getUUID() . ' (' . get_class($object) . ')');
		    $title = $object->getTitle();
		    if (!empty($title)) $output->writeln("\t" . $object->getTitle());
		    $output->writeln("\t" . date('r',$object->created));
		    $output->writeln('');
		}
	    } else
		throw new \RuntimeException("Could not find any entities matching your search");
	    
        }

        public function getCommand() {
            return 'dev-list-entities';
        }

        public function getDescription() {
            return 'List the UUIDs of the latest X entities';
        }

        public function getParameters() {
            return [
                new \Symfony\Component\Console\Input\InputArgument('types', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Comma separated list of entity types, or "all" for everything', 'all'),
		new \Symfony\Component\Console\Input\InputArgument('limit', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Number of stuff to return', 5),
		new \Symfony\Component\Console\Input\InputArgument('offset', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Offset', 0),
		new \Symfony\Component\Console\Input\InputArgument('username', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'User to use to retrieve data', ''),
		new \Symfony\Component\Console\Input\InputArgument('search', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Comma separated string of key=value search pairs', ''),
            ];
        }

    }
}