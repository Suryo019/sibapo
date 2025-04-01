<?php

namespace App\Http\Controllers\Pimpinan;

use App\Models\DP;
use App\Models\DPP;
use App\Models\DKPP;
use App\Models\DTPHP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReadDataController extends Controller
{
    public function index()
    {
        $dpp = DPP::all();
        $dtphp = DTPHP::all();
        $dkpp = DKPP::all();
        $dp = DP::all();

        return response()->json([
            'message' => 'Data berhasil diambil',
            'data' => [
                'dpp' => $dpp,
                'dtphp' => $dtphp,
                'dkpp' => $dkpp,
                'dp' => $dp,
            ]
        ], 200);
    }

    public function show($table, $id)
    {
        $model = null;

        switch ($table) {
            case 'dpp':
                $model = DPP::find($id);
                break;
            case 'dtphp':
                $model = DTPHP::find($id);
                break;
            case 'dkpp':
                $model = DKPP::find($id);
                break;
            case 'dp':
                $model = DP::find($id);
                break;
            default:
                return response()->json([
                    'message' => 'Tabel tidak ditemukan'
                ], 404);
        }

        if (!$model) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => $model
        ], 200);
    }
}
