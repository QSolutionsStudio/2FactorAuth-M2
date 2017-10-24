<?php
/**
 * @category    QSS
 * @package     QSS\GoogleAuth
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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