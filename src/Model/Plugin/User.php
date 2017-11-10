<?php
/**
 * @category    Qextensions
 * @package     Qextensions\Google2factor
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Qextensions\Google2factor\Model\Plugin;

class User
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    /**
     * @var \Qextensions\Google2factor\Mailer
     */
    protected $mailer;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Qextensions\Google2factor\Mailer $mailer
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
            $google2factorEnabled = $this->request->getParam('google2factor_enabled');

            $subject->setData('google2factor_enabled', $google2factorEnabled);

            if ($subject->dataHasChangedFor('google2factor_enabled') && boolval($google2factorEnabled)) {
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