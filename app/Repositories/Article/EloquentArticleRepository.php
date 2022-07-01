<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentArticleRepository implements ArticleRepository
{
    public function all(): LengthAwarePaginator
    {
        return Article::latest('updated_at')->paginate(5);
    }

    public function storeArticle(User $user, StoreArticleRequest $request): Article
    {
        $fileName = $this->saveImage($request);

        return $user->articles()->create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category,
            'image' => $fileName
        ]);
    }

    public function updateArticle(Article $article, UpdateArticleRequest $request): Article
    {
        $fileName = $this->saveImage($request) ?? $article->image;

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category,
            'image' => $fileName
        ]);

        return $article;
    }

    public function deleteArticle(Article $article): bool
    {
        return $article->delete();
    }

    private function saveImage(FormRequest $request): string|null
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');
        $fileName = Str::slug($request->title, '-') . '-' . $file->hashName();

        $file->storeAs('public', $fileName);

        return $fileName;
    }
}
