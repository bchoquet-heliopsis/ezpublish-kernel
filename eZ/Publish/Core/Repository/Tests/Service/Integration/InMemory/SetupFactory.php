<?php
/**
 * File containing the Test Setup Factory base class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\Repository\Tests\Service\Integration\InMemory;

use eZ\Publish\API\Repository\Tests\SetupFactory\Legacy as APILegacySetupFactory;
use eZ\Publish\Core\Base\ServiceContainer;

/**
 * A Test Factory is used to setup the infrastructure for a tests, based on a
 * specific repository implementation to test.
 */
class SetupFactory extends APILegacySetupFactory
{
    /**
     * Service container
     *
     * @var \eZ\Publish\Core\Base\ServiceContainer
     */
    protected static $memoryServiceContainer;

    /**
     * Returns the service container used for initialization of the repository
     *
     * @todo Getting service container statically, too, would be nice
     *
     * @return \eZ\Publish\Core\Base\ServiceContainer
     */
    protected function getServiceContainer()
    {
        if ( !isset( static::$memoryServiceContainer ) )
        {
            $configManager = $this->getConfigurationManager();

            $serviceSettings = $configManager->getConfiguration( 'service' )->getAll();

            $serviceSettings['persistence_handler']['alias'] = 'persistence_handler_inmemory';
            $serviceSettings['io_handler']['alias'] = 'io_handler_inmemory';

            // Needed for URLAliasService tests
            //$serviceSettings['inner_repository']['arguments']['service_settings']['language']['languages'][] = 'eng-US';
            //$serviceSettings['inner_repository']['arguments']['service_settings']['language']['languages'][] = 'eng-GB';

            static::$memoryServiceContainer = new ServiceContainer(
                $serviceSettings,
                $this->getDependencyConfiguration()
            );
        }

        return static::$memoryServiceContainer;
    }

    /**
     * Returns a configured repository for testing.
     *
     * @param boolean $initializeFromScratch if the back end should be initialized
     *                                    from scratch or re-used
     * @return \eZ\Publish\API\Repository\Repository
     */
    public function getRepository( $initializeFromScratch = true )
    {
        if ( $initializeFromScratch )
        {
            $this->getServiceContainer()->get( 'persistence_handler_inmemory' )->getBackend()->resetData();
        }

        $repository = $this->getServiceContainer()->get( 'inner_repository' );
        $repository->setCurrentUser(
            $repository->getUserService()->loadUser( 14 )
        );
        return $repository;
    }
}