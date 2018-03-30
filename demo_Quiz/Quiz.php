<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class Quiz extends AdminPanelModel
{
    const SETTINGS = [
        'name' => 'Квиз',
        'plural_name' => 'Квизы',
        'admin_route_prefix' => 'admin.quizzes',
    ];

    protected $fillable = [
        'name',
        'description',
        'image',
        'is_opened',
        'status',
        'level',
        'is_fixed',
        'points',
        'is_doubled',
        'background',
        'slug',
        'has_right_answers',
        'sort',
        'take_emails',
    ];

    protected $checkboxes = [
        'status',
        'has_right_answers',
        'take_emails',
    ];

    public static $levels = [
        1 => 'Легкий',
        2 => 'Средний',
        //3 => 'Сложный',
    ];

    public function scopeOpened($query)
    {
        return $query->where('is_opened', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeTakeEmails($query)
    {
        return $query->where('take_emails', 1);
    }

    public function isOpened()
    {
        return $this->is_opened === 1;
    }

    public function isDouble()
    {
        return $this->is_doubled === 1;
    }

    public function isActive()
    {
        return ($this->status === 1 && $this->finalScreens()->count());
    }

    public function isFixed()
    {
        return $this->is_fixed == 1;
    }

    public function bTakeEmails()
    {
        return $this->take_emails == 1;
    }

    public function withRightAnswers()
    {
        return $this->has_right_answers == 1;
    }

    public function getLevelName()
    {
        return self::$levels[$this->level];
    }

    public function delete()
    {
        return $this->deleteWithImages(['image']);
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function userQuizzes()
    {
        return $this->hasMany('App\Models\UserQuiz');
    }

    public function countQuestions()
    {
        return $this->questions->count();
    }

    public function countAnswersPoints()
    {
         $collection = collect($this->questions);

         $multiplied = $collection->map(function ($item, $key) {
                return $item->answers()->sum('points');
             });

         return  $multiplied->sum();
    }

    public function isAvailable()
    {
        return ($this->isOpened() || Auth::check()) && $this->isActive();
    }

    public function finalScreens()
    {
        return $this->hasMany('App\Models\FinalScreen');
    }

    public function countFinalScreens()
    {
        return $this->finalScreens->count();
    }

    public function countTags()
    {
        return $this->tags->count();
    }

    public function returnArrayRelatedLinks()
    {
        $links = [];
        $links[] = route('quiz', $this->slug);
        $this->finalScreens->map(function($finalScreen) use (&$links){
            $links[] = route('final_screen', $finalScreen->id);
        });
        return $links;
    }

    public function selectFinalScreen($points)
    {
        $result = $this->finalScreens()->where('min_points', '<=', $points)->where('max_points', '>=', $points)->get()->first();

        if (is_null($result)) {
            $result = $this->finalScreens()->where(function ($query) use ($points) {
                $query->where('min_points', '<=', $points)
                    ->orWhereNull('min_points');
            })->where(function ($query) use ($points) {
                $query->where('max_points', '>=', $points)
                    ->orWhereNull('max_points');
            })->get()->first();
        }

        return $result;
    }
}
