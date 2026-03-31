<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-screen">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Iniciar Sesión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased flex flex-col relative overflow-x-hidden">

    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiMzNzQxNTEiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] opacity-20 z-0"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-transparent to-black/50 z-0 pointer-events-none"></div>

    <header class="w-full py-6 px-8 flex justify-between items-center relative z-10">
        <a href="{{ url('/') }}" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
            NexoApp
        </a>
        <a href="/" class="text-xs tracking-widest text-[#9CA3AF] hover:text-white uppercase transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al Inicio
        </a>
    </header>

    <main class="flex-grow flex flex-col justify-center items-center px-4 py-8 relative z-10">
        
        <div class="w-full max-w-md bg-[#1a1a1a] border border-[#374151] p-8 md:p-12 shadow-2xl animate-fade-in-up">
            
            <div class="mb-10 text-center">
                <a href="/register" class="inline-flex items-center text-[10px] tracking-widest uppercase text-[#9CA3AF] hover:text-white mb-6 transition-colors font-bold">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Atrás
                </a>
                <h1 class="text-3xl font-bold uppercase tracking-wide text-white mb-2">
                    Iniciar Sesión
                </h1>
                <p class="text-[#9CA3AF] text-xs tracking-wide">
                    RELLENA LOS SIGUIENTES REQUISITOS
                </p>
            </div>

            <form class="space-y-8" id="loginForm">
                
                <div class="space-y-6">
                    <div class="group/input relative">
                        <input type="email" id="email" name="email" autocomplete="username email" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Email Address" required />
                        <label for="email" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Email Address</label>
                    </div>
                    
                    <div class="group/input relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" autocomplete="current-password" class="peer w-full bg-transparent border-b border-[#374151] py-3 pr-10 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Contraseña" required />
                        <label for="password" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Contraseña</label>
                        <button type="button" @click="show = !show" class="absolute right-0 top-3 text-[#9CA3AF] hover:text-white transition-colors">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div id="errorMessage" class="text-red-400 text-xs text-center hidden"></div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 cursor-pointer text-[#9CA3AF] hover:text-white transition-colors">
                        <input type="checkbox" id="remember" class="form-checkbox h-3 w-3 bg-transparent border border-[#374151] rounded-none checked:bg-white checked:border-white focus:ring-0 text-black appearance-none transition duration-200 cursor-pointer" />
                        <span class="tracking-wide">Recordarme</span>
                    </label>
                    <a href="/password/reset" class="text-[#9CA3AF] hover:text-white underline decoration-1 underline-offset-4 tracking-wide transition-colors">
                        ¿OLVIDASTE TU CONTRASEÑA?
                    </a>
                </div>

                <button type="submit" class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                    Iniciar Sesión
                </button>

                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-[#374151]"></div>
                    <span class="px-4 text-[#9CA3AF] text-[10px] uppercase tracking-widest">O</span>
                    <div class="flex-grow border-t border-[#374151]"></div>
                </div>

                <div class="space-y-3">
                    <button type="button" onclick="iniciarSesionConGoogle('cliente')" 
                            class="w-full py-4 px-6 bg-transparent text-white font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#EA4335] hover:border-transparent flex items-center justify-center group">
                        <i class="fa-brands fa-google mr-3 group-hover:animate-pulse"></i> 
                        Continuar como Cliente
                    </button>
                    
                    <button type="button" onclick="iniciarSesionConGoogle('admin')" 
                            class="w-full py-4 px-6 bg-transparent text-white font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#EA4335] hover:border-transparent flex items-center justify-center group">
                        <i class="fa-brands fa-google mr-3 group-hover:animate-pulse"></i> 
                        Continuar como Negocio
                    </button>
                </div>

                <div class="text-center pt-4">
                    <p class="text-[#9CA3AF] text-xs">
                        ¿Aún no tienes cuenta? 
                        <a href="/register" class="text-white font-bold tracking-widest uppercase ml-1 hover:underline decoration-1 underline-offset-4 transition-all">
                            Regístrate
                        </a>
                    </p>
                </div>

            </form>
        </div>
        
    </main>

    <footer class="w-full py-6 text-center relative z-10">
        <p class="text-[#374151] text-[10px] tracking-widest uppercase">© 2026 NexoApp Inc.</p>
    </footer>

    <script>
        function iniciarSesionConGoogle(rol) {
            window.location.href = '/auth/google?rol=' + rol;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedEmail = localStorage.getItem('remembered_email');
            if (savedEmail) {
                document.getElementById('email').value = savedEmail;
                document.getElementById('remember').checked = true;
            }
        });

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;
            const errorDiv = document.getElementById('errorMessage');
            const loginBtn = document.querySelector('button[type="submit"]');

            if (remember) {
                localStorage.setItem('remembered_email', email);
            } else {
                localStorage.removeItem('remembered_email');
            }
            
            errorDiv.classList.add('hidden');
            errorDiv.textContent = '';

            loginBtn.disabled = true;
            loginBtn.textContent = 'Procesando...';

            try {
                const response = await window.axios.post('/proxy/login', {
                    email: email,
                    password: password
                });

                if (response.data && response.data.redirect) {
                    window.location.href = response.data.redirect;
                }

            } catch (error) {
                errorDiv.classList.remove('hidden');
                loginBtn.disabled = false;
                loginBtn.textContent = 'Iniciar Sesión';

                if (error.response && error.response.data && error.response.data.message) {
                    errorDiv.textContent = error.response.data.message;
                } else if (error.response && error.response.status === 401) {
                    errorDiv.textContent = 'Email o contraseña incorrectos';
                } else {
                    errorDiv.textContent = 'Error al conectar con el servidor. Intenta más tarde.';
                    console.error('Proxy login error:', error);
                }
            }
        });
    </script>

</body>
</html>