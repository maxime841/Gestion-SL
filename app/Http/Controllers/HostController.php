<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\HostCreateRequest;
use App\Http\Requests\HostUpdateRequest;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $hosts = Host::all();
        foreach ($hosts as $host) {
            foreach ($host->pictures as $picture) {
                if ($picture->favori == true) {
                    $host->picture = $picture;
                }
            }
        }
        return response()->json(['hosts' => $hosts]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $host =  Host::find($id);
        foreach ($host->pictures as $picture) {
            if ($picture->favori == true) {
                $host->picture = $picture;
            }
        }
        return response()->json(['host' => $host]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(HostCreateRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $host = Host::create($validate);

        // for image upload on create dancer
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $host->id . 'host' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/hosts',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $host->pictures()->save($picture);
        }

        $host->pictures;

        return response()->json(['host' => $host], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HostUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $host = Host::find($request->id);
        $host->forceFill($validate)->save();
        $host->pictures;

        return response()->json(['host' => $host], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $host = Host::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $host->id . 'host' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/hosts',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $host->pictures()->save($picture);
        }

        $host->pictures;
        return response()->json(['host' => $host]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $host = Host::findOrFail($request->id);
        if ($host->parties()->exists()) {
            return response()->json([
                'message' => 'Cet host appartient à une soirée, impossible de le supprimer',
                'delete' => false,
            ], 200);
        }

        if (count($host->pictures)) {
            // delete all image file in project
            foreach ($host->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }

        // delete all image in database
        $host->pictures()->delete();
        // delete host
        $host->delete();

        return response()->json([
            'message' => 'Le host a bien été supprimé',
            'delete' => true,
        ], 200);
    }
}
