<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projects</title>
@extends('layouts.app')


@section('content')
<header class="flex items-end mb-3 py-3">
    <div class="w-full flex justify-between items-center">
        <h2 class="text-gray-darkest font-normal text-sm">My Projects </h2>
        <a href="/projects/create" class="text-gray-darkest button-blue">New Project</a>
    </div>
</header>

{{-- PROJECT CARD  --}}

<div class="lg:flex lg:flex-wrap -mx-3">
    @forelse ($projects as $project)
     <div class="lg:w-1/3 px-3 pb-6">
      @include('projects._card')
     </div>
    @empty
        <p>No Projects yet</p>
    @endforelse
</div>

@endsection


