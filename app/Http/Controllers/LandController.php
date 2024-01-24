<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\House;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\LandCreateRequest;
use App\Http\Requests\LandUpdateRequest;

class LandController extends Controller
{
    /**
     * get all lands.
     * * 200 [lands]
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $lands = Land::all();
        foreach ($lands as $land) {
            foreach ($land->pictures as $picture) {
                if ($picture->favori == true) {
                    $land->picture_favoris = $picture;
                }
            }
        }
        return response()->json(['lands' => $lands], 200);
    }

    /**
     * get one land.
     * * 200 [land]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $land = Land::find($id);
        foreach ($land->pictures as $picture) {
            if ($picture->favori == true) {
                $land->picture_favoris = $picture;
            }
        }
        return response()->json(['land' => $land], 200);
    }

    /**
     * create land and add image if input image exist.
     * * 201 [land]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LandCreateRequest $request): JsonResponse
    {

        $validate = $request->validated();
        $validate['owner'] = $request->owner ?? null;
        $land = Land::create($validate);

        // for image upload on create land
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $land->id . 'land' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/lands',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $land->pictures()->save($picture);
        }

        $land->pictures;

        return response()->json(['land' => $land], 201);
    }

    /**
     * Update the specified resource in storage.
     * * 200 [land]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LandUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $validate['owner'] = $request->owner ?? null;

        $land = Land::find($request->id);
        $land->forceFill($validate)->save();
        $land->pictures;

        return response()->json(['land' => $land], 200);
    }

    /**
     * upload all images
     * * 200 [land]
     * * 401 [message]
     * * 422 [message, errors=>nameinput]
     *
     * @return JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $land = Land::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $land->id . 'land' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/lands',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $land->pictures()->save($picture);
        }

        $land->pictures;
        return response()->json(['land' => $land]);
    }

    /**
     * delete land.
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $land = Land::findOrFail($request->id);
        if (count($land->pictures)) {
            // delete all image file in project
            foreach ($land->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }

        // delete all image in database
        $land->pictures()->delete();
        // delete land
        $land->delete();

        return response()->json([
            'message' => 'Le terrain a bien été supprimé',
            'delete' => true,
        ], 200);
    }
}
