<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gral "Juan Guillermo Iribaren"</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(["resources/css/cusmto_estilos_menu.css"])
    @vite(["resources/css/home/BoostrapHome.css"])
    @vite(["resources/css/home/vidaEstudiantil.css"])
    @vite(["resources/css/home/Home.css"])
    {{-- @vite(["resources/css/home/Encabezado.css"]) --}}
    {{-- @vite(["resources/css/home/Home.css"]) --}}
     @vite(["resources/js/HomePage/script.js"]) 



</head>
<body>

    @include("HomePage.Encabezado")
<div class="caja-imagen-nav" style="background-image: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),url({{asset("HomePage/vidaEstudiantil/Bievenida_img.jpg")}})">
        <div class="texto">
            <h2 class="titulo-imagen-nav">Bienvenidos al Liceo Gral "Juan Guillermo Iribarren"</h2>
            <p class="texto-imagen-nav">Formando el futuro con valores y excelencia</p>

        </div>
</div>

<div class="contenedor">

        <div class="vida-estudiantil">
            <h2 class="vida-est">Vida Estudiantil</h2>
        </div>




    <div class="contenedor-color-slider">
        <div class="contenedor-slider-grandes-talentos ">

            <h2 class="titulo-proyectos">Proyectos socio comunitarios</h2>
            <p class="pa">¡Manos a la obra! Transformando nuestra comunidad juntos</p>
            <p class="pa">En nuestra comunidad, no solo soñamos con un mejor entorno, ¡trabajamos para lograrlo! A través de diversos proyectos, nos unimos para recuperar mobiliario, embellecer espacios, fortalecer la autoestima y compartir ideas que impulsen el cambio. Desde la donación de insumos hasta charlas inspiradoras, cada iniciativa es una oportunidad para crecer, aprender y hacer la diferencia. ¡Juntos construimos un futuro más brillante!</p>

            <div class="card-body">
                <div class="contenedor-card">
                    <div class="card-wrapper swiper">
                        <!-- Flecha izquierda -->
                        <div class="swiper-button-prev"></div>
                        
                        <ul class="card-list swiper-wrapper">
                            <li class="card-item swiper-slide">
                                <a href="#" class="card-link">
                                    <img src="HomePage/vidaEstudiantil/proyecto-soc-2.jpg" alt="Card" class="card-image">
                                    <h3 class="subtitulo proyect-1">Recuperacion de Ambientes</h3>
                                    <p class="card-title">Pintamos, limpiamos y renovamos espacios para hacer de nuestra comunidad un lugar más agradable y acogedor.</p>

                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="#" class="card-link">
                                    <img src="HomePage/vidaEstudiantil/proyecto-soc-3.jpg" alt="Card " class="card-image">
                                    <p class="subtitulo proyect-2">Charlas Sobre Autoestima</p>
                                    <h2 class="card-title">Construyamos confianza y amor propio. En nuestras charlas, aprendemos a valorarnos y enfrentar desafíos con actitud positiva.</h2>

                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="#" class="card-link">
                                    <img src="HomePage/vidaEstudiantil/proyecto-soc-1.jpg" alt="Card " class="card-image">
                                    <p class="subtitulo proyect-3">Recuperación De Mobiliario</p>
                                    <h2 class="card-title">¡Démosle nueva vida a nuestros muebles! Restauramos sillas, mesas y escritorios para brindar espacios más cómodos y funcionales.</h2>

                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="#" class="card-link">
                                    <img src="HomePage/vidaEstudiantil/proyecto-soc-5.jpg" alt="Card " class="card-image">
                                    <p class="subtitulo proyect-4">Donación De Productos De Limpieza</p>
                                    <h2 class="card-title">Contribuimos a la salud y bienestar de todos con donaciones de productos esenciales para mantener nuestros espacios limpios y seguros.</h2>

                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="#" class="card-link">
                                    <img src="HomePage/vidaEstudiantil/proyecto-soc-4.jpg" alt="Card " class="card-image">
                                    <p class="subtitulo proyect-5">Proyecto De Vida</p>
                                    <h2 class="card-title">¿Qué quieres lograr en el futuro? A través de orientación y reflexión, ayudamos a jóvenes a trazar su camino con metas claras.</h2>

                                </a>
                            </li>
                        </ul>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="contenedor-color-grandes-talentos">
        <div class="contenedor-slider-grandes-talentos ">

            <div class="container-fluid contenedor-grandes-talentos">
                <h2 class="titulo-grandes-talentos">Grandes Talentos</h2>
                <h4 class="subtitulo-grandes-talentos">Retos extraacadémicos en ciencias: innovación y conocimiento en ación</h4>
                <p class="texto-grandes-talentos">El aprendizaje va más allá de las aulas, y nuestros estudiantes lo demuestran en cada reto que enfrentan. A través de ferias, concursos y demostraciones científicas, ponen a prueba su creatividad, conocimientos y habilidades para resolver problemas. Estos eventos, tanto a nivel local como estatal, reflejan el compromiso con la excelencia y la pasión por el saber.</p>
                
                <!-- Sección de maquetas en feria estatal -->
                <div class="d-flex flex-wrap align-items-stretch mb-5">
                    <!-- Imagen -->
                    <div class="col-12 col-md-6 p-0">
                        <img class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 300px;" src="HomePage/vidaEstudiantil/maquetas-feria-estadal.jpg" alt="talentos">
                    </div>
                    
                    <!-- Texto -->
                    <div class="col-12 col-md-6 p-4 d-flex flex-column justify-content-center">
                        <h3>Demostraciones de maquetas en la Feria Estatal</h3>
                        <p class="m-0">Con talento y dedicación, nuestros estudiantes representaron a la institución en una destacada feria estatal, donde exhibieron maquetas científicas que reflejan su capacidad de investigación y diseño. Esta experiencia les permitió compartir conocimientos con otros jóvenes apasionados por la ciencia y reafirmar su compromiso con la excelencia académica.</p>
                    </div>
                </div>

                <!-- Sección de Feria de Ciencias -->
                <div class="d-flex flex-wrap align-items-stretch mb-5">
                    <!-- Texto -->
                    <div class="col-12 col-md-6 p-4 d-flex flex-column justify-content-center order-2 order-md-1">
                        <h3>Feria de Ciencias</h3>
                        <p class="m-0">Nuestra institución abre sus puertas a la creatividad y el ingenio con la Feria de Ciencias, un evento local donde los estudiantes presentan proyectos innovadores y experimentos científicos. Aquí, la curiosidad y el pensamiento crítico toman protagonismo, impulsando el aprendizaje a través de la práctica y la experimentación.</p>
                    </div>
                    
                    <!-- Imagen -->
                    <div class="col-12 col-md-6 p-0 order-1 order-md-2">
                        <img class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 300px;" src="HomePage/vidaEstudiantil/feria-ciencias.jpg" alt="Feria de Ciencias">
                    </div>
                </div>
                <!-- movil -->
                <div class="row mb-5 d-flex d-md-none gap-2">
                    <div class="col-12 ">
                        <div class="grandesTalentosMovil p-2 rounded">
                            <img class="img-talento p-3 w-100" src="HomePage/vidaEstudiantil//maquetas-feria-estadal.jpg" alt="talentos">
                            <h3>Demostraciones de maquetas en la Feria Estatal movil</h3>
                            <p class="p-2">Con talento y dedicación, nuestros estudiantes representaron a la institución en una destacada feria estatal, donde exhibieron maquetas científicas que reflejan su capacidad de investigación y diseño. Esta experiencia les permitió compartir conocimientos con otros jóvenes apasionados por la ciencia y reafirmar su compromiso con la excelencia académica.
                            </p>
                        </div>
                    </div>
                    <div class="col-12 rounded">
                        <div class="grandesTalentosMovil p-2 rounded">
                            <img class="img-talento p-3 w-100" src="HomePage/vidaEstudiantil//feria-ciencias.jpg" alt="talentos">
                            <h3>Feria de Ciencias</h3>
                            <p class="p-2">Nuestra institución abre sus puertas a la creatividad y el ingenio con la Feria de Ciencias, un evento local donde los estudiantes presentan proyectos innovadores y experimentos científicos. Aquí, la curiosidad y el pensamiento crítico toman protagonismo, impulsando el aprendizaje a través de la práctica y la experimentación.
                            </p>
                        </div>
                    </div>
                </div>

                </div>

            </div>
        </div>
    </div>



</div>

@include("HomePage.Footer")


{{-- </div> --}}




</body>
</html>

