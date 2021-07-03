<?php

namespace App;

use App\Project;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use RecordActivity;

    protected $guarded = [];


    // this property to touch the parent class [which has a relationship with that class] and update the updated-at

    protected $touches = ['project'];

    public static $recordableEvents = ['created', 'deleted'];


    // the relationship between the task and the project

    public function project() {

        return $this->belongsTo(Project::class);
    }

    public function path() {


        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }



    public function complete() {

        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete() {

        $this->update(['completed' => false]);
        $this->recordActivity('incompleted_task');

    }



}
