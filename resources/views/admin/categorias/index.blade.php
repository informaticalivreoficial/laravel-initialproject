@extends('adminlte::page')

@section('title', 'Gerenciar Artigos')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Categorias</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Categorias</li>
        </ol>
    </div>
</div>
@stop

@section('content')

    <div class="card">
        <div class="card-header text-right">
            <a href="{{route('categorias.create',['catpai' => 'null'])}}" class="btn btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Categoria</a>
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
            @if(!empty($categorias) && $categorias->count() > 0)
                <table id="example1" class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th class="text-center">Exibir?</th>
                            <th class="text-center">Criada em</th>
                            <th class="text-center">Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($categorias as $categoria)                        
                        <tr style="{{ ($categoria->status == 'Sim' ? '' : 'background: #fffed8 !important;')  }}">                            
                            <td><img src="{{url(asset('backend/assets/images/seta.png'))}}"/> <b>{{$categoria->titulo}}</b></td>
                            <td class="text-center"> ---- </td>
                            <td class="text-center">{{$categoria->created_at}}</td>
                            <td class="text-center">{{$categoria->tipo}}</td>
                            <td>
                                <a href="{{route('categorias.create', ['catpai' => $categoria->id])}}" class="btn btn-xs btn-success">Criar Subcategoria</a>
                                <a href="{{ route('categorias.edit', [ 'id' => $categoria->id]) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$categoria->id}}" data-toggle="modal" data-target="#modal-default">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                            @if ($categoria->children)
                                @foreach($categoria->children as $subcategoria)                        
                                <tr style="">                            
                                    <td><img src="{{url(asset('backend/assets/images/setaseta.png'))}}"/> {{$subcategoria->titulo}}</td>
                                    <td class="text-center">{{$subcategoria->status}}</td>
                                    <td class="text-center">{{$subcategoria->created_at}}</td>
                                    <td class="text-center">{{$subcategoria->tipo}}</td>
                                    <td>
                                        <a href="{{ route('categorias.edit', [ 'id' => $subcategoria->id ]) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$subcategoria->id}}" data-toggle="modal" data-target="#modal-default">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
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
            {{ $categorias->links() }}
        </div>
    </div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm" action="" method="post">            
            @csrf
            @method('DELETE')
            <input id="id_categoria" name="categoria_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Categoria!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="j_param_data"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary onoff">Excluir Agora</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
       $(function () {
           
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var categoria_id = $(this).data('id');
                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('categorias.delete') }}",
                    data: {
                       'id': categoria_id
                    },
                    success:function(data) {
                        if(data.erroron){   
                            $('.onoff').attr('disabled', false);
                            $('.j_param_data').html(data.erroron);
                            $('#id_categoria').val(data.id);
                            $('#frm').prop('action','{{ route('categorias.deleteon') }}');
                        }else if(data.error){
                            $('.onoff').attr('disabled', true);
                            $('.j_param_data').html(data.error);
                        }else{
                            $('.onoff').attr('disabled', false);
                            $('#id_categoria').val(data.id);
                            $('#frm').prop('action','{{ route('categorias.deleteon') }}');
                        }
                    }
                });
            });           
            
        });
    </script>
@stop