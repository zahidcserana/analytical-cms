<form action="{{ $url ?? Request::url() }}" method="POST">
    @csrf
    @method('DELETE')
    <button type='submit' class="{{ $class ?? 'btn btn-danger' }}">{!! $text ?? 'delete' !!}</button>
</form>