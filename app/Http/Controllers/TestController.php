<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test() {
        $users = User::all();
        return view('test', compact('users'));
        // 配列またはwith関数でも変数の受け渡しが可能
        // return view('test', ['users' => $users]);
        // return view('test')->with('users', $users);
    }
}
