
<a href="#" class="showmobi-modal btn btn-secondary btn-sm ver-mobi" id="{{ $id }}"><i class="fa fa-eye"></i></a>
{{--{{ route('users.show', $id) }}--}}

<a href="{{ route('mobis.destroy', $id) }}" class="btn btn-danger btn-sm delete-mobi"><i class="fas fa-trash-alt"></i></a>

<a href="#{{--{{ route('mobis.edit', $id) }}--}}" class="btn btn-primary btn-sm edit-mobi" id="{{ $id }}"><i class="far fa-edit"></i></a>
