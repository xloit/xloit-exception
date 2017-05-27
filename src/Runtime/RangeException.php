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

namespace Xloit\Exception\Runtime;

use Xloit\Exception\RuntimeException;

/**
 * A {@link RangeException} class will thrown to indicate range errors during program execution. Normally this means
 * there was an arithmetic error other than under/overflow. This is the runtime version of
 * {@link \Xloit\Exception\Logic\DomainException}.
 *
 * @link    http://php.net/manual/en/class.rangeexception.php
 *
 * @package Xloit\Exception\Runtime
 */
class RangeException extends RuntimeException
{
    /**
     * Code of the exception.
     *
     * @var int|string
     */
    const CODE = 302;
} 
