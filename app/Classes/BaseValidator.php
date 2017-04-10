<?php
namespace App\Classes;

use Validator;

trait BaseValidator
{

  /**
   * Validation factory
   * @param  \Illuminate\Http\Request $request 
   * @param  array $rules   
   * @return \Validator          
   */
  public function validation($request, $rules)
  {
    return Validator::make($request->all(), $rules);
  }
}
