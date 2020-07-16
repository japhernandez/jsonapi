<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_single_article()
    {
        // Deshabilitamos las excepciones que captura Laravel
        // para tener un error mas claro
        $this->withoutExceptionHandling();

        // 1. Give => Teniendo un listado de articulos
        $article = factory(Article::class)->create();
        // 2. When => Cuando llamo al uri, me devuelve un articulo por el id
        $response = $this->jsonApi()->get(route('api.v1.articles.read', $article));
        // 3. Then => Entonces retorno ese articulo con el formato de acuerdo a la especificacion JSON
        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string)$article->getRouteKey(),
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content
                ],
                'links' => [
                    'self' => route('api.v1.articles.read', $article)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_article()
    {
        // Deshabilitamos las excepciones que captura Laravel
        // para tener un error mas claro
        $this->withoutExceptionHandling();

        // 1. Give => Teniendo un listado de articulos
        $articles = factory(Article::class)->times(3)->create();
        // 2. When => Cuando llamo al uri, me devuelve un tres articulos
        $response = $this->jsonApi()->get(route('api.v1.articles.index'));
        // 3. Then => Entonces retorno ese articulo en una respuesta en formato JSON
        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'articles',
                    'id' => (string)$articles[0]->getRouteKey(),
                    'attributes' => [
                        'title' => $articles[0]->title,
                        'slug' => $articles[0]->slug,
                        'content' => $articles[0]->content
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.read', $articles[0])
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => (string)$articles[1]->getRouteKey(),
                    'attributes' => [
                        'title' => $articles[1]->title,
                        'slug' => $articles[1]->slug,
                        'content' => $articles[1]->content
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.read', $articles[1])
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => (string)$articles[2]->getRouteKey(),
                    'attributes' => [
                        'title' => $articles[2]->title,
                        'slug' => $articles[2]->slug,
                        'content' => $articles[2]->content
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.read', $articles[2])
                    ]
                ]
            ]
        ]);
    }
}
