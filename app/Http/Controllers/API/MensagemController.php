<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mensagem;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MensagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topicos = Topico::all();
        return $this -> success($topicos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'mensagem' => 'required|max:255',
            'topico' => 'array|exists:App\Models\Topico,id'
        ]);
        if ($validated) {
            try{
                $mensagem = new Mensagem();
                $mensagem->user_id = Auth::user()->id;
                $mensagem->titulo = $request->get('titulo');
                $mensagem->mensagem = $request->get('mensagem');
                if ($request->get('imagem')){
                    $image_base64 = base64_decode($request->get('imagem'));
                    Storage::disk('s3')->put($request->get('file'), $image_base64, 'public');
                    $path = Storage::disk('s3')->url($request->get('file'));
                    $mensagem->imagem = $path;
                }
                $mensagem->save();
                $mensagem->topicos()->attach($request->get('topico'));
                return $this->sucess($mensagem);
            } catch (\Throwable $th) {
                return $this->error("Erro ao cadastrar a mensagem!!!", 401, $th->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $topico = Topico::findOrfail($id);
            return $this -> success ($topico);
        } catch (\Throwable $th){
            return $this -> error ("Tópico não encontrado!", 401, $th -> getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validated([
            'topico' => 'required|max:255',
        ]);
        if ($validated) {
            try {
                $topico = Topicp ::findOrFail($id);
                $topicp->topico = $request->get('topico');
                $topico->save();
                return $this->success($topico);
            } catch (\Throwable $th) {
                return $this->error("Tópico não encontrado!!!", 401, $th->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $topico = Topico::findOrfail($id);
            $topico = Topico->delete();
            return $this -> success ($topico);
        } catch (\Throwable $th){
            return $this -> error ("Tópico não encontrado!", 401, $th -> getMessage());
        }
    }
}
