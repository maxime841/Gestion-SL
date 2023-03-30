<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ActivityCreateRequest;
use App\Http\Requests\ActivityUpdateRequest;

class ActivityController extends Controller
{
     /**
     * get all activities.
     * * 200 [activities]
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(): JsonResponse
    {
        $activities = Activity::all();
        foreach ($activities as $activity) {
            foreach ($activity->pictures as $picture) {
                if ($picture->favori == true) {
                    $activity->picture = $picture;
                }
            }
        }
        return response()->json(['activities' => $activities], 200);
    }

    /**
     * get one activity.
     * * 200 [activity]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id): JsonResponse
    {
        $activity = Activity::find($id);
        foreach ($activity->pictures as $picture) {
            if ($picture->favori == true) {
                $activity->picture = $picture;
            }
        }
        return response()->json(['activity' => $activity], 200);
    }

    /**
     * create activity and add image if input image exist.
     * * 201 [activity]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ActivityCreateRequest $request): JsonResponse
    {

        $validate = $request->validated();
        $activity = Activity::create($validate);

        // for image upload on create activity
        if ($request->image) {
            $file = $request->file('image');
            $extension = $file->extension();
            $nameImage = $activity->id . 'activity' . uniqid() . '.' . $extension;

            $path = $request->file('image')->storeAs(
                'public/images/activities',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => true,
            ]);

            $activity->pictures()->save($picture);
        }

        $activity->pictures;

        return response()->json(['activity' => $activity], 201);
    }

    /**
     * Update the specified resource in storage.
     * * 200 [activity]
     * * 422 [message, errors=>nameinput]
     * * 401 [message]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityUpdateRequest $request): JsonResponse
    {
        $validate = $request->validated();

        $activity = Activity::find($request->id);
        $activity->forceFill($validate)->save();
        $activity->pictures;

        return response()->json(['activity' => $activity], 200);
    }

    /**
     * upload all images
     * * 200 [activity]
     * * 401 [message]
     * * 422 [message, errors=>nameinput]
     *
     * @return JsonResponse
     */
    public function uploadFiles(Request $request)
    {
        $request->validate(['images' => 'required']);
        $activity = Activity::find($request->id);

        foreach ($request->file('images') as $image) {
            $extension = $image->extension();
            $nameImage = $activity->id . 'activity' . uniqid() . '.' . $extension;

            $path = $image->storeAs(
                'public/images/activities',
                $nameImage
            );

            $picture = Picture::create([
                'name' => $nameImage,
                'picture_url' => $path,
                'favori' => false,
            ]);

            $activity->pictures()->save($picture);
        }

        $activity->pictures;
        return response()->json(['activity' => $activity]);
    }

    /**
     * delete activity.
     * * 200 [message, delete]
     * * 401 [message]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): JsonResponse
    {
        $activity = Activity::findOrFail($request->id);
        if (count($activity->pictures)) {
            // delete all image file in project
            foreach ($activity->pictures as $picture) {
                Storage::delete($picture->picture_url);
            }
        }

        // delete all image in database
        $activity->pictures()->delete();
        // delete activity
        $activity->delete();

        return response()->json([
            'message' => 'L activité a bien été supprimé',
            'delete' => true,
        ], 200);
    }
}
