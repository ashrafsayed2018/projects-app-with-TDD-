<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
  public function test_it_has_path() {

    $project = Factory('App\Project')->create();

     $this->assertEquals('projects/' . $project->id, $project->path());
  }


  public function test_belong_to_owner() {

    $project = factory('App\Project')->create();

    $this->assertInstanceOf('App\User', $project->owner);
  }

  public function test_user_can_add_task() {

    $project = factory(Project::class)->create();

    $task = $project->addTask('test task');

    $this->assertCount(1, $project->tasks);

    $this->assertTrue($project->tasks->contains($task));

  }
}
