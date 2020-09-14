@component('files.partials._file', compact('file'))
    @slot('links')
        <div class="level">
            <div class="level-left">
                <p class="level-item">
                    <a href="{{ route('admin.file.show', $file) }}">Preview Changes</a>
                </p>

                <p class="level-item">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('approve-{{ $file->id }}').submit()">Approve Changes</a>
                </p>

                <form action="{{ route('admin.files.updated.update', $file) }}" id="approve-{{ $file->id }}" method="POST" class="is-hidden">
                    {{ csrf_field() }}
                    {{ method_field("PATCH") }}
                </form>

                <p class="level-item">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('reject-{{ $file->id }}').submit()">Reject Changes</a>
                </p>

                <form action="{{ route('admin.files.updated.destroy', $file) }}" id="reject-{{ $file->id }}" method="POST" class="is-hidden">
                    {{ csrf_field() }}
                    {{ method_field("DELETE") }}
                </form>
            </div>
        </div>
    @endslot
@endcomponent
