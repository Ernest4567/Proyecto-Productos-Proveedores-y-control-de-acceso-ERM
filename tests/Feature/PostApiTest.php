use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('rejects unauthenticated requests', function () {
    $this->getJson('/api/posts')->assertUnauthorized();
});

it('creates a post for the authenticated user', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/posts', [
        'title'   => 'My first post',
        'content' => 'Written through the API.',
    ])
    ->assertCreated()
    ->assertJsonPath('data.title', 'My first post');

    expect(Post::count())->toBe(1);
});

it('blocks access to posts owned by another user', function () {
    $post = Post::factory()->create(); // belongs to a different user

    Sanctum::actingAs(User::factory()->create());

    $this->getJson("/api/posts/{$post->id}")->assertForbidden();
});