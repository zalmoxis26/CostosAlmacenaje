<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PedidoProducto
 *
 * @property $id
 * @property $pedido_id
 * @property $producto_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Pedido $pedido
 * @property Producto $producto
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PedidoProducto extends Model
{
    
    static $rules = [
		'pedido_id' => 'required',
		'producto_id' => 'required',
    ];

    protected $perPage = 20;
    protected $table = "pedido_producto";

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['pedido_id','producto_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pedido()
    {
        return $this->hasOne('App\Models\Pedido', 'id', 'pedido_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function producto()
    {
        return $this->hasOne('App\Models\Producto', 'id', 'producto_id');
    }
    

}
