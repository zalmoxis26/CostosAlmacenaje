<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Revision
 *
 * @property $id
 * @property $inicio_revision
 * @property $fin_revision
 * @property $revisor
 * @property $precio_revision
 * @property $total_revision
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Revision extends Model
{

    protected $table = 'revision';
    public $timestamps = false;
    static $rules = [
		'inicio_revision' => 'required',
		'fin_revision' => 'required',
		'revisor' => 'required',
		'precio_revision' => 'required',
		'total_revision' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['inicio_revision','fin_revision','revisor','precio_revision','total_revision','tiempo_revision'];

    public function pedido()
    {
        return $this->hasMany('App\Models\Pedido', 'revision_id', 'id');
    }

}
