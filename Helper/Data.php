<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\Helper;


use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const SECRET_CONFIG_PATH = "qss_googleauth/general/secret";
    const ENABLED_CONFIG_PATH = "qss_googleauth/general/enabled";
    /**
     * @var \QSS\GoogleAuth\Lib\PHPGangsta\GoogleAuthenticator
     */
    public $authenticator;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \QSS\GoogleAuth\Lib\PHPGangsta\GoogleAuthenticator $authenticator
    )
    {
        $this->authenticator = $authenticator;

        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->scopeConfig->getValue(self::SECRET_CONFIG_PATH);
    }

    /**
     * @param null $secret
     * @return string
     */
    public function getQRCodeUrl($secret=null)
    {
        if (is_null($secret)) {
            $secret = $this->getSecret();
        }

        return $this->authenticator->getQRCodeGoogleUrl($this->getStoreName(), $secret);
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::ENABLED_CONFIG_PATH) && $this->getSecret();
    }

    /**
     * @return mixed
     */
    public function isEnabledInConfig()
    {
        return $this->scopeConfig->getValue(self::ENABLED_CONFIG_PATH);
    }

    protected function getStoreName()
    {
        return str_replace(' ', '', $this->scopeConfig->getValue(
            'general/store_information/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) . 'Admin';
    }
}