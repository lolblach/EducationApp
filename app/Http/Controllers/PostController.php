<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Test;
use App\Models\Testlog;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function mainpage()
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        $tags = Tag::all();
        $progress = [];
        foreach ($tags as $tag) {
            $posts = Post::where('tag_id', $tag->id)->get();
            $user = User::where('name', session('name'))->first();
            $all = count($posts) * 2;
            $done = 0;
            foreach ($posts as $post) {
                if (History::where('user_id', $user->id)->where('post_id', $post->id)->exists()) {
                    $done = $done + 1;
                }
                if (Testlog::where('user_id', $user->id)->where('post_id', $post->id)->exists()) {
                    $done = $done + 1;
                }
            }
            if ($done != 0) {
                $percent = 100 / ($all / $done);
            } else {
                $percent = 0;
            }
            array_push($progress, $percent);
        }
        return view('mainpage', ['tags' => $tags, 'progress' => $progress]);
    }

    public function createpage($content = '')
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        $tags = Tag::all();
        return view('createpost', ['tags' => $tags, 'content' => $content]);
    }

    public function createaction(Request $request)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        $title = $request->get('title');
        $content = $request->get('content');
        session(['content' => $content]);
        $tag = $request->get('tag');
        if ($title == null) {
            return redirect()->route('post.createpage')->withErrors('Введите заголовок!');
        }
        if (strlen($title) > 100) {
            return redirect()->route('post.createpage')->withErrors('Заголовок не должен быть больше 100 символов!');
        }
        if ($content == null || $content == '<br>') {
            return redirect()->route('post.createpage')->withErrors('Нет текста!');
        }
        if (strlen($content) > 100000) {
            return redirect()->route('post.createpage')->withErrors('Урок не должен быть больше 10,000 символов!');
        }
        if ($tag == null) {
            return redirect()->route('post.createpage')->withErrors('Не выбрана категория!');
        }
        $user = User::where('name', session('name'))->first();
        $post = Post::create([
            'title' => $title,
            'content' => $content,
            'tag_id' => $tag,
            'creator_id' => $user->id
        ]);
        session(['content' => null]);
        return redirect()->route('post.view', ['id' => $post->id]);
    }

    public function view($id)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        $post = Post::where('id', $id)->first();
        $user = User::where('name', session('name'))->first();
        if (!History::where('user_id', $user->id)->where('post_id', $id)->exists()) {
            History::create([
                'user_id' => $user->id,
                'post_id' => $id
            ]);
        }
        return view('viewpage', ['post' => $post]);
    }

    public function delete($id)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        Test::where('post_id', $id)->delete();
        Testlog::where('post_id', $id)->delete();
        History::where('post_id', $id)->delete();
        $post = Post::where('id', $id)->first();
        Post::where('id', $id)->first()->delete();
        return redirect()->route('tag.view', ['id' => $post->tag_id]);
    }
}
