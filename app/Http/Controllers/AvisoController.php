<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgendaProfissional;
use App\Http\Requests\StoreAviso;
use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AvisoController extends Controller
{
    public function paginacaoAjax()
    {
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }
        return DataTables::of(Aviso::latest('created_at'))->make(true);
    }

    public function index()
    {
        if (Auth::user()->can('user')) {
            abort(403, 'Acesso não autorizado.');
        }
        $avisos = Aviso::all();
        return view('avisos.index', compact('avisos'));
    }

    public function create()
    {
  
        return view('avisos.create');
    }

    public function store(StoreAviso $request)
    {
    
        Aviso::create($request->all());
        return redirect()->route('avisos.index');
    }

    public function edit($id)
    {

        $aviso = Aviso::find($id);
        return view('avisos.edit', compact('aviso'));
    }

    public function update(StoreAviso $request, $id)
    {
        $aviso = Aviso::find($id);
        $aviso->update($request->all());
        return redirect()->route('avisos.index');
    }

    public function destroy($id)
    {
        $aviso = Aviso::find($id);
        $aviso->delete();
        return redirect()->route('avisos.index');
    }
}
