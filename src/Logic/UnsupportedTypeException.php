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
 * An {@link UnsupportedTypeException} class should be thrown when a provided variable is the incorrect type,
 * such as providing an int when an object is required.
 *
 * @package Xloit\Exception\Logic
 */
class UnsupportedTypeException extends LogicException
{
    /**
     * Code of the exception.
     *
     * @var integer|string
     */
    const CODE = 208;

    /**
     * Message template.
     *
     * @var string
     */
    protected $messageTemplate = 'Expected argument of type "%type%"; "%source%" given';
} 
