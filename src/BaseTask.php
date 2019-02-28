<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:18
 */

namespace Swokit\Task;

/**
 * Class BaseTask
 * @package Swokit\Task
 */
abstract class BaseTask implements TaskInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param array $config
     * @return static
     */
    public static function fromArray(array $config)
    {
        return new static($config);
    }

    /**
     * BaseTask constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        TaskHelper::initObject($this, $config);
    }

    /**
     * @param array $config
     */
    public function config(array $config): void
    {
        TaskHelper::initObject($this, $config);
    }

    /**
     * @param array $args
     */
    public function beforeRun(array $args): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function run(array $args = [])
    {
        $result = null;

        try {
            if (false !== $this->beforeRun($args)) {
                $result = $this->exec($args);

                $this->afterRun($result);
            }
        } catch (\Throwable $e) {
            $this->onException($e);
        }

        return $result;
    }

    /**
     * @param array $args
     * @return mixed
     */
    abstract protected function exec(array $args);

    /**
     * @param array $args
     */
    public function afterRun(array $args): void
    {
    }

    /**
     * @param \Throwable $e
     */
    protected function onException(\Throwable $e): void
    {
        // log error
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
