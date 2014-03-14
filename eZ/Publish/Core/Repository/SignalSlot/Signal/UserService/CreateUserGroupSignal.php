<?php
/**
 * CreateUserGroupSignal class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\Repository\SignalSlot\Signal\UserService;

use eZ\Publish\Core\Repository\SignalSlot\Signal;

/**
 * CreateUserGroupSignal class
 * @package eZ\Publish\Core\Repository\SignalSlot\Signal\UserService
 */
class CreateUserGroupSignal extends Signal
{
    /**
     * User Group ID
     *
     * @var mixed
     */
    public $userGroupId;
}