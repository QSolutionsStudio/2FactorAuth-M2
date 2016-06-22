<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\Model\Plugin;


class Auth
{
    /**
     * @var \Magento\Framework\Session\SessionManager
     */
    protected $session;

    public function __construct(
        \Magento\Framework\Session\SessionManager $sessionManager
    )
    {
        $this->session = $sessionManager;
    }

    public function beforeLogin()
    {
        $preventLogin = $this->session->getData('prevent_login', true);
        if ($preventLogin) {
            throw new \Magento\Framework\Exception\AuthenticationException(__('Provided login code is invalid.'));
        }
    }
}