<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 23:19
 */

namespace Swokit\Task\Timer;

use Swokit\Task\Traits\CallbackWrapperTaskTrait;

/**
 * Class CallbackTimerTask
 * @package Swokit\Task\Timer
 */
class CallbackTimerTask extends TimerTask
{
    use CallbackWrapperTaskTrait;
}
