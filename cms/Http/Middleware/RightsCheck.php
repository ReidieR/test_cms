<?php

namespace cms\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use DB;
use Auth;

// 用户权限校验中间件
class RightsCheck
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
        // 获取登录的用户名
        $admin = Auth::user();
        // 根据用户名信息获取用户的分组角色信息
        $role = DB::table('final_admin_groups')->where('gid', $admin->group_id)->item();
        // 判断该分组角色是否存在
        if (!$role) {
            return response($this->errorMsg($request, '该角色不存在'), 401);
        }
        // 获取用户的可用菜单权限
        $rights = \json_decode($role['rights'], true);
        // 获取请求的控制器和方法
        $action = \strtolower($request->route()->getActionName());      // 获取完整的控制器和方法（包括命名空间）
        $action = explode('@', $action);
        $actionName = end($action);     // 获取方法名称
        $controller = explode('\\', prev($action));
        $controllerName = end($controller);    // 获取控制器名称
        // 根据控制器和方法查询菜单
        $menu = DB::table('final_admin_menus')->where('controller', $controllerName)->where('action', $actionName)->orderBy('mid', 'asc')->item();
        if (!$menu) {
            return response($this->errorMsg($request, '该菜单不存在'), '401');
        }
        if ($menu['status']==2) {
            return response($this->errorMsg($request, '该菜单已被禁用，请联系管理员'), 200);
        }
        // 查看用户是否有权限访问该权限，当用户为超级管理员时拥有所有权限
        if (!$admin->group_id==1) {
            if (!in_array($menu['mid'], $rights)) {
                return response($this->errorMsg($request, '对不起您没有权限访问'), '401');
            }
        }
        // 将用户信息传给$request
        $admin->rights = $rights;
        // dd($rights);
        $request->admin = $admin;
        return $next($request);
    }
    // 错误信息提示方法
    public function errorMsg($req, $msg)
    {
        // 判断请求方式
        if ($req->ajax()) {     // ajax()请求返回json字符串提示
            $msg = json_encode(array('code'=>1,'msg'=>$msg));
        } else {    // 普通请求返回一段html错误提示代码
            $msg = '<div style="margin-top:50px;text-align:center;color:red;
            font-size:20px;">'.$msg.'</div>';
        }
        return $msg;
    }
}
