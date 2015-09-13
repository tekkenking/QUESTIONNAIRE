<?php

class Basemodel extends \Eloquent
{
  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];

  protected $guarded = ['id'];

  protected $defaultPurgeAttr = ['password_confirmation', '_token', '_method'];

  public $setPureAttr = [];


  protected function purger( array $attributes = array() )
  {
      $purges = array_merge($this->defaultPurgeAttr, $this->setPureAttr);

      $create = [];

      $toPurge = ( empty( $attributes ) ) ? Input::all() : $attributes;

      foreach( $toPurge as $key => $value )
      {
        if( ! in_array($key, $purges) ){
          $create[$key] = $value;
        }
      }

      return  $create;
  }


  public function savex( Array $data = null )
  {

      $purged = ( $data === null || empty($data) ) ? $this->purger() : $data;

      //tt($purged);

      $model = parent::create($purged);

      return $model;
  }

  /**
   * Update the model in the database.
   *
   * @param  array  $attributes
   * @return mixed
   */
  public function updatex(array $attributes = array())
  {

    $model = Parent::where('id', '=', $attributes['id']);

    return $model->update( $this->purger($attributes) );
    
  }
}