<?php

namespace Tests\Feature;

use App\Cat;
use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fetch_comments_related_to_a_cat()
    {
        $this->withoutExceptionHandling();
        $cat = factory(Cat::class)->create();
        $commentA = factory(Comment::class)->create(['cat_id' => $cat->id]);
        $commentB = factory(Comment::class)->create(['cat_id' => $cat->id]);
        $commentC = factory(Comment::class)->create(['cat_id' => $cat->id]);

        $replyA = factory(Comment::class)->create(['cat_id' => $cat->id, 'parent_id' => $commentB->id]);
        $replyB = factory(Comment::class)->create(['cat_id' => $cat->id, 'parent_id' => $commentB->id]);

        $response = $this->json('get', "cats/{$cat->id}/comments");

        $response->assertOk();
        $this->assertCount(3, $response->json());
        $response->assertJson([
            ['id' => $commentA->id, 'replies' => []],
            [
                'id' => $commentB->id,
                'replies' => [
                    ['id' => $replyA->id],
                    ['id' => $replyB->id],
                ]
            ],
            ['id' => $commentC->id, 'replies' => []],
        ]);
    }

    /** @test */
    public function it_can_post_a_new_comment_to_a_cat()
    {
        $this->withoutExceptionHandling();

        // arrange
        $cat = factory(Cat::class)->create();

        // act
        $response = $this->json('post', "/cats/{$cat->id}/comments", [
            'body' => 'test comment',
        ]);

        // assert
        $response->assertOk();
        $this->assertEquals(1, $cat->comments()->count());
        $comment = $cat->comments()->first();
        $this->assertEquals('test comment', $comment->body);
    }

    /** @test */
    public function it_can_post_a_reply_to_a_parent_comment()
    {
        $this->withoutExceptionHandling();

        // arrange
        $cat = factory(Cat::class)->create();
        $parentComment = factory(Comment::class)->create(['cat_id' => $cat->id]);

        // act
        $response = $this->json('post', "/cats/{$cat->id}/comments", [
            'parent_id' => $parentComment->id,
            'body' => 'test reply',
        ]);

        // assert
        $response->assertOk();
        $this->assertEquals(2, $cat->comments()->count());
        $this->assertEquals(1, $parentComment->replies()->count());
        $reply = $parentComment->replies()->first();
        $this->assertEquals('test reply', $reply->body);
    }
}
