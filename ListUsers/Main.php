<?php

namespace ConsolePlugins\ListUsers {
    
    class Main extends \Idno\Common\ConsolePlugin {
	
        public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
            
	    $admin = ($input->getArgument('admin') == 'yes');
	    
	    $limit = (int)$input->getArgument('limit');
	    $offset = (int)$input->getArgument('offset');
	    
	    $search = [];
	    if ($admin) {
		$search['admin'] = true;
	    }
	    
	    if ($objects = \Idno\Entities\User::get($search, [], $limit, $offset)) {
		foreach ($objects as $object) {
		    $line = " * " . $object->getUUID() . ' (' . get_class($object) . ')';
		    if ($object->admin) {
			$line.= ' - ADMIN USER';
		    }
		    $output->writeln($line);
		}
	    } else
		throw new \RuntimeException("Could not find any entities matching your search");
	    
        }

        public function getCommand() {
            return 'dev-list-users';
        }

        public function getDescription() {
            return 'List users';
        }

        public function getParameters() {
            return [
		new \Symfony\Component\Console\Input\InputArgument('limit', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Number of users to return', 5),
		new \Symfony\Component\Console\Input\InputArgument('offset', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Offset', 0),
		new \Symfony\Component\Console\Input\InputArgument('admin', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'List only admin users (yes/no)', 'no'),
            ];
        }

    }
}