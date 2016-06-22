<?php
/**
 * Created by Q-Solutions Studio.
 * Developer: Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace QSS\GoogleAuth\Console\Command;

class DisableCommand extends AbstractCommand
{
    protected $value = 0;
    protected $message = '2-factor authentication disabled for user \'%s\'';
    protected $name = 'admin:user:2factor:disable';
    protected $description = 'Disable 2-factor authentication for given user';
}