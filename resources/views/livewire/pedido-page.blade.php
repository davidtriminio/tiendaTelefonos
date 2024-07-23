<?php
$departamentos = json_decode(file_get_contents(resource_path('assets/departamentos.json')), true);
$municipios = json_decode(file_get_contents(resource_path('assets/municipios.json')), true);
?>

{{--<style>
    .oculto{
        display: none;
    }
</style>--}}


<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        Pedido
    </h1>
    <form wire:submit.prevent='realizarOrden'>
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            Dirección de envío
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                   Nombres
                                </label>
                                <input wire:model="nombres"
                                       class="w-full rounded-lg border border-gray-500 py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                       @error('nombres') border-red-500 @enderror"
                                       id="first_name" type="text">
                                @error('nombres')
                                <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                    Apellidos
                                </label>
                                <input wire:model="apellidos"
                                       class="w-full rounded-lg border border-gray-500 py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('nombres') border-red-500 @enderror"
                                       id="last_name" type="text">
                                @error('apellidos')
                                <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- /.mt-4 -->

                            <div class="mt-4">
                                <label class="block text-gray-700 dark:text-white mb-1" for="telefono">
                                    Teléfono
                                </label>
                                <input wire:model="telefono"
                                       class="w-full rounded-lg border border-gray-500 py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none  @error('telefono') border-red-500 @enderror"
                                       id="telefono" type="text" inputmode="numeric" maxlength="8" oninput="validatePhone(this)">
                                @error('telefono')
                                <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label class="block text-gray-700 dark:text-white mb-1" for="codigo_postal">
                                    Codigo Postal
                                </label>
                                <input wire:model="codigo_postal"
                                       class="w-full rounded-lg border border-gray-500 py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('codigo_postal') border-red-500 @enderror"
                                       id="codigo_postal" type="text" inputmode="numeric" maxlength="8" oninput="validateZIP(this)">
                                @error('codigo_postal')
                                <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- /.grid grid-cols-2 gap-4 -->
                        <div class="mt-4">
                            <p class="text-xs text-red-600 mt-2" style="display: none"  id="telefono-error">El teléfono debe empezar solo con 2, 3, 8 o 9</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mt-4">
                                <label class="block text-gray-700 dark:text-white mb-1" for="departamento">
                                    Departamento
                                </label>
                                <!-- /.mt-4 -->
                                <select id="departamento" wire:model="departamento"
                                        class=" py-3 px-4 pe-9 block w-full border border-gray-500 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('departamento') border-red-500 @enderror">
                                    <option value="">Open this select menu</option>
                                        <?php foreach ($departamentos as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>

                                @error('departamento')
                                <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label class="block text-gray-700 dark:text-white mb-1" for="municipio">
                                    Municipio
                                </label>
                                <select id="municipio" wire:model="ciudad"
                                        class="py-3 px-4 pe-9 block w-full border border-gray-500 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <option value="">Selecciona un municipio</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.grid grid-cols-2 gap-4 -->

                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="colonia">
                                Direccion Completa
                            </label>
                            <textarea wire:model="colonia"
                                   class="w-full rounded-lg border border-gray-500 py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('colonia') border-red-500 @enderror"
                                   id="colonia" type="text">
                            </textarea>
                            @error('colonia')
                            <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="text-lg font-semibold mb-4">
                        Seleccione Metodo de Envio
                    </div>
                    <ul class="grid w-full gap-6 md:grid-cols-3">
                        <li>
                            <input wire:model="metodo_envio" class="hidden peer" id="expreco" name="expreco" required="" type="radio"
                                   value="expreco"/>
                                    <label
                                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                        for="expreco">
                                        <div class="block">
                                            <div class="w-full text-lg font-semibold">
                                                Cargo Expreco
                                            </div>
                                        </div>
                                        <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                             viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-width="2">
                                            </path>
                                        </svg>
                                    </label>

                        </li>
                        <li>

                            <input wire:model="metodo_envio" class="hidden peer" id="c807" name="c807" type="radio"
                                   value="c807">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="c807">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        C807-Express
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                     viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                        <li>

                            <input wire:model="metodo_envio" class="hidden peer" id="expreso" name="expreso" type="radio"
                                   value="expreso">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="expreso">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Cargo Expreso
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                     viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                    </ul>
                    @error('metodo_envio')
                    <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror

                    <div class="text-lg font-semibold mb-4">
                        Seleccione Metodo de Pago
                    </div>
                    <ul class="grid w-full gap-6 md:grid-cols-3">
                        <li>
                            <input wire:model="metodo_pago" class="hidden peer" id="efectivo" name="efectivo" required="" type="radio"
                                   value="efectivo"/>
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="efectivo">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Efectivo
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                     viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>

                        </li>
                        <li>

                            <input wire:model="metodo_pago" class="hidden peer" id="paypal" name="paypal" type="radio"
                                   value="paypal">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="paypal">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Paypal
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                     viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                        <li>

                            <input wire:model="metodo_pago" class="hidden peer" id="tarjeta" name="tarjeta" type="radio"
                                   value="tarjeta">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="tarjeta">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Tarjeta
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                     viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                    </ul>
                    @error('metodo_pago')
                    <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror

                    <div class="text-lg font-semibold mb-4">
                        Seleccione Moneda
                    </div>
                    <ul class="grid w-full gap-6 md:grid-cols-3">
                        <li>
                            <input wire:model="metodo_pago" class="hidden peer" id="efectivo" name="efectivo" required="" type="radio"
                                   value="efectivo"/>
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="efectivo">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                       Lempiras
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                     viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>

                        </li>
                        <li>

                            <input wire:model="metodo_pago" class="hidden peer" id="paypal" name="paypal" type="radio"
                                   value="paypal">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="paypal">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Dólares
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                     viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                        <li>

                            <input wire:model="metodo_pago" class="hidden peer" id="tarjeta" name="tarjeta" type="radio"
                                   value="tarjeta">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-500 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="tarjeta">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Euros
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                     viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                    </ul>
                    @error('moneda')
                    <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Card -->
            </div>
            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        RESUMEN DEL PEDIDO
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
					<span>
						Subtotal
					</span>
                        <span>
                        {{Number::currency($total_final, 'lps')}}
					</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
					<span>
						Impuestos
					</span>
                        <span>
						0.00
					</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
					<span>
						Gastos de envío
					</span>
                        <span>
						0.00
					</span>
                    </div>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
                    <div class="flex justify-between mb-2 font-bold">
					<span>
						 Total Final
					</span>
                        <span>
						{{Number::currency($total_final, 'lps')}}
					</span>
                    </div>
                    </hr>
                </div>
                <button type="submit" wire:click="realizarOrden" class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                   <span wire:loading.remove>Realizar pedido</span> <span wire:loading>Ordenando</span>
                </button>
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        RESUMEN DE LA CESTA
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @forelse($cart_items as $key => $item)
                            <li wire:key="{{ $item['producto_id'] }}" class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img alt="{{$item['nombre']}}" class="w-12 h-12 rounded-full"
                                             src="{{url('storage', $item['imagen'])}}">
                                        </img>
                                    </div>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{$item['nombre']}}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            Cantidad: {{$item['cantidad']}}
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{Number::currency($item['monto_total'], 'lps')}}
                                    </div>
                                </div>
                            </li>

                        @empty
                        @endforelse

                    </ul>
                </div>
            </div>
        </div>
    </form>

