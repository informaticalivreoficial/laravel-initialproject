<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Support\Cropper;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts'; 

    protected $fillable = [
        'autor',
        'tipo',
        'titulo',
        'content',
        'slug',
        'tags',
        'views',
        'categoria',
        'comentarios',
        'cat_pai',        
        'status',
        'thumb_legenda',
        'publish_at'
    ];

    /**
     * Scopes
     */

    public function scopePostson($query)
    {
        return $query->where('status', 1);
    }
    
    public function scopePostsoff($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Relacionamentos
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'autor', 'id');
    }
    
    public function categoriaObject()
    {
        return $this->hasOne(CatPost::class, 'id', 'categoria');
    }
    
    public function userObject()
    {
        return $this->hasOne(User::class, 'id', 'autor');
    }
    
    public function images()
    {
        return $this->hasMany(PostGb::class, 'post', 'id')->orderBy('cover', 'ASC');
    }

    /**
     * Accerssors and Mutators
     */

    public function getContentWebAttribute()
    {
        return Str::words($this->content, '20', ' ...');
    }
        
    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !File::exists('../public/storage/' . $cover['path'])) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url(Cropper::thumb($cover['path'], 800, 800));
    }

    public function nocover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !File::exists('../public/storage/' . $cover['path'])) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url($cover['path']);
    }
    
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }
    
    public function setPublishAtAttribute($value)
    {
        $this->attributes['publish_at'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }
    
    public function getPublishAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }
    
    public function setSlug()
    {
        if(!empty($this->titulo)){
            $post = Post::where('titulo', $this->titulo)->first(); 
            if(!empty($post) && $post->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->titulo) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->titulo);
            }            
            $this->save();
        }
    }
    
    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
}
