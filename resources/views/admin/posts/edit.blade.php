@extends('admin.master.master')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Artigo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Painel de Controle</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.artigos.index')}}">Artigos</a></li>
                    <li class="breadcrumb-item active">Editar Artigo</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content text-muted">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
               @if($errors->all())
                    @foreach($errors->all() as $error)
                        @message(['color' => 'danger'])
                        {{ $error }}
                        @endmessage
                    @endforeach
                @endif 

                @if(session()->exists('message'))
                    @message(['color' => session()->get('color')])
                    {{ session()->get('message') }}
                    @endmessage
                @endif
            </div>            
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-teal card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-conteudo" role="tab" aria-controls="custom-tabs-conteudo" aria-selected="true">Conteúdo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-imagens" role="tab" aria-controls="custom-tabs-imagens" aria-selected="false">Imagens</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ route('admin.artigos.update', ['artigo' => $post->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tipo" value="artigo"/> 
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-conteudo" role="tabpanel" aria-labelledby="custom-tabs-conteudo-tab">
                                                       
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Título:</b></label>
                                            <input class="form-control" name="titulo" placeholder="Título do Artigo" value="{{old('titulo') ?? $post->titulo}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Autor:</b></label>
                                            <select class="form-control" name="autor">
                                                <option value="">Selecione o Autor</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ (old('autor') == $user->id ? 'selected' : ($user->id == $post->autor ? 'selected' : '')) }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Status:</b></label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ (old('status') == '1' ? 'selected' : ($post->status == 1 ? 'selected' : '')) }}>Publicado</option>
                                                <option value="0" {{ (old('status') == '0' ? 'selected' : ($post->status == 0 ? 'selected' : '')) }}>Rascunho</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Categoria:</b></label>
                                            <select name="categoria" class="form-control">
                                                @if(!empty($categorias) && $categorias->count() > 0)
                                                    <option value="">Selecione a Categoria</option>                                                    
                                                    @foreach($categorias as $categoria)
                                                        @if($categoria->tipo == 'artigo')
                                                            <optgroup label="{{ $categoria->titulo }}">  
                                                                @if($categoria->children)
                                                                    @foreach($categoria->children as $subcategoria)
                                                                        <option value="{{ $subcategoria->id }}" {{ (old('categoria') == $subcategoria->id ? 'selected' : ($subcategoria->id == $post->categoria ? 'selected' : '')) }}>{{ $subcategoria->titulo }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </optgroup>
                                                        @endif 
                                                    @endforeach
                                                @else
                                                    <option value="">Cadastre Categorias</option>
                                                @endif                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Permitir Comentários:</b></label>
                                            <select name="comentarios" class="form-control">
                                                <option value="1" {{ (old('comentarios') == '1' ? 'selected' : ($post->comentarios == 1 ? 'selected' : '')) }}>Sim</option>
                                                <option value="0" {{ (old('comentarios') == '0' ? 'selected' : ($post->comentarios == 0 ? 'selected' : '')) }}>Não</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Agendar Publicação:</b></label>
                                            <div class="input-group date" id="publish" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" data-target="#publish" name="publish_at" value="{{ old('publish_at') ?? $post->publish_at }}"/>
                                                <div class="input-group-append" data-target="#publish" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-1"> 
                                        <div class="form-group">
                                            <label class="labelforms"><b>MetaTags:</b></label>
                                            <input id="tags_1" class="tags" rows="5" name="tags" value="{{old('tags') ?? $post->tags}}">
                                        </div>
                                    </div>
                                    <div class="col-12">   
                                        <label class="labelforms"><b>Conteúdo:</b></label>
                                        <textarea id="compose-textarea" name="content" cols="30" rows="10" placeholder="Escreva o conteúdo do artigo aqui">{{ old('content') ?? $post->content }}</textarea>                                                      
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="tab-pane fade" id="custom-tabs-imagens" role="tabpanel" aria-labelledby="custom-tabs-imagens-tab">
                                <div class="row mb-4">
                                    <div class="col-sm-12">                                        
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="files[]" multiple>
                                                <label class="custom-file-label" for="exampleInputFile">Escolher Arquivos</label>
                                            </div>
                                        </div>
                                        
                                        <div class="content_image"></div> 
                                        
                                        <div class="property_image">
                                            @foreach($post->images()->get() as $image)
                                            <div class="property_image_item">
                                                <a href="{{ $image->getUrlImageAttribute() }}" data-toggle="lightbox" data-gallery="property-gallery" data-type="image">
                                                <img src="{{ $image->url_cropped }}" alt="">
                                                </a>
                                                <div class="property_image_actions">
                                                    <a href="javascript:void(0)" class="btn btn-xs {{ ($image->cover == true ? 'btn-success' : 'btn-default') }} icon-notext image-set-cover px-2" data-action="{{ route('admin.artigos.imageSetCover', ['image' => $image->id]) }}"><i class="nav-icon fas fa-check"></i> </a>
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove px-2" data-action="{{ route('admin.artigos.imageRemove', ['image' => $image->id]) }}"><i class="nav-icon fas fa-times"></i> </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row text-right">
                            <div class="col-12 mb-4">
                                <button type="submit" class="btn btn-success btn-lg"><i class="nav-icon fas fa-check mr-2"></i> Atualizar Agora</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                </div>
                
                
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@section('js')
    <script>
        $(function () {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            //Date range picker
            $('#publish').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'pt-br'
            });  
            
            $('input[name="files[]"]').change(function (files) {

                $('.content_image').text('');

                $.each(files.target.files, function (key, value) {
                    var reader = new FileReader();
                    reader.onload = function (value) {
                        $('.content_image').append(
                            '<div id="list" class="property_image_item">' +
                            '<div class="embed radius" style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;"></div>' +
                            '<div class="property_image_actions">' +
                                '<a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove1 px-2"><i class="nav-icon fas fa-times"></i> </a>' +
                            '</div>' +
                            '</div>');
                            
                        $('.image-remove1').click(function(){
                            $(this).closest('#list').remove()
                        });
                    };
                    reader.readAsDataURL(value);
                });
            });
            
            
            
            $('.image-set-cover').click(function (event) {
                event.preventDefault();
                var button = $(this);
                $.post(button.data('action'), {}, function (response) {
                    if (response.success === true) {
                        $('.property_image').find('a.btn-success').removeClass('btn-success');
                        button.addClass('btn-success');
                    }
                    if(response.success === false){
                        button.addClass('btn-default');
                    }
                }, 'json');
            });
            
            $('.image-remove').click(function(event){
                event.preventDefault();
                var button = $(this);
                $.ajax({
                    url: button.data('action'),
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(response){
                        if(response.success === true) {
                            button.closest('.property_image_item').fadeOut(function(){
                                $(this).remove();
                            });
                        }
                    }
                });
            });
            
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
              event.preventDefault();
              $(this).ekkoLightbox({
                alwaysShowClose: true
              });
            });
            
            //tag input
            function onAddTag(tag) {
                alert("Adicionar uma Tag: " + tag);
            }
            function onRemoveTag(tag) {
                alert("Remover Tag: " + tag);
            }
            function onChangeTag(input,tag) {
                alert("Changed a tag: " + tag);
            }
            $(function() {
                $('#tags_1').tagsInput({
                    width:'auto',
                    height:200
                });
            });
        });
    </script>
@endsection