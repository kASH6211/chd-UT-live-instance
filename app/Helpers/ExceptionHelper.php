<?php
namespace App\Helpers;
class ExceptionHelper
{
    
   
    public static function handleException(\Exception $e)
    {
        $pgsqlerrorcodes = [
            "23501" =>"FOREIGN_KEY_ERROR",
            "23505" =>"DUPLICATE_KEY_ERROR",
        ];
        // Handle the exception here
        if ($e instanceof \Illuminate\Database\QueryException) {
            
            if(array_key_exists($e->errorInfo[0], $pgsqlerrorcodes))
            {
                $message = $pgsqlerrorcodes[$e->errorInfo[0]];
            }
            else
            {
                $message = "ERROR";
            }
           return $message;
        } else {
            // Handle other types of exceptions
            return "An unexpected error occurred.";
        }
    }
}
?>