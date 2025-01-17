<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except("index", "show");
    }

    /**
     * @OA\Get(
     *     path="/setting",
     *     tags={"Setting"},
     *     summary="",
     *     description="Get all data",
     *     operationId="setting_index",
     *     @OA\Parameter(
     *          name="per_page",
     *          description="per_page value is number. ex : ?per_page=10",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          description="page value is number. ex : ?page=1",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="sort",
     *          description="Sort value is string with rule column-name:order. ex : ?sort=id:asc",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="where",
     *          description="Where value is object. ex : ?where={'name':['john','doe'], 'dob':'1990-12-31'}",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="count",
     *          description="Count value is boolean. ex : ?count=true",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Get Data Successfull",
     *                  "data"={},
     *                  "pagination"={"total_data":"", "per_page":"", "total_page":"", "page":""}
     *              }
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        // parameter
        $count = $request->has('count') ? $request->get('count') : false;
        $sort = $request->has('sort') ? $request->get('sort') : 'id:desc';
        $where = $request->has('where') ? $request->get('where') : '{}';
        $search = $request->has('search') ? $request->get('search') : '';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 50;
        $page = $request->has('page') ? $request->get('page') : 1;

        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query
        $query = Setting::where([['id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        if($where){
            foreach($where as $key => $value) {
                if (is_array($value)) {
                    $query = $query->whereIn($key, $value);
                } else {
                    $query = $query->where($key, $value);
                }
            }
        }

        if($search){
            $query = $query->whereAny(['name'], 'like', "%{$search}%");
        }

        // data
        $data = [];
        $pagination = [];

        // pagination
        $pagination['total_data'] = $query->count('id');
        $pagination['per_page'] = $per_page;
        $pagination['total_page'] = ceil($pagination['total_data'] / $pagination['per_page']);
        $pagination['page'] = $page;

        // get count
        if($count == true) {
            $query = $query->count('id');
            $data['count'] = $query;
        }
        // get data
        else {
            $query = $query
                ->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page-1) * $per_page)
                ->get()
                ->toArray();

            foreach($query as $qry) {
                $temp = $qry;
                array_push($data, $temp);
            };
        }

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

    /**
     * @OA\Get(
     *     path="/setting/{id}",
     *     tags={"Setting"},
     *     summary="",
     *     description="Get data by id",
     *     operationId="setting_show",
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Get Data Successfull",
     *                  "data"={},
     *                  "pagination"={}
     *              }
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        // query
        $query = Setting::where([['id','>','0']]);

        // cek token
        if(!auth()->guard('api')->user()) {
            $query = $query->where('is_active', 1);
        }

        // data
        $data = $query->find($id);

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 'No data found', [], []);
        }
    }

    /**
     * @OA\Post(
     *     path="/setting",
     *     tags={"Setting"},
     *     summary="",
     *     description="Insert data",
     *     operationId="setting_store",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="key",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="value",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="is_wysiwyg",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Insert Data Successfull",
     *                  "data"={},
     *                  "pagination"={}
     *              }
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);

        $req = $request->post();
        $data = Setting::create($req);

        if($data) {
            return new ApiResource(true, 'Insert data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 'Failed to insert data', [], []);
        }
    }

    /**
     * @OA\Put(
     *     path="/setting/{id}",
     *     tags={"Setting"},
     *     summary="",
     *     description="Update data",
     *     operationId="setting_update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="key",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="value",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="is_wysiwyg",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Update Data Successfull",
     *                  "data"={},
     *                  "pagination"={}
     *              }
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);

        $req = $request->post();
        $query = Setting::findOrFail($id);
        $query->update($req);

        $data = Setting::findOrFail($id);

        if($data) {
            return new ApiResource(true, 'Update data successfull', $data->toArray(), []);
        } else {
            return new ApiResource(false, 'Failed to update data', [], []);
        }
    }

    /**
     * @OA\Delete(
     *     path="/setting/{id}",
     *     tags={"Setting"},
     *     summary="",
     *     description="Delete data",
     *     operationId="setting_destroy",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="OK",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              example={
     *                  "success"=true,
     *                  "message"="Delete Data Successfull",
     *                  "data"={},
     *                  "pagination"={}
     *              }
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $query = Setting::findOrFail($id);
        $query->delete();

        if($query) {
            return new ApiResource(true, 'Delete data successfull', [], []);
        } else {
            return new ApiResource(false, 'Failed to delete data', [], []);
        }
    }
}
