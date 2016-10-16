<?php
/**
 * This source file is part of Xloit project.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * <http://www.opensource.org/licenses/mit-license.php>
 * If you did not receive a copy of the license and are unable to obtain it through the world-wide-web,
 * please send an email to <license@xloit.com> so we can send you a copy immediately.
 *
 * @license   MIT
 * @link      http://xloit.com
 * @copyright Copyright (c) 2016, Xloit. All rights reserved.
 */

namespace Xloit\Exception\Tests;

use ReflectionClass;
use Xloit\Exception\Exception;

/**
 * Test class for {@link AbstractExceptionTest}
 *
 * @package Xloit\Exception\Tests
 */
abstract class AbstractExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     *
     * @var string
     */
    protected $className;

    /**
     *
     *
     * @var string
     */
    protected $messageTemplate;

    /**
     *
     *
     * @var array
     */
    protected $messageVariables;

    /**
     *
     *
     * @var string
     */
    protected $expectedMessage;

    public function testClassName()
    {
        $reflection = new ReflectionClass($this->className);
        $exception  = $reflection->newInstance();

        static::assertInstanceOf(Exception::class, $exception);
    }

    public function testDefaultCode()
    {
        $reflection = new ReflectionClass($this->className);
        $exception  = $reflection->newInstance();

        static::assertSame($reflection->getConstant('CODE'), $exception->getCode());
    }

    public function testDefaultMessage()
    {
        $reflection = new ReflectionClass($this->className);
        $exception  = $reflection->newInstance();

        if ($this->messageTemplate && $this->messageVariables) {
            $exception->setMessage([
                'message' => $this->messageTemplate,
                'messageVariables' => $this->messageVariables
            ]);
        }

        if ($this->expectedMessage) {
            static::assertSame($this->expectedMessage, $exception->getMessage());
        } else {
            static::assertSame('Unknown Exception Reason.', $exception->getMessage());
        }
    }
}
