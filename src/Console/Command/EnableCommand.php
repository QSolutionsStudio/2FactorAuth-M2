<?php
/**
 * @category    Qextensions
 * @package     Qextensions\Google2factor
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Qextensions\Google2factor\Console\Command;

class EnableCommand extends AbstractCommand
{
    protected $value = 1;
    protected $message = '2-factor authentication enabled for user \'%s\'';
    protected $name = 'admin:user:2factor:enable';
    protected $description = 'Enable 2-factor authentication for given user';
    protected $sendMail = true;
}