<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - Sistema de Inscripción</title>
    
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">  
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    
    <style>
        /*FONDO */
        .login-page {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), 
                        url('{{ asset("HomePage/comunidad/login.jpeg") }}') no-repeat center center fixed;
            background-size: cover;
        }
        
        /* Ajustes adicionales */
        .login-box {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
    
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- Logo -->
        <div class="login-logo">
            <a href="{{ url('/') }}" class="d-flex flex-column align-items-center">
                <div class="logo-container">
                    <img src="{{ asset('HomePage/comunidad/liceoLogo.png') }}" alt="Logo" class="login-logo-img">
                </div>
                <div class="mt-3 text-center">
                    <h4 class="mb-0">Sistema de Inscripción</h4>
                    <small class="text-white-50">Liceo "Gral" Juan Guillermo Iribarren</small>
                </div>
            </a>
        </div>
        
        <!-- Card de login -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inicia sesión para acceder al sistema</p>

                <!-- Mensaje de error general -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" style="font-size: 0.875rem; padding: 0.75rem 1rem;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="font-size: 1rem;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle mr-2" style="font-size: 1rem;"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <span class="mb-0">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    
                    <!-- Email -->
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" 
                               placeholder="correo123@gmail.com" value="{{ old('email') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contraseña -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" 
                               placeholder="Contraseña (8-16 caracteres)" maxlength="16" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recordar sesión -->
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    Recordar sesión
                                </label>
                            </div>
                        </div>
                        <!-- Botón de login -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>
                    </div>
                </form>

                @if (Route::has('password.request'))
                    <p class="mb-1 text-center">
                        <a href="{{ route('password.request') }}" class="text-center">¿Olvidaste tu contraseña?</a>
                    </p>
                @endif
                
                @if (Route::has('register'))
                    <p class="mb-0 text-center">
                        <a href="{{ route('register') }}" class="text-center">Registrar una nueva cuenta</a>
                    </p>
                @endif
                
                <!-- Espacio adicional -->
                <div class="mt-4 mb-3"></div>
                
                <!-- Copyright -->
                <p class="mb-0 text-center text-muted">
                    <small>&copy; {{ date('Y') }} Sistema de Inscripción. Todos los derechos reservados.</small>
                </p>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>