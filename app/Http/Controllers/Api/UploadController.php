<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\FileResize;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UploadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(
     *     path="/upload",
     *     tags={"Upload"},
     *     summary="",
     *     description="Upload file",
     *     operationId="upload",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="documentType",
     *                      description="documentType",
     *                      type="file"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "error"=false,
     *                  "message"="Upload Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */

    public function upload(Request $request){

        if($request->hasFile('file')) {
            $image = $request->file('file');
            $file = $image->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $size = $request->file('file')->getSize();

            setlocale(LC_TIME, 'IND');
            $date_format = Carbon::now()->format('Ymd_His');
            $filename_new = $date_format.'-'.str_replace(' ','_', $filename).'.'.$extension;

            ImageManager::gd()->read($image->getRealPath())->save(public_path('uploads/' .$filename_new));
            ImageManager::gd()->read($image->getRealPath())->scale(300, 300)->save(public_path('uploads/thumb/' .$filename_new));

            $upload = [];
            $upload['originalName'] = $filename;
            $upload['mimeType'] = $extension;
            $upload['fileSize'] = $size;
            $upload['fileName'] = $filename_new;
            $upload['path'] = url('/') . '/uploads/' . $filename_new;
            $upload['pathThumbnail'] = url('/') . '/uploads/thumb/' . $filename_new;

            $result = [];
            $result['status'] = true;
            $result['message'] = 'Upload Successfull';
            $result['data'] = $upload;

            return $result;
        } else {
            $result = [];
            $result['status'] = false;
            $result['message'] = 'Upload Failed';
            $result['data'] = [];

            return $result;
        }
        // $now = \Carbon\Carbon::now()->format('Y-m-d_H:i:s');
        // $md5 = md5($now);

        // $originalPath = public_path().'/uploads/';
        // $originalImage= $request->file('file');
        // $thumbnailImage = Image::make($originalImage);
        // $thumbnailImage->save($originalPath.$md5.'.'.$originalImage->getClientOriginalExtension());

        // $thumbnailPath = public_path().'/uploads/thumb/';
        // $thumbnailImage->resize(250, null, function ($constraint) {$constraint->aspectRatio();});
        // $thumbnailImage->save($thumbnailPath.$md5.'.'.$originalImage->getClientOriginalExtension());

        // $upload = [];
        // $upload['originalName'] = $originalImage->getClientOriginalName();
        // $upload['mimeType'] = $originalImage->getClientOriginalExtension();
        // $upload['fileSize'] = $originalImage->getSize();
        // $upload['fileName'] = $md5.'.'.$originalImage->getClientOriginalExtension();
        // $upload['path'] = url('/') . '/uploads/' . $md5.'.'.$originalImage->getClientOriginalExtension();
        // $upload['pathThumbnail'] = url('/') . '/uploads/thumb/' . $md5.'.'.$originalImage->getClientOriginalExtension();

        // $result = [];
        // $result['status'] = true;
        // $result['message'] = 'Upload Successfull';
        // $result['data'] = $upload;

        return $result;

        return back()->with('status', 'Your images has been successfully Upload');

    }

    public function sendEmail(Request $request) {

        $to = $request->has('to') ? $request->get('to') : 'admin@desaqu.com';
        $subject = $request->has('subject') ? $request->get('to') : 'test subject';
        $text = $request->has('text') ? $request->get('text') : 'test text';

        try {
            Mail::send([], [], function ($message) use ($to, $text, $subject) {
                $message->to($to)
                    ->subject($subject)
                    ->from('admin@desaqu.com')
                    ->setBody($text, 'text/html');
            });
            if (Mail::failures()) {
                error_log(Mail::failures());
            } else {
                error_log('mail success');
            }
        }
        catch(Exception $e) {
            error_log($e);
        }
    }
}
