<?php

namespace App;

use App\Activity;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    use RecordActivity;
    protected $guarded = [];


    public function path() {

        return 'projects/' . $this->id;
    }

    // relationship between the owner and the project

    public function owner () {

        return $this->belongsTo("App\User");
    }


    // relationship between the tasks and the project

    public function tasks() {

        return $this->hasMany(Task::class);
    }

    // add a task to a project

    public function addTask($body) {


        return $this->tasks()->create(compact('body'));

    }


    // add activity method

    public function activity () {

        return $this->hasMany(Activity::class)->latest();
    }
}
