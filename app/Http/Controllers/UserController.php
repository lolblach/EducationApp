<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Testlog;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

class UserController extends Controller
{
    public function index()
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        $users = User::all();
        return view('users', ['users' => $users]);
    }

    public function loginpage()
    {
        if (session('name') != null) {
            return redirect()->route('post.mainpage');
        }
        return view('loginpage');
    }

    public function registerpage()
    {
        if (session('name') != null) {
            return redirect()->route('post.mainpage');
        }
        return view('registerpage');
    }

    public function login(Request $request)
    {
        $name = $request->get('name');
        $password = $request->get('password');
        if ($name == null || $password == null) {
            return redirect()->route('user.loginpage')->withErrors('Введите данные верно!');
        }
        if (strlen($name) > 100) {
            return redirect()->route('user.loginpage')->withErrors('Имя пользователя должно быть не больше 100 символов!');
        }
        if (strlen($password) > 100) {
            return redirect()->route('user.loginpage')->withErrors('Пароль должен быть не больше 100 символов!');
        }
        if (User::where('name', $name)->exists()) {
            $user = User::where('name', $name)->first();
            if (password_verify($password, $user->pass)) {
                session(['name' => $name, 'role' => $user->role_id]);
                return redirect()->route('post.mainpage');
            }
            return redirect()->route('user.loginpage')->withErrors('Пароль не верный!');
        }
        return redirect()->route('user.loginpage')->withErrors('Такого пользователя не существует!');
    }

    public function register(Request $request)
    {
        $name = $request->get('name');
        $password = $request->get('password');
        $repeatPassword = $request->get('repeat-password');
        if ($name == null || $password == null || $repeatPassword == null) {
            return redirect()->route('user.registerpage')->withErrors('Введите данные верно!');
        }
        if (User::where('name', $name)->exists()) {
            return redirect()->route('user.registerpage')->withErrors('Имя пользователя должно быть уникально!');
        }
        if ($password != $repeatPassword) {
            return redirect()->route('user.registerpage')->withErrors('Пароли не совпадают!');
        }
        if (strlen($name) > 100) {
            return redirect()->route('user.registerpage')->withErrors('Имя пользователя должно быть не больше 100 символов!');
        }
        if (strlen($password) > 100) {
            return redirect()->route('user.registerpage')->withErrors('Пароль должен быть не больше 100 символов!');
        }
        User::create([
            'name' => $name,
            'pass' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        session(['name' => $name, 'role' => 2]);
        return redirect()->route('post.mainpage');
    }

    public function logout()
    {
        session(['name' => null, 'role' => null, 'content' => null]);
        return redirect()->route('user.loginpage');
    }

    public function profile()
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        $user = User::where('name', session('name'))->first();
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
        return view('profile', ['user' => $user, 'tags' => $tags, 'progress' => $progress]);
    }

    public function changepass(Request $request, $name)
    {
        $pass = $request->get('password');
        $newPass = $request->get('newpassword');
        $repeatNewPass = $request->get('repeat_newpassword');
        if ($pass == null) {
            return redirect()->route('user.profile')->withErrors('Текуший пароль не введен!');
        }
        if ($newPass == null) {
            return redirect()->route('user.profile')->withErrors('Вы не ввели новый пароль!');
        }
        if ($repeatNewPass == null) {
            return redirect()->route('user.profile')->withErrors('Пароли не совпадают!');
        }
        if (strlen($newPass) > 100) {
            return redirect()->route('user.profile')->withErrors('Пароль не может быть длинее 100 символов!');
        }
        if ($newPass != $repeatNewPass) {
            return redirect()->route('user.profile')->withErrors('Пароли не совпадают!');
        }
        $user = User::where('name', $name)->first();
        if (!password_verify($pass, $user->pass)) {
            return redirect()->route('user.profile')->withErrors('Не верный пароль!');
        }
        $user->pass = password_hash($newPass, PASSWORD_DEFAULT);
        $user->save();
        return redirect()->route('user.profile')->with('success', 'Пароль изменен!');
    }

    public function changerole($id)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        $user = User::where('id', $id)->first();
        if ($user->role_id == 2) {
            $user->role_id = 1;
        } else {
            $user->role_id = 2;
        }
        $user->save();
        return redirect()->route('user.index');
    }

    public function image(Request $request)
    {
        if ($request->file('file') == null) {
            return redirect()->route('user.profile');
        }
        $file = $request->file('file');
        $name = uniqid() . '.png';
        $file->move(storage_path('app/public/images'), $name);
        $user = User::where('name', session('name'))->first();
        $user->image = $name;
        $user->save();
        return redirect()->route('user.profile');
    }
}
