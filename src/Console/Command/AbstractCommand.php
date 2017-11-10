<?php
/**
 * @category    Qextensions
 * @package     Qextensions\Google2factor
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Qextensions\Google2factor\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    protected $attribute = 'google2factor_enabled';
    protected $value = null;
    protected $message = '';
    protected $argument = 'username';
    protected $name = 'admin:user:2factor';
    protected $description = '';
    protected $sendMail = false;
    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $userFactory;
    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;
    /**
     * @var \Qextensions\Google2factor\MailerFactory
     */
    protected $mailerFactory;

    public function __construct(
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\Framework\App\State $state,
        \Qextensions\Google2factor\MailerFactory $mailerFactory,
        $name = null
    )
    {
        $this->userFactory = $userFactory;
        $this->state = $state;
        $this->mailerFactory = $mailerFactory;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description)
            ->addArgument($this->argument, InputArgument::REQUIRED, 'Username');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $username = $input->getArgument($this->argument);
        $user = $this->getUser($username);
        $user->setData($this->attribute, $this->value)->save();
        $output->writeln(sprintf($this->message, $username));

        if ($this->sendMail) {
            try {
                $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
            }
            catch (\Magento\Framework\Exception\LocalizedException $e) {}

            $this->mailerFactory->create()->sendSecretToUser($user);
        }
    }

    /**
     * @param $username
     * @return \Magento\User\Model\User
     */
    protected function getUser($username)
    {
        return $this->userFactory->create()->loadByUsername($username);
    }
}