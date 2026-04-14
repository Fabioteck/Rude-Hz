<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index() {
    $user = auth()->user();
    
    if (!$user->artist) {
        $user->artist()->create([
            'name' => $user->name,
            'slug' => \Illuminate\Support\Str::slug($user->name),
            'style' => 'default',
        ]);
    }
    
    return view('dashboard');
}

}
