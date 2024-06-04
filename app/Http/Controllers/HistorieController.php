<?php

namespace App\Http\Controllers;

use App\Models\Historie;
use Illuminate\Http\Request;
use App\Traits\ReflactionNameMethod;

class HistorieController extends Controller
{
    use ReflactionNameMethod;
    public function index(Request $request, Historie $historie)
    {
        return view('listHistories', [
            'histories' => $historie->all()->toArray(),
            'order'     => (('asc' == ($request->order ?? 'desc')) ? 'desc' : 'asc')
        ]);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(Historie $historie)
    {
        //
    }
    public function edit(Historie $historie)
    {
        //
    }
    public function update(Request $request, Historie $historie)
    {
        //
    }
    public function destroy(Historie $historie)
    {
        //
    }
}
