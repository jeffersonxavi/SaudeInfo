<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;

class EspecialidadeController extends Controller
{
    public function index()
    {
        $especialidades = Especialidade::all();
        return view('especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('especialidades.create');
    }

    public function store(Request $request)
    {
        $tag = $request->input('tag');

        // Verifica se já existe uma especialidade com o mesmo nome
        $especialidade = Especialidade::where('nome', $tag)->first();

        if ($especialidade) {
            // Se existir, retorna o ID da especialidade
            return response()->json(['id' => $especialidade->id]);
        } else {
            // Caso contrário, cria uma nova especialidade
            $especialidade = new Especialidade();
            $especialidade->nome = $tag;
            $especialidade->save();

            return response()->json(['id' => $especialidade->id]);
        }
    }

    public function edit($id)
    {
        $especialidade = Especialidade::find($id);
        return view('especialidades.edit', compact('especialidade'));
    }

    public function update(Request $request, $id)
    {
        $especialidade = Especialidade::find($id);
        $especialidade->update($request->all());
        return redirect()->route('especialidades.index');
    }

    public function destroy($id)
    {
        $especialidade = Especialidade::find($id);
        $especialidade->delete();
        return redirect()->route('especialidades.index');
    }
}
