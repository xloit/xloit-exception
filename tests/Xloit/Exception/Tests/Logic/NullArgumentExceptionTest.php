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

namespace Xloit\Exception\Tests\Logic;

use Xloit\Exception\Logic\NullArgumentException;
use Xloit\Exception\Tests\AbstractExceptionTest;

/**
 * Test class for {@link NullArgumentExceptionTest}
 *
 * @package Xloit\Exception\Tests\Logic
 */
class NullArgumentExceptionTest extends AbstractExceptionTest
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->className = NullArgumentException::class;
        $this->messageTemplate = 'You must specify a non-null value for the parameters. %type% given.';
        $this->messageVariables = [
            'type' => new NullArgumentException
        ];
        $this->expectedMessage = sprintf(
            'You must specify a non-null value for the parameters. [Object "%s"] given.',
            NullArgumentException::class
        );
    }
} 
