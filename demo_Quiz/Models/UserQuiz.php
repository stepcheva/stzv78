<?php

namespace App\Models;

use App\Models\AdminPanelModel;

class UserQuiz extends AdminPanelModel
{
    protected $fillable = [
        'user_id',
        'user_type',
        'quiz_id',
        'points',
        'by_api',
        'final_screen_id',
        'email',
    ];

    public function scopeWithContacts($query)
    {
        return $query->whereNotNull('email')->whereNotNull('final_screen_id');
    }

    public function user()
    {
        return $this->morphTo();
    }

    public function quiz()
    {
        return $this->belongsTo('App\Models\Quiz');
    }

    public function userQuizQuestions()
    {
        return $this->hasMany('App\Models\UserQuizQuestion');
    }

    public function finalScreen()
    {
        return $this->belongsTo('App\Models\FinalScreen');
    }

    public function isComplete()
    {
        return $this->countUserQuizQuestions() === $this->quiz->countQuestions();
    }

    public function byApi()
    {
        return $this->by_api == 1;
    }

    public function countUserQuizQuestions()
    {
        return $this->userQuizQuestions->count();
    }

    public function setAwardPoints()
    {
        if ($this->quiz->isFixed()) {
            $this->points = $this->quiz->points;
        } else {
            $this->points = $this->userQuizQuestions->map(function ($item) {
                return $item->userQuizQuestionAnswers->map->answer->sum('points');
            })->sum();
        }
        $this->save();
    }

    public function countRightAnswers()
    {
        return $this->userQuizQuestions->map(function ($userQuizQuestion) {
            return ($userQuizQuestion->userQuizQuestionAnswers->first()->answer->isCorrect()) ? 1 : 0;
        })->sum();
    }
}
