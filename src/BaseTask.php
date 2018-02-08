<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/10/12
 * Time: 下午7:18
 */

namespace SwooleLib\Task;

/**
 * Class BaseTask
 * @package SwooleLib\Task
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
     * @param array $args
     */
    public function beforeRun(array $args)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function run(array $args = [])
    {
        $this->beforeRun($args);
        $this->exec($args);
        $this->afterRun($args);
    }

    /**
     * @param array $args
     * @return mixed
     */
    abstract protected function exec(array $args);

    /**
     * @param array $args
     */
    public function afterRun(array $args)
    {
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
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
