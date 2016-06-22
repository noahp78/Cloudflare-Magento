<?php
namespace CloudFlare\Plugin\Test\Unit\Backend;

use CloudFlare\Plugin\Backend\DataStore;

class DataStoreTest extends \PHPUnit_Framework_TestCase{

    protected $dataStore;
    protected $mockMagentoAPI;

    public function setUp() {
        $this->mockMagentoAPI = $this->getMockBuilder('\CloudFlare\Plugin\Backend\MagentoAPI')
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataStore = new DataStore($this->mockMagentoAPI);
    }

    public function testCreateUserDataStoreSavesAPIKeyAndEmail() {
        $apiKey = "apiKey";
        $email = "email";
        
        $this->mockMagentoAPI->expects($this->at(0))
            ->method('setValue')
            ->with(DataStore::CLIENT_API_KEY, $apiKey);

        $this->mockMagentoAPI->expects($this->at(1))
            ->method('setValue')
            ->with(DataStore::CLOUDFLARE_EMAIL, $email);

        $this->dataStore->createUserDataStore($apiKey, $email, null, null);
    }

    public function testGetClientV4APIKeyReturnsCorrectValue() {
        $apiKey = "apiKey";
        $this->mockMagentoAPI->method('getValue')->willReturn($apiKey);

        $response = $this->dataStore->getClientV4APIKey();
        $this->assertEquals($response,$apiKey);
    }

    public function testGetCloudFlareEmailReturnsCorrectValue() {
        $email = "email";
        $this->mockMagentoAPI->method('getValue')->willReturn($email);

        $response = $this->dataStore->getClientV4APIKey();
        $this->assertEquals($response,$email);
    }

    public function testGetHostAPIUserKeyReturnsNull() {
        $this->assertNull($this->dataStore->getHostAPIUserKey());
    }

    public function testGetHostAPIUserUniqueIdReturnsNull() {
        $this->assertNull($this->dataStore->getHostAPIUserUniqueId());
    }
}
