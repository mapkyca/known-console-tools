<?php

namespace ConsolePlugins\DumpConfig {
    class Main extends \Idno\Common\ConsolePlugin {
        public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
            
            $output->writeln(print_r(\Idno\Core\Idno::site()->config(), true));
        }

        public function getCommand() {
            return 'dev-dump-config';
        }

        public function getDescription() {
            return 'Dump the current running config';
        }

        public function getParameters() {
            return [
            ];
        }

    }
}