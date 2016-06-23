<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth;


class Mailer
{
    const EMAIL_NEW_SECRET = 'qss_googleauth_email_new_secret';
    const EMAIL_USER = 'qss_googleauth_email_user';
    /**
     * @var \QSS\GoogleAuth\Helper\Data
     */
    protected $qssHelper;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;
    /**
     * @var \Magento\User\Model\ResourceModel\User\Collection
     */
    protected $collection;
    /**
     * @var array
     */
    protected $recipients;
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authSession;

    public function __construct(
        \QSS\GoogleAuth\Helper\Data $helper,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\User\Model\ResourceModel\User\Collection $collection,
        \Magento\Backend\Model\Auth\Session $authSession
    )
    {
        $this->qssHelper = $helper;
        $this->transportBuilder = $transportBuilder;
        $this->collection = $collection;
        $this->authSession = $authSession;

        $this->recipients = [];

        foreach ($this->collection as $user) {
            if ($user->getIsActive() && $user->getData('googleauth_enabled')) {
                $this->recipients[$user->getName()] = $user->getEmail();
            }
        }
    }

    /**
     * @param $newSecret
     */
    public function sendNewSecret($newSecret)
    {
        $this->sendSecret($newSecret, $this->authSession->getUser(), self::EMAIL_NEW_SECRET, $this->recipients);
    }

    /**
     * @param \Magento\User\Model\User $user
     */
    public function sendSecretToUser($user)
    {
        $this->sendSecret($this->qssHelper->getSecret(), $user, self::EMAIL_USER, [$user->getName() => $user->getEmail()]);
    }

    /**
     * @param $secret
     * @param $user
     * @param $templateIdentifier
     * @param $recipients
     */
    protected function sendSecret($secret, $user, $templateIdentifier, $recipients)
    {
        if (empty($recipients)) {
            return;
        }

        $sender = [
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ];
        $transport = $this->transportBuilder
            ->setTemplateIdentifier($templateIdentifier)
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID
                ]
            )
            ->setTemplateVars(
                [
                    'secret' => $secret,
                    'qrcode' => $this->qssHelper->getQRCodeUrl($secret)
                ]
            )
            ->addTo($recipients)
            ->setFrom($sender)
            ->getTransport();

        $transport->sendMessage();
    }
}