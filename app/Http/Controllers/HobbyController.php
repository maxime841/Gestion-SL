<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\HobbyCreateRequest;
use App\Http\Requests\HobbyUpdateRequest;

class HobbyController extends Controller
{
      /**
     * get all hobbies.
     * * 200 [hobbies]
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $hobbies = Hobby::all();
        foreach ($hobbies as $hobby) {
            foreach ($hobby->pictures as $picture) {
                if ($picture->favori == true) {
                    $hobby->picture = $picture;
                }
            }
            // recover activities
            $hobby->activities;
        
            // recover pictures of activities
            foreach ($hobby->activities as $activity) {
                foreach ($activity->pictures as $picture) {
                    // filter favoris picture of activity
                    if ($picture->favori == true) {
                        $activity->picture = $picture;
                    }
                }
            };
        }
        return response()->json(['hobbies' => $hobbies], 200);
    }

    /**
     * get one hobby.
     * * 200 [hobby]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $hobby = Hobby::find($id);
        foreach ($hobby->pictures as $picture) {
            if ($picture->favori == true) {
                $hobby->picture = $picture;
            }
            // recover article
            $hobby->activities;
            // recover pictures of activity
            foreach ($hobby->activities as $activity) {
                foreach ($activity->pictures as $picture) {
                    // filter favoris picture of activity
                    if ($picture->favori == true) {
                        $activity->picture = $picture;
                    }
                }
            };
        }
        return response()->json(['hobby' => $hobby], 200);
    }

    /**
     * create shop and add image if input image exist.
     * * 201 [hobby]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @return \Illuminate\Http\Response
     */
    public function create(HobbyCreateRequest $request): JsonResponse
    {

        $validate = $request->validated();
        $hobby = Hobby::create($validate);

        // for image upload on create hobby
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $hobby->id . 'hobby' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/hobbies',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $hobby->pictures()->save($picture);
        }

        $hobby->pictures;

        return response()->json(['hobby' => $hobby], 201);
    }

    /**
     * Update the specified resource in storage.
     * * 200 [hobby]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HobbyUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $hobby = Hobby::find($request->id);
        $hobby->forceFill($validate)->save();
        $hobby->pictures;

        return response()->json(['hobby' => $hobby], 200);
    }

    /**
     * upload all images
     * * 200 [hobby]
     * * 401 [message]
     * * 422 [message, errors=>nameinput]
     *
     * @return JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $hobby = Hobby::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $hobby->id . 'hobby' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/hobbies',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $hobby->pictures()->save($picture);
        }

        $hobby->pictures;
        return response()->json(['hobby' => $hobby]);
    }

    /**
     * delete hobby.
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $hobby = Hobby::findOrFail($request->id);
        if ($hobby->activities()->exists()) {
            return response()->json([
                'message' => 'Ce terrain de loisir contient des activités, impossible de le supprimer',
                'delete' => false,
            ], 200);
        }

        if (count($hobby->pictures)) {
            // delete all image file in project
            foreach ($hobby->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }
        
        // delete all image in database
        $hobby->pictures()->delete();
        // delete all commentaire in database
        $hobby->commentaires()->delete();
        // delete club
        $hobby->delete();

        return response()->json([
            'message' => 'Le terrain de loisir a bien été supprimé',
            'delete' => true,
        ], 200);
    }
}
