<?php
/**
 * File containing the Legacy\DeleteVersionSlot class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\Repository\SignalSlot\Slot;

use eZ\Publish\Core\Repository\SignalSlot\Signal;
use eZContentCacheManager;
use eZContentObject;
use eZSearch;
use eZContentOperationCollection;

/**
 * A legacy slot handling DeleteVersionSignal.
 */
class LegacyDeleteVersionSlot extends AbstractLegacySlot
{
    /**
     * Receive the given $signal and react on it
     *
     * @param \eZ\Publish\Core\Repository\SignalSlot\Signal $signal
     *
     * @return void
     */
    public function receive( Signal $signal )
    {
        if ( !$signal instanceof Signal\ContentService\DeleteVersionSignal )
            return;

        $kernel = $this->getLegacyKernel();
        $kernel->runCallback(
            function () use ( $signal )
            {
                eZContentCacheManager::clearContentCacheIfNeeded( $signal->contentId );
                eZSearch::removeObjectById( $signal->contentId, null );
                eZContentOperationCollection::registerSearchObject( $signal->contentId );
                eZContentObject::clearCache();// Clear all object memory cache to free memory
            },
            false
        );
    }
}