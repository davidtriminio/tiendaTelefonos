<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
        <main class="w-full max-w-md mx-auto p-6">
            <div
                class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Reset password</h1>
                    </div>

                    <div class="mt-5">

                       @if(session('error'))
                            <div class="mt-2 bg-red-500 text-sm text-white rounded-lg p-4" role="alert">
                                <span class="font-bold"> {{session('error')}}
                            </div>
                       @endif

                        <!-- Form -->
                        <form wire:submit.prevent="save">
                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                <div>
                                    <label for="hs-toggle-password" class="block text-sm mb-2 dark:text-white">Password</label>
                                    <div class="relative">

                                        <input id="hs-toggle-password" type="password" wire:model="password"
                                               class="py-3 px-4 block w-full border-2 border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                               placeholder="Enter password" value="12345qwerty">
                                        <button type="button" data-hs-toggle-password='{
                                                    "target": "#hs-toggle-password"
                                                  }' class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                            <svg class="flex-shrink-0 size-3.5 text-gray-400 dark:text-neutral-600"
                                                 width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path class="hs-password-active:hidden"
                                                      d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                                <path class="hs-password-active:hidden"
                                                      d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                                <path class="hs-password-active:hidden"
                                                      d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                                <line class="hs-password-active:hidden" x1="2" x2="22" y1="2"
                                                      y2="22"></line>
                                                <path class="hidden hs-password-active:block"
                                                      d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle class="hidden hs-password-active:block" cx="12" cy="12"
                                                        r="3"></circle>
                                            </svg>
                                        </button>

                                        @error('password')
                                        <div
                                            class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor"
                                                 viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('password')
                                    <p class="text-red-600 mt-2" id="password-error">{{$message}}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <div>
                                    <label for="hs-toggle-password_confirmation" class="block text-sm mb-2 dark:text-white">Confirm
                                        Password</label>
                                    <div class="relative">
                                        <input id="hs-toggle-password_confirmation" type="password" wire:model="password_confirmation"
                                               class="py-3 px-4 block w-full border-2 border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                               placeholder="Enter password" value="12345qwerty">
                                        <button type="button" data-hs-toggle-password='{
                                                    "target": "#hs-toggle-password_confirmation"
                                                  }' class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                            <svg class="flex-shrink-0 size-3.5 text-gray-400 dark:text-neutral-600"
                                                 width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path class="hs-password_confirmation-active:hidden"
                                                      d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                                <path class="hs-password_confirmation-active:hidden"
                                                      d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                                <path class="hs-password_confirmation-active:hidden"
                                                      d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                                <line class="hs-password_confirmation-active:hidden" x1="2" x2="22" y1="2"
                                                      y2="22"></line>
                                                <path class="hidden hs-password_confirmation-active:block"
                                                      d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle class="hidden hs-password_confirmation-active:block" cx="12" cy="12"
                                                        r="3"></circle>
                                            </svg>
                                        </button>
                                        @error('password-confirmation')
                                        <div
                                            class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor"
                                                 viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('password_confirmation')
                                    <p class="text-red-600 mt-2" id="password-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                        class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                    Save password
                                </button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
