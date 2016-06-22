<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\Controller\Adminhtml\Generate;


use Magento\Backend\App\AbstractAction;
use Magento\Framework\App\ResponseInterface;

class Index extends AbstractAction
{
    /**
     * @var \QSS\GoogleAuth\Helper\Data
     */
    protected $qssHelper;
    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $config;
    /**
     * @var \QSS\GoogleAuth\Mailer
     */
    protected $mailer;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \QSS\GoogleAuth\Helper\Data $helper,
        \Magento\Config\Model\ResourceModel\Config $config,
        \QSS\GoogleAuth\Mailer $mailer
    )
    {
        $this->qssHelper = $helper;
        $this->config = $config;
        $this->mailer = $mailer;

        parent::__construct($context);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $newSecret = $this->qssHelper->authenticator->createSecret();
        try {
            $this->config->saveConfig(
                \QSS\GoogleAuth\Helper\Data::SECRET_CONFIG_PATH,
                $newSecret,
                'default',
                0
            );

            $this->sendNewSecret($newSecret);
        }
        catch (\Exception $e) {
            $this->messageManager->addException($e, $e->getMessage());
        }
        $this->messageManager->addSuccess(__('Your secret code has been updated.'));
    }

    protected function sendNewSecret($newSecret)
    {
        $this->mailer->sendNewSecret($newSecret);
    }
}