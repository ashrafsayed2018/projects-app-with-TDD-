
    <div class="card" style="height: 200px">
        <h3 class="font-normal text-xl py-4 pl-4 -ml-5 mb-3 border-blue-300 border-l-4">
            <a href="/{{ $project->path() }}">{{ $project->title }}</a>

        </h3>
        <p class="text-gray-custom">{{ str_limit($project->description,100,'...') }}</p>
    </div>
