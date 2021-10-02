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
    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="card card-danger">                
            <div class="card-body">
              <canvas id="donutChartusers" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
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
                <span class="info-box-text">Ativos: </span>
                <span class="info-box-text">Inativos: </span>
                <span class="info-box-text">Time: {{ $time }}</span>
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
    <script>  
    $(function (){
        var donutChartCanvasUsers = $('#donutChartusers').get(0).getContext('2d');
        var donutDatausers        = {
            labels: [ 
                'Clientes Inativos', 
                'Clientes Ativos',
                'Time'             
            ],
            datasets: [
                {
                data: [{{ $usersUnavailable }},{{ $usersAvailable }}, {{ $time }}],
                    backgroundColor : ['#4BC0C0', '#36A2EB', '#FF6384'],
                }
            ]
            }
            var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }

            var donutChart = new Chart(donutChartCanvasUsers, {
            type: 'doughnut',
            data: donutDatausers,
            options: donutOptions      
            });
    });    
    </script>
@stop
