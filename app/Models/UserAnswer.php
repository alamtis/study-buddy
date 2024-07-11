<?php
// app/Models/UserAnswer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserAnswer extends Pivot
{
    public $incrementing = true;
    protected $table = 'user_answers';
    protected $fillable = ['evaluation_id', 'question_id', 'selected_answer'];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
