@extends('adminlte::page')

@section('title', 'Painel de Controle')

@section('css')
<style>
.info-box .info-box-content {   
    line-height: 120%;
}
</style>
@stop

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Painel de Controle</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Início</a></li>
            <li class="breadcrumb-item active">Painel de Controle</li>
        </ol>
    </div><!-- /.col -->
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-teal"><a href="{{--route('admin.imoveis.index')--}}" title="Imóveis"><i class="fa far fa-home"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Tenants</b></span>
                <span class="info-box-text">Disponíveis: {{-- $imoveisAvailable --}}</span>
                <span class="info-box-text">Inativos: {{-- $imoveisUnavailable --}}</span>
                <span class="info-box-text">Total: {{-- $imoveisTotal --}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-teal"><a href="{{--route('admin.users.index')--}}" title="Clientes"><i class="fa far fa-users"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Clientes</b></span>
                <span class="info-box-text">Locadores: </span>
                <span class="info-box-text">Locatários: </span>
                <span class="info-box-text">Time: {{-- $time --}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-teal"><a href="{{--route('admin.artigos.index')--}}" title="Artigos"><i class="fa far fa-pen"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Artigos</b></span>
                <span class="info-box-text">Publicados: {{-- $postsPostson --}}</span>
                <span class="info-box-text">Rascunhos: {{-- $postsPostsoff --}}</span>
                <span class="info-box-text">Total: {{-- $postsTotal --}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- ./col -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="info-box">
        <span class="info-box-icon bg-teal"><a href="{{--route('admin.empresas.index')--}}" title="Empresas"><i class="fa far fa-city"></i></a></span>

        <div class="info-box-content">
            <span class="info-box-text"><b>Empresas</b></span>
            <span class="info-box-text">Publicadas: {{--$empresasAvailable--}}</span>
            <span class="info-box-text">Rascunhos: {{--$empresasUnavailable--}}</span>
            <span class="info-box-text">Total: {{--$empresasTotal--}}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- ./col -->
</div>
@stop

@section('js')
    <script>  </script>
@stop
