<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Test;
use App\Models\Testlog;
use App\Models\User;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        $tags = Tag::all();
        return view('tags', ['tags' => $tags]);
    }

    public function create(Request $request)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        $name = $request->get('name');
        if ($name == null) {
            return redirect()->route('tag.index')->withErrors('Введите название темы!');
        }
        if (strlen($name) > 100) {
            return redirect()->route('tag.index')->withErrors('Название темы не должно быть больше 100 символов!');
        }
        Tag::create([
            'name' => $name
        ]);
        return redirect()->route('tag.index')->with('success', 'Тема успешно создана!');
    }

    public function delete($id)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        $posts = Post::where('tag_id', $id)->get();
        foreach ($posts as $post) {
            Test::where('post_id', $post->id)->delete();
            Testlog::where('post_id', $post->id)->delete();
            History::where('post_id', $post->id)->delete();
            Post::where('id', $post->id)->first()->delete();
        }
        Tag::where('id', $id)->delete();
        return redirect()->route('tag.index')->with('success', 'Тема удалена!');
    }

    public function view($id)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        $posts = Post::where('tag_id', $id)->get();
        $user = User::where('name', session('name'))->first();
        $progress =[];
        foreach ($posts as $post) {
            $percent = 0;
            if (History::where('user_id', $user->id)->where('post_id', $post->id)->exists()) {
                $percent = $percent + 1;
            }
            if (Testlog::where('user_id', $user->id)->where('post_id', $post->id)->exists()) {
                $percent = $percent + 1;
            }
            $percent = $percent * 50;
            array_push($progress, $percent);
        }
        return view('tagview', ['posts' => $posts, 'progress' => $progress, 'tagName' => Tag::where('id', $id)->first()->name]);
    }
}
