<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#FF5722] p-6">
        <div class="max-w-md w-full bg-white border-[6px] border-black rounded-[3rem] shadow-[15px_15px_0px_0px_rgba(0,0,0,1)] p-10">

            <div class="text-center mb-8">
                <span class="text-6xl inline-block transform -rotate-12">🍕</span>
                <h2 class="text-4xl font-[900] uppercase italic text-black mt-4 tracking-tighter">¡ÚNETE YA!</h2>
                <p class="text-black font-bold uppercase tracking-widest text-[10px] mt-1">Crea tu cuenta en Prieto Eats</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <input id="name" type="text" name="name" placeholder="TU NOMBRE" value="{{ old('name') }}" required
                           class="w-full border-4 border-black p-4 rounded-2xl font-black placeholder-gray-400 focus:bg-yellow-50 outline-none transition-all">
                    <x-input-error :messages="$errors->get('name')" class="font-bold text-red-600 mt-1" />
                </div>

                <div>
                    <input id="email" type="email" name="email" placeholder="TU EMAIL" value="{{ old('email') }}" required
                           class="w-full border-4 border-black p-4 rounded-2xl font-black placeholder-gray-400 focus:bg-yellow-50 outline-none transition-all">
                    <x-input-error :messages="$errors->get('email')" class="font-bold text-red-600 mt-1" />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <input id="password" type="password" name="password" placeholder="CLAVE" required
                           class="w-full border-4 border-black p-4 rounded-2xl font-black placeholder-gray-400 focus:bg-yellow-50 outline-none transition-all">
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="REPETIR" required
                           class="w-full border-4 border-black p-4 rounded-2xl font-black placeholder-gray-400 focus:bg-yellow-50 outline-none transition-all">
                </div>
                <x-input-error :messages="$errors->get('password')" class="font-bold text-red-600 mt-1" />

                <button type="submit" class="w-full bg-black text-white font-black text-xl py-5 rounded-2xl shadow-[6px_6px_0px_0px_rgba(255,87,34,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all uppercase tracking-tighter">
                    ¡EMPEZAR A PEDIR! ➔
                </button>

                <p class="text-center mt-6">
                    <a href="{{ route('login') }}" class="font-black text-black underline decoration-[#FF5722] decoration-4 underline-offset-4 hover:text-[#FF5722] transition-colors">YA TENGO CUENTA</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
