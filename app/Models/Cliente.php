<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 *
 * @property $id
 * @property $name
 * @property $codigo_cliente
 * @property $created_at
 * @property $updated_at
 *
 * @property Pedido[] $pedidos
 * @property Pedido[] $pedidos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cliente extends Model
{
    
    static $rules = [
		'name' => 'required',
		'codigo_cliente' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','codigo_cliente'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany('App\Models\Pedido', 'cliente_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos2()
    {
        return $this->hasMany('App\Models\Pedido', 'codigo_id', 'id');
    }

    public function precio()
    {
        return $this->hasMany('App\Models\Precio', 'cliente_id', 'id');
    }
    

}
