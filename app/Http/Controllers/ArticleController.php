<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;

class ArticleController extends Controller
{
    /**
     * get all articles.
     * * 200 [articles]
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $articles = Article::all();
        foreach ($articles as $article) {
            foreach ($article->pictures as $picture) {
                if ($picture->favori == true) {
                    $article->picture = $picture;
                }
            }
        }
        return response()->json(['articles' => $articles], 200);
    }

    /**
     * get one article.
     * * 200 [article]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $article = Article::find($id);
        foreach ($article->pictures as $picture) {
            if ($picture->favori == true) {
                $article->picture = $picture;
            }
        }
        return response()->json(['article' => $article], 200);
    }

    /**
     * create article and add image if input image exist.
     * * 201 [article]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ArticleCreateRequest $request): JsonResponse
    {

        $validate = $request->validated();
        $article = Article::create($validate);

        // for image upload on create article
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $article->id . 'article' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/articles',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $article->pictures()->save($picture);
        }

        $article->pictures;

        return response()->json(['article' => $article], 201);
    }

    /**
     * Update the specified resource in storage.
     * * 200 [article]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $article = Article::find($request->id);
        $article->forceFill($validate)->save();
        $article->pictures;

        return response()->json(['article' => $article], 200);
    }

    /**
     * upload all images
     * * 200 [article]
     * * 401 [message]
     * * 422 [message, errors=>nameinput]
     *
     * @return JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $article = Article::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $article->id . 'article' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/articles',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $article->pictures()->save($picture);
        }

        $article->pictures;
        return response()->json(['article' => $article]);
    }

    /**
     * delete article.
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $article = Article::findOrFail($request->id);
        if (count($article->pictures)) {
            // delete all image file in project
            foreach ($article->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }

        // delete all image in database
        $article->pictures()->delete();
        // delete article
        $article->delete();

        return response()->json([
            'message' => 'L article a bien été supprimé',
            'delete' => true,
        ], 200);
    }
}
