<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Question extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'questions';

    const IS_ACTIVE_RADIO = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public static function findQuestion($id){
        $question = Question::find($id);
        return $question;
    }
    public static function findAnswer($question_id,$id){
        $answer = Answer::where('question_id',$question_id)->where('id',$id)->first();
        return $answer;
    }
        public static function assessment($questions){
            echo "<table>";
                echo "<tr>";
                    echo "<td>Question</td><td>My Answer and Marks</td>";
                echo "</tr>";
                $totalMarks = 0;
                $totalQuestion = 0;
                foreach ($questions as $key=>$question){
                    $totalQuestion++;
                    echo "<tr>";
                    echo "<td>";
                    echo Question::find($key)->title;
                    echo "</td><td>";
                    $totalMarks +=  Answer::find($question)->mark;
            echo Answer::find($question)->title . " (".Answer::find($question)->mark.")";
            echo "</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td> Total Question = $totalQuestion";
                echo "</td>";
            echo "<td> Assessment Marks = $totalMarks";
            echo "</td>";
                echo "</tr>";
            echo "</table>";
    }


}
