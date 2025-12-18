<?php

namespace App\Http\Controllers;

use App\Models\answars;
use Illuminate\Http\Request;

class insertAnswars extends Controller
{
    //
    public function insert_answars(Request $request)
    {
        try{
        $data = $request->all();
      
        $adGenerator = app(AdGeneratorController::class);
        return $adGenerator->generate($request);
    }
         catch (\Exception $e) {
        
        return response()->json([
            'status' => 'error',
            'message' => 'حدث خطأ في السيرفر',
            'error_details' => $e->getMessage(), 
            'file' => $e->getFile(), 
            'line' => $e->getLine() 
        ], 500);
    }
    }
}
