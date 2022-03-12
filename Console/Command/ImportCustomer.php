<?php
namespace Mind\ImportCustomer\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBarFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Filesystem\Io\File as IoFile;
use Mind\ImportCustomer\Model\Customer;
use Mind\ImportCustomer\Helper\Data;
/**
 * Class ImportCustomer
 * @package Mind\ImportCustomer\Console\Command
 */
class ImportCustomer extends Command
{


    /**
     * @var File
     */
    private $fileDriver;

    /**
     * @var CustomerInterfaceFactory
     */
    private $customerDataFactory;

    /**
     * @var ProgressBarFactory
     */
    private $progressBarFactory;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var IoFile
     */
    private $ioFile;
    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var Data
     */
    private $data;

    /**
     * @param File $fileDriver
     * @param CustomerInterfaceFactory $customerDataFactory
     * @param ProgressBarFactory $progressBarFactory
     * @param Json $serializer
     * @param CustomerRepositoryInterface $customerRepository
     * @param IoFile $ioFile
     */
    public function __construct(
        File $fileDriver,
        CustomerInterfaceFactory $customerDataFactory,
        ProgressBarFactory $progressBarFactory,
        Json $serializer,
        Data $data,
        CustomerRepositoryInterface $customerRepository,
        Customer $customer,
        IoFile $ioFile
    ) {
        $this->fileDriver = $fileDriver;
        $this->customerDataFactory = $customerDataFactory;
        $this->progressBarFactory = $progressBarFactory;
        $this->serializer = $serializer;
        $this->customerRepository = $customerRepository;
        $this->customer = $customer;
        $this->ioFile = $ioFile;
        $this->data = $data;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('customer:import')
            ->setDescription('Import customers via csv or json')
            ->setDefinition($this->customer->getInputList());

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $errors = $this->customer->validate($input);
        if ($errors) {
            throw new \InvalidArgumentException(implode("\n", $errors));
        }

        $profileType = $input->getArgument($this->data::INPUT_KEY_PROFILE);
        $allCustomerData = [];
        if ($profileType == $this->data::INPUT_KEY_CSV) {
            $filePath = $input->getArgument($this->data::INPUT_KEY_SOURCE);
            $output->writeln('<info>'.$filePath. 'have benn found.</info>');
            //todo: set specified path for file import
            $pathInfo = $this->ioFile->getPathInfo($filePath);
            if (isset($pathInfo['extension']) && $pathInfo['extension'] != 'csv') {
                throw new ValidationException(__('File extension must be csv'));
            }

            if ($this->fileDriver->isExists($filePath)) {
                $csvData = $this->customer->_csvToArray($this->fileDriver->fileGetContents($filePath));
                $allCustomerData = $csvData['data'];
            } else {
                throw new ValidationException(__('File not exist in specified location'));
            }
        } else {
            $filePath = $input->getArgument($this->data::INPUT_KEY_SOURCE);
            $pathInfo = $this->ioFile->getPathInfo($filePath);
            if (isset($pathInfo['extension']) && $pathInfo['extension'] != 'json') {
                throw new ValidationException(__('File extension must be json'));
            }

            if ($this->fileDriver->isExists($filePath)) {
                $allCustomerData = $this->customer->_jsonToArray($this->fileDriver->fileGetContents($filePath));
            } else {
                throw new ValidationException(__('File not exist in specified location'));
            }
        }

        if (!empty($allCustomerData)) {
            $output->writeln('<info>Starting customer import process.</info>');
            $progressBar = $this->progressBarFactory->create(
                [
                    'output' => $output,
                    'max' => count($allCustomerData),
                ]
            );

            $progressBar->setFormat(
                '%current%/%max% [%bar%] %percent:3s%% %elapsed% %memory:6s%'
            );
            $progressBar->start();
            $returnValue = \Magento\Framework\Console\Cli::RETURN_SUCCESS;

            $alreadyExistCustomers = $errorsExistCustomers = [];
            $successfullyProcessCustomers = 0;


            foreach ($allCustomerData as $customerData) {
                if (isset($customerData['emailaddress']) && $customerData['fname'] && $customerData['lname']) {


                    $customer = $this->customerDataFactory->create()
                        ->setEmail($customerData['emailaddress'])
                        ->setFirstname($customerData['fname'])
                        ->setLastname($customerData['lname']);
                    try {

                        $this->customerRepository->save($customer, null);
                        $progressBar->advance();
                        $successfullyProcessCustomers++;
                    } catch (AlreadyExistsException $e) {
                        $alreadyExistCustomers[] = $customerData['emailaddress'];
                    } catch (LocalizedException $e) {
                        $errorsExistCustomers[] = $customerData['emailaddress'];
                    }
                }
            }
            $progressBar->finish();
            $output->write(PHP_EOL);
            $output->writeln('<info>Customers Imported '.$successfullyProcessCustomers.'</info>');

            if (!empty($alreadyExistCustomers)) {
                $output->writeln('<comment>Existing Customers '.
                    count($alreadyExistCustomers).'</comment>');
            }

            if (!empty($errorsExistCustomers)) {
                $output->writeln('<error>Errors while creating Customers '.
                    count($errorsExistCustomers).' Emails: '.implode(",", $errorsExistCustomers) . '</error>');
            }

            $output->writeln('<info>Process finished.</info>');

            return $returnValue;
        } else {
            $output->writeln('<info>No Customers found to import.</info>');
        }
        return 0;
    }


}
