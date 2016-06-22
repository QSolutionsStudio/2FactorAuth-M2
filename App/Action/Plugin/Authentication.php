<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\App\Action\Plugin;


class Authentication
{
    /**
     * @var \QSS\GoogleAuth\Helper\Data
     */
    protected $helper;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    /**
     * @var \Magento\Backend\Model\Auth
     */
    protected $auth;
    /**
     * @var \Magento\Framework\Session\SessionManager
     */
    protected $session;
    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $userFactory;

    public function __construct(
        \Magento\Backend\Model\Auth $auth,
        \QSS\GoogleAuth\Helper\Data $helper,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Session\SessionManager $sessionManager,
        \Magento\User\Model\UserFactory $userFactory
    )
    {
        $this->auth = $auth;
        $this->helper = $helper;
        $this->request = $request;
        $this->session = $sessionManager;
        $this->userFactory = $userFactory;
    }

    public function beforeDispatch()
    {
        if (!$this->auth->isLoggedIn() && $this->helper->isEnabled() && $this->request->isPost()) {
            $username = $this->request->getParam('login')['username'];

            if (!$this->userHasGoogleAuthEnabled($username)) {
                $this->session->setPreventLogin(false);
                return;
            }

            $code = $this->request->getParam('login')['code'];

            if ($this->helper->authenticator->verifyCode($this->helper->getSecret(), $code)) {
                $this->session->setPreventLogin(false);
            }
            else {
                $this->session->setPreventLogin(true);
            }
        }
    }

    /**
     * @param $username
     * @return bool
     */
    protected function userHasGoogleAuthEnabled($username)
    {
        return boolval($this->userFactory->create()->loadByUsername($username)->getGoogleauthEnabled());
    }
}