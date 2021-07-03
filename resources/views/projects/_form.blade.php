
    <div class="field my-5">
        <label class="label mb-3 block" for="title">Title</label>

        <div class="control">
            <input type="text"
                   class="input w-full px-3 py-2 outline-none border border-gray-dark rounded"
                   name="title"
                   value="{{ $project->title }}"
                   placeholder="my next awesome project"
                   >
        </div>
    </div>

    <div class="field my-5">
        <label class="label block mb-5" for="description">Description</label>

        <div class="control">
            <textarea
                     name="description"
                     class="textarea w-full px-3 outline-none border h-48 border-gray-dark rounded"
                     placeholder="i should start learning piano"
                      >{{ $project->description }}</textarea>
        </div>
    </div>

    <div class="field">
        <div class="control flex justify-between">
            <button type="submit" class="button is-link button-blue focus:outline-none">{{ $project->exists ? 'Update' : 'Create' }} Project</button>
            <a href="/{{ $project->path() }}" class="bg-red-600 text-white py-2 px-3 rounded">Cancel</a>
        </div>
    </div>
    @include('projects._errors')



