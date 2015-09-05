<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlogTest extends TestCase
{
    use WithoutMiddleware;

    protected $blogEndpoint = '/v1/blog';
    protected $tagEndpoint = '/v1/tag';

    // seeder data from database/seeds/DatabaseSeeder.php
    private $seederUserId = 1;

    private $testBlogTitle   = 'Blog test title';
    private $testBlogContent = 'This is a test blog.';
    private $testTagContent  = 'TestTag';

    public function testCreateBlog()
    {
        $response = $this->call('POST', $this->blogEndpoint, [
            'user_id' => $this->seederUserId,
            'title'   => $this->testBlogTitle,
            'content' => $this->testBlogContent,
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']['id']));
        $this->assertEquals(true, isset($array['success']['created_at']));
        return $array['success']['id'];
    }

    public function testReadBlogByUserId()
    {
        $response = $this->call('GET', $this->blogEndpoint . '?user_id=' . $this->seederUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
        $this->assertEquals(true, count($array['success']) >= 1);
    }

    /**
     *  @depends testCreateBlog
     */
    public function testReadBlogByBlogId($blogId)
    {
        $response = $this->call('GET', $this->blogEndpoint
            . '/' . $blogId . '?user_id=' . $this->seederUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['id'] == $blogId);
    }

    /**
     *  @depends testCreateBlog
     */
    public function testUpdateBlogByBlogId($blogId)
    {
        $response = $this->call('PUT', $this->blogEndpoint
            . '/' . $blogId . '?user_id=' . $this->seederUserId, [
                'content' => 'This is updated test blog',
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, $array['success']['id'] == $blogId);
    }

    /**
     *  @depends testCreateBlog
     */
    public function testCreateTag($blogId)
    {
        $response = $this->call('POST', $this->tagEndpoint, [
            'blog_id' => $blogId,
            'content' => $this->testTagContent,
        ]);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']['id']));
        $this->assertEquals(true, $array['success']['content'] == $this->testTagContent);
        return $array['success']['id'];
    }

    /**
     *  @depends testCreateBlog
     */
    public function testReadTagByBlogId($blogId)
    {
        $response = $this->call('GET', $this->tagEndpoint
            . '/blog/' . $blogId . '?user_id=' . $this->seederUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
        $this->assertEquals(true, count($array['success']) >= 1);
    }

    /**
     *  @depends testCreateTag
     */
    public function testDeleteTagByTagId($tagId)
    {
        $response = $this->call('DELETE', $this->tagEndpoint
            . '/' . $tagId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
    }

    /**
     *  @depends testCreateBlog
     */
    public function testDeleteBlogByBlogId($blogId)
    {
        $response = $this->call('DELETE', $this->blogEndpoint
            . '/' . $blogId . '?user_id=' . $this->seederUserId);
        $this->assertEquals(200, $response->status());
        $array = json_decode($response->content(), true);
        $this->assertEquals(true, isset($array['success']));
    }
}
