@if (session('error') || session('success') || session('warning'))
    <div class="alert @if (session('error')) alert-danger @elseif (session('success')) alert-success @else alert-warning @endif alert-dismissible fade show my-2" role="alert">
        {{ session('error') ?? (session('success') ?? session('warning')) }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }} <br>
        @endforeach
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($isWarning)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span class="fas fa-bullhorn me-1"></span>
        <strong>{{ $title }}</strong> {{ $text }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
