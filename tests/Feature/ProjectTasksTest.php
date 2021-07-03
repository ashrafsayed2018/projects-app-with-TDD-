<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Facades\Tests\SetUp\ProjectFactoryTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;


    public function test_guests_cannot_add_tasks_to_project() {

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }


    // only the owner add task

    public function test_only_the_owner_of_a_project_may_add_task() {

        $this->signIn();

        $project = factory('App\Project')->create();


        $this->post($project->path() . '/tasks',['body' => 'test task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'test task']);

    }

        // only the owner add task

    public function test_only_the_owner_of_a_project_may_update_task() {

        $this->signIn();

        $project = factory('App\Project')->create();

        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id,['body' => 'changed'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);

    }

    public function test_a_project_can_have_tasks () {


        $this->withoutExceptionHandling();

        $project = ProjectFactoryTest::create();

        $attributes = [
            'body' => 'test task'
        ];

        // when we reach submit a post request to project path tasks
       $response =  $this->actingAs($project->owner)->post($project->path(). '/tasks', $attributes );

        // when we get

        $this->get($project->path())->assertSee('test task');


    }


    // test task can be updated

    public function test_task_can_be_updated() {

          // create a project

        $project = ProjectFactoryTest::withTasks(1)->create();

        $this->ActingAs($project->owner)->patch($project->tasks()->first()->path(), ['body' => 'changed']);

        // assert to see that updated task in the database

        $this->assertDatabaseHas('tasks' , ['body' => 'changed']);


    }

    public function test_task_can_be_completed() {

        // create a project

      $project = ProjectFactoryTest::withTasks(1)->create();

      $this->ActingAs($project->owner)->patch($project->tasks[0]->path(), [
          'body'  => 'hello world',
          'completed' => true
      ]);

      // assert to see that completed task in the database

      $this->assertDatabaseHas('tasks' , [
          'body'  => 'hello world',
          'completed' => true
        ]);
    }

    public function test_task_can_be_incompleted() {

        // create a projectww

      $project = ProjectFactoryTest::withTasks(1)->create();

      $this->ActingAs($project->owner)->patch($project->tasks[0]->path(), [
        'body'  => 'hello world',
        'completed' => true
    ]);


      $this->ActingAs($project->owner)->patch($project->tasks[0]->path(), [
          'body'  => 'hello world',
          'completed' => false
      ]);

      // assert to see that completed task in the database

      $this->assertDatabaseHas('tasks' , [
          'body'  => 'hello world',
          'completed' => false
        ]);
    }
    // test a task require a body

    public function test_a_task_require_a_body () {

        // sign in the user

        $this->signIn();

        // create a project

        $project = ProjectFactoryTest::create();

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->ActingAs($project->owner)->post($project->path(). '/tasks', $attributes)->assertSessionHasErrors('body');


    }
}
