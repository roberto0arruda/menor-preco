<?php
/**
 * Created by PhpStorm.
 * User: JPaulo
 * Date: 18/06/2018
 * Time: 15:54
 */

namespace App\Repository;

use App\Models\StoreEndereco;
use App\Models\StoreConsultas;
use App\Models\StoreProducts;
use App\Repository\Importacao\ProdutosConsultas;
use Illuminate\Support\Facades\Auth;

abstract class Strategy
{
    public $heard;
    public $methods;
    public $error;
    public $dtNow;
    public $hrNow;
    /** @var $svConsulta ProdutosConsultas */
    public $svConsulta;

    public function __construct()
    {
        StoreConsultas::truncate();
        //StoreProducts::truncate();
        //StoreEndereco::truncate();
    }

    abstract public function execute();

    public function add()
    {
        $this->insertConsulta();
    }


    private function insertConsulta()
    {
        $newConsulta = new StoreConsultas();
        $newConsulta->id_user       = Auth::user()->id;
        $newConsulta->id_produto    = $this->svConsulta->getIdProduto();
        $newConsulta->id_endereco   = $this->svConsulta->getIdLocal();
        $newConsulta->valor         = $this->svConsulta->getValor();
        $newConsulta->dateEntrada   = $this->dtNow;
        $newConsulta->horaEntrada   = $this->hrNow;
        $newConsulta->save();

    }
}