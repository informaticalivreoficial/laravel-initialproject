@extends('admin.master.master')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-user mr-2"></i> Perfil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Painel de Controle</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Clientes</a></li>
                    <li class="breadcrumb-item active">Perfil</li>
                </ol>
            </div>
        </div>        
    </div><!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-teal card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
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
              <img class="profile-user-img img-fluid img-circle" src="{{$cover}}" alt="{{$user->name}}">
            </div>

            <h3 class="profile-username text-center">{{$user->name}}</h3>

            <p class="text-muted text-center">{{$user->getFuncao()}}</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Telefone:</b> <a class="float-right">{{$user->telefone}}</a>
              </li>
              <li class="list-group-item">
                <b>Celular:</b> <a class="float-right">{{$user->celular}}</a>
              </li>
              <li class="list-group-item">
                <b>WhatsApp:</b> <a class="float-right">{{$user->whatsapp}}</a>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">          
          <div class="card-body">
              <h5 class="text-bold">Informações Pessoais</h5>
              <div class="row mt-3 text-muted">
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>CPF:</b> {{$user->cpf}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>RG:</b> {{$user->rg}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>RG/Expedição:</b> {{$user->rg_expedicao}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>Data de Nascimento:</b> {{$user->nasc}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>Naturalidade:</b> {{$user->naturalidade}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>Estado Civil:</b> {{$user->estado_civil}}</p>
                  </div>
              </div>
              <hr>
              <h5 class="text-bold">Informações de Contato</h5>
              <div class="row mt-3 text-muted">
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>telefone:</b> {{$user->telefone}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>Celular:</b> {{$user->celular}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>WhatsApp:</b> {{$user->whatsapp}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                      <p><b>Skype:</b> {{$user->skype}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-5">
                      <p><b>Email:</b> {{$user->email}}</p>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                      <p><b>Email 1:</b> {{$user->email1}}</p>
                  </div>                  
              </div>              
              <hr>
              <h5 class="text-bold">Endereço</h5>
              <div class="row mt-3 text-muted">
                  <div class="col-md-6">
                      <p><b>Endereço:</b> {{$user->rua}}</p>
                  </div>
                  <div class="col-md-3">
                      <p><b>Número:</b> {{$user->num}}</p>
                  </div>
                  <div class="col-md-3">
                      <p><b>Cep:</b> {{$user->cep}}</p>
                  </div>
              </div>
          </div>
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection