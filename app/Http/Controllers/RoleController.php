<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/


function __construct()
{

$this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
$this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
$this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
$this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);


}




/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
$roles = Role::orderBy('id','DESC')->paginate(5);
return view('roles.index',compact('roles'))
->with('i', ($request->input('page', 1) - 1) * 5);
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
$permission = Permission::get();
return view('roles.creat',compact('permission'));
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
    $this->validate($request, [
        'name' => 'required|unique:roles,name',
        'permissions' => 'required', // تصحيح الاسم هنا
    ]);

    $role = Role::create(['name' => $request->input('name')]);
    $role->permissions()->attach($request->input('permissions')); // تصحيح الاسم هنا

    return redirect()->route('roles.index')->with('success', 'Role created successfully');
}
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$role = Role::find($id);
$rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
->where("role_has_permissions.role_id",$id)
->get();
return view('roles.show',compact('role','rolePermissions'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
    $role = Role::find($id);
    $permissions = Permission::all(); // استعلام للحصول على جميع الصلاحيات

    $rolePermissions = $role->permissions->pluck('id')->toArray(); // قائمة بمعرفات الصلاحيات للدور

    return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
    $role = Role::find($id);

    $role->name = $request->name;

    if ($request->has('permissions') && is_array($request->permissions)) {
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions); // تمت إزالة 'guard_name'
    }

    $role->save();

    return redirect()->route('roles.index')->with('success', 'تم تحديث الصلاحية بنجاح');
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
DB::table("roles")->where('id',$id)->delete();
return redirect()->route('roles.index')
->with('success','Role deleted successfully');
}
}