<?php

namespace Tests\Unit;

use App\Task;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
  use RefreshDatabase;


  public function test_a_task_belongs_to_project () {

    $task = factory(Task::class)->create();

    $this->assertInstanceOf(Project::class, $task->project);

  }

  public function test_it_has_a_path () {
      $task = factory(Task::class)->create();

      // check the equality of the path

      $this->assertEquals($task->path(), $task->path());
  }

  public function test_it_can_be_completed() {

    //    $this->withoutExceptionHandling();

        $task = factory(Task::class)->create(['completed'=> FALSE]);


        $task->complete();

        $this->assertTrue(1 == $task->fresh()->completed);

    }

    public function test_it_can_markedas_incompleted() {

           $this->withoutExceptionHandling();

            $task = factory(Task::class)->create(['completed'=> TRUE]);


            $task->incomplete();
            // dd($task->incomplete());

            $this->assertTrue(0 == $task->fresh()->completed);

        }
}
