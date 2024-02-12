<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index()
    {
        try {
            $articles = Article::with('category','user','tags')->get();
            // return $articles;
            return view('articles.index', compact('articles'));
        } catch (\Exception $e) {
            Log::error("Error retrieving articles: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Failed to retrieve articles');
        }
    }

    public function create()
    {
        $tags = Tag::all(); // Cargar todos los tags para seleccionar en el formulario
        $categories = Category::all(); // Cargar todas las categorias para seleccionar en el formulario
        return view('articles.create', compact('tags','categories'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        try {
            $params = [
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category,
                'user_id' => $request->user()->id,
            ];
            $article = Article::create($params);
            $article->tags()->attach($request->tags);

            return redirect('/')->with('success', 'Article created successfully');
        } catch (\Exception $e) {
            Log::error('Article store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save article');
        }
    }

    public function show($id)
    {
        try {
            $article = Article::findOrFail($id);
            $article = new ArticleResource($article);
            return view('articles.show', compact('article'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve article');
        }
    }

    public function edit($id)
    {
        try {
            $article = Article::findOrFail($id);
            $tags = Tag::all();
            return view('articles.edit', compact('article', 'tags'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Article not found');
        }
    }

    public function update(ArticleRequest $request, $id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->update($request->validated());
            $article->tags()->sync($request->tags); // Actualizar la asociación de tags

            return redirect()->route('articles.index')->with('success', 'Article updated successfully');
        } catch (\Exception $e) {
            Log::error("Error updating article: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Failed to update article');
        }
    }

    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->delete();
            return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
        } catch (\Exception $e) {
            Log::error("Error deleting article: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Failed to delete article');
        }
    }
}
