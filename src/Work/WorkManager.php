<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 18-2-8
 * Time: 下午5:56
 */

namespace SwooleLib\Task\Work;

use SwooleLib\Task\AbstractManager;

/**
 * Class WorkManager
 * @package SwooleLib\Task\Work
 */
class WorkManager extends AbstractManager
{
    protected static $taskInterface = WorkTaskInterface::class;

    public function start()
    {
        // TODO: Implement start() method.
    }
}