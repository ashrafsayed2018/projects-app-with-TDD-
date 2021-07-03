@extends('layouts.app')

@section('content')
<div class="bg-white mx-auto lg:w-1/2 my-5 p-10">
    <h1 class="heading text-center text-xl">Edit the project </h1>
    <form
        method="POST"
        action="/{{ $project->path() .'/edit'}}">
        @csrf
        @method('PATCH')
        @include('projects._form', [
            'buttonText' => 'Updated Project'])
    </form>
</div>

@endsection
