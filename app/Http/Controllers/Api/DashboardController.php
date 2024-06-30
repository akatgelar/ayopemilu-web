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
use App\Http\Resources\ApiResource;

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
}
