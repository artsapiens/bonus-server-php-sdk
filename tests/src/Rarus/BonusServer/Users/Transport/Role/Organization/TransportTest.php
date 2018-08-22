<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\Transport\Role\Organization;

use \Rarus\BonusServer\Cards;
use PHPUnit\Framework\TestCase;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Users\Transport
 */
class TransportTest extends TestCase
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
     * @var Cards\Transport\Role\Organization\Transport
     */
    private $cardTransport;

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::getByUserId()
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testGetByUserIdMethod(): void
    {
        $user = $this->userTransport->addNewUser(\DemoDataGenerator::createNewUser());

        $user2 = $this->userTransport->getByUserId($user->getUserId());

        $this->assertEquals($user->getUserId()->getId(), $user2->getUserId()->getId());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::getByUserId()
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserMethod(): void
    {
        $newUser = \DemoDataGenerator::createNewUser();
        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals('grishi@rarus.ru', $user->getEmail());
        $this->assertEquals($newUser->getBirthdate()->getTimestamp(), $user->getBirthdate()->getTimestamp());
        $this->assertEquals($newUser->getBirthdate()->format('d.m.Y H:i:s'), $user->getBirthdate()->format('d.m.Y H:i:s'));
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserWithSummerBirthdayMethod(): void
    {
        $newUser = \DemoDataGenerator::createNewUserWithSummerBirthday();
        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals($newUser->getEmail(), $user->getEmail());
        $this->assertEquals($newUser->getBirthdate()->getTimestamp(), $user->getBirthdate()->getTimestamp());
        $this->assertEquals($newUser->getBirthdate()->format('d.m.Y H:i:s'), $user->getBirthdate()->format('d.m.Y H:i:s'));
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserWithWinterBirthdayMethod(): void
    {
        $newUser = \DemoDataGenerator::createNewUserWithWinterBirthday();
        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals($newUser->getEmail(), $user->getEmail());
        $this->assertEquals($newUser->getBirthdate()->getTimestamp(), $user->getBirthdate()->getTimestamp());
        $this->assertEquals($newUser->getBirthdate()->format('d.m.Y H:i:s'), $user->getBirthdate()->format('d.m.Y H:i:s'));
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUser()
     */
    public function testAddNewUserWithoutBirthday(): void
    {
        $newUser = \DemoDataGenerator::createNewUserWithoutBirthday();
        $user = $this->userTransport->addNewUser($newUser);

        $this->assertEquals(null, $user->getBirthdate());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::addNewUserAndAttachFreeCard()
     */
    public function testAddNewUserAndAttachFreeCardMethod(): void
    {
        $newUser = \DemoDataGenerator::createNewUser();
        $user = $this->userTransport->addNewUserAndAttachFreeCard($newUser);
        // юзера вычитали корректного
        $this->assertEquals($user->getLogin(), $newUser->getLogin());

        $cards = $this->cardTransport->getByUser($user);
        // у него одна привязанная карта
        $attachedCard = $cards->current();
        $this->assertEquals($user->getUserId()->getId(), $attachedCard->getUserId()->getId());
    }

    /**
     * @covers \Rarus\BonusServer\Users\Transport\Role\Organization\Transport::importNewUsers()
     */
    public function testImportNewUsers(): void
    {
        $newUserCollection = \DemoDataGenerator::createNewUserWithUserUidAndPasswordCollection(5);
        $this->userTransport->importNewUsers($newUserCollection);
        foreach ($newUserCollection as $newUser) {
            $addedUser = $this->userTransport->getByUserId($newUser->getUserId());
            $this->assertEquals($addedUser->getPhone(), $newUser->getPhone());
        }
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->cardTransport = Cards\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );

        $this->userTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}