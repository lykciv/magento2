<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Email\Model\Template\Config;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Email\Model\Template\Config\Converter
     */
    protected $_model;

    public function setUp()
    {
        $this->_model = new \Magento\Email\Model\Template\Config\Converter();
    }

    public function testConvert()
    {
        $inputData = new \DOMDocument();
        $inputData->load(__DIR__ . '/_files/email_templates_merged.xml');
        $expectedResult = require __DIR__ . '/_files/email_templates_merged.php';
        $this->assertEquals($expectedResult, $this->_model->convert($inputData));
    }
}
