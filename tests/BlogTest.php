<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Blog;

class BlogTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint      = '/v1/blog';

    private $testUserId      = 1;
    private $testBlogId      = 1;
    private $testBlogTitle   = 'Blog test title';
    private $testBlogContent = 'This is a test blog.';

    public function testCreateBlog()
    {
        $response = $this->call('POST', $this->endpoint, [
            'user_id' => $this->testUserId,
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
        $response = $this->call('GET', $this->endpoint . '?user_id=' . $this->testUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
        $this->assertEquals(true, count($array['success']) >= 1);
    }

    public function testReadBlogByBlogId()
    {
        $response = $this->call('GET', $this->endpoint
            . '/' . $this->testBlogId . '?user_id=' . $this->testUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['id'] == $this->testBlogId);
    }

    public function testUpdateBlogByBlogId()
    {
        $response = $this->call('PUT', $this->endpoint
            . '/' . $this->testBlogId . '?user_id=' . $this->testUserId, [
                'content' => 'This is updated test blog',
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['id'] == $this->testBlogId);
    }

    public function testDeleteBlogByBlogId()
    {
        $response = $this->call('DELETE', $this->endpoint
            . '/' . $this->testBlogId . '?user_id=' . $this->testUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
    }
}
