<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
        {{--categorias--}}
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-24 -mx-3">
                <div class="w-full pr-2 lg:w-1/4 lg:block">
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400"> Categorias</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            @forelse($categorias as $categoria)
                                <li class="mb-4" wire:key="{{$categoria->id}}">
                                    <label for="{{$categoria -> slug}}" class="flex items-center dark:text-gray-400">
                                        <input type="checkbox" wire:model.live="categorias_seleccionadas"
                                               id="{{$categoria -> slug}}" value="{{$categoria -> id}}"
                                               class="w-4 h-4 mr-2">
                                        <span class="text-lg">{{$categoria->nombre}}</span>
                                    </label>
                                </li>

                            @empty
                            @endforelse

                        </ul>

                    </div>

                    {{--Marcas--}}
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Marcas</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            @forelse($marcas as $marca)
                                <li class="mb-4" wire:key="{{$marca->id}}">
                                    <label for="{{$marca->slug}}" class="flex items-center dark:text-gray-300">
                                        <input type="checkbox" wire:model.live="marcas_seleccionadas"
                                               class="w-4 h-4 mr-2" id="{{$marca -> slug}}" value="{{$marca -> id}}">
                                        <span class="text-lg dark:text-gray-400">{{$marca -> nombre}}</span>
                                    </label>
                            @empty
                            @endforelse

                        </ul>
                    </div>
                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Product Status</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <ul>
                            <li class="mb-4">
                                <label for="featured" class="flex items-center dark:text-gray-300">
                                    <input id="featured" type="checkbox" wire:model.live="en_existencia" class="w-4 h-4 mr-2">
                                    <span class="text-lg dark:text-gray-400">In Stock</span>
                                </label>
                            </li>
                            <li class="mb-4">
                                <label for="" class="flex items-center dark:text-gray-300">
                                    <input type="checkbox" class="w-4 h-4 mr-2" wire:model.live="en_venta">
                                    <span class="text-lg dark:text-gray-400">On Sale</span>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                        <h2 class="text-2xl font-bold dark:text-gray-400">Price</h2>
                        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                        <div>
                            <div class="font-semibold text-blue-900">{{Number::currency($rango_precio, 'lps')}}</div>
                            <input type="range" wire:model.live="rango_precio"
                                   class="w-full h-1 mb-4 bg-blue-100 rounded appearance-none cursor-pointer"
                                   max="50000" value="30000" step="1000">
                            <div class="flex justify-between ">
                                <span class="inline-block text-lg font-bold text-blue-400"> {{Number::currency(1000, 'lps')}}</span>
                                <span class="inline-block text-lg font-bold text-blue-400 ">{{Number::currency(50000, 'lps')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full px-3 lg:w-3/4">
                    <div class="px-3 mb-4">
                        <div
                            class="items-center justify-between hidden px-3 py-2 bg-gray-100 md:flex dark:bg-gray-900 ">
                            <div class="flex items-center justify-between">
                                <select name="" id="" wire:model.live="sort"
                                        class="block w-40 text-base bg-gray-100 cursor-pointer dark:text-gray-400 dark:bg-gray-900">
                                    <option value="recientes" >Sort by latest</option>
                                    <option value="precios" >Sort by Price</option>
                                </select>
                            </div>
                        </div>

                        {{--Productos--}}
                        <div class="flex flex-wrap items-center ">
                            @forelse($productos as $producto)
                                <div class="w-full px-3 mb-6 sm:w-1/2 md:w-1/3" wire:key="{{$producto -> id}}">
                                    <div class="border border-gray-300 dark:border-gray-700">
                                        <div class="relative bg-gray-200">
                                            <a href="/productos/{{$producto -> slug}}" class="">
                                                <img src="{{url('storage', $producto -> imagen[0])}}"
                                                     alt="{{$producto -> imagen[0]}}"
                                                     class="object-cover w-full h-56 mx-auto aspect-square">
                                            </a>
                                        </div>
                                        <div class="p-3 ">
                                            <div class="flex items-center justify-between gap-2 mb-2">
                                                <h3 class="text-xl font-medium dark:text-gray-400">
                                                    {{$producto -> nombre}}
                                                </h3>
                                            </div>
                                            <p class="text-lg ">
                                                <span
                                                    class="text-green-600 dark:text-green-600">{{Number::currency($producto->precio, 'Lps')}}</span>
                                            </p>
                                        </div>
                                        <div
                                            class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">

                                            <a href="#"
                                               class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300">

                                                <span>Add to Cart</span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>
                        <!-- pagination start -->
                        <div class="flex justify-end mt-6">
                            {{$productos -> links()}}
                        </div>
                        <!-- pagination end -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
