<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\Block\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Generate extends Field
{
    /**
     * @var \QSS\GoogleAuth\Helper\Data
     */
    protected $helper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \QSS\GoogleAuth\Helper\Data $helper,
        array $data = [])
    {
        $this->helper = $helper;

        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $generate = __('Generate secret');
        $disabled = $this->helper->isEnabledInConfig() ? '' : ' disabled';
        $url = $this->getUrl('adminhtml/generate');

        return <<<HTML
<button class="action-default scalable save primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="jQuery.get('$url', {}, function(){location.reload()});return false;"$disabled>$generate</button>
HTML;
    }
}