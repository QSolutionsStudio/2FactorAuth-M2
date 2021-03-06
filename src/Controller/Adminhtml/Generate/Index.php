<?php
/**
 * @category    Qextensions
 * @package     Qextensions\Google2factor
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Qextensions\Google2factor\Controller\Adminhtml\Generate;


use Magento\Backend\App\AbstractAction;
use Magento\Framework\App\ResponseInterface;

class Index extends AbstractAction
{
    /**
     * @var \Qextensions\Google2factor\Helper\Data
     */
    protected $qssHelper;
    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $config;
    /**
     * @var \Qextensions\Google2factor\Mailer
     */
    protected $mailer;
    /**
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $logger;
    /**
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $cacheManager;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Qextensions\Google2factor\Helper\Data $helper,
        \Magento\Config\Model\ResourceModel\Config $config,
        \Magento\Framework\App\CacheInterface $cacheManager,
        \Magento\Framework\Logger\Monolog $logger,
        \Qextensions\Google2factor\Mailer $mailer
    )
    {
        $this->qssHelper = $helper;
        $this->config = $config;
        $this->cacheManager = $cacheManager;
        $this->logger = $logger;
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
                \Qextensions\Google2factor\Helper\Data::SECRET_CONFIG_PATH,
                $newSecret,
                'default',
                0
            );

            $this->messageManager->addSuccessMessage(__('Your secret code has been updated.'));

            $this->cacheManager->clean([\Magento\Framework\App\Config::CACHE_TAG]);

            $this->sendNewSecret($newSecret);
        }
        catch (\Exception $e) {
            $this->logger->critical($e->getTraceAsString());
            $this->messageManager->addExceptionMessage($e, $e->getMessage());
        }
    }

    protected function sendNewSecret($newSecret)
    {
        $this->mailer->sendNewSecret($newSecret);
    }
}