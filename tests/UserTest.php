<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     *  auto reroll database
     */
    use DatabaseTransactions;

    protected $endpoint = '/v1/user/';

    public function testCreateUserSuccess()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username'              => 'test',
            'email'                 => 'test@test.com',
            'password'              => '123456',
            'password_confirmation' => '123456',
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['user_created']['username'] == 'test');
    }

    public function testCreateUserFail()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username'              => 'test',
            'email'                 => 'test@test.com',
        ]);
        $this->assertEquals(400, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['password'] == ['The password field is required.']);
    }

    public function testReadUserInfoSuccess()
    {
        $userId = '6';
        $username = 'kebing';
        $response = $this->call('GET', $this->endpoint . $userId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['user_found']['username'] == $username);
    }

    public function testUserDelete()
    {
        $response = $this->call('DELETE', $this->endpoint . '1');
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['deleted']['id'] == 1);
    }
}
