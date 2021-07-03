<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Facades\Tests\SetUp\ProjectFactoryTest;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function creating_a_project() {

        // create a project

        $project = ProjectFactoryTest::create();

        // assert that the project has at least one activity

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function ($activity)   {

            // assert the create activity has a description of created

            $this->assertEquals('project_created', $activity->description);

            $this->assertNull($activity->changes);



        });

    }

    /** @test */

    public function updating_a_project () {

        // $this->withoutExceptionHandling();

        // create a project

        $project = ProjectFactoryTest::create();

        $originalTitle = $project->title;

        // update the project

        $project->update(['title' => 'changed']);

        // assert that the project has the updated activity

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle)  {

            // assert the updated activity has a description of updated

            $this->assertEquals('project_updated', $activity->description);

            $expected = [
                'before' => ['title'=> $originalTitle ],
                'after'  => ['title' => 'changed']
            ];

            // $this->assertEquals($expected, $activity->changes);
            // var_dump($expected);

        });


    }

    /** @test */

    public function creating_a_new_task () {

        $this->withoutExceptionHandling();

        $project = ProjectFactoryTest::create();

        $project->addTask('some task');


        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity) {

            $this->assertEquals('task_created', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('some task', $activity->subject->body);
        });
    }

        /** @test */

        public function completing_a_task () {

             $this->withoutExceptionHandling();

            $project = ProjectFactoryTest::withTasks(1)->create();

            $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'task body',
                'completed' => true
            ]);

            $this->assertCount(3, $project->activity);
            $this->assertEquals('completed_task', $project->activity->last()->description);

            $this->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => false
            ]);

           $project->refresh();

            $this->assertCount(4, $project->activity);

            tap($project->activity->last() , function ($activity) {

                $this->assertEquals('incompleted_task', $activity->description);
                $this->assertInstanceOf(Task::class, $activity->subject);
            });


        }


        /** @test */

        public function incompleting_a_task () {

            $this->withoutExceptionHandling();

           $project = ProjectFactoryTest::withTasks(1)->create();

           $this->actingAs($project->owner)
           ->patch($project->tasks[0]->path(), [
               'body' => 'task body',
               'completed' => true
           ]);

           $this->assertCount(3, $project->activity);
           $this->assertEquals('completed_task', $project->activity->last()->description);

           $this->patch($project->tasks[0]->path(), [
               'body' => 'foobar',
               'completed' => false
           ]);

          $project->refresh();

           $this->assertCount(4, $project->activity);

           $this->assertEquals('incompleted_task', $project->activity->last()->description);

       }

        /** @test */

        public function deleting_a_task () {

        $project = ProjectFactoryTest::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);


    }

}
