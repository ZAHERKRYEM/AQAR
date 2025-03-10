<?php  

namespace App\Exceptions;  


use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;  
use Throwable;  
use Illuminate\Database\Eloquent\ModelNotFoundException;  
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;  

class Handler extends ExceptionHandler  
{  
    /**  
     * A list of exception types with their corresponding custom log levels.  
     *  
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>  
     */  
    protected $levels = [  
    ];  

    /**  
     * A list of the exception types that are not reported.  
     *  
     * @var array<int, class-string<\Throwable>>  
     */  
    protected $dontReport = [  
    ];  

    /**  
     * A list of the inputs that are never flashed to the session on validation exceptions.  
     *  
     * @var array<int, string>  
     */  
    protected $dontFlash = [  
        'current_password',  
        'password',  
        'password_confirmation',  
    ];  

    /**  
     * Register the exception handling callbacks for the application.  
     */  
    public function register(): void  
    {  
        $this->reportable(function (Throwable $e) {  
        });  
    }  

    /**  
     * Render an exception into an HTTP response.  
     */  
    public function render($request, Throwable $exception)  
    {  
        if ($exception instanceof ModelNotFoundException) {  
            return response()->json([  
                "status" => false,  
                "data" => [],  
                "message" => "Resource not found",  
                "status_code" => 404  
            ], 404);  
        }  
       
        if ($exception instanceof NotFoundHttpException) {  
            return response()->json([  
                "status" => false,  
                "data" => [],  
                "message" => "Route not found",  
                "status_code" => 404  
            ], 404);  
        }  

        return response()->json([  
            "status" => false,  
            "data" => [],  
            "message" => "Server error: " . $exception->getMessage(),  
            "status_code" => 500  
        ], 500);  
    }  
}  