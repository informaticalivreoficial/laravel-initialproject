<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'admin',
        'client',
        'editor',
        'superadmin',
        'status'
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

     /**
     * Accerssors and Mutators
     */
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
