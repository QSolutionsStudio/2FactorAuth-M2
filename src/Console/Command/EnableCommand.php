<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\Console\Command;

class EnableCommand extends AbstractCommand
{
    protected $value = 1;
    protected $message = '2-factor authentication enabled for user \'%s\'';
    protected $name = 'admin:user:2factor:enable';
    protected $description = 'Enable 2-factor authentication for given user';
    protected $sendMail = true;
}