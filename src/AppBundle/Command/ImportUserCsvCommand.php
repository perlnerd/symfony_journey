<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Model\CsvFileModel;
use AppBundle\Entity\ImportCsv as Import;
use LimitIterator;

class ImportUserCsvCommand extends ContainerAwareCommand
{
    private $defaultFileName;
    private $applicationName;
    private $applicationDescription;

    public function __construct($defaultFileName, $applicationName, $applicationDescription)
    {
        $this->defaultFileName = $defaultFileName;

        $this
            ->setName($applicationName)
            ->setDescription($applicationDescription);
        
        parent::__construct();
    }

    protected function configure()
    {
        $defaultFileName = $this->defaultFileName;

        $this->addOption(
            'file',
            '-f',
            InputOption::VALUE_REQUIRED,
            'The file to import',
            $defaultFileName
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set("auto_detect_line_endings", true);

        $fileName   = $input->getOption('file');
        $fileObject = new CsvFileModel($fileName);

        if (! $fileObject->fileIsValid()) {
            throw new Exception('File is not a valid text file');
        }

        $fileObject->configureFlags();

        $it = new LimitIterator($fileObject, 1);

        foreach ($it as $data) {
            $doctrine                            = $this->getContainer()->get('doctrine');
            $em                                  = $doctrine->getManager();
            $import                              = new Import();

            $import
                ->setIcFirstName($data[0])
                ->setIcLastName($data[1])
                ->setIcEmailAddress($data[2]);
            $em->persist($import);
            $em->flush();
        }

        $output->writeln($fileObject->getFilename());
    }
}
