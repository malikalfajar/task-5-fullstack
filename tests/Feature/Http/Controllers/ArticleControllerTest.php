<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
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

        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(ArticleRepository::class, EloquentArticleRepository::class);
    }


    /** @test */
    public function user_can_view_articles_list()
    {
        $articles = Article::factory(5)->create();

        $response = $this->actingAs($this->user)
            ->get(route('articles.index'));

        $response->assertOk();
        $response->assertViewHas('articles');
        $response->assertSeeText($articles->random()->title);
    }

    /** @test */
    public function user_can_view_a_article_detail()
    {
        $article = Article::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('articles.show', ['article' => $article]));

        $response->assertOk();
        $response->assertViewHas('article');
        $response->assertSeeText($article->title);
        $response->assertSeeText($article->content);
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
            ->post(route('articles.store'), $data);

        $data['category_id'] = $data['category'];
        unset($data['category']);

        $data['user_id'] = $this->user->id;

        $this->assertDatabaseHas('articles', $data);

        $response->assertRedirect(route('articles.show', ['article' => 1]));
    }

    /** @test */
    public function user_can_update_a_article()
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
            ->put(route('articles.update', ['article' => $article]), $newData);

        $oldData['category_id'] = $oldData['category'];
        unset($oldData['category']);

        $newData['category_id'] = $newData['category'];
        unset($newData['category']);

        $this->assertDatabaseMissing('articles', $oldData);
        $this->assertDatabaseHas('articles', $newData);

        $response->assertRedirect(route('articles.show', ['rticle' => $article]));
    }

    /** @test */
    public function user_can_delete_a_article()
    {
        $article = Article::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('articles.destroy', ['article' => $article]));

        $this->assertDatabaseMissing('articles', $article->toArray());

        $response->assertRedirect(route('articles.index'));
    }
}
