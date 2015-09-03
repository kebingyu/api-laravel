<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/user/';

    private $testUsername  = 'test';
    private $testUserEmail = 'test@test.com';
    private $testPassword  = '123456';

    // seeder data from database/seeds/DatabaseSeeder.php
    private $seederUserId      = 1;
    private $seederUsername    = 'tester';
    private $seederEmail       = 'tester@tester.com';
    private $seederPassword    = 'tester';

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testCreateUserSuccess()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username'              => $this->testUsername,
            'email'                 => $this->testUserEmail,
            'password'              => $this->testPassword,
            'password_confirmation' => $this->testPassword,
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['username'] == $this->testUsername);
    }

    public function testCreateUserFail()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username' => $this->seederUsername,
            'email'    => $this->seederEmail,
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['error']));
    }

    public function testGetUserByName()
    {
        $response = $this->call('GET', $this->endpoint . $this->testUsername);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['username'] == $this->testUsername);
    }

    public function testGetUserByEmail()
    {
        $response = $this->call('GET', $this->endpoint . $this->testUserEmail);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['username'] == $this->testUsername);
    }

    public function testUpdateUserSuccess()
    {
        $response = $this->call('PUT', $this->endpoint . $this->testUsername, [
            'is_active' => 0,
            'is_admin'  => 1,
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['username'] == $this->testUsername);
    }

    public function testUserDeleteSuccess()
    {
        $response = $this->call('DELETE', $this->endpoint . $this->testUsername);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
    }

    public function testUserLogin()
    {
        $response = $this->call('POST', '/login', [
            'username' => $this->seederUsername,
            'password' => $this->seederPassword,
        ]);
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']['token']));
    }

    /*
    public function testUserLogout()
    {
        $response = $this->call('POST', '/logout', [
            'user_id' => $this->seederUserId,
            'token' => $this->seederAccessToken,
        ]);
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']['loggedout']));
    }
     */
}
