<?php


namespace Mind\ImportCustomer\Helper;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Attribute\Data\AbstractData;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException as CoreException;
use Magento\Framework\ObjectManagerInterface;


/**
 * Class Data
 * @package Mind\ImportCustomer\Helper
 */
class Data extends AbstractData
{

    const FILTER_TYPE_LIST   = 'list';
    const INPUT_KEY_PROFILE = 'profile-name';
    const INPUT_KEY_SOURCE = 'source';
    const INPUT_KEY_CSV= 'sample-csv';
    const INPUT_KEY_JSON = 'sample-json';


    /**
     * Extract data from request and return value
     *
     * @param RequestInterface $request
     * @return array|string|bool
     */
    public function extractValue(RequestInterface $request)
    {
        // TODO: Implement extractValue() method.
    }/**
 * Validate data
 *
 * @param array|string $value
 * @return bool
 * @throws CoreException
 */
    public function validateValue($value)
    {
        // TODO: Implement validateValue() method.
    }

    /**
     * Export attribute value to entity model
     *
     * @param array|string $value
     * @return $this
     */
    public function compactValue($value)
    {
        // TODO: Implement compactValue() method.
    }

    /**
     * Restore attribute value from SESSION to entity model
     *
     * @param array|string $value
     * @return $this
     */
    public function restoreValue($value)
    {
        // TODO: Implement restoreValue() method.
    }

    /**
     * Return formatted attribute value from entity model
     *
     * @param string $format
     * @return string|array
     */
    public function outputValue($format = \Magento\Eav\Model\AttributeDataFactory::OUTPUT_FORMAT_TEXT)
    {
        // TODO: Implement outputValue() method.
    }
}
