<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Test;
use App\Models\Testlog;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class TestController extends Controller
{
    public function view($id)
    {
        $tests = Test::where('post_id', $id)->get();
        $types = Type::all();
        $post = Post::where('id', $id)->first();
        return view('testview', ['tests' => $tests, 'post' => $post, 'types' => $types]);
    }

    public function add(Request $request, $id)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        $ask = $request->get('ask');
        $right = $request->get('right');
        $type = $request->get('type');
        $ans1 = $request->get('ans1');
        $ans2 = $request->get('ans2');
        $ans3 = $request->get('ans3');
        $ans4 = $request->get('ans4');
        if ($ask == null) {
            return redirect()->route('test.view', ['id' => $id])->withErrors('Введите текст вопроса!');
        }
        if (strlen($ask) > 500) {
            return redirect()->route('test.view', ['id' => $id])->withErrors('Вопрос не может быть больше 500 символов!');
        }
        if (strlen($right) > 100) {
            return redirect()->route('test.view', ['id' => $id])->withErrors('Правильный ответ не может быть больше 100 символов!');
        }
        if ($type == null) {
            return redirect()->route('test.view', ['id' => $id])->withErrors('Вы не выбрали тип вопроса!');
        }
        if ($type == 1) {
            if (strlen($right) > 1 || !is_numeric($right)) {
                return redirect()->route('test.view', ['id' => $id])->withErrors('Правильный ответ не соответствует типу вопроса!');
            }
        }
        if (strlen($ans1) > 50 || strlen($ans2) > 50 || strlen($ans3) > 50 || strlen($ans4) > 50) {
            return redirect()->route('test.view', ['id' => $id])->withErrors('Вариант ответа не может быть больше 50 символов!');
        }
        $count = 0;
        if ($ans1 != null) {
            $count = $count + 1;
        }
        if ($ans2 != null) {
            $count = $count + 1;
        }
        if ($ans3 != null) {
            $count = $count + 1;
        }
        if ($ans4 != null) {
            $count = $count + 1;
        }
        if ($type == 1 && (int)$right > $count) {
            return redirect()->route('test.view', ['id' => $id])->withErrors('Правильный ответ не может быть больше количества ответов!');
        }
        Test::create([
            'post_id' => $id,
            'text' => $ask,
            'right' => $right,
            'type_id' => $type,
            'ans1' => ($ans1 != null) ? $ans1 : null,
            'ans2' => ($ans2 != null) ? $ans2 : null,
            'ans3' => ($ans3 != null) ? $ans3 : null,
            'ans4' => ($ans4 != null) ? $ans4 : null
        ]);
        return redirect()->route('test.view', ['id' => $id]);
    }

    public function confirm(Request $request, $id)
    {
        $tests = Test::where('post_id', $id)->get();
        foreach ($tests as $test) {
            if ($test->right != $request->get('ans'.$test->id)) {
                return redirect()->route('test.view', ['id' => $id])->withErrors('У вас в тесте присутствуют ошибки!');
            }
        }
        $user = User::where('name', session('name'))->first();
        Testlog::create([
            'user_id' => $user->id,
            'post_id' => $id
        ]);
        $tag = Post::where('id', $id)->first()->tag_id;
        return redirect()->route('tag.view', ['id' => $tag]);
    }

    public function delete($id)
    {
        if (session('name') == null) {
            return redirect()->route('user.loginpage');
        }
        if (session('role') != 1) {
            return redirect()->route('post.mainpage');
        }
        $post = Test::where('id', $id)->first();
        Test::where('id', $id)->first()->delete();
        return redirect()->route('test.view', ['id' => $post->id]);
    }
}
