<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::all();
        return view('home', compact('posts'));
    }

    public function detail()
    {
        return view('detail');
    }

    public function personalpage() {
        $user = Auth::user();
        $posts = $user->posts;
        return view('webpage')
            ->with([
            'user' => $user->name,
            'posts' => $posts
        ]);

    }
}
