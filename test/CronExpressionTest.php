<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2018/02/5
 * Time: 下午7:53
 */

namespace SwooleKit\Task\Test;

use SwooleKit\Task\CronExpression;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class CronExpressionTest extends TestCase
{

    public function testParse()
    {
        // $time = CronExpression::parse('*/1 * * * *');
        // var_dump($time, CronExpression::getNodes());

        $time = CronExpression::parse('* * * * * *');

        var_dump($time);
    }
}
