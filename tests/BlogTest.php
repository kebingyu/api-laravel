<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/blog';

    // seeder data from database/seeds/DatabaseSeeder.php
    private $seederUserId = 1;
    private $seederBlogId = 1;

    private $testBlogTitle   = 'Blog test title';
    private $testBlogContent = 'This is a test blog.';

    public function testCreateBlog()
    {
        $response = $this->call('POST', $this->endpoint, [
            'user_id' => $this->seederUserId,
            'title'   => $this->testBlogTitle,
            'content' => $this->testBlogContent,
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']['id']));
        $this->assertEquals(true, isset($array['success']['created_at']));
    }

    public function testReadBlogByUserId()
    {
        $response = $this->call('GET', $this->endpoint . '?user_id=' . $this->seederUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
        $this->assertEquals(true, count($array['success']) >= 1);
    }

    public function testReadBlogByBlogId()
    {
        $response = $this->call('GET', $this->endpoint
            . '/' . $this->seederBlogId . '?user_id=' . $this->seederUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['id'] == $this->seederBlogId);
    }

    public function testUpdateBlogByBlogId()
    {
        $response = $this->call('PUT', $this->endpoint
            . '/' . $this->seederBlogId . '?user_id=' . $this->seederUserId, [
                'content' => 'This is updated test blog',
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['id'] == $this->seederBlogId);
    }

    /*
    public function testDeleteBlogByBlogId()
    {
        $response = $this->call('DELETE', $this->endpoint
            . '/' . $this->seederBlogId . '?user_id=' . $this->seederUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
    }
     */
}
