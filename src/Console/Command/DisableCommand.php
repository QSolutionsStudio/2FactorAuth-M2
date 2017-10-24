<?php
/**
 * @category    QSS
 * @package     QSS\GoogleAuth
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace QSS\GoogleAuth\Console\Command;

class DisableCommand extends AbstractCommand
{
    protected $value = 0;
    protected $message = '2-factor authentication disabled for user \'%s\'';
    protected $name = 'admin:user:2factor:disable';
    protected $description = 'Disable 2-factor authentication for given user';
}