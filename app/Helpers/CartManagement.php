<?php

namespace App\Helpers;

use App\Models\Producto;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    // Agregar items al carrito
    static public function addItemToCart($producto_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;
        // Buscar si el producto ya está en el carrito
        foreach ($cart_items as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                $existing_item = $key;
                break;
            }
        }
        if ($existing_item !== null) {
            // Incrementar la cantidad del producto existente
            $cart_items[$existing_item]['cantidad']++;
            $cart_items[$existing_item]['monto_total'] = $cart_items[$existing_item]['cantidad'] *
                $cart_items[$existing_item]['monto_unitario'];
        } else {
            // Agregar nuevo producto al carrito
            $producto = Producto::where('id', $producto_id)->first(['id', 'nombre', 'precio', 'imagen']);
            if ($producto) {
                $cart_items[] = [
                    'producto_id' => $producto_id,
                    'nombre' => $producto->nombre,
                    'imagen' => $producto->imagen[0],
                    'cantidad' => 1,
                    'monto_unitario' => $producto->precio,
                    'monto_total' => $producto->precio
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    // Quitar items del carrito
    static public function removeCartItem($producto_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                unset($cart_items[$key]);
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Guardar items en cookies
    static public function addCartItemsToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    // Limpiar items del carrito en cookies
    static public function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // Obtener todos los items del carrito desde cookies
    static public function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }
        return $cart_items;
    }

    // Incrementar cantidad de un item en el carrito
    static public function incrementQuantityToCartItem($producto_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                $cart_items[$key]['cantidad']++;
                $cart_items[$key]['monto_total'] = $cart_items[$key]['cantidad'] *
                    $cart_items[$key]['monto_unitario'];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Decrementar cantidad de un item en el carrito
    static public function decrementQuantityToCartItem($producto_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                if ($cart_items[$key]['cantidad'] > 1) {
                    $cart_items[$key]['cantidad']--;
                    $cart_items[$key]['monto_total'] = $cart_items[$key]['cantidad'] *
                        $cart_items[$key]['monto_unitario'];
                }
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // Calcular el total final del carrito
    static public function calcularTotalFinal($items)
    {
        return array_sum(array_column($items, 'monto_total'));
    }

    static public function addItemToCartWithQty($producto_id, $cantidad = 1)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;
        // Buscar si el producto ya está en el carrito
        foreach ($cart_items as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                $existing_item = $key;
                break;
            }
        }
        if ($existing_item !== null) {
            // Incrementar la cantidad del producto existente
            $cart_items[$existing_item]['cantidad'] = $cantidad;
            $cart_items[$existing_item]['monto_total'] = $cantidad * $cart_items[$existing_item]['monto_unitario'];

        } else {
            // Agregar nuevo producto al carrito
            $producto = Producto::where('id', $producto_id)->first(['id', 'nombre', 'precio', 'imagen']);
            if ($producto) {
                $cart_items[] = [
                    'producto_id' => $producto_id,
                    'nombre' => $producto->nombre,
                    'imagen' => $producto->imagen[0],
                    'cantidad' => $cantidad,
                    'monto_unitario' => $producto->precio,
                    'monto_total' => $cantidad * $producto->precio
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }
}
