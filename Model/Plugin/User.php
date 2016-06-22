<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\Model\Plugin;

class User
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    /**
     * @var \QSS\GoogleAuth\Mailer
     */
    protected $mailer;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \QSS\GoogleAuth\Mailer $mailer
    )
    {
        $this->request = $request;
        $this->mailer = $mailer;
    }

    public function aroundSave(
        \Magento\User\Model\User $subject,
        \Closure $proceed
    )
    {
        if ($this->request->isPost() && $this->isAllowed()) {
            $googleauthEnabled = $this->request->getParam('googleauth_enabled');

            $subject->setData('googleauth_enabled', $googleauthEnabled);

            if ($subject->dataHasChangedFor('googleauth_enabled') && boolval($googleauthEnabled)) {
                $shouldSendMail = true;
            }
        }

        $result = $proceed();

        if (isset($shouldSendMail) && $shouldSendMail === true) {
            $this->sendMail($subject);
        }

        return $result;
    }

    /**
     * @param $user
     */
    protected function sendMail($user)
    {
        $this->mailer->sendSecretToUser($user);
    }

    /**
     * @return bool
     */
    protected function isAllowed()
    {
        return ($this->request->getFullActionName() === 'adminhtml_system_account_save'
            || $this->request->getFullActionName() === 'adminhtml_user_save');
    }
}