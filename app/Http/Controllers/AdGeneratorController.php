<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\questions;
use OpenAI\Laravel\Facades\OpenAI; // 1. استدعاء الواجهة الخاصة بالمكتبة

class AdGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $userAnswers = $request->all();

        if (empty($userAnswers)) {
            return response()->json(['message' => 'لا توجد بيانات'], 400);
        }

        $promptDetails = "";

        foreach ($userAnswers as $questionId => $answer) {
            $question = questions::find($questionId);
            if ($question) {
                if (is_array($answer)) {
                    $answerText = implode(", ", $answer);
                } else {
                    $answerText = (string) $answer;
                }
                $promptDetails .= "- " . $question->title . ": " . $answerText . "\n";
            }
        }

        
        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo', 
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'أنت خبير تسويق إعلاني محترف. مهمتك هي كتابة إعلان جذاب وإبداعي بناءً على المعلومات التي سيقدمها لك المستخدم. الإعلان يجب أن يكون مقسماً إلى: عنوان جذاب، نص الإعلان، ودعوة لاتخاذ إجراء (Call to Action).'
                    ],
                    [
                        'role' => 'user',
                        'content' => "قم بكتابة إعلان بناءً على البيانات التالية:\n" . $promptDetails
                    ],
                ],
                'temperature' => 0.7, 
                'max_tokens' => 500,
            ]);

            $generatedAd = $result->choices[0]->message->content;

            
            return response()->json([
                'status' => 'success',
                'ad_content' => $generatedAd, 
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء الاتصال بـ OpenAI: ' . $e->getMessage()
            ], 500);
        }
    }
}