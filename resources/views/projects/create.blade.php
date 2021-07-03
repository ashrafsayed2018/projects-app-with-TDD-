@extends('layouts.app')

@section('content')
<div class="bg-white mx-auto lg:w-1/2 my-5 p-10">
    <h1 class="heading text-center text-xl">Let's create something special </h1>
    <form method="POST" action="/projects">
        @csrf
        @include('projects._form', [
            'project' => new  App\Project,
            'buttonText' => 'Create Project'])
    </form>
</div>
@endsection
