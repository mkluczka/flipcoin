<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Adapters\Cli;

use MKluczka\FlipCoins\ReadModel\Overview\OverviewReadModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class OverviewCommand extends Command
{
    public function __construct(private readonly OverviewReadModel $overviewReadModel)
    {
        parent::__construct('flipcoin:Overview');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>Overview</comment>');

        $view = $this->overviewReadModel->getAll();

        $table = new Table($output);
        $table->setStyle('box');
        $table->setHeaders(['Customer', 'Amount']);
        $table->setRows($view);
        $table->render();

        return self::SUCCESS;
    }
}
