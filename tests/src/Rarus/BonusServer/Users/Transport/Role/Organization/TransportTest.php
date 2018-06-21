<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\Transport\Role\Organization;

use \Rarus\BonusServer\Cards;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Users\Transport
 */
class TransportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rarus\BonusServer\ApiClient
     */
    private $apiClient;
    /**
     * @var Transport
     */
    private $userTransport;

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::getByUserId()
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testGetByUserIdMethod(): void
    {
        $newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . random_int(0, PHP_INT_MAX),
            'Михаил Гришин',
            '+7978 888 22 22',
            'grishi@rarus.ru'
        );

        $user = $this->userTransport->addNewUser($newUser);

        $user2 = $this->userTransport->getByUserId($user->getUserId());

        $this->assertEquals($user->getUserId()->getId(), $user2->getUserId()->getId());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::getByUserId()
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserMethod(): void
    {

        $newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . random_int(0, PHP_INT_MAX),
            'Михаил Гришин',
            '+7978 888 22 22',
            'grishi@rarus.ru'
        );

        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals('grishi@rarus.ru', $user->getEmail());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::importNewUsers()
     */
    public function testImportNewUsers(): void
    {
        $userCollection = new \Rarus\BonusServer\Users\DTO\UserCollection();
        $userCollection->attach(
            \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
                'grishi-' . random_int(0, PHP_INT_MAX),
                'Михаил Гришин 1',
                '+7978 888 22 22',
                'grishi@rarus.ru',
                null,
                null,
                'passs-hash-1',
                new \Rarus\BonusServer\Users\DTO\UserId('grishi-uid-' . random_int(0, PHP_INT_MAX)),
                \Rarus\BonusServer\Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
            )
        );
        $userCollection->attach(
            \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
                'grishi-' . random_int(0, PHP_INT_MAX),
                'Михаил Гришин 2',
                '+7978 888 22 22',
                'grishi@rarus.ru',
                null,
                null,
                'passs-hash-1',
                new \Rarus\BonusServer\Users\DTO\UserId('grishi-uid-' . random_int(0, PHP_INT_MAX)),
                \Rarus\BonusServer\Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
            )
        );
        $userCollection->attach(
            \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
                'grishi-' . random_int(0, PHP_INT_MAX),
                'Михаил Гришин 3',
                '+7978 888 22 22',
                'grishi@rarus.ru',
                null,
                null,
                'passs-hash-1',
                new \Rarus\BonusServer\Users\DTO\UserId('grishi-uid-' . random_int(0, PHP_INT_MAX)),
                \Rarus\BonusServer\Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
            )
        );

        $this->userTransport->importNewUsers($userCollection);
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->userTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}