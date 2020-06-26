<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AreaRestritaController extends Controller
{

    protected $redirectTo = '/area-restrita';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $certificados = DB::select('SELECT c.*, m.mtr, os.sequencial AS os_sequencial, os.orcamento_id AS orcamento_id, cl.razao_social AS cliente 
                                            FROM certificados AS c 
                                            INNER JOIN mtrs AS m ON m.id = c.mtr_id 
                                            INNER JOIN ordens_servico AS os ON os.id = m.ordem_servico_id 
                                            INNER JOIN orcamentos AS o ON o.id = os.orcamento_id 
                                            INNER JOIN clientes AS cl ON cl.id = o.cliente_id 
                                            WHERE (cl.id = :id) 
                                            ORDER BY os.id DESC', ['id' => Auth::id()]);
        return view('area-restrita', ['certificados' => $certificados]);
    }
}
