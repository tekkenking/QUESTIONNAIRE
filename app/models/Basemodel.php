<?php

//use LaravelBook\Ardent\Ardent;

//use Watson\Validating\ValidatingTrait;

//use Watson\Validating\ValidatingModel as Watson;

class Basemodel extends Eloquent
{

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


  public function savex()
  {

    $purged = $this->purger();

      $data = parent::create($purged);

      return $data;
  }

  /**
   * Update the model in the database.
   *
   * @param  array  $attributes
   * @return mixed
   */
  public function update(array $attributes = array())
  {

    $model = Parent::where('id', '=', $attributes['id']);

    return $model->update( $this->purger($attributes) );
    
  }
}