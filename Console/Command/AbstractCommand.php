<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    protected $attribute = 'googleauth_enabled';
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
     * @var \QSS\GoogleAuth\Mailer
     */
    protected $mailer;

    public function __construct(
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\Framework\App\State $state,
        \QSS\GoogleAuth\MailerFactory $mailerFactory,
        $name = null
    )
    {
        try {
            $state->getAreaCode();
        }
        catch (\Magento\Framework\Exception\LocalizedException $e) {
            $state->setAreaCode('admin');
        }
        $this->userFactory = $userFactory;
        $this->mailer = $mailerFactory->create();

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
            $this->mailer->sendSecretToUser($user);
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