<?php

namespace App\Http\Controllers;
use Mail;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use App\Http\Requests\TarefaRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TarefasExport;
use PDF;

class TarefaController extends Controller
{

    public function __construction()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarefas = Tarefa::paginate(5);
        return view('tarefa.index', ['tarefas' => $tarefas]);
    }


    public function create()
    {
        return view('tarefa.create');
    }

    public function store(TarefaRequest $request)
    {
        $dados            = $request->all('tarefa', 'data_limite_conclusao');
        $user             = auth()->user();
        $dados['user_id'] = $user->id;

        $tarefa = Tarefa::create($dados);
        
       // Mail::to($user->email)->send(new NovaTarefaMail($tarefa));
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        $userId = auth()->user()->id;
        if($tarefa->user_id == $userId){
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }
        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(TarefaRequest $request, Tarefa $tarefa)
    {

        $userId = auth()->user()->id;
        if($tarefa->user_id != $userId){
            return view('acesso-negado');
        }
        $tarefa->update($request->all());
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        $userId = auth()->user()->id;
        if($tarefa->user_id != $userId){
            return view('acesso-negado');
        }
        $tarefa->delete();
        return redirect()->route('tarefa.index');
    }

    public function exportacao($extensao)
    {
        if (!in_array($extensao, ['xlsx','pdf','csv']) ){
            throw new \ErrorException('Extensoes aceitas sao apenas xlsx e csv e pdf');
        }
        $nomeArquivo = 'lista_de_tarefas.'. $extensao;
        return Excel::download(new TarefasExport, $nomeArquivo);
    }

    public function exportar()
    {
        $tarefas = auth()->user()->tarefas()->get();
        $pdf = PDF::loadView('tarefa.pdf', ['tarefas' => $tarefas]);
        $pdf->setPaper('A4', 'landscape');
        //return $pdf->download('lista_de_tarefas.pdf');
        return $pdf->stream('lista_de_tarefas.pdf');
    }
}
