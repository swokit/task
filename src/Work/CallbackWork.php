<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 22:43
 */

namespace SwooleLib\Task\Work;

use SwooleLib\Task\CallbackWrapperTaskInterface;
use SwooleLib\Task\CallbackWrapperTaskTrait;

/**
 * Class CallbackWrapperWork
 * @package SwooleLib\Task\Work
 */
class CallbackWork extends WorkTask implements CallbackWrapperTaskInterface
{
    use CallbackWrapperTaskTrait;
}
