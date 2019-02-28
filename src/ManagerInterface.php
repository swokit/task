<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:20
 */

namespace Swokit\Task;

use Psr\Log\LoggerAwareInterface;

/**
 * Interface ManagerInterface
 * @package Swokit\Task
 */
interface ManagerInterface extends LoggerAwareInterface
{
    public function start(): void;
}
