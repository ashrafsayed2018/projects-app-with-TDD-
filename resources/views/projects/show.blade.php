@extends('layouts.app')

@section('content')

<header class="flex items-end mb-3 py-3">
    <div class="w-full flex justify-between items-center">
        <p class="text-gray-darkest font-normal text-sm">
            <a href="/projects">My Projects </a> / {{ $project->title }}
        </p>
        <a href="/{{ $project->path() . '/edit'}}" class="text-gray-darkest button-blue">Update Project</a>
    </div>
</header>
<main>
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6 lg:mb-0">
            <div class="mb-8">
                <h2 class="text-lg text-gray text-sm mb-3">Tasks</h2>

                <form action="/{{ $project->path(). '/tasks' }}" method="POST">
                    @csrf
                    <input type="text" name="body" placeholder="Add a new tasks" class="w-full mb-4 px-2 py-4 outline-none shadow focus:ring-1 focus:ring-blue-300 transition-all ">
                </form>
                {{-- tasks --}}

                @foreach ($project->tasks as $task)


                    <form action="{{ $task->path()}}" method="POST" class="bg-white p-4 mb-4">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center">
                            <input name="body" value="{{$task->body }}" class="w-full outline-none {{ $task->completed ? 'text-gray' : '' }}"  {{ $task->completed ? 'readonly' : '' }} />
                            <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }} />
                        </div>
                    </form>

                @endforeach


            </div>
            <div>
                <h2 class="text-lg text-gray text-sm mb-3">General Notes</h2>
                {{-- general notes --}}

                <form action="/{{ $project->path() }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea
                    name="notes"
                    class="w-full mb-4 p-3"
                    style="min-height: 200px"
                    placeholder="Anything Special that you want to make a note of ? ">{{ $project->notes }}</textarea>
                   <input type="submit" value="Save" class="button-blue">
                </form>
                @include('projects._errors')
            </div>
        </div>
        <div class="lg:w-1/4 px-3">
            @include('projects._card')
            <div class="card mt-3">
                <ul class="list-reset text-sm">
                    @foreach ($project->activity as $activity)
                    <li class="{{ $loop->last ? '' : 'mb-1' }}">
                        @include("projects.activity.$activity->description")
                       <span class="text-gray"> {{ $activity->created_at->diffForHumans() }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</main>

@endsection
