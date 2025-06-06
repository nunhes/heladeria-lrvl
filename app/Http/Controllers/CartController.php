<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // metodos de la clase que son chamados por route/web.php
    public function cart()
    {
        // Lógica para mostrar o carrito
        return view('cart');
    }

    public function add_to_cart(Request $request)
    {
        // Lógica para engadir un produto ao carrito
        // Aquí podes acceder aos datos do formulario usando $request->input('nome_do_campo')
        if($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');     
            
            $products_array_ids = array_column($cart, 'id');
            $id = $request->input('id');


            if(!in_array($id, $products_array_ids)) {
                // Se o produto non está no carrito, engadímolo
                    $id = $request->input('id');
                    $name = $request->input('name');
                    $image = $request->input('image');
                    $price = $request->input('price');
                    $quantity = $request->input('quantity'); // Cantidade por defecto é 1
                    $sale_price = $request->input('sale_price'); // Prezo de venda, se existe

                    if ($sale_price != null) {
                        $price_to_charge = $sale_price; // Se hai prezo de venda, usámolo
                    }
                    else {
                        $price_to_charge = $price; // Se non hai prezo de venda, usamos o prezo normal
                    }
                    $product_array = array(
                        'id' => $id,
                        'name' => $name,
                        'image' => $image,
                        'price' => $price_to_charge,
                        'quantity' => $quantity
                         );

                $cart[$id] = $product_array; // Engadimos o produto ao carrito
                $request->session()->put('cart', $cart); // Actualizamos a sesión

            } else {
                echo "<script>alert('O produto xa está no carriño.')</script>";
            }

            $this->calculateTotalCart($request);

            return view('cart');
            
            } else {
                                
                // Se o carrito non existe, creámolo e engadimos o produto
                $cart = array();

                // engadir producto a cart
                $id = $request->input('id');
                    $name = $request->input('name');
                    $image = $request->input('image');
                    $price = $request->input('price');
                    $quantity = $request->input('quantity'); // Cantidade por defecto é 1
                    $sale_price = $request->input('sale_price'); // Prezo de venda, se existe
                    if ($sale_price != null) {
                        $price_to_charge = $sale_price; // Se hai prezo de venda, usámolo
                    }
                    else {
                        $price_to_charge = $price; // Se non hai prezo de venda, usamos o prezo normal
                    }
                    $product_array = array(
                        'id' => $id,
                        'name' => $name,
                        'image' => $image,
                        'price' => $price_to_charge,
                        'quantity' => $quantity
                         );

                $cart[$id] = $product_array; // Engadimos o produto ao carrito
                $request->session()->put('cart', $cart); // Actualizamos a sesión

                $this->calculateTotalCart($request);

            return view('cart');
            }
    }


    public function calculateTotalCart(Request $request)
    {
        // Lógica para calcular o total do carrito
        $cart = $request->session()->get('cart');
        $total_price = 0;
        $total_quantity = 0;

        foreach($cart as $id => $product){
            $product = $cart[$id];

            $price = $product['price'];
            $quantity = $product['quantity'];
            //$total_price += $price * $quantity; // Prezo total do produto
            //$total_quantity += $quantity; // Cantidade total de produtos
            $total_price = $total_price + ($price * $quantity); // Prezo total do produto
            $total_quantity = $total_quantity + $quantity; // Cantidade total de produtos
        }

        // Actualizamos o total do carrito na sesión
        $request->session()->put('total', $total_price);
        $request->session()->put('quantity', $total_quantity);
    }


    function remove_from_cart(Request $request)
    {
        // Lógica para eliminar un produto do carrito
        if($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            $id = $request->input('id');

            /* if(array_key_exists($id, $cart)) {
                unset($cart[$id]); // Eliminamos o produto do carrito
                $request->session()->put('cart', $cart); // Actualizamos a sesión

                $this->calculateTotalCart($request);
            } else {
                echo "<script>alert('O produto non está no carriño.')</script>";
            } */
           unset($cart[$id]); // Eliminamos o produto do carrito
           
           $request->session()->put('cart', $cart); // Actualizamos a sesión

           $this->calculateTotalCart($request);

        
       }

        return view('cart');
    }
}
