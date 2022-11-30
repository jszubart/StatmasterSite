<?php

namespace App\Command;

use App\Entity\GameEvent;
use League\Csv\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportGameEventsCommand extends Command
{
    protected static $defaultName = 'import-events';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }
    protected function configure()
    {
        $this
            ->setDescription('This command allows you to import GameEvents from json file ("GameEvents")')
            ->addArgument('filename', InputArgument::REQUIRED, 'Input filename');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importing game events...');

        $fileName = $input->getArgument('filename');

        $json_file = file_get_contents('%kernel.project_dir%/../public/assets/uploads/csv/' . $fileName . '.json');
        $events = json_decode($json_file, true);

        foreach ($events as $event) {
            $eventName = $event['name'];
            $eventType = $event['type'];
            $eventScore = $event['score'];

            $gameEvent = new GameEvent();
            $gameEvent->setName($eventName);
            $gameEvent->setType($eventType);
            $gameEvent->setScore($eventScore);
            $this->entityManager->persist($gameEvent);
        }

        $this->entityManager->flush();
        $io->success('Imported successfully!');
    }
}
