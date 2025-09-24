<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class RoleController extends Controller implements HasMiddleware
{
      public static function middleware()
    {
        return [
            new Middleware('permission:view roles' ,only: ['index']),
            new Middleware('permission:view roles' ,only: ['edit']),
            new Middleware('permission:view roles' ,only: ['create']),
            new Middleware('permission:view roles' ,only: ['destroy']),
        ];
    }
    // Display all roles
    public function index()
    {
$roles = Role::orderBy('name', 'ASC')->paginate(10);
        return view('roles.index',compact('roles'));
    }

    // Show form to create a new role
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', compact('permissions'));
    }

    // Store a new role

public function store(Request $request)
{
    // التحقق من صحة البيانات
    $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|unique:roles,name',
        'permissions' => 'nullable|array',
        'permissions.*' => 'string'
    ]);

    if ($validator->fails()) {
        return redirect()->route('roles.create')
                         ->withInput()
                         ->withErrors($validator);
    }

    // إنشاء الدور
    $role = Role::create(['name' => $request->name]);

    // ربط الصلاحيات إذا موجودة
    if ($request->filled('permissions')) {
        foreach ($request->permissions as $permName) {
            // إنشاء الصلاحية إذا لم تكن موجودة
            $permission = Permission::firstOrCreate(['name' => $permName]);
            $role->givePermissionTo($permission);
        }
    }

    return redirect()->route('roles.index')->with('success', 'Role created successfully.');
}



    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $haspermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.edit', compact('role', 'haspermissions','permissions'));
    }

    // Update a role
  public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|unique:roles,name,' .$id. ',id',
    ]);

     if ($validator->passes()) {
            //  Permission::create(['name' => $request->name]);
            $role->name = $request->name;
            $role->save();
            if(!empty($request->permissions)){
                $role->syncPermissions($request->permissions);
            }
            else{
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.index')->with('success', 'role update successfully.');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }

}

    // Delete a role
       public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::find($id);
        if ($role == null) {
            session()->flash('error', 'role not found.');
            return response()->json(['status' => false]);
        }
        $role->delete();
        session()->flash('success', 'role deleted  successfully.');
        return response()->json(['status' => true]);


    }
}
