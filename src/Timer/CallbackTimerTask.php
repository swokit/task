<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 23:19
 */

namespace SwoKit\Task\Timer;

use SwoKit\Task\Traits\CallbackWrapperTaskTrait;

/**
 * Class CallbackTimerTask
 * @package SwoKit\Task\Timer
 */
class CallbackTimerTask extends TimerTask
{
    use CallbackWrapperTaskTrait;
}
