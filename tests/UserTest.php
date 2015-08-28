<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;

class UserTest extends TestCase
{
    protected $endpoint = '/v1/user/';

    private $testUsername = 'test';
    private $testUserEmail = 'test@test.com';

    public function testCreateUserSuccess()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username'              => $this->testUsername,
            'email'                 => $this->testUserEmail,
            'password'              => '123456',
            'password_confirmation' => '123456',
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['user_created']['username'] == $this->testUsername);
    }

    public function testCreateUserFail()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username' => $this->testUsername,
            'email'    => $this->testUserEmail,
        ]);
        $this->assertEquals(400, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['password'] == ['The password field is required.']);
    }

    public function testGetUserByName()
    {
        $response = $this->call('GET', $this->endpoint . $this->testUsername);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['user_found']['username'] == $this->testUsername);
    }

    public function testGetUserByEmail()
    {
        $response = $this->call('GET', $this->endpoint . $this->testUserEmail);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['user_found']['username'] == $this->testUsername);
    }

    public function testUpdateUserSuccess()
    {
        $response = $this->call('PUT', $this->endpoint . $this->testUsername, [
            'is_active'=> 0,
            'is_admin' => 1,
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['user_updated']['username'] == $this->testUsername);
    }

    public function testUserDeleteSuccess()
    {
        $response = $this->call('DELETE', $this->endpoint . $this->testUsername);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['user_deleted'] == 1);
    }
}
