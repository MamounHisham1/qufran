<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerUser;
use App\Models\Category;
use App\Models\Examination;
use App\Models\Post;
use App\Models\Question;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExaminationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $time = now();

        $questions = DB::table('answer_user')->where('user_id', auth()->user()->id)->pluck('question_id');

        $takenExams = Question::whereIn('id', $questions)->pluck('examination_id')->unique()->toArray();

        $takenExams = Examination::whereIn('id', $takenExams)->get();

        // only show exams that are currently active and not taken by the user using wherenotin
        $exams = Examination::whereNotIn('id', $takenExams->pluck('id'))
            ->where('end_at', '>', $time)
            ->where('start_at', '<', $time)
            ->paginate(3);

        $settings = Setting::firstWhere('page', 'exams')?->value;

        $categories = Category::whereIn('id', $settings['categories'] ?? [])->get();
        $lessons = Post::whereIn('id', $settings['lessons'] ?? [])->get();
        $recommended = Examination::whereIn('id', $settings['recommended'] ?? [])->get();
        $mostTaken = Examination::whereIn('id', $settings['most_taken'] ?? [])->get();

        return view('exams.index', [
            'exams' => $exams,
            'categories' => $categories,
            'lessons' => $lessons,
            'recommended' => $recommended,
            'mostTaken' => $mostTaken,
            'takenExams' => $takenExams,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Examination $exam)
    {
        $questions = DB::table('answer_user')->where('user_id', auth()->user()->id)->pluck('question_id');

        foreach ($questions as $question) {
            if ($exam->questions->contains('id', $question)) {
                return redirect()->route('exams.completed', $exam);
            }
        }

        return view('exams.show', [
            'exam' => $exam,
        ]);
    }

    public function store(Request $request, Examination $exam)
    {
        $request->validate([
            'question.*' => 'required',
        ]);

        foreach ($request->question as $question => $answer) {
            DB::table('answer_user')->insert([
                'user_id' => auth()->user()->id,
                'question_id' => $question,
                'answer_id' => $answer,
            ]);
        }

        return redirect()->route('exams.completed', $exam);
    }

    public function completed(Examination $exam)
    {
        $questions = $exam->questions;

        $correctAnswers = array_map(function ($question) {
            return $question = $question['correct_answer_id'];
        }, $questions->toArray());

        $userAnswers = array_map(function ($question) {
            return $question =
                DB::table('answer_user')
                    ->where('user_id', auth()->user()->id)
                    ->where('question_id', $question['id'])
                    ->pluck('answer_id')->first();
        }, $questions->toArray());

        $percentage = collect($userAnswers)->intersect($correctAnswers)->count() / collect($correctAnswers)->count() * 100;

        // dd($questions);

        return view('exams.completed', [
            'exam' => $exam,
            'questions' => collect($questions),
            'percentage' => (int) $percentage,
            'userAnswers' => $userAnswers,
            'correctAnswers' => $correctAnswers,
        ]);
    }
}
