<?php

namespace Tests\SetUp;

use App\Task;
use App\User;
use App\Project;

class ProjectFactoryTest {


    public $taskCount = 0;

    protected $user;

    public function withTasks($count) {

        $this->taskCount = $count;

        return $this;


    }

    public function ownedBy($user) {


        $this->user = $user;

        return $this;

    }

    public function create () {

        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?? factory(User::class)
        ]);

        // create a new task

        factory(Task::class, $this->taskCount)->create([
            'project_id'  => $project->id
        ]);

         return $project;

    }
}
