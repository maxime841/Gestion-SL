<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PartyCreateRequest;
use App\Http\Requests\PartyUpdateRequest;

class PartyController extends Controller
{
    /**
     * get all partiess.
     * * 200 [parties]
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $parties = Party::all();
        foreach ($parties as $party) {
            foreach ($party->pictures as $picture) {
                if ($picture->favori == true) {
                    $party->picture = $picture;
                }
            }
        }
        return response()->json(['parties' => $parties], 200);
    }

    /**
     * get one party.
     * * 200 [party]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $party = Party::find($id);
        foreach ($party->pictures as $picture) {
            if ($picture->favori == true) {
                $party->picture = $picture;
            }
        }
        return response()->json(['party' => $party], 200);
    }

    /**
     * create party and add image if input image exist.
     * * 201 [party]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PartyCreateRequest $request): JsonResponse
    {

        $validate = $request->validated();
        Log::channel('stderr')->info('validation', $validate);
        $party = Party::create($validate);

        // for image upload on create party
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $party->id . 'party' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/parties',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $party->pictures()->save($picture);
        }

        $party->pictures;

        return response()->json(['party' => $party], 201);
    }

    /**
     * Update the specified resource in storage.
     * * 200 [party]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PartyUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $party = Party::find($request->id);
        $party->forceFill($validate)->save();
        $party->pictures;

        return response()->json(['party' => $party], 200);
    }

    /**
     * upload all images
     * * 200 [party]
     * * 401 [message]
     * * 422 [message, errors=>nameinput]
     *
     * @return JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $party = Party::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $party->id . 'party' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/parties',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $party->pictures()->save($picture);
        }

        $party->pictures;
        return response()->json(['party' => $party]);
    }

    /**
     * delete party.
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $party = Party::findOrFail($request->id);
        if ($party->djs()->exists()) {
            return response()->json([
                'message' => 'Cette soirée contient des djs, impossible de la supprimer',
                'delete' => false,
            ], 200);
        } else if ($party->dancers()->exists()) {
            return response()->json([
                'message' => 'Cette soirée contient des danseurs, impossible de la supprimer',
                'delete' => false,
            ], 200);
        } else if ($party->hosts()->exists()) {
            return response()->json([
                'message' => 'Cette soirée contient des hosts, impossible de la supprimer',
                'delete' => false,
            ], 200);
        }

        if (count($party->pictures)) {
            // delete all image file in project
            foreach ($party->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }

        // delete all image in database
        $party->pictures()->delete();
        // delete club
        $party->delete();

        return response()->json([
            'message' => 'La soirée a bien été supprimée',
            'delete' => true,
        ], 200);
    }
}
