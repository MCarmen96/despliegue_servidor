<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#FF5722] p-6">
        <div class="max-w-md w-full bg-white border-[6px] border-black rounded-[3rem] shadow-[15px_15px_0px_0px_rgba(0,0,0,1)] p-10">

            <div class="text-center mb-8">
                <h1 class="text-5xl font-[1000] text-black tracking-tighter italic">
                    PRIETO<span class="text-[#FF5722]">EATS</span>
                </h1>
                <div class="h-2 w-16 bg-black mx-auto mt-2 rounded-full"></div>
            </div>

            <x-auth-session-status class="mb-4 font-bold text-green-600" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="text-black font-[900] text-xs uppercase mb-2 block ml-2">Email de Usuario</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full border-4 border-black p-4 rounded-2xl font-black focus:bg-yellow-50 outline-none transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                    <x-input-error :messages="$errors->get('email')" class="font-bold text-red-600 mt-1" />
                </div>

                <div>
                    
                    <div class="flex justify-between items-center mb-2 px-2">
                        <label class="text-black font-[900] text-xs uppercase">Tu Clave</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-gray-400 hover:text-black uppercase">¿Olvido?</a>
                        @endif
                    </div>

                    <input id="password" type="password" name="password" required
                            class="w-full border-4 border-black p-4 rounded-2xl font-black focus:bg-yellow-50 outline-none transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                    <x-input-error :messages="$errors->get('password')" class="font-bold text-red-600 mt-1" />
                </div>

                <div class="flex items-center px-2">
                    <input id="remember_me" type="checkbox" name="remember" class="w-6 h-6 border-4 border-black rounded-lg text-[#FF5722] focus:ring-0">
                    <label for="remember_me" class="ms-3 text-xs font-black text-black uppercase">No me cierres la sesión</label>
                </div>

                <button type="submit" class="w-full bg-black text-white font-black text-2xl py-5 rounded-2xl shadow-[6px_6px_0px_0px_rgba(255,87,34,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all uppercase tracking-tighter">
                    ¡ENTRAR! ➔
                </button>

                <div class="text-center pt-4">
                    <a href="{{ route('register') }}" class="inline-block px-6 py-2 bg-yellow-300 border-4 border-black font-black text-black rounded-xl hover:bg-yellow-400 transition-all transform -rotate-2">
                        CREAR CUENTA NUEVA
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
