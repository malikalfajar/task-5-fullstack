<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use Tests\TestCase;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Http\Middleware\Authenticate;
use App\Repositories\Article\ArticleRepository;
use Illuminate\Foundation\Testing\WithFaker;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Article\EloquentArticleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Category\EloquentCategoryRepository;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;
    protected $categories;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->categories = Category::factory(5)->create();

        $this->withoutMiddleware(Authenticate::class);

        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(ArticleRepository::class, EloquentArticleRepository::class);
    }


    /** @test */
    public function user_can_get_list_of_articles()
    {
        $articles = Article::factory(5)->create();

        $response = $this->actingAs($this->user)
            ->get(route('api.articles.index'));

        $response->assertOk();
        $response->assertJsonFragment([
            'title' => $articles->random()->title
        ]);
    }

    /** @test */
    public function user_can_get_a_article_detail()
    {
        $article = article::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('api.articles.show', ['article' => $article]));

        $response->assertOk();
        $response->assertJsonFragment([
            'title' => $article->title,
            'content' => $article->content
        ]);
    }

    /** @test */
    public function user_can_store_a_article()
    {
        $data = [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->sentence(24),
            'category' => $this->categories->random()->id
        ];

        $response = $this->actingAs($this->user)
            ->post(route('api.articles.store'), $data);

        $data['category_id'] = $data['category'];
        unset($data['category']);

        // $data['user_id'] = $this->user->id;

        // $this->assertDatabaseHas('articles', $data);

        $response->assertCreated();
        $response->assertJsonFragment([
            'title' => $data['title'],
            'content' => $data['content']
        ]);
    }

    /** @test */
    public function user_can_update_article()
    {
        $oldData = [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->sentence(24),
            'category' => $this->categories->random()->id
        ];

        $newData = [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->sentence(24),
            'category' => $this->categories->random()->id
        ];

        $article = $this->user->articles()->create($oldData);

        $response = $this->actingAs($this->user)
            ->put(route('api.articles.update', ['article' => $article]), $newData);

        $oldData['category_id'] = $oldData['category'];
        unset($oldData['category']);

        $newData['category_id'] = $newData['category'];
        unset($newData['category']);

        // $this->assertDatabaseMissing('articles', $oldData);
        // $this->assertDatabaseHas('articles', $newData);

        $response->assertOk();
        $response->assertJsonFragment([
            'title' => $newData['title'],
            'content' => $newData['content']
        ]);
    }

    /** @test */
    public function user_can_delete_a_article()
    {
        $article = Article::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('api.articles.destroy', ['article' => $article]));

        $this->assertDatabaseMissing('articles', $article->toArray());

        $response->assertOk();
        $response->assertJsonFragment(['OK']);
    }
}
