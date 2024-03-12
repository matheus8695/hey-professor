@props([
    'action',
    'post' => null,
    'put' => null,
    'patch' => null,
    'delete' => null,
])

<form action="{{ $action }}" method="post" class="mx-auto">
    @csrf

    @if($put)
        @method('PUT')
    @endif

    @if($patch)
        @method('PATCH')
    @endif

    @if($delete)
        @method('DELETE')
    @endif

    {{ $slot }}

</form>
