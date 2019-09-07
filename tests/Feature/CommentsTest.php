<?php

namespace Tests\Feature;

use App\Cat;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

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
}
