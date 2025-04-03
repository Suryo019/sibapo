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
    public function getDPP()
    {
        $data = DPP::all();
        return response()->json([
            'message' => 'Data DPP berhasil diambil',
            'data' => $data
        ], 200);
    }
    
    public function getDKPP()
    {
        $data = DKPP::all();
        return response()->json([
            'message' => 'Data DKPP berhasil diambil',
            'data' => $data
        ], 200);
    }

    public function getDTPHP()
    {
        $data = DTPHP::all();
        return response()->json([
            'message' => 'Data DTPHP berhasil diambil',
            'data' => $data
        ], 200);
    }

    public function getDP()
    {
        $data = DP::all();
        return response()->json([
            'message' => 'Data DP berhasil diambil',
            'data' => $data
        ], 200);
    }
}
