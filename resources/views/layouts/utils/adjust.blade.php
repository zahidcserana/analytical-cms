<form action="{{ $url ?? Request::url() }}" method="POST">
    @csrf
    <button type='submit' class="{{ $class ?? 'btn btn-warning' }}">{!! $text ?? 'Next' !!}</button>
</form>