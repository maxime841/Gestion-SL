<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Picture;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CommentClubCreateRequest;
// use App\Http\Requests\CommentUpdateRequest;

class CommentaireController extends Controller
{
     /**
     * get all commentaires.
     * * 200 [commentaires]
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $commentaires = Commentaire::all();
        foreach ($commentaires as $commentaire) {
            foreach ($commentaire->pictures as $picture) {
                if ($picture->favori == true) {
                    $commentaire->picture = $picture;
                }
            }
        }
        return response()->json(['commentaires' => $commentaires], 200);
    }

    /**
     * get one commentaire.
     * * 200 [commentaire]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function getOne($id): JsonResponse
    {
        $commentaire = Commentaire::find($id);
        foreach ($commentaire->pictures as $picture) {
            if ($picture->favori == true) {
                $commentaire->picture = $picture;
            }
        }
        return response()->json(['commentaire' => $commentaire], 200);
    }

    /**
     * create club and add image if input image exist.
     * * 201 [club]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CommentClubCreateRequest $request, $id)//: JsonResponse
    {
        $club = Club::find($id);
        Commentaire::create([
            //'user_id' => Auth()->id,
            'title' => $club->commentaire->title,
            'comment_id' => $club->commentaire->id,
            'commentClub' => $request('commentClub')
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     * * 200 [club]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(/*commentClubUpdateRequest*/ $request): JsonResponse
    {
        $validate = $request->validated();

        $commentaire = Commentaire::find($request->id);
        $commentaire->forceFill($validate)->save();
        $commentaire->pictures;

        return response()->json(['commentaire' => $commentaire], 200);
    }

    /**
     * upload all images
     * * 200 [club]
     * * 401 [message]
     * * 422 [message, errors=>nameinput]
     *
     * @return JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $commentaire = Commentaire::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $commentaire->id . 'commentaire' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/commentaires',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $commentaire->pictures()->save($picture);
        }

        $commentaire->pictures;
        return response()->json(['commentaire' => $commentaire]);
    }

    /**
     * delete club.
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $commentaire = Commentaire::findOrFail($request->id);
        if (count($commentaire->pictures)) {
            // delete all image file in project
            foreach ($commentaire->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }
        
        // delete all image in database
        $commentaire->pictures()->delete();
        // delete club
        $commentaire->delete();

        return response()->json([
            'message' => 'Le commentaire a bien été supprimé',
            'delete' => true,
        ], 200);
    }
}
