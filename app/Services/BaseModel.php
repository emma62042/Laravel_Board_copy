<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends EloquentModel
{
   public function __construct(array $attributes = [])
   {
       parent::__construct($attributes);
   }
   
   /**
    * Set the keys for a save update query.
    */
   protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query) {
       if (is_array($this->primaryKey)) {
           foreach ($this->primaryKey as $pk) {
               $query->where($pk, '=', $this->original[$pk]);
           }
           
           return $query;
       }else{
           return parent::setKeysForSaveQuery($query);
       }
   }
   
   public function getDateFormat() {
       return 'Y-m-d H:i:s';
   }
   
}
