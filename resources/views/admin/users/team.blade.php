@extends('adminlte::page')

@section('title', 'Gerenciar Time')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Time</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Time</li>
        </ol>
    </div>
</div>
@stop

@section('content')

<!-- Main content -->
<section class="content">
    <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
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
                <div class="row d-flex align-items-stretch">
                @foreach($users as $user)  
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light" style="{{ ($user->status == '1' ? '' : 'background: #fffed8 !important;')  }}">
                    <div class="card-header text-muted border-bottom-0">
                      {{$user->profissao}}
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b>{{$user->name}}</b></h2>
                          <p class="text-muted text-sm">{{$user->getFuncao()}}</p>
                          <p class="text-muted text-sm"><b>Data de Entrada: </b><br> 
                               {{$user->created_at}}</p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small">
                                @if($user->rua != '')
                                <span class="fa-li">
                                    <i class="fas fa-lg fa-home"></i>
                                </span> {{$user->rua}}
                                @endif
                                @if($user->rua != '' && $user->num != '')
                                    , {{$user->num}}
                                @endif
                                @if($user->rua != '' || $user->num != '')
                                    , {{$user->bairro}}
                                @endif
                                @if($user->rua != '' || $user->num != '' || $user->bairro != '')
                                    - {{ getCidadeNome($user->cidade, 'cidades') }}
                                @endif
                            </li>
                            @if($user->telefone)
                                <li class="small">
                                    <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> 
                                    {{$user->telefone}}
                                    @if($user->celular)
                                    - {{$user->celular}}
                                    @endif
                                </li>
                            @endif

                          </ul>
                        </div>
                        <div class="col-5 text-center">
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
                          <img src="{{url($cover)}}" alt="" class="img-circle img-fluid">
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="text-right"> 
                        <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $user->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $user->status == true ? 'checked' : ''}}> 
                        @php
                        if($user->id != Auth::user()->id){
                        @endphp 
                        @if($user->whatsapp != '')
                            <a target="_blank" href="{{getNumZap($user->whatsapp)}}" class="btn btn-xs btn-success text-white"><i class="fab fa-whatsapp"></i></a>
                        @endif 
                        <a href="{{route('email.send',['id' => $user->id, 'parametro' => 'user'] )}}" class="btn btn-xs text-white bg-teal"><i class="fas fa-envelope"></i></a>
                        @php
                        }
                        @endphp                    
                        <a href="{{route('users.view',['id' => $user->id])}}" class="btn btn-xs btn-primary"><i class="fas fa-search"></i></a>
                        @if($user->superadmin == true && \Illuminate\Support\Facades\Auth::user()->admin == true)
                            
                        @elseif($user->superadmin == true && \Illuminate\Support\Facades\Auth::user()->superadmin == true)
                            <a href="{{route('users.edit',['id' => $user->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                        @else
                            <a href="{{route('users.edit',['id' => $user->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                        @endif
                        
                        
                        <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-campo="{{$user->name}}" data-id="{{$user->id}}" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach            
              </div>
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
        <!-- /.card-body -->
        <div class="card-footer paginacao">  
            {{ $users->links() }}
        </div>
          
      </div>
      <!-- /.card -->
</section>

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

@endsection

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
                        console.log(data);
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
