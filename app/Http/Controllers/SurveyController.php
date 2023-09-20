<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function creta(Request $request)
  
    {
        Auth::id();
       // dd(Auth::id());
        $validator = Validator::make($request->all(), [
            "question" => "required",
            "answer1" => "required",
            "answer2" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 400);
        }
        Survey::create([
            "user_id" => $request->user()->id,
            "question" => $request->question,
            "answer1" => $request->answer1,
            "answer2" => $request->answer2,
            "answer3" => $request->answer3,
            "answer4" => $request->answer4,
            "answer5" => $request->answer5,
        ]);

        return response()->json(["status" => "success"], 200);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "question" => "required",
            "answer1" => "required",
            "answer2" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 400);
        }

        $survey = Survey::where("id", $request->id)->first();
        $survey->update([
            "question" => $request->question,
            "answer1" => $request->answer1,
            "answer2" => $request->answer2,
            "answer3" => $request->answer3,
            "answer4" => $request->answer4,
            "answer5" => $request->answer5,
        ]);
        return response()->json(["status" => "success"], 200);
    }
    public function show(Request $request)
    {
        $survey = Survey::where("id", $request->id)->get();
        return response()->json($survey, 200);
    }
    public function delete(Request $request)
    {
        $survey = Survey::where("id", $request->id)->first();
        $survey->delete();
        return response()->json(["status" => "success"], 200);
    }
}
