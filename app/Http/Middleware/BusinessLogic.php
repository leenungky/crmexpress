<?php

namespace App\Http\Middleware;

use Closure;
use \DB;
class BusinessLogic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $routeArray = $request->route()->getAction(); 
        $controllerAction = class_basename($routeArray["controller"]);
        list($controller, $action) = explode("@", $controllerAction);
        $role =  $request->session()->get("role", "");
        $strRedirect =  $this->getRedirect($controller, $action, $role);
        if ($strRedirect[0]==""){                      
            return $next($request);
        }else{
            return redirect($strRedirect[0]);
        }       
        
    }

    public function isPayment(){
        $is_payment = true;
        if (isset(\Auth::user()->company_id)){
            $company_id = \Auth::user()->company_id;
            $payment = DB::table("company_payment")->select(DB::raw("DATE(payment_date) as payment_date"))->where("company_id", $company_id)->orderBy("id","desc")->first();
            $today = date("Y-m-d");
            $last_date =  date('Y-m-d',strtotime($payment->payment_date." +1 Months"));            
            if ($today > $last_date){
                $is_payment =false;
            }
        }
        return $is_payment;
    }

    public function getRedirect($controller, $action, $role){        
        $strRedirect = ""; 
        $message = "";      

        if ($role=="staff"){
            if ($controller == "UserController"){
                if ($action == "getLogout" || $action=="getLogin" || $action=="postLogin"){                    
                }else{
                    $strRedirect = "/transaction";    
                }
                
            }else if ($controller == "CustomerController" 
                || $controller == "ReportController" 
                || $controller == "CityController"
                || $controller == "RoleController"
                || $controller == "CollectController"
                || $controller == "PriceController"
                || $controller == "TreeplController"
                || $controller == "EmployeeController" ){
                $strRedirect = "/transaction";
            }
        }
        if ($role=="admin"){
             if ($controller == "UserController"){
                if ($action == "getLogout" || $action=="getLogin" || $action=="postLogin"){  
                }else{
                    $strRedirect = "/customer";    
                }
            }
                
        }

        if (!empty($role)){    
            $is_cek_payment = true;        
            if ($controller == "UserController"){
                if ($action == "getLogout" || $action=="getLogin" || $action=="postLogin"){  
                    $is_cek_payment = false;
                }
            }
            if ($is_cek_payment){
                if (!$this->isPayment()){            
                     $strRedirect = "/user/logout?status=payment";                                     
                }
            }
        }
        return array($strRedirect, $message);

    }
}
