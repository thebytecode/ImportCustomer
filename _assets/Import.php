<?php
/**
 * Copyright © All right Received All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mind\Import\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{

    const CMD_CSV = "sample-csv";
    const CMD_JSON = "sample-json";
    const CMD_OPTION = "option";


    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(Area::AREA_GLOBAL);

        if ($name = $input->getOption(self::NAME)) {
            $output->writeln('<info>Provided name is `' . $name . '`</info>');
        }

        $name = $input->getArgument(self::NAME_ARGUMENT);
        $option = $input->getOption(self::NAME_OPTION);

        $output->writeln('<info>Success Message.</info>');
        $output->writeln('<error>An error encountered.</error>');
        $output->writeln('<comment>Some Comment.</comment>');

        } catch (Exception $e) {
            $msg = $e->getMessage();
            $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
            return Cli::RETURN_FAILURE;
        }

    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("customer:import");
        $this->setDescription("accept file for import data csv or json");
        $this->addOption(
            self::CMD_CSV,
            "csv",
            InputOption::VALUE_REQUIRED,
            ' get sample-csv'
        );
        $this->addOption(
            self::CMD_JSON,
            "json",
            InputOption::VALUE_REQUIRED,
            ' get sample-json'
        );
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name"),
            new InputOption(self::NAME_OPTION, "-a", InputOption::VALUE_NONE, "Option functionality")
        ]);



        parent::configure();
    }
}

