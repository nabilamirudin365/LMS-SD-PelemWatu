<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Websd</title>

    @vite('resources/css/app.css')
</head>
<body class="h-full bg-white">

    <div class="flex min-h-full">

        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" 
                 src="{{ asset('images/bglogin.jpg') }}" 
                 alt="Background Login">
        </div>


        {{-- BAGIAN KANAN: FORM LOGIN --}}
        {{-- Kita pindahkan kode form Anda yang sudah ada ke dalam bagian ini --}}
        <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            {{-- Ini adalah kode form Anda yang sudah ada, dibungkus dalam container baru --}}
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                        Login ke Akun Anda
                    </h2>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form class="space-y-6" method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Input Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Alamat Email</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" required autofocus 
                                           class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                                </div>
                            </div>

                            {{-- Input Password --}}
                            <div>
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password" required 
                                           class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                                </div>
                            </div>
                            
                            {{-- Checkbox Ingat Saya & Lupa Password --}}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="remember" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                                </div>
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Lupa password?</a>
                                </div>
                            </div>

                            {{-- Tombol Submit --}}
                            <div>
                                <button type="submit" 
                                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
