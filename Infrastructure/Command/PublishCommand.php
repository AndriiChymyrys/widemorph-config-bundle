<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use WideMorph\Morph\Bundle\MorphConfigBundle\Interaction\DomainInteractionInterface;

#[AsCommand(
    name: 'morph:config:publish',
    description: 'Publish WideMorph entities from packages'
)]
class PublishCommand extends Command
{
    /**
     * @param  DomainInteractionInterface  $domainInteraction
     */
    public function __construct(
        protected DomainInteractionInterface $domainInteraction
    ) {
        parent::__construct();
    }

    /**
     * @param  InputInterface   $input
     * @param  OutputInterface  $output
     *
     * @return int
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $this->domainInteraction->getBundleCrawlerService()->crawl();
//        $this->domainInteraction->getPublishFactory()->getService('entity')->execute();

        return Command::SUCCESS;
    }
}
