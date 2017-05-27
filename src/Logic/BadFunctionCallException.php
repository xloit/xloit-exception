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

namespace Xloit\Exception\Logic;

use Xloit\Exception\LogicException;

/**
 * A {@link BadFunctionCallException} class will thrown if a callback refers to an undefined function or if
 * some arguments are missing.
 *
 * @link    http://php.net/manual/en/class.badfunctioncallexception.php
 * @package Xloit\Exception\Logic
 */
class BadFunctionCallException extends LogicException
{
    /**
     * Code of the exception.
     *
     * @var int|string
     */
    const CODE = 200;

    /**
     * Message template.
     *
     * @var string
     */
    protected $messageTemplate = 'Exception encountered while invoking a function on the activity.';
} 
