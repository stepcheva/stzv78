<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserQuizTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $quiz;
    private $userQuiz;

    private function setAuthReturnUser()
    {
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($this->user);
    }

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(\App\Models\Guest::class)->create();

        $this->quiz = factory(\App\Models\Quiz::class)->create();
        $this->quiz->questions = factory(\App\Models\Question::class, 5)->create([
            'quiz_id' => $this->quiz->id,
        ]);

        $this->setAuthReturnUser();

        $this->userQuiz = factory(\App\Models\UserQuiz::class)->create([
            'user_id' => $this->user->id,
            'quiz_id' => $this->quiz->id,
            'points' => null,
        ]);
    }

    public function testIsComplete()
    {
        foreach ($this->quiz->questions as $question) {
            factory(\App\Models\UserQuizQuestion::class)->create([
                'user_quiz_id' => $this->userQuiz->id,
                'question_id' => $question->id,
            ]);
        }

        $this->assertTrue(($this->userQuiz)->isComplete());
    }

    public function testIsHalfComplete()
    {
        for ($i = 0; $i < intval($this->quiz->questions->count() / 2); $i++) {
            factory(\App\Models\UserQuizQuestion::class)->create([
                'user_quiz_id' => $this->userQuiz->id,
                'question_id' => $this->quiz->questions[$i]->id,
            ]);
        }

        $this->assertFalse(($this->userQuiz)->isComplete());
    }

    public function testIsCompleteOnLaunchedQuiz()
    {
        $this->assertFalse(($this->userQuiz)->isComplete());
    }

    public function testSetAwardPoints()
    {
        //создаем по два ответа к вопросам квиза
        foreach ($this->quiz->questions as $question) {
            factory(\App\Models\Answer::class, 2)->create([
                'question_id' => $question->id,
                'points' => 5,
            ]);
        }
        //проходим квиз целиком с выбором одного ответа
        foreach ($this->quiz->questions as $question) {

            $userQuizQuestion = factory(\App\Models\UserQuizQuestion::class)->create([
                'user_quiz_id' => $this->userQuiz->id,
                'question_id' => $question->id,
            ]);

            factory(\App\Models\UserQuizQuestionAnswer::class)->create([
                'user_quiz_question_id' => $userQuizQuestion->id,
                'answer_id' => $question->answers[0]->id,
            ]);

        }

        ($this->userQuiz)->setAwardPoints();

        $this->assertEquals(25, $this->userQuiz->points);
    }

    public function setAwardPointsForFixedQuiz()
    {
        $this->userQuiz = factory(\App\Models\UserQuiz::class)->states('isFixed')->create([
            'user_id' => $this->user->id,
            'quiz_id' => $this->quiz->id,
        ]);

        ($this->userQuiz)->setAwardPoints();

        $this->assertEquals($this->userQuiz->quiz->points, $this->userQuiz->points);
    }

    public function testCountRightAnswers()
    {
        foreach ($this->quiz->questions as $question) {
            factory(\App\Models\Answer::class)->states('correct')->create([
                'question_id' => $question->id,
            ]);
            factory(\App\Models\Answer::class)->states('incorrect')->create([
                'question_id' => $question->id,
            ]);
        }
        $odd = 0;
        foreach ($this->quiz->questions as $question) {
            $userQuizQuestion = factory(\App\Models\UserQuizQuestion::class)->create([
                'user_quiz_id' => $this->userQuiz->id,
                'question_id' => $question->id,
            ]);
            //четный правильный, нечетный - неправильный
            factory(\App\Models\UserQuizQuestionAnswer::class)->create([
                'user_quiz_question_id' => $userQuizQuestion->id,
                'answer_id' => $question->answers[$odd++ % 2]->id,
            ]);
        }
        $this->assertEquals(3, $this->userQuiz->countRightAnswers());
    }
}
