@component('mail::layout')

{{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        <!-- header here -->
    @endcomponent
@endslot
{{-- Body --}}
<div style="width:100%; padding:10px;"> 
    <div style="background:#FFF;">       
        <h2>Esqueceu Sua Senha?</h2> 
        <p>Olá {{$nome}},</p>
        <p>Para criar uma nova senha de acesso a {{$sitename}}, 
            clique no link abaixo, será aberta uma nova janela 
            para que você cadastre uma nova senha.</p> 
        <a style="text-decoration:none;border: 1px solid transparent;padding: 0.375rem 0.75rem;font-size: 1rem; line-height: 1.5;border-radius: .25rem;width: 100%;display: block;text-align:center;color: #fff;background-color: #007bff;border-color: #007bff;box-shadow: none;" 
        href="{{config('app.url')}}/admin/redefinir-senha/{{$remember_token}}">Redefinir Minha Senha</a>
        <p style="margin-top:50px;text-align:center; font-size:11px;">Problemas e outras questões? {{$telefone1}}<br>ou email {{$emailsite}}</p>  
        <p style="text-align:center; font-size:11px;">© {{$ano_de_inicio}} {{$sitename}} - Todos os direitos reservados.</p>       
    </div> 
</div>
{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        <div style="width:100%; margin:10px 0; text-align:center; font-size:10px;"><pre>Sistema de consultas desenvolvido por {{env('DESENVOLVEDOR')}} <br> <a href="mailto:{{env('DESENVOLVEDOR_EMAIL')}}">{{env('DESENVOLVEDOR_EMAIL')}}</a></pre></div>
    @endcomponent
@endslot

@endcomponent