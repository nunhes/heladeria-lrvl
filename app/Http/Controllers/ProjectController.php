<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    // definir o metodo inicial da clase
    public function index(){
        // retornar a view de projetos
        // return view('index');
        // buscar os projetos do banco de dados
        $products = DB::table('products')->get();
        // retornar a view de projetos com os produtos
        return view('index', ['products' => $products]);
    }

    // metodo para buscar os produtos da api
     public function products(){
        $products = DB::table('products')->get();
        return view('products', ['products' => $products]);
     }

    // metodo para buscar os produtos da api
     // e mostrar na galeria
     // este metodo se usa para mostrar os produtos na galeria
     // e non na pagina de produtos
    public function gallery(){
        $gallery = DB::table('products')->get();
        return view('gallery', ['products' => $gallery]);
     }

     // metodo para buscar os produtos un a un
     public function single_product(Request $request, $id){
        // buscar o produto pelo id
        $product_array = DB::table('products')->where('id', $id)->get();
        // retornar a view de produto com o produto
        return view('single_product', ['product_array' => $product_array]);
     }
}
