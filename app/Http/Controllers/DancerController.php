<?php

namespace App\Http\Controllers;

use App\Models\Dancer;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DancerCreateRequest;
use App\Http\Requests\DancerUpdateRequest;

class DancerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $dancers = Dancer::all();
        foreach ($dancers as $dancer) {
            foreach ($dancer->pictures as $picture) {
                if ($picture->favori == true && $picture->picturable_id == $dancer->id) {
                    $dancer->picture = $picture;
                }
            }
        }
        return response()->json(['dancers' => $dancers]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $dancer =  Dancer::find($id);
        foreach ($dancer->pictures as $picture) {
            if ($picture->picturable_type == 'dancer') {
                $dancer->picture = $picture;
            }
        }
        return response()->json(['dancer' => $dancer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DancerCreateRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $dancer = Dancer::create($validate);

        // for image upload on create dancer
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $dancer->id . 'dancer' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/dancers',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $dancer->pictures()->save($picture);
        }

        $dancer->pictures;

        return response()->json(['dancer' => $dancer], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DancerUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $dancer = Dancer::find($request->id);
        $dancer->forceFill($validate)->save();
        $dancer->pictures;

        return response()->json(['dancer' => $dancer], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $dancer = Dancer::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $dancer->id . 'dancer' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/dancers',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $dancer->pictures()->save($picture);
        }

        $dancer->pictures;
        return response()->json(['dancer' => $dancer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $dancer = Dancer::findOrFail($request->id);
        if ($dancer->parties()->exists()) {
            return response()->json([
                'message' => 'Ce danseur appartient à une soirée, impossible de le supprimer',
                'delete' => false,
            ], 200);
        }

        if (count($dancer->pictures)) {
            // delete all image file in project
            foreach ($dancer->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }

        // delete all image in database
        $dancer->pictures()->delete();
        // delete club
        $dancer->delete();

        return response()->json([
            'message' => 'Le danseur a bien été supprimé',
            'delete' => true,
        ], 200);
    }
}
