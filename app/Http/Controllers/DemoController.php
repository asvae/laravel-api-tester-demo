<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;

class DemoController extends Controller
{
    public function json()
    {
        return response()->json(['this', 'is' => 'json']);
    }

    public function varDump()
    {
        var_dump(['this', 'is' => 'var_dump']);
    }

    public function dd()
    {
        dd([
            'several',
            'values' => ['to', 'dump', 'and' => 'die'],
        ]);
    }

    public function request(Request $request)
    {
        return $request->all();
    }

    public function status(Request $request)
    {
        return $request->all();

        abort($request->status);
    }

    public function redirect($times = 1)
    {
        if (! $times) {
            return 'Redirections done';
        }

        return redirect('http://localhost:8080/api/redirect/'.($times - 1));
    }

    public function string()
    {
        return 'some static';
    }

    public function abort()
    {
        abort(418);
    }
}