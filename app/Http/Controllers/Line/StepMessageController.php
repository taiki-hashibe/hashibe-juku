<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\TrialLesson;
use App\Models\User;
use Illuminate\Support\Carbon;

class StepMessageController extends Controller
{
    public function step1()
    {
        $user = auth('users')->user();
        if (request()->method() === 'POST') {
            request()->validate([
                'question_1' => 'required',
                'question_2' => 'required',
                'question_3' => 'required'
            ]);
            $data = [
                'ベースをもう弾いていますか？' => request()->question_1,
                'ベース歴はどれくらいですか？' => request()->question_2,
                '興味のある奏法はありますか？' => request()->question_3
            ];
            Questionnaire::create([
                'url' => request()->url(),
                'route_name' => request()->route()->getName(),
                'user_id' => $user->id,
                'value' => $data
            ]);
            return redirect()->route('line.step.questionnaire_success');
        }
        return view('pages.line.step.step_1', [
            'user' => $user
        ]);
    }

    public function step2()
    {
        $user = auth('users')->user();
        if (request()->method() === 'POST') {
            request()->validate([
                'question_1' => 'required',
                'question_2' => 'nullable|max:500',
            ]);
            $data = [
                '動画の内容はいかがでしたか？' => request()->question_1,
                '他に感想があればお聞かせください！' => request()->question_2,
            ];
            Questionnaire::create([
                'url' => request()->url(),
                'route_name' => request()->route()->getName(),
                'user_id' => $user->id,
                'value' => $data
            ]);
            return redirect()->route('line.step.questionnaire_success');
        }
        return view('pages.line.step.step_2', [
            'user' => $user
        ]);
    }

    public function trialLesson()
    {
        /** @var User $user */
        $user = auth('users')->user();
        $valid = $user->questionnaireCompleted([
            'line.step.step-1',
            'line.step.step-2'
        ]);
        return view('pages.line.step.trial-lesson', [
            'user' => $user,
            'valid' => $valid
        ]);
    }

    public function trialLessonConfirm()
    {
        request()->validate([
            'date_1' => 'required|date|after:now',
            'time_1' => 'required',
            'date_2' => 'required|date|after:now',
            'time_2' => 'required',
            'date_3' => 'required|date|after:now',
            'time_3' => 'required',
            'request_value' => 'nullable|max:1000'
        ]);
        return view('pages.line.step.trial-lesson-confirm', [
            'date_1' => request()->date_1,
            'time_1' => request()->time_1,
            'date_2' => request()->date_2,
            'time_2' => request()->time_2,
            'date_3' => request()->date_3,
            'time_3' => request()->time_3,
            'request_value' => request()->request_value
        ]);
    }

    public function trialLessonSubmit()
    {
        $user = auth('users')->user();
        $date_1 = new Carbon(request()->date_1 . ' ' . request()->time_1 . ':00');
        $date_2 = new Carbon(request()->date_2 . ' ' . request()->time_2 . ':00');
        $date_3 = new Carbon(request()->date_3 . ' ' . request()->time_3 . ':00');
        $trialLesson = TrialLesson::create([
            'user_id' => $user->id,
            'date_1' => $date_1,
            'date_2' => $date_2,
            'date_3' => $date_3,
            'request' => request()->request_value
        ]);
        return view('pages.line.step.trial-lesson-submit', [
            'user' => $user
        ]);
    }

    public function QuestionnaireSuccess()
    {
        return view('pages.line.step.questionnaire_success');
    }
}
