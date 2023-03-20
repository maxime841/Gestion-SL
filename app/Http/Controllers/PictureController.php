<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class PictureController extends Controller
{
    /**
     * update picture
     * * 200 [message]
     * * 404 [message]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @return JsonResponse
     */
    public function updateImage(Request $request): JsonResponse
    {
        // validate request
        $request->validate(['image' => 'required']);
        // get picture
        $picture = Picture::findOrFail($request->id);
        // delete picture file in project
        Storage::delete($picture->picture_url);
        // upload new image
        if ($request->image) {
            // add image file in project
            $path = $request->file('image')->storeAs(
                'public/images/lands',
                $picture->name
            );

            // update url in database
            $picture->picture_url = $path;
        }
        return response()->json(['message' => "L'image a bien été modifié"], 200);
    }

    /**
     * change value of favori for picture
     * * 200 [message]
     * * 404 [message]
     * * 401 [message]
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateFavori(Request $request): JsonResponse
    {
        $picture = Picture::findOrFail($request->id);
        $picture->favori = $request->favori;
        $picture->save();
        if ($request->favori) {
            return response()->json(['message' => "L'image a bien été mis en favori"], 200);
        } else {
            return response()->json(['message' => "L'image a bien été supprimée des favoris"], 200);
        }
    }

    /**
     * delete picture
     * * 200 [message]
     * * 404 [message]
     * * 401 [message]
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $picture = Picture::findOrFail($request->id);
        Storage::delete($picture->picture_url);
        $picture->delete();

        return response()->json(['message' => "L'image a bien été supprimé"], 200);
    }
}
