<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Precio
 *
 * @property $id
 * @property $name
 * @property $precio
 * @property $cliente_id
 * @property $producto_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Cliente $cliente
 * @property Producto $producto
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Precio extends Model
{
    
    static $rules = [
		
		'precio' => 'required',
		'cliente_id' => 'required',
		'producto_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['precio','cliente_id','producto_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cliente()
    {
        return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function producto()
    {
        return $this->hasOne('App\Models\Producto', 'id', 'producto_id');
    }

     public function pedidos()
    {
        return $this->hasMany('App\Models\Pedido', 'precio_id', 'id');
    }

}
