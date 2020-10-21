<?php 
namespace App; 
use Auth; 
trait Updater { protected static function boot() { 
        parent::boot(); /* * During a model create Eloquent will also update the updated_at field so * need to have the updated_by field here as well * */ 
        // static::creating(function($model) { $model->created_by = Auth::user()->id;
        //     if(!empty(Auth::user()->id))
        //         $model->updated_by = Auth::user()->id;
        // });
 
        // static::updating(function($model)  {
        //     if(!empty(Auth::user()->id))
        //         $model->updated_by = Auth::user()->id;
        // });
        // static::deleting(function($model)  {
        //     if(!empty(Auth::user()->id))
        //     {
        //         $model->deleted_by = Auth::user()->id;
        //         $model->save();
        //     }
        // });
    }
}