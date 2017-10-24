<?php
/**
 * @category    QSS
 * @package     QSS\GoogleAuth
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace QSS\GoogleAuth\Block\Adminhtml;


use Magento\Framework\View\Element\AbstractBlock;

class Auth extends AbstractBlock
{
    /**
     * @var \QSS\GoogleAuth\Helper\Data
     */
    protected $helper;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \QSS\GoogleAuth\Helper\Data $helper,
        array $data = []
    )
    {
        $this->helper = $helper;

        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->helper->isEnabled()) {
            return '';
        }

        $label = __('Code');
        $placeholder = __('code');

        return <<<HTML
        <div class="admin__field field-code">
            <label for="code" class="admin__field-label">
                <span>$label</span>
            </label>
            <div class="admin__field-control">
                <input id="code"
                       class="admin__control-text"
                       type="text"
                       name="login[code]"
                       data-validate="{required:false}"
                       value=""
                       placeholder="$placeholder"
                       autocomplete="off"
                    />
            </div>
        </div>
HTML;
    }
}