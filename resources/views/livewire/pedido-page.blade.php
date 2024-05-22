<?php
$departamentos = json_decode(file_get_contents(resource_path('assets/departamentos.json')), true);
$municipios = json_decode(file_get_contents(resource_path('assets/municipios.json')), true);
?>

<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        Checkout
    </h1>
    <form wire:submit.prevent='realizarOrden'>
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            Shipping Address
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                    First Name
                                </label>
                                <input wire:model="nombres"
                                       class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                       @error('nombres') border-red-500 @enderror"
                                       id="first_name" type="text">
                                </input>
                                @error('nombres')
                                <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                    Last Name
                                </label>
                                <input wire:model="apellidos"
                                       class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('nombres') border-red-500 @enderror"
                                       id="last_name" type="text">
                                </input>
                                @error('apellidos')
                                <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="telefono">
                                Phone
                            </label>
                            <input wire:model="telefono"
                                   class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none  @error('telefono') border-red-500 @enderror"
                                   id="telefono" type="text">
                            </input>
                            @error('telefono')
                            <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="departamento">
                                Departamento
                            </label>
                            <!-- /.mt-4 -->
                            <select id="departamento" wire:model="departamento"
                                    class="border-2 py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('departamento') border-red-500 @enderror">
                                <option value="">Open this select menu</option>
                                <?php foreach ($departamentos as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>

                            @error('departamento')
                            <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror

                            {{--<label class="block text-gray-700 dark:text-white mb-1" for="municipio">
                                <select id="municipio"
                                        class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <option value="">Open this select menu</option>
                                </select>--}}
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="ciudad">
                                Municipio
                            </label>
                            <input wire:model="ciudad"
                                   class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('ciudad') border-red-500 @enderror"
                                   id="ciudad" type="text">
                            </input>
                            @error('ciudad')
                            <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="codigo_postal">
                                Codigo Postal
                            </label>
                            <input wire:model="codigo_postal"
                                   class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('codigo_postal') border-red-500 @enderror"
                                   id="codigo_postal" type="number">
                            </input>
                            @error('codigo_postal')
                            <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="colonia">
                                Direccion Completa
                            </label>
                            <textarea wire:model="colonia"
                                   class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('colonia') border-red-500 @enderror"
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
                                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
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
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
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
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
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
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
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
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
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
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="tarjeta">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Tarjeta de Credito/Debito
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
                </div>
                <!-- End Card -->
            </div>
            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        ORDER SUMMARY
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
						Taxes
					</span>
                        <span>
						0.00
					</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
					<span>
						Shipping Cost
					</span>
                        <span>
						0.00
					</span>
                    </div>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
                    <div class="flex justify-between mb-2 font-bold">
					<span>
						Grand Total
					</span>
                        <span>
						{{Number::currency($total_final, 'lps')}}
					</span>
                    </div>
                    </hr>
                </div>
                <button type="submit" wire:click="realizarOrden" class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                    Place Order
                </button>
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        BASKET SUMMARY
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
    const municipios = <?php echo json_encode($municipios); ?>;
</script>

<script src="{{asset('js/deptos.js')}}"></script>
