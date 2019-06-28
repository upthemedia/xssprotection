# xssprotection
Block the XSS entry globally in your Laravel projects.
It can be used in two different ways. Or through a middleware that affects all the requests, or through the FormRequest
# Install 
## composer
    composer require upthemedia/xss-protection

## Configuration
**Use Middleware**
To use globally throughout the project it is necessary to create a middeware and add it to Kernel.php in protected $middleware

    <?php
    namespace App\Http\Middleware;  
    use Closure;
    use Illuminate\Http\Request;
    use Upthemedia\XssProtection\XssProtectionTrait;  
    final class XssClean {  
	    use XssProtectionTrait;  
	    public function handle(Request $request, Closure $next)  
	    {  
		    $input = $request->all();  
		    array_walk_recursive($input, function(&$input) {  
			    $input = $this->xss_clean($input);  
			});  
			$request->merge($input);  
			return $next($request);
		}
	}
	
File Kernel.php

    <?php  
    namespace App\Http;  
    use Illuminate\Foundation\Http\Kernel as HttpKernel;  
    
    class Kernel extends HttpKernel{  
    /**
    * The application's global HTTP middleware stack.
    * These middleware are run during every request to your application. 
    * 
    * @var array   
    */  
    protected $middleware = [
	     \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,  			
	     \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,  
	     \App\Http\Middleware\TrimStrings::class,  
	     \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,  
	     \App\Http\Middleware\XssClean::class  //Add Middleware XSS
	      ];

**Use in FormRequest**
To use in FormRequest it is only necessary to import the XssProtectionTrait
In this case it will execute the clean xss on both inputs

    <?php  
    namespace App\Http\Requests;  
    use Illuminate\Foundation\Http\FormRequest;
    use Upthemedia\XssProtection\XssProtectionTrait;  
    class StoreComment extends FormRequest  {  
	    use XssProtectionTrait;  
	    /**  
	    * Determine if the user is authorized to make this request. * * @return bool  
	    */  
	    public function authorize()  {  
	    return true;
	    }  
	    /**
	    *Get the validation rules that apply to the request. * * @return array  
	    */  
	    public function rules() {  
		    return [  '
			    'comment' => 'require', 
			    'subject  => 'nullable'
			      ];
		}
	}
