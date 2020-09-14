@component('files.partials._file', compact('file'))
    @slot('links')
        <div class="level">
            <div class="level-left">
                <p class="level-item">
                    {{ $file->isFree() ? 'Free' : $file->price . '$' }}
                </p>
                <p class="level-item">
                    @if(!$file->isApproved())
                        Pending Approval
                    @endif
                </p>
                <p class="level-item">
                    {{ $file->isLive() ? 'Live' : "Not Live" }}
                </p>
                <a href="{{ route('account.files.edit', $file) }}" class='level-item'>Make Changes</a>
            </div>
        </div>
    @endslot
@endcomponent
