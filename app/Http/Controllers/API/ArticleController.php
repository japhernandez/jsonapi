<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * @return ResourceCollection
     */
    public function index()
    {
        $articles = Article::applyFilters()->applySorts()->jsonPaginate();
        return ResourceCollection::make($articles);
    }

    /**
     * @param Article $article
     * @return ResourceObject
     */
    public function show(Article $article)
    {
        return ResourceObject::make($article);
    }
}
