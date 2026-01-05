<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Sistema de Inscripción</title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    
    <style>
        /* Fondo con imagen */
        .login-page {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), 
                        url('{{ asset("HomePage/vidaEstudiantil/Bievenida_img.jpg") }}') no-repeat center center fixed;
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
        
        /* Estilos para validación en tiempo real */
        .is-valid {
            border-color: #28a745 !important;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        .valid-feedback {
            color: #28a745;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .validation-message {
            font-size: 0.875rem;
            margin-top: 0.25rem;
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
        
        <!-- Card de registro -->
        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Registrar una nueva cuenta</p>

                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Nombre completo" value="{{ old('name') }}" maxlength="255" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Correo electrónico" value="{{ old('email') }}" maxlength="255" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Contraseña" maxlength="8" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control" 
                               placeholder="Repetir contraseña" maxlength="8" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        </div>
                    </div>
                </form>

<p class="mb-0 text-center">
                    <a href="{{ route('login') }}" class="text-center">¿Ya tengo una cuenta? Iniciar sesión</a>
                </p>
                
                <!-- Espacio adicional -->
                <div class="mt-4 mb-3"></div>
                
                <!-- Copyright -->
                <p class="mb-0 text-center text-muted">
                    <small>&copy; {{ date('Y') }} Sistema de Inscripción. Todos los derechos reservados.</small>
                </p>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    
    <!-- Validación en tiempo real -->
    <script>
    $(document).ready(function() {
        let emailTimeout;
        let validationResults = {
            name: false,
            email: false,
            password: false,
            password_confirmation: false
        };
        
        function scrollToBottomIfNeeded() {
            const body = document.body;
            const html = document.documentElement;
            const height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
            const scrollPosition = window.scrollY + window.innerHeight;
            if (scrollPosition >= height) {
                window.scrollTo(0, height);
            }
        }
        
        // Validación del nombre
        $('input[name="name"]').on('input', function() {
            const name = $(this).val();
            const $inputGroup = $(this).closest('.input-group');
            
            // Eliminar mensajes anteriores
            $inputGroup.find('.validation-message').remove();
            $(this).removeClass('is-valid is-invalid');
            
            if (name.length === 0) {
                validationResults.name = false;
                return;
            }
            
            if (name.length < 3) {
                $(this).addClass('is-invalid');
                $inputGroup.append('<div class="validation-message invalid-feedback">El nombre debe tener al menos 3 caracteres.</div>');
                validationResults.name = false;
                scrollToBottomIfNeeded();
            } else if (name.length > 255) {
                $(this).addClass('is-invalid');
                $inputGroup.append('<div class="validation-message invalid-feedback">El nombre no puede tener más de 255 caracteres.</div>');
                validationResults.name = false;
                scrollToBottomIfNeeded();
            } else {
                $(this).addClass('is-valid');
                validationResults.name = true;
            }
        });
        
        // Validación del email
        $('input[name="email"]').on('input', function() {
            const email = $(this).val();
            const $inputGroup = $(this).closest('.input-group');
            
            // Eliminar mensajes anteriores
            $inputGroup.find('.validation-message').remove();
            $(this).removeClass('is-valid is-invalid');
            
            // Limpiar timeout anterior
            clearTimeout(emailTimeout);
            
            if (email.length === 0) {
                validationResults.email = false;
                return;
            }
            
            // Validación básica de formato
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                $(this).addClass('is-invalid');
                $inputGroup.append('<div class="validation-message invalid-feedback">El formato del correo electrónico no es válido.</div>');
                validationResults.email = false;
                return;
            }
            
            if (email.length > 255) {
                $(this).addClass('is-invalid');
                $inputGroup.append('<div class="validation-message invalid-feedback">El correo electrónico no puede tener más de 255 caracteres.</div>');
                validationResults.email = false;
                return;
            }
            
            // Verificar si el email ya existe (con debounce)
            emailTimeout = setTimeout(function() {
                $.get('/check-email?email=' + encodeURIComponent(email))
                    .done(function(data) {
                        if (data.exists) {
                            $('input[name="email"]').addClass('is-invalid');
                            $inputGroup.append('<div class="validation-message invalid-feedback">Este correo electrónico ya está registrado.</div>');
                            validationResults.email = false;
                            scrollToBottomIfNeeded();
                        } else {
                            $('input[name="email"]').removeClass('is-invalid').addClass('is-valid');
                            validationResults.email = true;
                        }
                        scrollToBottomIfNeeded();
                    })
                    .fail(function() {
                        $('input[name="email"]').removeClass('is-invalid').addClass('is-valid');
                        validationResults.email = true;
                        scrollToBottomIfNeeded();
                    });
            }, 500);
        });
        
        // Validación de la contraseña
        $('input[name="password"]').on('input', function() {
            const password = $(this).val();
            const $inputGroup = $(this).closest('.input-group');
            
            // Eliminar mensajes anteriores
            $inputGroup.find('.validation-message').remove();
            $(this).removeClass('is-valid is-invalid');
            
            if (password.length === 0) {
                validationResults.password = false;
                return;
            }
            
            if (password.length !== 8) {
                $(this).addClass('is-invalid');
                $inputGroup.append('<div class="validation-message invalid-feedback">La contraseña debe tener exactamente 8 caracteres.</div>');
                validationResults.password = false;
                scrollToBottomIfNeeded();
            } else {
                $(this).addClass('is-valid');
                validationResults.password = true;
            }
            
            // Revalidar confirmación de contraseña si ya tiene valor
            const confirmValue = $('input[name="password_confirmation"]').val();
            if (confirmValue.length > 0) {
                $('input[name="password_confirmation"]').trigger('input');
            }
        });
        
        // Validación de confirmación de contraseña
        $('input[name="password_confirmation"]').on('input', function() {
            const password = $('input[name="password"]').val();
            const confirmation = $(this).val();
            const $inputGroup = $(this).closest('.input-group');
            
            // Eliminar mensajes anteriores
            $inputGroup.find('.validation-message').remove();
            $(this).removeClass('is-valid is-invalid');
            
            if (confirmation.length === 0) {
                validationResults.password_confirmation = false;
                return;
            }
            
            if (password !== confirmation) {
                $(this).addClass('is-invalid');
                $inputGroup.append('<div class="validation-message invalid-feedback">La confirmación de contraseña no coincide.</div>');
                validationResults.password_confirmation = false;
                scrollToBottomIfNeeded();
            } else {
                $(this).addClass('is-valid');
                validationResults.password_confirmation = true;
            }
        });
        
        // Prevenir envío si hay errores
        $('form').on('submit', function(e) {
            // Forzar validación de todos los campos
            $('input[name="name"]').trigger('input');
            $('input[name="email"]').trigger('input');
            $('input[name="password"]').trigger('input');
            $('input[name="password_confirmation"]').trigger('input');
            
            // Esperar un momento para que se complete la validación
            setTimeout(function() {
                const allValid = Object.values(validationResults).every(result => result === true);
                if (!allValid) {
                    e.preventDefault();
                    alert('Por favor, corrija los errores en el formulario antes de continuar.');
                }
            }, 100);
        });
    });
    </script>
</body>
</html>