</div>

<script>
    const departamentos = <?php echo json_encode($departamentos); ?>;
    const municipios = <?php echo json_encode($municipios); ?>

    var municipiosPorDepartamento = <?php echo json_encode($municipios); ?>;



    document.getElementById('departamento').addEventListener('change', function () {
        var departamento = this.value;
        var municipios = municipiosPorDepartamento[departamento];
        var municipioDropdown = document.getElementById('municipio');
        municipioDropdown.innerHTML = '<option value="">Selecciona un municipio</option>';
        if (municipios) {
            Object.keys(municipios).forEach(function (key) {
                var option = document.createElement('option');
                option.value = key;
                option.text = municipios[key];
                municipioDropdown.add(option);
            });
        }
    });

    function validatePhone(input) {
        // Elimina cualquier carácter que no sea un número
        input.value = input.value.replace(/[^0-9]/g, '');

        // Limita a 8 caracteres
        if (input.value.length > 8) {
            input.value = input.value.slice(0, 8);
        }

        // Verifica que el primer número sea 2, 3, 8 o 9
        const mensajeError = document.getElementById('telefono-error')
        if (input.value.length > 0 && !/^[2389]/.test(input.value)) {
            mensajeError.style.display = 'block';
        } else {
            mensajeError.style.display = 'none';
        }
    }

    function validateZIP(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 5) {
            input.value = input.value.slice(0, 5);
        }
    }

</script>

<script src="{{asset('js/deptos.js')}}"></script>
