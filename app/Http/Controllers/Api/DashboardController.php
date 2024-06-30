<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\User;
use App\Models\Election;
use App\Models\Report;
use App\Models\Finance;
use App\Models\Inventory;
use App\Models\Log;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function home($election_id)
    {
        // variable data
        $datas = [];
        $datas['election'] = [];
        $datas['election'] = Election::find($election_id);

        $datas['caleg'] = [];
        $datas['caleg'] = User::where('election_id', '=', $election_id)
            ->where('role_id', '=', '2')
            ->orderBy('id', 'asc')
            ->limit(1)
            ->get()
            ->toArray()[0];

        $datas['bignumber'] = [];
        $datas['bignumber']['relawan'] = User::where('election_id', '=', $election_id)->where('role_id', '=', '3')->count('id');
        $datas['bignumber']['laporan'] = Report::where('election_id', '=', $election_id)->count('id');
        $datas['bignumber']['pemilih'] = Voter::where('election_id', '=', $election_id)->count('id');
        $datas['bignumber']['pemilih_target'] = $datas['election']['voters_target'];
        $datas['bignumber']['pemilih_semua'] = $datas['election']['voters_all'];
        $datas['bignumber']['percentage'] = ($datas['bignumber']['pemilih'] / $datas['bignumber']['pemilih_target']) * 100;

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }

    public function voters($election_id)
    {
        // variable data
        $datas = [];
        $datas['election'] = [];
        $datas['election'] = Election::find($election_id);

        $datas['bignumber'] = [];
        $datas['bignumber']['voters'] = Voter::where('election_id', '=', $election_id)->count('id');
        $datas['bignumber']['voters_target'] = $datas['election']['voters_target'];
        $datas['bignumber']['voters_all'] = $datas['election']['voters_all'];
        $datas['bignumber']['percentage'] = ($datas['bignumber']['voters'] / $datas['bignumber']['voters_target']) * 100;

        $datas['group_gender'] = [];
        $datas['group_gender'] = Voter::selectRaw('gender, count(id)')
            ->where('election_id', '=', $election_id)
            ->groupBy('gender')
            ->get()
            ->toArray();

        $datas['group_religion'] = [];
        $datas['group_religion'] = Voter::selectRaw('religion, count(id)')
            ->where('election_id', '=', $election_id)
            ->groupBy('religion')
            ->get()
            ->toArray();

        $datas['group_month'] = [];
        $group_month = Voter::selectRaw("date_trunc('month', created_at) AS month, count(id) as count")
            ->where('election_id', '=', $election_id)->groupBy("month")->get()->toArray();
        foreach($group_month as $temp) {
            $created_at_indo = \Carbon\Carbon::parse($temp['month']);
            $created_at_indo->locale('id')->settings(['formatFunction' => 'translatedFormat']);

            $temp['month_indo'] = $created_at_indo->format('F Y');
            $temp['count'] = $temp['count'];
            array_push($datas['group_month'], $temp);
        }

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }

    public function report($election_id)
    {
        // variable data
        $datas['bignumber'] = [];
        $datas['bignumber']['report'] = Report::where('election_id', '=', $election_id)->count('id');

        $datas['group_status'] = [];
        $datas['group_status'] = Report::selectRaw('status, count(id)')
            ->where('election_id', '=', $election_id)
            ->groupBy('status')
            ->get()
            ->toArray();

        $datas['group_month'] = [];
        $group_month = Report::selectRaw("date_trunc('month', created_at) AS month, count(id) as count")
            ->where('election_id', '=', $election_id)->groupBy("month")->get()->toArray();
        foreach($group_month as $temp) {
            $created_at_indo = \Carbon\Carbon::parse($temp['month']);
            $created_at_indo->locale('id')->settings(['formatFunction' => 'translatedFormat']);

            $temp['month_indo'] = $created_at_indo->format('F Y');
            $temp['count'] = $temp['count'];
            array_push($datas['group_month'], $temp);
        }

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }

    public function finance($election_id)
    {
        // variable data
        $datas['bignumber'] = [];
        $datas['bignumber']['count'] = Finance::where('election_id', '=', $election_id)->count('id');
        $datas['bignumber']['nominal'] = Finance::where('election_id', '=', $election_id)->sum('nominal');

        $datas['group_month'] = [];
        $group_month = Finance::selectRaw("date_trunc('month', created_at) AS month, sum(nominal) as sum")
            ->where('election_id', '=', $election_id)->groupBy("month")->get()->toArray();
        foreach($group_month as $temp) {
            $created_at_indo = \Carbon\Carbon::parse($temp['month']);
            $created_at_indo->locale('id')->settings(['formatFunction' => 'translatedFormat']);

            $temp['month_indo'] = $created_at_indo->format('F Y');
            $temp['sum'] = $temp['sum'];
            array_push($datas['group_month'], $temp);
        }

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }

    public function inventory($election_id)
    {
        // variable data
        $datas['bignumber'] = [];
        $datas['bignumber']['count'] = Inventory::where('election_id', '=', $election_id)->count('id');
        $datas['bignumber']['price'] = Inventory::where('election_id', '=', $election_id)->sum('price');
        $datas['bignumber']['amount'] = Inventory::where('election_id', '=', $election_id)->sum('amount');

        $datas['group_month'] = [];
        $group_month = Inventory::selectRaw("date_trunc('month', created_at) AS month, sum(price) as sum")
            ->where('election_id', '=', $election_id)->groupBy("month")->get()->toArray();
        foreach($group_month as $temp) {
            $created_at_indo = \Carbon\Carbon::parse($temp['month']);
            $created_at_indo->locale('id')->settings(['formatFunction' => 'translatedFormat']);

            $temp['month_indo'] = $created_at_indo->format('F Y');
            $temp['sum'] = $temp['sum'];
            array_push($datas['group_month'], $temp);
        }

        // pagination
        $pagination = [];

        return new ApiResource(true, 'Get Data Successfull', $datas, $pagination);
    }


    /**
     * @OA\Get(
     *     path="/dashboard/top-page",
     *     tags={"Dashboard"},
     *     summary="",
     *     description="Get top page",
     *     operationId="dashboard_top_page",
     *     security={{"bearerAuth":{}}},
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
    public function topPage(Request $request)
    {
        // query
        $query = Log::groupBy('path')->selectRaw('path, count(*) as total')->orderBy('total', 'desc')->get()->toArray();

        $data = [];
        $pagination = [];
        foreach($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

    /**
     * @OA\Get(
     *     path="/dashboard/top-device",
     *     tags={"Dashboard"},
     *     summary="",
     *     description="Get top device",
     *     operationId="dashboard_top_device",
     *     security={{"bearerAuth":{}}},
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
    public function topDevice(Request $request)
    {
        // query
        $queryDesktop = Log::selectRaw('count(*) as total')->where('is_desktop', '1')->get();
        $queryMobile = Log::selectRaw('count(*) as total')->where('is_mobile', '1')->get();
        $queryTablet = Log::selectRaw('count(*) as total')->where('is_tablet', '1')->get();

        $data = [];
        $pagination = [];

        $tempDesktop = [
            'device' => 'Desktop',
            'total' => $queryDesktop[0]['total']
        ];
        array_push($data, $tempDesktop);

        $queryMobile = [
            'device' => 'Mobile',
            'total' => $queryMobile[0]['total']
        ];
        array_push($data, $queryMobile);

        $queryTablet = [
            'device' => 'Tablet',
            'total' => $queryTablet[0]['total']
        ];
        array_push($data, $queryTablet);

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

    /**
     * @OA\Get(
     *     path="/dashboard/top-os",
     *     tags={"Dashboard"},
     *     summary="",
     *     description="Get top os",
     *     operationId="dashboard_top_os",
     *     security={{"bearerAuth":{}}},
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
    public function topOs(Request $request)
    {
        // query
        $query = Log::groupBy('os')->selectRaw('os, count(*) as total')->orderBy('total', 'desc')->get()->toArray();

        $data = [];
        $pagination = [];
        foreach($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

    /**
     * @OA\Get(
     *     path="/dashboard/top-browser",
     *     tags={"Dashboard"},
     *     summary="",
     *     description="Get top browser",
     *     operationId="dashboard_top_browser",
     *     security={{"bearerAuth":{}}},
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
    public function topBrowser(Request $request)
    {
        // query
        $query = Log::groupBy('browser')->selectRaw('browser, count(*) as total')->orderBy('total', 'desc')->get()->toArray();

        $data = [];
        $pagination = [];
        foreach($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

    /**
     * @OA\Get(
     *     path="/dashboard/top-country",
     *     tags={"Dashboard"},
     *     summary="",
     *     description="Get top country",
     *     operationId="dashboard_top_country",
     *     security={{"bearerAuth":{}}},
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
    public function topCountry(Request $request)
    {
        // query
        $query = Log::groupBy('country_name')->selectRaw('country_name, count(*) as total')->whereRaw("country_name is not null and country_name != '' ")->orderBy('total', 'desc')->limit(10)->get()->toArray();

        $data = [];
        $pagination = [];
        foreach($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

    /**
     * @OA\Get(
     *     path="/dashboard/top-city",
     *     tags={"Dashboard"},
     *     summary="",
     *     description="Get top city",
     *     operationId="dashboard_top_city",
     *     security={{"bearerAuth":{}}},
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
    public function topCity(Request $request)
    {
        // query
        $query = Log::groupBy('city_name')->selectRaw('city_name, count(*) as total')->whereRaw("city_name is not null and city_name != '' ")->orderBy('total', 'desc')->limit(10)->get()->toArray();

        $data = [];
        $pagination = [];
        foreach($query as $qry) {
            $temp = $qry;
            array_push($data, $temp);
        };

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

    /**
     * @OA\Get(
     *     path="/dashboard/access-daily",
     *     tags={"Dashboard"},
     *     summary="",
     *     description="Get access daily",
     *     operationId="dashboard_access_daily",
     *     security={{"bearerAuth":{}}},
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
    public function accessDaily(Request $request)
    {
        // query
        $query = DB::select("
            SELECT
                seq::date as dates,
                (select count(*) from logs where created_at::date = seq::date) as count
            FROM
            GENERATE_SERIES (NOW() - INTERVAL '1 MONTH', NOW() , '1 day')  as seq
        ");

        $data = [];
        $pagination = [];
        foreach($query as $qry) {
            $temp = $qry;
            $temp->dates_indo = \App\Helpers\AppHelper::instance()->convertDateIndo($temp->dates);
            array_push($data, $temp);
        };

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

    /**
     * @OA\Get(
     *     path="/dashboard/top-monthly",
     *     tags={"Dashboard"},
     *     summary="",
     *     description="Get top monthly",
     *     operationId="dashboard_top_monthly",
     *     security={{"bearerAuth":{}}},
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
    public function accessMonthly(Request $request)
    {
        // query
        $query = DB::select("
            SELECT
                    seq::date as months,
                    (
                        select count(*) from logs
                        where
                            extract('month' from created_at) = extract('month' from seq) and
                            extract('year' from created_at) = extract('year' from seq)
                    ) as count
            FROM
            GENERATE_SERIES (NOW() - INTERVAL '1 YEAR', NOW() , '1 MONTH') as seq
        ");

        $data = [];
        $pagination = [];
        foreach($query as $qry) {
            $temp = $qry;
            $temp->months_indo = \App\Helpers\AppHelper::instance()->convertMonthIndo($temp->months);
            array_push($data, $temp);
        };

        // result
        if($data) {
            return new ApiResource(true, 'Get data successfull', $data, $pagination);
        } else {
            return new ApiResource(false, 'No data found', [], $pagination);
        }
    }

}
