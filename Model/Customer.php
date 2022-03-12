<?php

namespace Mind\ImportCustomer\Model;

use Exception;
use Generator;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;
use Mind\ImportCustomer\Helper\Data;
use Mind\ImportCustomer\Model\Import\CustomerImport;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Customer
 * @package Mind\ImportCustomer\Model
 */
class Customer
{

    private $storeManagerInterface;
    private $customerImport;
    private $output;
    /**
     * @var Data
     */

    /**
     * @var Json
     */
    private $serializer;
    private $data;

    public function __construct(
        File $file,
        StoreManagerInterface $storeManagerInterface,
        CustomerImport $customerImport,
        Json $serializer,
        Data $data
    ) {
        $this->serializer= $serializer;
        $this->data = $data;
        $this->file = $file;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->customerImport = $customerImport;
    }

    public function install(string $fixture, OutputInterface $output): void
    {
        $this->output = $output;

        // get store and website ID
        $store = $this->storeManagerInterface->getStore();
        $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
        $storeId = (int) $store->getId();

        // read the csv header
        $header = $this->readCsvHeader($fixture)->current();

        // read the csv file and skip the first (header) row
        $row = $this->readCsvRows($fixture, $header);
        $row->next();

        // while the generator is open, read current row data, create a customer and resume the generator
        while ($row->valid()) {
            $data = $row->current();
            $this->createCustomer($data, $websiteId, $storeId);
            $row->next();
        }
    }

    private function readCsvRows(string $file, array $header): ?Generator
    {
        $handle = fopen($file, 'rb');

        while (!feof($handle)) {
            $data = [];
            $rowData = fgetcsv($handle);
            if ($rowData) {
                foreach ($rowData as $key => $value) {
                    $data[$header[$key]] = $value;
                }
                yield $data;
            }
        }

        fclose($handle);
    }

    private function readCsvHeader(string $file): ?Generator
    {
        $handle = fopen($file, 'rb');

        while (!feof($handle)) {
            yield fgetcsv($handle);
        }

        fclose($handle);
    }


    private function createCustomer(array $data, int $websiteId, int $storeId): void
    {
        try {
            // collect the customer data
            $customerData = [
                'email'         => $data['email_address'],
                '_website'      => 'base',
                '_store'        => 'default',
                'confirmation'  => null,
                'dob'           => null,
                'firstname'     => $data['firstname'],
                'gender'        => null,
                'group_id'      => $data['customer_group_id'],
                'lastname'      => $data['last_name'],
                'middlename'    => null,
                'password_hash' => $data['password_hash'],
                'prefix'        => null,
                'store_id'      => $storeId,
                'website_id'    => $websiteId,
                'password'      => null,
                'disable_auto_group_change' => 0,
                'some_custom_attribute'     => 'some_custom_attribute_value'
            ];

            // save the customer data
            $this->customerImport->importCustomerData($customerData);
        } catch (Exception $e) {
            $this->output->writeln(
                '<error>'. $e->getMessage() .'</error>',
                OutputInterface::OUTPUT_NORMAL
            );
        }
    }


    /**
     * Get list of arguments for the command
     *
     * @return InputArgument[]
     */
    public function getInputList(): array
    {

        $arguments = [
            new InputArgument(
                $this->data::INPUT_KEY_PROFILE,
                InputArgument::REQUIRED,
                'Profile type ['. $this->data::INPUT_KEY_CSV . '|' . $this->data::INPUT_KEY_JSON .']'
            ),

            new InputArgument(
                $this->data::INPUT_KEY_SOURCE,
                InputArgument::REQUIRED,
                'Source Absolute path'
            ),
        ];
        return $arguments;
    }

    /**
     * Check if all admin options are provided
     *
     * @param InputInterface $input
     * @return string[]
     */
    public function validate(InputInterface $input): array
    {
        $errors = [];
        $acceptedValues = ' Accepted values for ' . $this->data::INPUT_KEY_PROFILE . ' are \''
            . $this->data::INPUT_KEY_CSV . '\' or \'' . $this->data::INPUT_KEY_JSON . '\'';

        $inputMode = $input->getArgument($this->data::INPUT_KEY_PROFILE);
        if (!$inputMode) {
            $errors[] = 'Missing argument \'' . $this->data::INPUT_KEY_PROFILE .'\'.' . $acceptedValues;
        } elseif (!in_array($inputMode, [$this->data::INPUT_KEY_CSV, $this->data::INPUT_KEY_JSON])) {
            $errors[] = $acceptedValues;
        }
        return $errors;
    }

    /**
     * Export CSV string to array
     *
     * @param string $content
     * @return array
     */
    public function _csvToArray(string $content): array
    {
        $data = ['header' => [], 'data' => []];

        $lines = str_getcsv($content, "\n");
        foreach ($lines as $index => $line) {
            if ($index == 0) {
                $data['header'] = str_getcsv($line);
            } else {
                $row = array_combine($data['header'], str_getcsv($line));
                $data['data'][] = $row;
            }
        }
        return $data;
    }

    /**
     * Export JSON string to array
     *
     * @param string $content
     * @return array
     */
    public function _jsonToArray(string $content): array
    {
        $content = $this->serializer->unserialize($content);
        return $content;
    }


}