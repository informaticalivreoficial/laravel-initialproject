@extends('adminlte::page')

@section('title', 'Gerenciar Clientes')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Clientes</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Clientes</li>
        </ol>
    </div>
</div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-sm-6 my-2">
                    <div class="card-tools">
                        <div style="width: 250px;">
                            <form class="input-group input-group-sm" action="{{route('users.search')}}" method="post">
                                @csrf   
                                <input type="text" name="filter" value="{{ $filters['filter'] ?? '' }}" class="form-control float-right" placeholder="Pesquisar">
                
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-right">
                    <a href="{{route('users.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>        
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-12">                
                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                            {{ session()->get('message') }}
                        @endmessage
                    @endif
                </div>            
            </div>
            @if(!empty($users) && $users->count() > 0)
                <table class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Perfil</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)                    
                        <tr style="{{ ($user->status == '1' ? '' : 'background: #fffed8 !important;')  }}">
                            @php
                                if(!empty($user->avatar) && \Illuminate\Support\Facades\File::exists(public_path() . '/storage/' . $user->avatar)){
                                    $cover = url('storage/'.$user->avatar);
                                } else {
                                    if($user->genero == 'masculino'){
                                        $cover = url(asset('backend/assets/images/avatar5.png'));
                                    }else{
                                        $cover = url(asset('backend/assets/images/avatar3.png'));
                                    }
                                }
                            @endphp
                            <td class="text-center">
                                <a href="{{url($cover)}}" data-title="{{$user->name}}" data-toggle="lightbox">
                                    <img alt="{{$user->name}}" class="table-avatar" src="{{url($cover)}}">
                                </a>
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->cpf}}</td>
                            <td>{{$user->getFuncao()}}</td>
                            <td>
                                <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $user->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $user->status == true ? 'checked' : ''}}>
                                @if($user->whatsapp != '')
                                    <a target="_blank" href="{{getNumZap($user->whatsapp)}}" class="btn btn-xs btn-success text-white"><i class="fab fa-whatsapp"></i></a>
                                @endif 
                                <a href="{{--route('email.send',['id' => $user->id, 'parametro' => 'user'] )--}}" class="btn btn-xs text-white bg-teal"><i class="fas fa-envelope"></i></a>                           
                                <a href="{{route('users.view',['id' => $user->id])}}" class="btn btn-xs btn-info text-white"><i class="fas fa-search"></i></a>
                                <a href="{{route('users.edit',['id' => $user->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$user->id}}" data-toggle="modal" data-target="#modal-default">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>                
                </table>
            @else
                <div class="row mb-4">
                    <div class="col-12">                                                        
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>                                                        
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer paginacao">  
            @if (isset($filters))
                {{ $users->appends($filters)->links() }}
            @else
                {{ $users->links() }}
            @endif                
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->   
  

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm" action="" method="post">            
            @csrf
            @method('DELETE')
            <input id="id_user" name="user_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Usuário!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="j_param_data"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary">Excluir Agora</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.css'))}}">
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@stop

@section('js')
    <script src="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.min.js'))}}"></script>
    <script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
    <script>
       $(function () {           
           
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
              event.preventDefault();
              $(this).ekkoLightbox({
                alwaysShowClose: true
              });
            }); 
            
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var user_id = $(this).data('id');
                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('users.delete') }}",
                    data: {
                       'id': user_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_user').val(data.id);
                            $('#frm').prop('action','{{ route('users.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('users.deleteon') }}');
                        }
                    }
                });
            });
            
            $('#toggle-two').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });
            
            $('.toggle-class').on('change', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var user_id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('users.userSetStatus') }}",
                    data: {
                        'status': status,
                        'id': user_id
                    },
                    success:function(data) {
                        
                    }
                });
            });
        });
    </script>
@endsection