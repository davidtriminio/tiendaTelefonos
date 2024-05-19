<?php

namespace App\Helpers;

use App\Models\Producto;

class CarritotManagement
{
    //Agregar items al carrito
    static public function agregarElementosAlCarrito($producto_id)
    {
        $elementos_carrito = self::getItemsCarritodeCookies();

        $elementos_existentes = null;

        foreach ($elementos_carrito as $key => $elemento) {
            if ($elemento['producto_id' == $producto_id]) {
                $elementos_existentes = $key;
            };

            if ($elementos_existentes !== null) {
                $elementos_carrito[$elementos_existentes]['cantidad']++;
                $elementos_carrito[$elementos_existentes]['monto_total'] = $elementos_carrito[$elementos_existentes]['cantidad'] *
                $elementos_carrito[$elementos_existentes]['monto_unitario'];
            } else {
                $producto = Producto::where('id', $producto_id)->first(['id', 'nombre', 'precio', 'imagen']);

                if ($producto) {
                    $elementos_carrito = [
                        'producto_id' => $producto_id,
                        'nombre' => $producto->nombre,
                        'imagen' => $producto->imagen[0],
                        'cantidad' => 1,
                        'monto_unitario' => $producto->precio,
                        'monto_total' => $producto->precio
                    ];
                }
            }
        }
        self::agregarElementosCarritoACookies($elementos_carrito);
        return count($elementos_carrito);
    }

    //Quitar items al carrito
    static public function quitarElementosCarrito($producto_id)
    {
        $elementos_carrito = self::getItemsCarritodeCookies();

        foreach ($elementos_carrito as $key => $elemento) {
            if ($elemento['producto_id'] == $producto_id) {
                unset($elementos_carrito[$key]);
            }//fin si
        }//fin foreach
        self::getItemsCarritodeCookies($elementos_carrito);
        return $elementos_carrito;
    } //fin funcion

    //Agregar items a cookies
    static public function agregarElementosCarritoACookies($elementos_carrito)
    {
        \Cookie::queue('elementos_carrito', json_encode($elementos_carrito), 60 * 24 * 30);
    }

    //Quitar items de cookies
    static public function quitarElementosCarritodeCookies()
    {
        \Cookie::forget('elementos_carrito');
    }

    //Quitar todos los items de cookies
    static public function getItemsCarritodeCookies()
    {
        $elementos_carrito = json_decode(\Cookie::get('elementos_carrito'), true);
        if (!$elementos_carrito) {
            $elementos_carrito = [];
        }
        return $elementos_carrito;
    }
    //Obtener todos los items de cookies
    //Incrementar cantidad  items al carrito
    static public function incrementarCantidadCarrito($producto_id)
    {
        $elementos_carrito = self::getItemsCarritodeCookies();

        foreach ($elementos_carrito as $key => $elemento) {
            if ($elemento['producto_id'] == $producto_id) {
                $elementos_carrito[$key]['cantidad']++;
                $elementos_carrito[$key]['monto_total'] = $elementos_carrito[$key]['cantidad'] *
                $elementos_carrito[$key]['monto_unitario'];
            }
        }
        self::agregarElementosCarritoACookies($elementos_carrito);
        return $elementos_carrito;
    }
    //Quitar cantidad  items al carrito
    static public function decrementarCantidadCarrito($producto_id){
        $elementos_carrito = self::getItemsCarritodeCookies();

        foreach ($elementos_carrito as $key => $elemento) {
            if ($elemento['producto_id'] == $producto_id) {
                if ($elementos_carrito[$key]['cantidad'] > 1){
                    $elementos_carrito[$key]['cantidad']--;
                    $elementos_carrito[$key]['monto_total'] = $elementos_carrito[$key]['cantidad'] *
                        $elementos_carrito[$key]['monto_unitario'];
                }
            }
        }
        self::agregarElementosAlCarrito($elementos_carrito);
        return $elementos_carrito;
    }
    //Calcular total final
    static public function calcularTotalFinal($elementos){
        return array_sum(array_column($elementos, 'monto_total'));
    }
}
