<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pedido
 *
 * @property $id
 * @property $cliente_id
 * @property $codigo_id
 * @property $producto_id
 * @property $precio_id
 * @property $factura
 * @property $fecha_entrada
 * @property $fecha_salida
 * @property $cantidad
 * @property $dias
 * @property $total
 * @property $created_at
 * @property $updated_at
 *
 * @property Cliente $cliente
 * @property Cliente $cliente
 * @property Producto $producto
 * @property Producto $producto
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pedido extends Model
{
    
    static $rules = [
		'cliente_id' => 'required',
		'codigo_id' => 'required',
		'producto_id' => 'required',
		//'precio_id' => 'required',
		'cantidad' => 'required',
    ];

    protected $perPage = 20;
    protected $casts = [ 'fecha_salida' =>'datetime' , 'fecha_entrada' =>'datetime'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['cliente_id','codigo_id','producto_id','precio_id','factura','fecha_entrada','fecha_salida','cantidad','dias','total','salida','revision_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cliente2()
    {
        return $this->hasOne('App\Models\Cliente', 'id', 'codigo_id');
    }
    
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
   
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function producto()
    {
        return $this->hasOne('App\Models\Producto', 'id', 'producto_id');
    }

    //relacion muchos a  muchos

    public function productos(){

        return $this->belongsToMany('App\Models\Producto')->withPivot('producto_id','cantidades','precio');
    }

    public function revision()
    {
        return $this->hasOne('App\Models\Revision', 'id', 'revision_id');
    }

}
