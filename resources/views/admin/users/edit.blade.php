@extends('adminlte::page')

@section('title', 'Editar Usuário')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Editar Usuário</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Usuários</a></li>
            <li class="breadcrumb-item active">Editar Usuário</li>
        </ol>
    </div>
</div>
@stop

@section('content')    
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
        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="row">            
                <div class="col-12">
                    <div class="card card-teal card-outline card-outline-tabs">

                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Dados Cadastrais</a>
                                </li>                               
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Dados Complementares</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-redes-tab" data-toggle="pill" href="#custom-tabs-four-redes" role="tab" aria-controls="custom-tabs-four-redes" aria-selected="false">Redes Sociais</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-permissoes-tab" data-toggle="pill" href="#custom-tabs-four-permissoes" role="tab" aria-controls="custom-tabs-four-permissoes" aria-selected="false">Permissões</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">


                                    <div class="row">                                        
                                        <div class="col-12 col-md-6 col-lg-3"> 
                                            <div class="form-group">
                                                <div class="thumb_user_admin">
                                                    @php
                                                        if(!empty($user->avatar) && \Illuminate\Support\Facades\File::exists(public_path() . '/storage/' . $user->avatar)){
                                                            $cover = url('storage/'.$user->avatar);
                                                        } else {
                                                            $cover = url(asset('backend/assets/images/image.jpg'));
                                                        }
                                                    @endphp
                                                    <img id="preview" src="{{$cover}}" alt="{{ old('name') ?? $user->name }}" title="{{ old('name') ?? $user->name }}"/>
                                                    <input id="img-input" type="file" name="avatar">
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-9"> 
                                            <div class="row mb-2">
                                                <div class="col-12 col-md-6 col-lg-8 mb-2">
                                                    <div class="form-group">
                                                        <label class="labelforms text-muted"><b>*Nome</b></label>
                                                        <input type="text" class="form-control" placeholder="Nome do Cliente" name="name" value="{{ old('name') ?? $user->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                    <div class="form-group">
                                                        <label class="labelforms text-muted"><b>*Data de Nascimento</b></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control datepicker-here" data-language='pt-BR' name="nasc" value="{{ old('nasc') ?? $user->nasc }}"/>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                    <div class="form-group">
                                                        <label class="labelforms text-muted"><b>*Genero</b></label>
                                                        <select class="form-control" name="genero">
                                                            <option value="masculino" {{(old('genero') == 'masculino' ? 'selected' : ($user->genero == 'masculino' ? 'selected' : '')) }}>Masculino</option>
                                                            <option value="feminino" {{(old('genero') == 'feminino' ? 'selected' : ($user->genero == 'feminino' ? 'selected' : '')) }}>Feminino</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                 <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                    <div class="form-group">
                                                        <label class="labelforms text-muted"><b>*Estado Civil</b></label>
                                                        <select class="form-control" name="estado_civil">
                                                            <optgroup label="Cônjuge Obrigatório">
                                                                <option value="casado" {{ (old('estado_civil') == 'casado' ? 'selected' : ($user->estado_civil == 'casado' ? 'selected' : '')) }}>Casado</option>
                                                                <option value="separado" {{ (old('estado_civil') == 'separado' ? 'selected' : ($user->estado_civil == 'separado' ? 'selected' : '')) }}>Separado</option>
                                                                <option value="solteiro" {{ (old('estado_civil') == 'solteiro' ? 'selected' : ($user->estado_civil == 'solteiro' ? 'selected' : '')) }}>Solteiro</option>
                                                                <option value="divorciado" {{ (old('estado_civil') == 'divorciado' ? 'selected' : ($user->estado_civil == 'divorciado' ? 'selected' : '')) }}>Divorciado</option>
                                                                <option value="viuvo" {{ (old('estado_civil') == 'viuvo' ? 'selected' : ($user->estado_civil == 'viuvo' ? 'selected' : '')) }}>Viúvo(a)</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                    <div class="form-group">
                                                        <label class="labelforms text-muted"><b>*CPF</b></label>
                                                        <input type="text" class="form-control cpfmask" placeholder="CPF do Cliente" name="cpf" value="{{ old('cpf') ?? $user->cpf }}"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                    <div class="form-group">
                                                        <label class="labelforms text-muted"><b>RG</b></label>
                                                        <input type="text" class="form-control rgmask" placeholder="RG do Cliente" name="rg" value="{{ old('rg') ?? $user->rg }}"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                    <div class="form-group">
                                                        <label class="labelforms text-muted"><b>Órgão Expedidor</b></label>
                                                        <input type="text" class="form-control" placeholder="Expedição" name="rg_expedicao" value="{{ old('rg_expedicao') ?? $user->rg_expedicao }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                    <div class="form-group">
                                                        <label class="labelforms text-muted"><b>Naturalidade</b></label>
                                                        <input type="text" class="form-control" placeholder="Cidade de Nascimento" name="naturalidade" value="{{ old('naturalidade') ?? $user->naturalidade }}">
                                                    </div>
                                                </div>
                                            </div>                                           
                                        </div>
                                        
                                    </div>

                                    <div id="accordion">   
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>                          
                                                    <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseRenda">
                                                        <i class="nav-icon fas fa-plus mr-2"></i> Renda
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseRenda" class="panel-collapse collapse show">
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Profissão:</b></label>
                                                                <input type="text" class="form-control" placeholder="Profissão do Cliente" name="profissao" value="{{old('profissao') ?? $user->profissao}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Renda:</b></label>
                                                                <input type="text" class="form-control mask-money" placeholder="Valores em Reais" name="renda" value="{{old('renda') ?? $user->renda}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Empresa:</b></label>
                                                                <input type="text" class="form-control" placeholder="Contratante" name="profissao_empresa" value="{{old('profissao_empresa') ?? $user->profissao_empresa}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>
                                                    <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseEndereco">
                                                        <i class="nav-icon fas fa-plus mr-2"></i> Endereço
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseEndereco" class="panel-collapse collapse show">
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Estado:</b></label>
                                                                <select id="state-dd" class="form-control" name="uf">
                                                                    @if(!empty($estados))
                                                                        @foreach($estados as $estado)
                                                                        <option value="{{$estado->estado_id}}" {{ (old('uf') == $estado->estado_id ? 'selected' : ($user->uf == $estado->estado_id ? 'selected' : '')) }}>{{$estado->estado_nome}}</option>
                                                                        @endforeach                                                                        
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Cidade:</b></label>
                                                                <select id="city-dd" class="form-control" name="cidade">
                                                                    @if(!empty($cidades) && !empty($user->cidade))
                                                                        @foreach($cidades as $cidade)
                                                                        <option value="{{$cidade->cidade_id}}" {{ (old('cidade') == $cidade->cidade_id ? 'selected' : ($user->cidade == $cidade->cidade_id ? 'selected' : '')) }}>{{$cidade->cidade_nome}}</option>
                                                                        @endforeach                                                                        
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Bairro:</b></label>
                                                                <input type="text" class="form-control" placeholder="Bairro" name="bairro" value="{{old('bairro') ?? $user->bairro}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-12 col-md-6 col-lg-5"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Endereço:</b></label>
                                                                <input type="text" class="form-control" placeholder="Endereço Completo" name="rua" value="{{old('rua') ?? $user->rua}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-2"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Número:</b></label>
                                                                <input type="text" class="form-control" placeholder="Número do Endereço" name="num" value="{{old('num') ?? $user->num}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Complemento:</b></label>
                                                                <input type="text" class="form-control" placeholder="Completo (Opcional)" name="complemento" value="{{old('complemento') ?? $user->complemento}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-2"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>CEP:</b></label>
                                                                <input type="text" class="form-control mask-zipcode" placeholder="Digite o CEP" name="cep" value="{{old('cep') ?? $user->cep}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>
                                                    <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseContato">
                                                        <i class="nav-icon fas fa-plus mr-2"></i> Contato
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContato" class="panel-collapse collapse show">
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-12 col-md-6 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Residencial:</b></label>
                                                                <input type="text" class="form-control telefonemask" placeholder="Número do Telefonce com DDD" name="telefone" value="{{old('telefone') ?? $user->telefone}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>*Celular:</b></label>
                                                                <input type="text" class="form-control celularmask" placeholder="Número do Celuler com DDD" name="celular" value="{{old('celular') ?? $user->celular}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>WhatsApp:</b></label>
                                                                <input type="text" class="form-control whatsappmask" placeholder="Número do Celuler com DDD" name="whatsapp" value="{{old('whatsapp') ?? $user->whatsapp}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>E-mail Alternativo:</b></label>
                                                                <input type="text" class="form-control" placeholder="Email Alternativo" name="email1" value="{{old('email1') ?? $user->email1}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Skype:</b></label>
                                                                <input type="text" class="form-control" placeholder="Usuário Skype" name="skype" value="{{old('skype') ?? $user->skype}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>
                                                    <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                                        <i class="nav-icon fas fa-plus mr-2"></i> Acesso
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFour" class="panel-collapse collapse show">
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-6 col-md-6 col-lg-6"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>*E-mail:</b></label>
                                                                <input type="email" class="form-control" placeholder="Melhor e-mail" name="email" value="{{old('email') ?? $user->email}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-6 col-lg-6"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>*Senha:</b></label>
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control" id="senha" name="password" value="{{ old('senha') ?? $user->senha }}"/>
                                                                    <div class="input-group-append" id="olho">
                                                                        <div class="input-group-text"><i class="fa fa-eye"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div> 
                                </div>
                                
                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>
                                                    <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                                        <i class="nav-icon fas fa-plus mr-2"></i> Cônjuge
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFive" class="panel-collapse collapse content_spouse show">
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-12 col-md-6 col-lg-3"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Tipo de Comunhão:</b></label>
                                                                <select class="form-control" name="tipo_de_comunhao">
                                                                    <option value="universal" {{ (old('tipo_de_comunhao') == 'universal' ? 'selected' : ($user->tipo_de_comunhao == 'universal' ? 'selected' : '')) }}>Comunhão Universal de Bens</option>
                                                                    <option value="parcial" {{ (old('tipo_de_comunhao') == 'parcial' ? 'selected' : ($user->tipo_de_comunhao == 'parcial' ? 'selected' : '')) }}>Comunhão Parcial de Bens</option>
                                                                    <option value="total" {{ (old('tipo_de_comunhao') == 'total' ? 'selected' : ($user->tipo_de_comunhao == 'total' ? 'selected' : '')) }}>Separação Total de Bens</option>
                                                                    <option value="final" {{ (old('type_of_communion') == 'final' ? 'selected' : ($user->tipo_de_comunhao == 'final' ? 'selected' : '')) }}>Participação Final de Aquestos</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>*Nome</b></label>
                                                                <input type="text" class="form-control" placeholder="Nome do Cônjuge" name="nome_conjuje" value="{{ old('nome_conjuje') ?? $user->nome_conjuje }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>*Data de Nascimento</b></label>
                                                                <div class="input-group date">
                                                                    <input type="text" class="form-control datepicker-here" data-language='pt-BR' name="nasc_conjuje" value="{{ old('nasc_conjuje') ?? $user->nasc_conjuje }}"/>
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-2"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>*Genero</b></label>
                                                                <select class="form-control" name="genero_conjuje">
                                                                    <option value="masculino" {{(old('genero_conjuje') == 'masculino' ? 'selected' : ($user->genero_conjuje == 'masculino' ? 'selected' : ''))}}>Masculino</option>
                                                                    <option value="feminino" {{(old('genero_conjuje') == 'feminino' ? 'selected' : ($user->genero_conjuje == 'feminino' ? 'selected' : ''))}}>Feminino</option>
                                                                </select>
                                                            </div>
                                                        </div>                                                                                                      
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-12 col-md-6 col-lg-3"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>*CPF</b></label>
                                                                <input type="text" class="form-control cpfmask" placeholder="CPF do Cônjuge" name="cpf_conjuje" value="{{ old('cpf_conjuje') ?? $user->cpf_conjuje }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>RG</b></label>
                                                                <input type="text" class="form-control rgmask" placeholder="RG do Cônjuge" name="rg_conjuje" value="{{ old('rg_conjuje') ?? $user->rg_conjuje }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Órgão Expedidor</b></label>
                                                                <input type="text" class="form-control" placeholder="Expedição" name="rg_expedicao_conjuje" value="{{ old('rg_expedicao_conjuje') ?? $user->rg_expedicao_conjuje }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Naturalidade</b></label>
                                                                <input type="text" class="form-control" placeholder="Cidade de Nascimento do Cônjuge" name="naturalidade_conjuje" value="{{ old('naturalidade_conjuje') ?? $user->naturalidade_conjuje }}">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row mb-2">
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Profissão:</b></label>
                                                                <input type="text" class="form-control" placeholder="Profissão do Cliente" name="profissao_conjuje" value="{{old('profissao_conjuje') ?? $user->profissao_conjuje}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Renda:</b></label>
                                                                <input type="text" class="form-control mask-money" placeholder="Valores em Reais" name="renda_conjuje" value="{{old('renda_conjuje') ?? $user->renda_conjuje}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>Empresa:</b></label>
                                                                <input type="text" class="form-control" placeholder="Contratante" name="profissao_empresa_conjuje" value="{{old('profissao_empresa_conjuje') ?? $user->profissao_empresa_conjuje}}">
                                                            </div>
                                                        </div>
                                                    </div>                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                        
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-redes" role="tabpanel" aria-labelledby="custom-tabs-four-redes-tab">
                                    <div class="row mb-2 text-muted">
                                        <div class="col-sm-12 text-muted">
                                            <div class="form-group">
                                                <h5><b>Redes Sociais</b></h5>            
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>Facebook:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="Facebook" name="facebook" value="{{old('facebook') ?? $user->facebook}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>Twitter:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="Twitter" name="twitter" value="{{old('twitter') ?? $user->twitter}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>Youtube:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="Youtube" name="youtube" value="{{old('youtube') ?? $user->youtube}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>Flickr:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="Flickr" name="fliccr" value="{{old('fliccr') ?? $user->fliccr}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>Instagram:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="Instagram" name="instagram" value="{{old('instagram') ?? $user->instagram}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>Vimeo:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="Vimeo" name="vimeo" value="{{old('vimeo') ?? $user->vimeo}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>Linkedin:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="Linkedin" name="linkedin" value="{{old('linkedin') ?? $user->linkedin}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>Sound Cloud:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="Linkedin" name="soundclound" value="{{old('soundclound') ?? $user->soundclound}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4"> 
                                            <div class="form-group">
                                                <label class="labelforms text-muted"><b>SnapChat:</b></label>
                                                <input type="text" class="form-control text-muted" placeholder="SnapChat" name="snapchat" value="{{old('snapchat') ?? $user->snapchat}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="tab-pane fade" id="custom-tabs-four-permissoes" role="tabpanel" aria-labelledby="custom-tabs-four-permissoes-tab">
                                    <div class="row mb-2 text-muted">
                                        <div class="col-sm-12 bg-gray-light mb-3">                                        
                                            <!-- checkbox -->
                                            <div class="form-group p-3 mb-0">
                                                <span class="mr-3"><b>Acesso ao Sistema:</b></span> 
                                                <div class="form-check d-inline mx-2">
                                                    <input id="editor" class="form-check-input" type="checkbox" name="editor" {{ (old('editor') == 'on' || old('editor') == true ? 'checked' : ($user->editor == true ? 'checked' : '')) }}>
                                                    <label for="editor" class="form-check-label">Editor</label>
                                                </div> 
                                                <div class="form-check d-inline mx-2">
                                                    <input id="admin" class="form-check-input" type="checkbox" name="admin" {{ (old('admin') == 'on' || old('admin') == true ? 'checked' : ($user->admin == true ? 'checked' : '')) }}>
                                                    <label for="admin" class="form-check-label">Administrativo</label>
                                                </div>
                                                <div class="form-check d-inline mx-2">
                                                    <input id="client" class="form-check-input" type="checkbox"  name="client" {{ (old('client') == 'on' || old('client') == true ? 'checked' : ($user->client == true ? 'checked' : '')) }}>
                                                    <label for="client" class="form-check-label">Cliente</label>
                                                </div>
                                                @if(\Illuminate\Support\Facades\Auth::user()->superadmin == 1)
                                                <div class="form-check d-inline mx-2">
                                                    <input id="superadmin" class="form-check-input" type="checkbox"  name="superadmin" {{ (old('superadmin') == 'on' || old('superadmin') == true ? 'checked' : ($user->superadmin == true ? 'checked' : '')) }}>
                                                    <label for="superadmin" class="form-check-label">Super Administrador</label>
                                                </div>
                                                @endif
                                            </div>
                                        </div>                                        
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="row text-right">
                                <div class="col-12 mb-4">
                                    <button type="submit" class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i> Atualizar Agora</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->

                        
                    </div>
                </div>
            </div>

              

        </form>


@stop

@section('css')    
    <style>
        /* Foto User Admin */
        .thumb_user_admin{
        border: 1px solid #ddd;
        border-radius: 4px; 
        text-align: center;
        }
        .thumb_user_admin input[type=file]{
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        .thumb_user_admin img{
            width: 100%;            
        }
    </style>
<link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
@stop

@section('js')
<script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $Cpf = $(".cpfmask");
        $Cpf.mask('000.000.000-00', {reverse: true});
        var $whatsapp = $(".whatsappmask");
        $whatsapp.mask('(99) 99999-9999', {reverse: false});
        var $telefone = $(".telefonemask");
        $telefone.mask('(99) 9999-9999', {reverse: false});
        var $celularmask = $(".celularmask");
        $celularmask.mask('(99) 99999-9999', {reverse: false});
        var $zipcode = $(".mask-zipcode");
        $zipcode.mask('00.000-000', {reverse: true});
        var $money = $(".mask-money");
        $money.mask('R$ 000.000.000.000.000,00', {reverse: true, placeholder: "R$ 0,00"});
    });
</script>    
    <script>
        
        $(function () {  
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });  

            function normalizeSpouse() {
                if (typeof ($('select[name="estado_civil"]')) !== 'undefined') {
                    if ($('select[name="estado_civil"]').val() === 'casado' || $('select[name="estado_civil"]').val() === 'separado') {
                        $('.content_spouse input, .content_spouse select').prop('disabled', false);
                    } else {
                        $('.content_spouse input, .content_spouse select').prop('disabled', true);
                    }
                }
            }
            normalizeSpouse();
            $('select[name="estado_civil"]').change(function () {
                normalizeSpouse();
            });          
                    
            function readImage() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        document.getElementById("preview").src = e.target.result;
                    };       
                    file.readAsDataURL(this.files[0]);
                }
            }
            document.getElementById("img-input").addEventListener("change", readImage, false);
                        
           
            $('#state-dd').on('change', function () {
                var idState = this.value;
                $("#city-dd").html('');
                $.ajax({
                    url: "{{route('users.fetchCity')}}",
                    type: "POST",
                    data: {
                        estado_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city-dd').html('<option value="">Selecione a cidade</option>');
                        $.each(res.cidades, function (key, value) {
                            $("#city-dd").append('<option value="' + value
                                .cidade_id + '">' + value.cidade_nome + '</option>');
                        });
                    }
                });
            });
            
            // Visualizar senha no input
            var senha = $('#senha');
            var olho= $("#olho");
            olho.mousedown(function() {
                senha.attr("type", "text");
            });
            olho.mouseup(function() {
                senha.attr("type", "password");
            });
            
        });
    </script>
@stop