@if ($errors->any)
<div class="field mt-6">
    @foreach ($errors->all() as $error)
        <li class="text-red-600 text-sm">{{ $error }}</li>
    @endforeach
</div>
@endif
