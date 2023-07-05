<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $name
 * @property $precio
 * @property $created_at
 * @property $updated_at
 *
 * @property Pedido[] $pedidos
 * @property Pedido[] $pedidos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
    
    static $rules = [
		'name' => 'required',
		'precio' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','precio','codigo_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
   
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany('App\Models\Pedido', 'producto_id', 'id');
    }

     public function precio()
    {
        return $this->hasMany('App\Models\Precio', 'producto_id', 'id');
    }


      //relacion muchos a  muchos

    public function pedido(){

        return $this->belongsToMany('App\Models\Pedido')->withPivot('pedido_id','cantidades','precio');
    }

}
