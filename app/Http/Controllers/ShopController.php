<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ShopCreateRequest;
use App\Http\Requests\ShopUpdateRequest;

class ShopController extends Controller
{
     /**
     * get all shops.
     * * 200 [shops]
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $shops = Shop::all();
        foreach ($shops as $shop) {
            foreach ($shop->pictures as $picture) {
                if ($picture->favori == true) {
                    $shop->picture = $picture;
                }
            }
            // recover party
            $shop->articles;
        
            // recover pictures of articles
            foreach ($shop->articles as $article) {
                foreach ($article->pictures as $picture) {
                    // filter favoris picture of party
                    if ($picture->favori == true) {
                        $article->picture = $picture;
                    }
                }
            };
        }
        return response()->json(['shops' => $shops], 200);
    }

    /**
     * get one shop.
     * * 200 [shop]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $shop = Shop::find($id);
        foreach ($shop->pictures as $picture) {
            if ($picture->favori == true) {
                $shop->picture = $picture;
            }
            // recover article
            $shop->articles;
            // recover pictures of party
            foreach ($shop->articles as $article) {
                foreach ($article->pictures as $picture) {
                    // filter favoris picture of article
                    if ($picture->favori == true) {
                        $article->picture = $picture;
                    }
                }
            };
        }
        return response()->json(['shop' => $shop], 200);
    }

    /**
     * create shop and add image if input image exist.
     * * 201 [cshop]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ShopCreateRequest $request): JsonResponse
    {

        $validate = $request->validated();
        $shop = Shop::create($validate);

        // for image upload on create shop
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $shop->id . 'shop' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/shops',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $shop->pictures()->save($picture);
        }

        $shop->pictures;

        return response()->json(['shop' => $shop], 201);
    }

    /**
     * Update the specified resource in storage.
     * * 200 [shop]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $shop = Shop::find($request->id);
        $shop->forceFill($validate)->save();
        $shop->pictures;

        return response()->json(['shop' => $shop], 200);
    }

    /**
     * upload all images
     * * 200 [shop]
     * * 401 [message]
     * * 422 [message, errors=>nameinput]
     *
     * @return JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $shop = Shop::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $shop->id . 'shop' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/shops',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $shop->pictures()->save($picture);
        }

        $shop->pictures;
        return response()->json(['shop' => $shop]);
    }

    /**
     * delete shop.
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $shop = Shop::findOrFail($request->id);
        if ($shop->articles()->exists()) {
            return response()->json([
                'message' => 'Ce club contient des articles, impossible de le supprimer',
                'delete' => false,
            ], 200);
        }

        if (count($shop->pictures)) {
            // delete all image file in project
            foreach ($shop->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }
        
        // delete all image in database
        $shop->pictures()->delete();
        // delete all commentaire in database
        $shop->commentaires()->delete();
        // delete club
        $shop->delete();

        return response()->json([
            'message' => 'Le shop a bien été supprimé',
            'delete' => true,
        ], 200);
    }
}
