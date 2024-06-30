<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\Election;
use App\Models\AreaKelurahan;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Http;

class VoterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/api/voter",
     *     tags={"Voter"},
     *     summary="",
     *     description="Get all data",
     *     operationId="voter_index",
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
        $query = Voter::select(
            'voters.*',
            'area_kelurahan.kemendagri_provinsi_nama as provinsi_nama',
            'area_kelurahan.kemendagri_kota_nama as kota_nama',
            'area_kelurahan.kemendagri_kecamatan_nama as kecamatan_nama',
            'area_kelurahan.kemendagri_kelurahan_nama as kelurahan_nama',
            'c.name as created_name',
            'u.name as updated_name')
            ->join('area_kelurahan', 'voters.kelurahan_kode', '=', 'area_kelurahan.kemendagri_kelurahan_kode')
            ->join('users as c', 'c.id', '=', 'voters.created_by')
            ->join('users as u', 'u.id', '=', 'voters.updated_by');

        // query where
        if($where){
            foreach($where as $key => $value) {
                $query = $query->where('voters.'.$key, '=', $value);
            }
        }

        // query search
        if($search){
            $query = $query->where(function ($query) use ($search){
                $query->where('voters.name', 'ILIKE', '%'.$search.'%')
                ->orWhere('voters.address', 'ILIKE', '%'.$search.'%')
                ->orWhere('area_kelurahan.kemendagri_provinsi_nama', 'ILIKE', '%'.$search.'%')
                ->orWhere('area_kelurahan.kemendagri_kota_nama', 'ILIKE', '%'.$search.'%')
                ->orWhere('area_kelurahan.kemendagri_kecamatan_nama', 'ILIKE', '%'.$search.'%')
                ->orWhere('area_kelurahan.kemendagri_kelurahan_nama', 'ILIKE', '%'.$search.'%')
                ->orWhere('c.name', 'ILIKE', '%'.$search.'%');
            });
        }

        // variable data
        $datas = [];

        // pagination
        $pagination = [];
        $pagination['page'] = (int)$page;
        $pagination['per_page'] = (int)$per_page;
        $pagination['total_data'] = $query->count('voters.id');
        $pagination['total_page'] = ceil($pagination['total_data'] / $pagination['per_page']);

        // count
        if($count == true)
        {
            $query = $query->count('voters.id');
            $datas['count'] = $query;
        }
        // get data
        else
        {
            $query = $query
                ->orderBy('voters.'.$sort[0], $sort[1])
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
     *     path="/api/voter/{id}",
     *     tags={"Voter"},
     *     summary="",
     *     description="Get data by id",
     *     operationId="voter_show",
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
        $query = Voter::select(
            'voters.*',
            'area_kelurahan.kemendagri_provinsi_nama as provinsi_nama',
            'area_kelurahan.kemendagri_kota_nama as kota_nama',
            'area_kelurahan.kemendagri_kecamatan_nama as kecamatan_nama',
            'area_kelurahan.kemendagri_kelurahan_nama as kelurahan_nama',
            'c.name as created_name',
            'u.name as updated_name')
            ->join('area_kelurahan', 'voters.kelurahan_kode', '=', 'area_kelurahan.kemendagri_kelurahan_kode')
            ->join('users as c', 'c.id', '=', 'voters.created_by')
            ->join('users as u', 'u.id', '=', 'voters.updated_by')
            ->find($id);

        // variable data
        $datas = $query;

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data By Id Successfull', $datas, $pagination);
    }

    /**
     * @OA\Post(
     *     path="/api/voter",
     *     tags={"Voter"},
     *     summary="",
     *     description="Insert data",
     *     operationId="voter_store",
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
        $temp = $request->all();

        // query insert
        $query = Voter::create($temp);

        // get after insert
        $datas = Voter::select(
            'voters.*',
            'area_kelurahan.kemendagri_provinsi_nama as provinsi_nama',
            'area_kelurahan.kemendagri_kota_nama as kota_nama',
            'area_kelurahan.kemendagri_kecamatan_nama as kecamatan_nama',
            'area_kelurahan.kemendagri_kelurahan_nama as kelurahan_nama',
            'c.name as created_name',
            'u.name as updated_name')
            ->join('area_kelurahan', 'voters.kelurahan_kode', '=', 'area_kelurahan.kemendagri_kelurahan_kode')
            ->join('users as c', 'c.id', '=', 'voters.created_by')
            ->join('users as u', 'u.id', '=', 'voters.updated_by')
            ->find($query['id']);

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Insert Data Successfull', $datas, $pagination);
    }

    /**
     * @OA\Put(
     *     path="/api/voter/{id}",
     *     tags={"Voter"},
     *     summary="",
     *     description="Update data",
     *     operationId="voter_update",
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
        $temp = $request->all();

        // query insert
        $query = Voter::findOrFail($id);
        $query = $query->update($temp);

        // get after update
        $datas = Voter::select(
            'voters.*',
            'area_kelurahan.kemendagri_provinsi_nama as provinsi_nama',
            'area_kelurahan.kemendagri_kota_nama as kota_nama',
            'area_kelurahan.kemendagri_kecamatan_nama as kecamatan_nama',
            'area_kelurahan.kemendagri_kelurahan_nama as kelurahan_nama',
            'c.name as created_name',
            'u.name as updated_name')
            ->join('area_kelurahan', 'voters.kelurahan_kode', '=', 'area_kelurahan.kemendagri_kelurahan_kode')
            ->join('users as c', 'c.id', '=', 'voters.created_by')
            ->join('users as u', 'u.id', '=', 'voters.updated_by')
            ->find($id);

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Update Data Successfull', $datas, $pagination);
    }

    /**
     * @OA\Delete(
     *     path="/api/voter/{id}",
     *     tags={"Voter"},
     *     summary="",
     *     description="Delete data",
     *     operationId="voter_destroy",
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
        $query = Voter::findOrFail($id);
        $query = $query->delete();

        // variable data
        $datas = [];

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Delete Data Successfull', $datas, $pagination);
    }

    public function dash_big_number($election_id)
    {
        // variable data
        $datas = [];
        $datas['election'] = [];
        $datas['election'] = Election::find($election_id);

        $datas['bignumber'] = [];
        $datas['bignumber']['voters'] = 0;
        $datas['bignumber']['voters_target'] = 0;
        $datas['bignumber']['voters_all'] = 0;

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }

    public function nik($nik)
    {
        $apiURL = 'https://cekdptonline.kpu.go.id/apilhp';
        $token = '03ADUVZwDb3TMKHjBZ2g_nDytQfLotcgB_kSuT_8aLXvUYTceutGd7dlEdjxGKUfa8MRiMRy7cTdgkrIZ0b9UOX3SctlxL-OLJ1KLthMIMhfl_Fk5PaWodFji-5eGyZMghd3y-jyTuP-pGEhsIeKh3KPWXtjO0D34ytskRa8OEUcFhlroLZUq5-hMtPvOq9mzRdKQRy86-9-MSvt45h73zNp-p7CsfRe2oU825ThCuEWAkpqZ7mqcpibHkKHE_o9Y47y2Rr9hHowGyXwMIN6j-1CnTABhPlcOB3-h5FqWnU6EGebozYu8e3NIl9OGjATEgI3Qacbxcc6V2PjMHxNbE7aaVKbm8WRhSL8wjEMxkT4g94ZrcdzV7X_o-I8MuLS71Y2EFBBxhIzFxk6q8f4Sq8CMU5UUFbr1SMojBCWzrYuhK_JCArjLXMci35ICdQb4snJJmaAL7B0Mw7GmpMtWNisnY4fDOhnY4a-d59v8lRLeRalYh6nN8ZUH4ZgSJ-Cnx467AmvElnSuxwkoHaCt_l3kc_JgjcujWLxEubpB165Uus4_tw9RsS_A';
        $queryStr = '{findNikSidalih(nik:"'.$nik.'",wilayah_id:0,token:"'.$token.'"){nama,nik,nkk,jenis_kelamin,provinsi,kabupaten,kecamatan,kelurahan,tps}}';

        $body = [
            "query" => str($queryStr)
        ];
        $headers = [
            'Origin' => 'https://cekdptonline.kpu.go.id',
            'Referer' => 'https://cekdptonline.kpu.go.id/',
            'Content-Type' => 'application/json',
            'Cookie' => 'cookiesession1=678B2869LMNOPQRSTV01234567896FD2'
        ];

        $response = Http::withHeaders($headers)->post($apiURL, $body);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);


        if (array_key_exists('data',$responseBody)) {

            if (array_key_exists('findNikSidalih',$responseBody['data'])) {

                // variable data
                $temp = [];
                $temp = $responseBody['data']['findNikSidalih'];

                $datas = [];
                $wilayah = [];

                // query
                $query = AreaKelurahan::select('area_kelurahan.*');
                $query = $query->where('bps_kota_nama', 'ILIKE', $temp['kabupaten']);
                $query = $query->where('bps_kecamatan_nama', 'ILIKE', $temp['kecamatan']);
                $query = $query->where('bps_kelurahan_nama', 'ILIKE', $temp['kelurahan']);
                $query = $query
                    ->limit(1)
                    ->get()
                    ->toArray();

                foreach($query as $qry) {
                    $wilayah = $qry;
                };

                if ($wilayah) {
                    $datas['provinsi_kode'] = $wilayah['kemendagri_provinsi_kode'];
                    $datas['provinsi_nama'] = $wilayah['kemendagri_provinsi_nama'];
                    $datas['kota_kode'] = $wilayah['kemendagri_kota_kode'];
                    $datas['kota_nama'] = $wilayah['kemendagri_kota_nama'];
                    $datas['kecamatan_kode'] = $wilayah['kemendagri_kecamatan_kode'];
                    $datas['kecamatan_nama'] = $wilayah['kemendagri_kecamatan_nama'];
                    $datas['kelurahan_kode'] = $wilayah['kemendagri_kelurahan_kode'];
                    $datas['kelurahan_nama'] = $wilayah['kemendagri_kelurahan_nama'];
                    $datas['tps'] = $temp['tps'];
                    $datas['nama'] = $temp['nama'];
                    $datas['nik'] = $temp['nik'];
                    $datas['gender'] = $temp['jenis_kelamin'];
                }

                // pagination
                $pagination = [];

                return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);

            } else {
                return new ApiResource(false, 'Error from KPU, findNikSidalih not found', [], []);
            }
        } else {
            return new ApiResource(false, 'Error from KPU, data not found', [], []);
        }

    }
}
