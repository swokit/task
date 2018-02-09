<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 23:19
 */

namespace SwooleLib\Task\Timer;

use SwooleLib\Task\Traits\CallbackWrapperTaskTrait;

/**
 * Class CallbackTimerTask
 * @package SwooleLib\Task\Timer
 */
class CallbackTimerTask extends TimerTask
{
    use CallbackWrapperTaskTrait;
}
