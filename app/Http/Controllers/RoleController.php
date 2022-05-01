<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // public function addRole()
    // {
    //     $roles = [
    //         ['name'=>'Admin'],
    //         ['name'=>'Staff'],
    //         ['name'=>'Accountant'],
    //         ['name'=>'HR']
    //     ];

    //     Role::insert($roles);
    //     return "Roles added succefully";
    // }

    // public function addUser()
    // {
    //     $user = new User();
    //     $user->name = "traoreabdoulaye";
    //     $user->email = "traoreabdoulaye@gmail.com";
    //     $user->password = encrypt("traoreabdoulaye");
    //     $user->save();
    //     $roleArr = [2,3,4];
    //     $user->roles()->attach($roleArr);

    //     return "User add successfuly and roles assigned";
    // }

    // public function getRoleByUserId($id)
    // {
    //     $user = User::find($id);
    //     $roles = $user->roles;
    //     return $roles;
    // }
    // public function getUserByRoleId($id)
    // {
    //     $role = Role::find($id);
    //     $users = $role->users;
    //     return $users;
    // }
}
