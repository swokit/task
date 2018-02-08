<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:20
 */

namespace SwooleLib\Task;

use Psr\Log\LoggerAwareInterface;

/**
 * Interface ManagerInterface
 * @package SwooleLib\Task
 */
interface ManagerInterface extends LoggerAwareInterface
{
    public function start();
}
