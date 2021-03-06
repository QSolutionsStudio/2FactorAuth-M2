<?php
/**
 * @category    Qextensions
 * @package     Qextensions\Google2factor
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Qextensions\Google2factor\Block\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class QRCode extends Field
{
    /**
     * @var \Qextensions\Google2factor\Helper\Data
     */
    protected $helper;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Qextensions\Google2factor\Helper\Data $helper, array $data = [])
    {
        $this->helper = $helper;

        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getQRCodeUrl()
    {
        return $this->helper->getQRCodeUrl();
    }

    /**
     * Retrieve element HTML markup
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        if (!$this->helper->isEnabled()) {
            return __('Code not yet generated.');
        }

        return <<<HTML
<img src="{$this->getQRCodeUrl()}"/>
<div><strong>Secret code:</strong> {$this->_getSecret()}</div>
HTML;

    }

    /**
     * @return string
     */
    protected function _getSecret()
    {
        return $this->helper->getSecret();
    }
}