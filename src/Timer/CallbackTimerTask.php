<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 23:19
 */

namespace SwooleKit\Task\Timer;

use SwooleKit\Task\Traits\CallbackWrapperTaskTrait;

/**
 * Class CallbackTimerTask
 * @package SwooleKit\Task\Timer
 */
class CallbackTimerTask extends TimerTask
{
    use CallbackWrapperTaskTrait;
}
