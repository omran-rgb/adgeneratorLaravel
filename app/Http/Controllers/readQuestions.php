<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\questions;


class readQuestions extends Controller
{
    //
    public function get_all_question()
{
    // 2. جلب كل السجلات من جدول questions
    $questions = questions::all();

    // 3. إرجاع النتائج (سيقوم لارافل تلقائياً بتحويلها إلى JSON)
    return response()->json($questions, 200, [], JSON_UNESCAPED_UNICODE);
}

    
}
