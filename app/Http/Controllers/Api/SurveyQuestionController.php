<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurveyQuestion;
use App\Http\Resources\ApiResource;

class SurveyQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/api/survey_question",
     *     tags={"SurveyQuestion"},
     *     summary="",
     *     description="Get all data",
     *     operationId="survey_question_index",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="per_page",
     *          description="Per Page value is number. ex : ?per_page=10",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          description="Page value is number. ex : ?page=2",
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
     *          description="Where value is object. ex : ?where={'name':'john', 'dob':'1990-12-31'}",
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
     *                  "status"=true,
     *                  "message"="Get Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        // parameter
        $where = $request->has('where') ? $request->get('where') : '{}';
        $sort = $request->has('sort') ? $request->get('sort') : 'id:asc';
        $per_page = $request->has('per_page') ? $request->get('per_page') : 10;
        $page = $request->has('page') ? $request->get('page') : 1;
        $count = $request->has('count') ? $request->get('count') : false;
        $search = $request->has('search') ? $request->get('search') : '';

        // prepare parameter
        $sort = explode(':', $sort);
        $where = str_replace("'", "\"", $where);
        $where = json_decode($where, true);

        // query get
        $query = SurveyQuestion::where([['id','>','0']]);

        // query where
        if($where){
            foreach($where as $key => $value) {
                $query = $query->where($key, '=', $value);
            }
        }

        // query search
        if($search){
            $query = $query->where(function ($query) use ($search){
                $query->where('question', 'ILIKE', '%'.$search.'%')
                ->orWhere('description', 'ILIKE', '%'.$search.'%');
            });
        }

        // variable data
        $datas = [];

        // pagination
        $pagination = [];
        $pagination['page'] = (int)$page;
        $pagination['per_page'] = (int)$per_page;
        $pagination['total_data'] = $query->count('id');
        $pagination['total_page'] = ceil($pagination['total_data'] / $pagination['per_page']);

        // count
        if($count == true)
        {
            $query = $query->count('id');
            $datas['count'] = $query;
        }
        // get data
        else
        {
            $query = $query
                ->orderBy($sort[0], $sort[1])
                ->limit($per_page)
                ->offset(($page - 1) * $per_page)
                ->get()
                ->toArray();

            foreach($query as $qry) {
                $temp = $qry;
                array_push($datas, $temp);
            };
        }

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }

    /**
     * @OA\Get(
     *     path="/api/survey_question/{id}",
     *     tags={"SurveyQuestion"},
     *     summary="",
     *     description="Get data by id",
     *     operationId="survey_question_show",
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
     *                  "message"="Get Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        // query get by id
        $query = SurveyQuestion::find($id);

        // variable data
        $datas = $query;

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data By Id Successfull', $datas, $pagination);
    }

    /**
     * @OA\Post(
     *     path="/api/survey_question",
     *     tags={"SurveyQuestion"},
     *     summary="",
     *     description="Insert data",
     *     operationId="survey_question_store",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
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
     *                  "success"=true,
     *                  "message"="Insert Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        // variable data
        $datas = $request->all();

        // query insert
        $query = SurveyQuestion::create($datas);

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Insert Data Successfull', $query, $pagination);
    }

    /**
     * @OA\Put(
     *     path="/api/survey_question/{id}",
     *     tags={"SurveyQuestion"},
     *     summary="",
     *     description="Update data",
     *     operationId="survey_question_update",
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
     *                      property="name",
     *                      type="string"
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
     *                  "success"=true,
     *                  "message"="Update Data Successfull",
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // variable data
        $datas = $request->all();

        // query insert
        $query = SurveyQuestion::findOrFail($id);
        $query = $query->update($datas);

        // get after update
        $query = SurveyQuestion::find($id);

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Update Data Successfull', $query, $pagination);
    }

    /**
     * @OA\Delete(
     *     path="/api/survey_question/{id}",
     *     tags={"SurveyQuestion"},
     *     summary="",
     *     description="Delete data",
     *     operationId="survey_question_destroy",
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
     *                  "data"={}
     *              }
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        // query insert
        $query = SurveyQuestion::findOrFail($id);
        $query = $query->delete();

        // variable data
        $datas = [];

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Delete Data Successfull', $datas, $pagination);
    }
}
