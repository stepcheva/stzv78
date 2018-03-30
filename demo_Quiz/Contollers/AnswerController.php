<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\IncludedCrudController;

class AnswersController extends IncludedCrudController
{
    protected $imagesPath = 'answers';
    protected $images = ['image'];

    public function index($quizId, $questionId)
    {
        $list = Answer::where('question_id', $questionId)->orderInTable()->paginate($this->paginate);
        return view($this->adminViewsPath . '.index', compact('list'))->withSettings($this->settings)->with([
            'route_params' => [
                $quizId,
                $questionId
            ]
        ]);
    }

    public function create($quizId, $questionId)
    {
        $question = Question::find($questionId);
        return view($this->adminViewsPath . '.create',
            compact('question'))->withSettings($this->settings)->with(['route_params' => [$quizId, $questionId]]);
    }

    public function store(Request $request, $quizId, $questionId)
    {
        $inputRequest = new $this->requestClass;
        $this->validate($request, $inputRequest->rules(), $inputRequest->messages());
        $this->params['question_id'] = $questionId;
        $entity = $this->storeEntity();
        return $this->afterSaveReturn($request, $entity);
    }

    public function edit($quizId, $questionId, $answerId)
    {
        $item = Answer::find($answerId);
        $question = $item->question;
        return view($this->settings['admin_route_prefix'] . '.create',
            compact('item', 'question'))->withSettings($this->settings)->with(['route_params' => [$quizId, $questionId, $answerId]]);
    }

    public function afterSaveReturn($params, $answer)
    {
        if (request()->has('add_question')) {
            return redirect()->route('admin.questions.create', [$answer->question->quiz->id]);
        } elseif (request()->has('add_answer')) {
            return redirect()->route($this->settings['admin_route_prefix'] . '.create', [$answer->question->quiz->id, $answer->question->id]);
        } elseif (request()->has('add_question')) {
            return redirect()->route($this->settings['admin_route_prefix'] . '.index', [$answer->question->quiz->id, $answer->question->id]);
        } elseif (request()->has('add_final_screen')) {
            return redirect()->route(final_screen_settings('admin_route_prefix') . '.create', [$answer->question->quiz->id]);
        } else {
            return redirect()->route($this->settings['admin_route_prefix'] . '.index', [$answer->question->quiz->id, $answer->question->id]);
        }
    }
}
