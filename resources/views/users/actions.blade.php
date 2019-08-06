
<a href="#" class="showuser-modal btn btn-secondary btn-sm" id="ver-user" data-path="{{$path}}" data-id="{{$id}}" data-nombre="{{$nombre}}" data-apellido="{{$apellido}}" data-telefono="{{$telefono}}" data-tipo="{{$tipo_usuario}}" data-email="{{$email}}" data-numcontrol="{{$numcontrol}}" data-created_at="{{$created_at}}" data-updated_at="{{$updated_at}}"><i class="fa fa-eye"></i></a>
{{--{{ route('users.show', $id) }}--}}

{{--<a href="{{ route('users.destroy', $id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>--}}
<a href="#" class="btn btn-xs btn-primary edit-user" id="{{ $id }}"><i class="fas fa-user-edit"></i>Editar</a>
<a href="#" class="btn btn-xs btn-danger delete-user" id="{{ $id }}"><i class="fas fa-trash-alt"></i>Eliminar</a>

{{--<a href="{{ route('users.edit', $id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>--}}
