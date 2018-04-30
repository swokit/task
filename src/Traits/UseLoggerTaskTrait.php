<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2018/2/8 0008
 * Time: 22:48
 */

namespace SwooleKit\Task\Traits;

use Psr\Log\LoggerAwareTrait;

/**
 * Trait UseLoggerTaskTrait
 * @package SwooleKit\Task\Traits
 * @property string $name
 */
trait UseLoggerTaskTrait
{
    use LoggerAwareTrait;

    /**
     * @param string $msg
     * @param array $data
     */
    protected function debug(string $msg, array $data = [])
    {
        $this->log("name=$this->name " . $msg, $data, 'debug');
    }

    /**
     * @param string $msg
     * @param array $data
     */
    protected function info(string $msg, array $data = [])
    {
        $this->log("name=$this->name " . $msg, $data, 'info');
    }

    /**
     * @param $msg
     * @param array $data
     */
    protected function err(string $msg, array $data = [])
    {
        $this->log("name=$this->name " . $msg, $data, 'error');
    }

    /**
     * @param string $msg
     * @param array $data
     * @param string $type
     */
    protected function log(string $msg, array $data = [], string $type = 'info')
    {
        if ($this->logger) {
            $this->logger->log($type, $msg, $data);
        }
    }
}
