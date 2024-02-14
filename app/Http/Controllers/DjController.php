<?php

namespace App\Http\Controllers;

use App\Models\Dj;
use App\Models\User;
use App\Models\Picture;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\DjCreateRequest;
use App\Http\Requests\DjUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CommentDjCreateRequest;

class DjController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $djs = Dj::all();
        foreach ($djs as $dj) {
            foreach ($dj->pictures as $picture) {
                if ($picture->favori == true) {
                    $dj->picture = $picture;
                }
            }

            $dj->commentaires;
            // recover pictures of commentaires
            foreach ($dj->commentaires as $commentaire) {
                foreach ($commentaire->pictures as $picture) {
                    // filter favoris picture of commentaire
                    if ($picture->favori == true) {
                        $commentaire->picture = $picture;
                    }
                }

            };
        }
        return response()->json(['djs' => $djs]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $dj =  Dj::find($id);
        foreach ($dj->pictures as $picture) {
            if ($picture->favori == true) {
                $dj->picture = $picture;
            }
            $dj->commentaires;
        }
        return response()->json(['dj' => $dj]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DjCreateRequest $request): JsonResponse
    {
        $validate = $request->validated();
        $dj = Dj::create($validate);

        // for image upload on create dj
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $dj->id . 'dj' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/djs',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $dj->pictures()->save($picture);
        }

        $dj->pictures;

        return response()->json(['dj' => $dj], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DjUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $dj = Dj::find($request->id);
        $dj->forceFill($validate)->save();
        $dj->pictures;

        return response()->json(['dj' => $dj], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $dj = Dj::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $dj->id . 'dj' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/djs',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $dj->pictures()->save($picture);
        }

        $dj->pictures;
        return response()->json(['dj' => $dj]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $dj = Dj::findOrFail($request->id);
        if ($dj->parties()->exists()) {
            return response()->json([
                'message' => 'Ce dj appartient à une soirée, impossible de le supprimer',
                'delete' => false,
            ], 200);
        }

        if (count($dj->pictures)) {
            // delete all image file in project
            foreach ($dj->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }
        // delete all image in database
        $dj->pictures()->delete();
        // delete club
        $dj->delete();

        return response()->json([
            'message' => 'Le dj a bien été supprimé',
            'delete' => true,
        ], 200);
    }

    public function addCommentaireDj(Dj $dj, CommentDjCreateRequest $request)
    {
        $commentaire = new Commentaire();
        $commentaire->title = $request->title;
        $commentaire->content = $request->content;
        // $commentaire->user_id = $request->user_id;
        $commentaire->user()->associate($request->user());
        $user = User::find($request->user_id);
        $dj = Dj::find($request->id);
        $dj->commentaires()->save($commentaire, $user);

        return response()->json([
            'message' => 'Le commentaire du dj a bien était ajouté',
        ], 200);

    }
}
