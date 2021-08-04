<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Profile
     *
     * Show the profile of the current user
     *
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return $this->showOne([
            'user' => $user,
            'purchases' => $user->transactions->count(),
            'products' => $user->products->count(),
        ]);
    }
}
