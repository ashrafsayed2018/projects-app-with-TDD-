<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\SetUp\ProjectFactoryTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     // guest can view a signle project

    public function test_guests_cannot_manage_projects () {


        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path() .'/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');


    }

    public function test_user_can_create_a_project()
    {

        $this->withoutExceptionHandling();
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes'       => 'general notes'

        ];

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $reponse = $this->post('/projects',$attributes);

        $project = Project::where($attributes)->first();

        $reponse->assertRedirect($project->path());

        // dd($project->path());


        $this->get($project->path())
              ->assertSee($attributes['title'])
              ->assertSee($attributes['description'])
              ->assertSee($attributes['notes']);


    }

    /** @test */

    public function user_can_update_a_project () {


        $project = ProjectFactoryTest::ownedBy($this->signIn())->create();

        $this->patch($project->path(), $attributes = [
            'title'       => 'changed',
            'description' => 'changed',
            'notes'       => 'test notes'
        ]);

        $this->get($project->path(). '/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attributes);

    }

        /** @test */

        public function user_can_update_a_project_general_notes () {


            $project = ProjectFactoryTest::ownedBy($this->signIn())->create();

            $this->patch($project->path(), $attributes = [
                'notes'       => 'test notes'
            ]);

            $this->get($project->path(). '/edit')->assertOk();
            $this->assertDatabaseHas('projects', $attributes);

        }

    public function test_project_requires_a_title () {

            $this->signIn();

            $attributes = Factory('App\Project')->raw(['title' => '']);

            $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

        public function test_project_requires_a_description () {

            $this->actingAs(factory('App\User')->create());

            $attributes = Factory('App\Project')->raw(['description' => '']);

            $this->post('/projects', $attributes)->assertSessionHasErrors('description');
        }



        public function test_user_can_view_their_project() {

            $this->signIn();

            $this->withoutExceptionHandling();


            $project = ProjectFactoryTest::ownedBy($this->signIn())->create();

            $this->get($project->path())
                ->assertSee($project->title)
                ->assertSee( str_limit($project->description,100));

        }

        public function test_authanticated_user_cannot_view_the_projects_of_others() {

            // sign in the user

            $this->signIn();

            $project = Factory('App\Project')->create();

            $this->get($project->path())->assertStatus(403);
        }


        public function test_authanticated_user_cannot_update_the_projects_of_others() {

            // sign in the user

            $this->signIn();

            // $this->withoutExceptionHandling();

            $project = Factory('App\Project')->create();

            $this->patch($project->path(), [])->assertStatus(403);
        }
}
