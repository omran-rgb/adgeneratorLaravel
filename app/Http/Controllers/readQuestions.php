<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\questions;


class readQuestions extends Controller
{
    //
    public function get_all_question()
{

    $questions = questions::all();
    return response()->json($questions, 200, [], JSON_UNESCAPED_UNICODE);
}

    
}
