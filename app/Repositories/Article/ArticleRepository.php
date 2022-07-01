<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Models\User;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepository
{
    public function all(): LengthAwarePaginator;
    public function storeArticle(User $user, StoreArticleRequest $request): Article;
    public function updateArticle(Article $article, UpdateArticleRequest $request): Article;
    public function deleteArticle(Article $article): bool;
}
