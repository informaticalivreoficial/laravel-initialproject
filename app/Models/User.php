<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'tenant_id',
        'email',
        'email1',
        'password',
        'remember_token',
        'senha',
        'genero',
        'cpf',
        'rg',
        'rg_expedicao',
        'nasc',
        'naturalidade',
        'estado_civil',
        'avatar',
        'profissao',
        'renda',
        'profissao_empresa',
        'cep',
        'rua',
        'num',
        'complemento',
        'bairro',
        'uf',
        'cidade',
        'telefone',
        'celular',
        'whatsapp',
        'skype',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'vimeo',
        'youtube',
        'fliccr',
        'soundclound',
        'snapchat',
        'tipo_de_comunhao',
        'nome_conjuje',
        'genero_conjuje',
        'cpf_conjuje',
        'rg_conjuje',
        'rg_expedicao_conjuje',
        'nasc_conjuje',
        'naturalidade_conjuje',
        'profissao_conjuje',
        'renda_conjuje',
        'profissao_empresa_conjuje',
        'admin',
        'client',
        'editor',
        'superadmin',
        'status',
        'notasadicionais'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'autor', 'id');
    }

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }

     /**
     * Accerssors and Mutators
     */

    //Exibe a função do usuário
    public function getFuncao() {
        if($this->admin == 1 && $this->client == 0 && $this->superadmin == 0){
            return 'Administrador';
        }elseif($this->admin == 0 && $this->client == 1 && $this->superadmin == 0){
            return 'Cliente';
        }elseif($this->admin == 0 && $this->client == 0 && $this->editor == 1 && $this->superadmin == 0){
            return 'Editor';
        }elseif($this->admin == 1 && $this->client == 1 && $this->superadmin == 0){
            return 'Administrador/Cliente'; 
        }else{
            return 'Super Administrador'; 
        }
    }
    
    public function getCivilStatusTranslateAttribute(string $status, string $genre)
    {
        if ($genre === 'feminino') {
            if ($status === 'casado') {
                return 'casada';
            } elseif ($status === 'separado') {
                return 'separada';
            } elseif ($status === 'solteiro') {
                return 'solteira';
            } elseif ($status === 'divorciado') {
                return 'divorciada';
            } elseif ($status === 'viuvo') {
                return 'viúva';
            } else {
                return '';
            }
        } else {
            if ($status === 'masculino') {
                return 'casado';
            } elseif ($status === 'separado') {
                return 'separado';
            } elseif ($status === 'solteiro') {
                return 'solteiro';
            } elseif ($status === 'divorciado') {
                return 'divorciado';
            } elseif ($status === 'viuvo') {
                return 'viúvo';
            } else {
                return '';
            }
        }

    }

    public function getUrlAvatarAttribute()
    {
        if (!empty($this->avatar)) {
            return Storage::url(Cropper::thumb($this->avatar, 500, 500));
        }
        return '';
    }

    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getCpfAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return
            substr($value, 0, 3) . '.' .
            substr($value, 3, 3) . '.' .
            substr($value, 6, 3) . '-' .
            substr($value, 9, 2);
    }

    public function setRgAttribute($value)
    {
        $this->attributes['rg'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getRgAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return
            substr($value, 0, 2) . '.' .
            substr($value, 2, 3) . '.' .
            substr($value, 5, 3) . '-' .
            substr($value, 8, 1);
    }
    
    public function setNascAttribute($value)
    {
        $this->attributes['nasc'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }
    
    public function getNascAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }

    public function setCepAttribute($value)
    {
        $this->attributes['cep'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getCepAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    }
    
    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = (!empty($value) ? $this->clearField($value) : null);
    }
    //Formata o telefone para exibir
    public function getTelefoneAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return  
            substr($value, 0, 0) . '(' .
            substr($value, 0, 2) . ') ' .
            substr($value, 2, 4) . '-' .
            substr($value, 6, 4) ;
    }
    
    public function setCelularAttribute($value)
    {
        $this->attributes['celular'] = (!empty($value) ? $this->clearField($value) : null);
    }
    //Formata o celular para exibir
    public function getCelularAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return  
            substr($value, 0, 0) . '(' .
            substr($value, 0, 2) . ') ' .
            substr($value, 2, 5) . '-' .
            substr($value, 7, 4) ;
    }
    
    public function setWhatsappAttribute($value)
    {
        $this->attributes['whatsapp'] = (!empty($value) ? $this->clearField($value) : null);
    }
    //Formata o celular para exibir
    public function getWhatsappAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return  
            substr($value, 0, 0) . '(' .
            substr($value, 0, 2) . ') ' .
            substr($value, 2, 5) . '-' .
            substr($value, 7, 4) ;
    }

    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            unset($this->attributes['password']);
            return;
        }
        $this->attributes['senha'] = $value;
        $this->attributes['password'] = bcrypt($value);
    } 

    public function setCpfconjujeAttribute($value)
    {
        $this->attributes['cpf_conjuje'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getCpfconjujeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return
            substr($value, 0, 3) . '.' .
            substr($value, 3, 3) . '.' .
            substr($value, 6, 3) . '-' .
            substr($value, 9, 2);
    }
    
    public function setRgconjujeAttribute($value)
    {
        $this->attributes['rg_conjuje'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getRgconjujeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return
            substr($value, 0, 2) . '.' .
            substr($value, 2, 3) . '.' .
            substr($value, 5, 3) . '-' .
            substr($value, 8, 1);
    }
    
    public function setNascconjujeAttribute($value)
    {
        $this->attributes['nasc_conjuje'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }
    
    public function getNascconjujeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return date('d/m/Y', strtotime($value));
    }

    public function setAdminAttribute($value)
    {
        $this->attributes['admin'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setEditorAttribute($value)
    {
        $this->attributes['editor'] = ($value === true || $value === 'on' ? 1 : 0);
    }

    public function setClientAttribute($value)
    {
        $this->attributes['client'] = ($value === true || $value === 'on' ? 1 : 0);
    }
    
    public function setSuperAdminAttribute($value)
    {
        $this->attributes['superadmin'] = ($value === true || $value === 'on' ? 1 : 0);
    }
    
    public function setRememberTokenAttribute($value)
    {
        if (empty($value)) {
            unset($this->attributes['remember_token']);
            return;
        }
        $this->attributes['remember_token'] = bcrypt($value);
    }

    public function setRendaAttribute($value)
    {
        $this->attributes['renda'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function setRendaConjujeAttribute($value)
    {
        $this->attributes['renda_conjuje'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getCreatedAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return date('d/m/Y', strtotime($value));
    }

    public function getRendaAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    private function convertStringToDouble(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }
    
    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
    
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
