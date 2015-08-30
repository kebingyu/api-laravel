<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use App\Models\AccessToken;

class UserTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/user/';

    private $testUsername = 'test';
    private $testUserEmail = 'test@test.com';
    private $testPassword = '123456';

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
            'username' => $this->testUsername,
            'email'    => $this->testUserEmail,
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['error']));
    }

    /*
    public function testUserLogin()
    {
        $response = $this->call('POST', '/login', [
            'username' => $this->testUsername,
            'password' => $this->testPassword,
        ]);
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['user_loggedin']));
    }
     */

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
        $this->assertEquals(true, $array['success'] == 1);
    }

    /*
    public function testUserLogout()
    {
        $user = User::findUserByPrimaryKey($this->testUsername);
        $token = AccessToken::find($user->id);
        $response = $this->call('POST', '/logout', [
            'user_id' => $token->user_id,
            'token' => $token->token,
        ]);
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['user_loggedout']));
    }
     */
}
