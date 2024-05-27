<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500">Mis Ordenes</h1>
    <div class="flex flex-col bg-white p-5 rounded mt-4 shadow-lg">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Orden
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Fecha
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Estado del Pedido
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Estado del Pago
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Total de La Orden
                            </th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ordenes as $orden)
                            @php
                                $estado_orden = '';
                                 if($orden->estado_envio == 'nuevo'){
                                     $estado_orden = '<span class="bg-blue-700 py-1 px-3 rounded text-white shadow">Nuevo</span>';
                                 } elseif ($orden->estado_envio == 'procesado'){
                                     $estado_orden = '<span class="bg-orange-700 py-1 px-3 rounded text-white shadow">En Proceso</span>';
                                 } elseif ($orden->estado_envio == 'enviado'){
                                     $estado_orden = '<span class="bg-green-600 py-1 px-3 rounded text-white shadow">Enviado</span>';
                                 } elseif ($orden->estado_envio == 'entregado'){
                                     $estado_orden = '<span class="bg-green-700 py-1 px-3 rounded text-white shadow">Entregado</span>';
                                 } else{
                                     $estado_orden = '<span class="bg-red-700 py-1 px-3 rounded text-white shadow">Cancelado </span>';
                                 }

                                 $estado_pago = '';
                                 if($orden->estado_pago == 'fallo'){
                                     $estado_pago = '<span class="bg-red-700 py-1 px-3 rounded text-white shadow">Falló</span>';
                                 } elseif ($orden->estado_pago == 'pendiente'){
                                     $estado_pago = '<span class="bg-orange-700 py-1 px-3 rounded text-white shadow">Pendiente</span>';
                                 } else {
                                     $estado_pago = '<span class="bg-green-700 py-1 px-3 rounded text-white shadow">Pagado</span>';
                                 }

                                 $moneda = '';
                                 if ($orden -> moneda == 'usd'){
                                     $moneda = 'usd';
                                  } elseif ($orden -> moneda == 'lps'){
                                      $moneda = 'lps';
                                  } else{
                                       $moneda = 'eur';
                                  }
                            @endphp
                            <tr wire:key="{{$orden -> id}}"
                                class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$orden->id}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $orden->created_at ->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{!! $estado_orden !!}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{!! $estado_pago !!}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{Number::currency($orden -> total_final, $moneda)}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <a href="/mis-pedidos/{{$orden->id}}"
                                       class="bg-slate-600 text-white py-2 px-4 rounded-md hover:bg-slate-500">Ver Detalles</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    {{$ordenes -> links()}}
                </div>
            </div>
        </div>
    </div>
</div>
