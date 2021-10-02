@extends('admin.master.master')

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Escrever Mensagem</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Email</li>
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
                    <div class="card card-teal card-outline">
                        <form action="{{ route('admin.email.sendEmail') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @php 
                            if(!empty($user)){
                                if($user->email != '' && $user->email != Auth::user()->email){
                                    $usernome = $user->name;
                                    $useremail = $user->email;
                                }else{
                                    $usernome = '';
                                    $useremail = '';
                                }
                            }elseif(!empty($empresa)){
                                if($empresa->email != '' && $empresa->email != Auth::user()->email){
                                    $usernome = $empresa->alias_name;
                                    $useremail = $empresa->email;
                                }else{
                                    $usernome = '';
                                    $useremail = '';
                                }
                            }else{
                                $usernome = '';
                                $useremail = '';
                            }
                            @endphp                            
                            <input type="hidden" name="destinatario_nome" value="{{$usernome}}">
                            <input type="hidden" name="remetente_nome" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="sitename" value="{{ $configuracoes->nomedosite }}">
                        <div class="card-header">
                            <label class="">Remetente:</label>
                            <select class="form-control" name="remetente_email">
                                <option value="{{ Auth::user()->email }}">{{ Auth::user()->email }}</option>
                                <option value="{{ Auth::user()->email1 }}">{{ Auth::user()->email1 }}</option>
                                <option value="{{ $configuracoes->email }}">{{ $configuracoes->email }}</option>
                                <option value="{{ $configuracoes->email1 }}">{{ $configuracoes->email1 }}</option>
                            </select>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label class="">Para:</label>
                                <input type="text" class="form-control" name="destinatario_email" placeholder="Para:" value="{{$useremail}}">
                            </div>
                            <p>
                                <a href="#" class="text-front open_cc">Com Cópia &darr;</a>
                            </p>
                            <div class="form-group copiapara" style="display: none;">
                                <input class="form-control" name="copiapara" placeholder="Cópia Para:" value="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="assunto" placeholder="Assunto:" value="">
                            </div>
                            <div class="form-group">
                                <textarea name="mensagem" id="compose-textarea">
                                <p>Olá {{ $usernome }},</p>     
                                
                                <p>{{ getPrimeiroNome(Auth::user()->name) }} digite sua mensagem aqui...</p>
                                <p style="font-size:11px;text-align:left;color:#666;margin-top: 40px;line-height:1em !important;">
                                att<br />
                                {{ Auth::user()->name }}<br />
                                @php 
                                   if(Auth::user()->whatsapp){ 
                                       echo 'WhatsApp: '.Auth::user()->whatsapp.'<br />';
                                    }
                                @endphp 
                                <b>{{ $configuracoes->nomedosite }}</b><br />
                                {{ $configuracoes->telefone1 }} {{ $configuracoes->telefone2 }} 
                                @php 
                                   if($configuracoes->whatsapp){ 
                                       echo '<br />WhatsApp: '.$configuracoes->whatsapp;
                                    }
                                    if($configuracoes->dominio){
                                        echo '<br /><a href="'.$configuracoes->dominio.'">website</a>';
                                    }
                                    if($configuracoes->facebook){
                                        echo ($configuracoes->dominio ? ' - <a href="'.$configuracoes->facebook.'">Facebook</a>' : '<br /><a href="'.$configuracoes->facebook.'">Facebook</a>') ;
                                    }
                                    if($configuracoes->instagram){
                                        echo ($configuracoes->dominio || $configuracoes->facebook ? ' - <a href="'.$configuracoes->instagram.'">Instagram</a>' : '<br /><a href="'.$configuracoes->instagram.'">Instagram</a>') ;
                                    }
                                    if($configuracoes->linkedin){
                                        echo ($configuracoes->dominio || $configuracoes->facebook || $configuracoes->instagram ? ' - <a href="'.$configuracoes->linkedin.'">Linkedin</a>' : '<br /><a href="'.$configuracoes->linkedin.'">Linkedin</a>') ;
                                    }
                                    if($configuracoes->youtube){
                                        echo ($configuracoes->dominio || $configuracoes->facebook || $configuracoes->instagram || $configuracoes->linkedin ? ' - <a href="'.$configuracoes->youtube.'">Youtube</a>' : '<br /><a href="'.$configuracoes->youtube.'">Youtube</a>') ;
                                    }
                                @endphp                                
                                </p>
                                </textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> Anexo
                                    <input type="file" name="anexos[]" multiple> 
                                    <!--<input type="file" name="anexo">-->
                                </div>
                                <p class="help-block">Tamanho Max. 5MB</p>
                                <p class="content_anexo"></p>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="far fa-envelope"></i> Enviar Agora</button>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

@endsection

@section('js')
    <script>
        $(function () {

            // FUNÇÃO PARA EXCLUIR OS ANEXOS DO EMAIL
            $('input[name="anexos[]').change(function (anexos){
                for (var i = 0; i < this.files.length; i++)
                {
                    $('.content_anexo').append(
                    '<span id="list">' + this.files[i].name + 
                    '<a href="javascript:void(0)" class="anexo-remove ml-3"><i class="nav-icon fas fa-times"></i></a>' +
                    '<br /></span>');                    
                }
                $('.anexo-remove').click(function(){
                    $(this).closest('#list').remove()
                });
            });

            $('.open_cc').on('click', function (event) {
                event.preventDefault();
                box = $(".copiapara");
                button = $(this);
                if (box.css("display") !== "none") {
                    button.text("Com cópia ↓");
                } else {
                    button.text("↑ Ocultar");
                }
                box.slideToggle();
            });

        });
    </script>
@endsection