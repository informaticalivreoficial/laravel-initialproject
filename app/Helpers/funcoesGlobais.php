<?php

// pega o nome da cidade a partir de um ID relacionado
function getCidadeNome($id, $tabela)
{
    if (empty($id) && empty($tabela)) {
        return null;
    }
    $cidade = Illuminate\Support\Facades\DB::table(''.$tabela.'')->where('cidade_id', '=', $id)->get();
    if(!empty($cidade)){
        return $cidade[0]->cidade_nome.'/'.$cidade[0]->cidade_uf;
    }else{
        return null;
    }
}

// pega o nome da cidade a partir de um ID relacionado
function getCidade($id, $tabela)
{
    if (empty($id) && empty($tabela)) {
        return null;
    }
    $cidade = Illuminate\Support\Facades\DB::table(''.$tabela.'')->where('cidade_id', '=', $id)->get();
    if(!empty($cidade)){
        return $cidade[0]->cidade_nome;
    }else{
        return null;
    }
}

// pega o nome da cidade a partir de um ID relacionado
function getEstado($id, $tabela, $campo = null)
{
    if (empty($id) && empty($tabela)) {
        return null;
    }
    $estado = Illuminate\Support\Facades\DB::table(''.$tabela.'')->where('estado_id', '=', $id)->get();
    if(!empty($estado)){
        if($campo == null){
            return $estado[0]->estado_nome;
        }else{
            return $estado[0]->{$campo};
        }
    }else{
        return null;
    }
}

/**
* <b>Formata Numero WhatsApp:</b> Ao executar este HELPER, ele automaticamente converte o numero para o formato aceito
* zap. retorna o link formatado!
* @return HTML = numero formatado!
*/
function getNumZap($nZap ,$textZap = null) {
   if(!empty($nZap)):
       $textZap = ($textZap == null ? getSaudacao() : $textZap);
       $zap = '55' . preg_replace("/[^0-9]/", "", $nZap);
       return "https://api.whatsapp.com/send?l=pt_pt&phone={$zap}&text={$textZap}";
   endif;
   return null;
}

/**
* <b>Saudação:</b> Ao executar este HELPER, dependendo do horário envia uma saudação
* nome. retorna o texto informado + a saudação!
* @return HTML = texto informado + a saudação!
*/
function getSaudacao($nome = null) {
   $hora = date('H');		
   if($hora >= 6 && $hora <= 12):
       return (empty($nome) ? '' : $nome).' Bom dia';		
   elseif( $hora > 12 && $hora <=18  ):
       return (empty($nome) ? '' : $nome).' Boa tarde';		
   else:			
       return (empty($nome) ? '' : $nome).' Boa noite';	
   endif;
}

/*****************************
    FUNÇÃO PARA PEGAR SOMENTE O PRIMEIRO NOME DO USUÁRIO
*****************************/
function getPrimeiroNome($pNome) {
    if(!empty($pNome)):
        $pData = explode(" ",$pNome);
        return count( $pData ) > 0 ? $pData[0] : $pNome;
    else:
        return false;
    endif;
    // return false;
}
/*****************************
    FUNÇÃO PARA PEGAR SOMENTE O USUÁRIO DA URL FACEBOOK
*****************************/
function fbUser($url)
{
    $regex ='/https?\:\/\/(?:www\.|web\.|m\.|touch\.)?(?:facebook\.com|fb(?:\.me|\.com))\/(\d+|[A-Za-z0-9\.]+)\/?/';
    if( preg_match( $regex, $url, $matches ) ){
        return $matches['1'];
    }else{
        return false;
    } 
 }

