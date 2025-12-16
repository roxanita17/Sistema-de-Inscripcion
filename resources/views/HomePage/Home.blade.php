<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gral "Juan Guillermo Iribaren"</title>




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js',
        'resources/css/cusmto_estilos_menu.css',
        'resources/css/home/BoostrapHome.css',
        'resources/css/home/Home.css'
    ])
    
    <style>

    </style>
</head>
<body> 

    @include("HomePage.Encabezado")
    
<div class="caja-imagen-nav" style="background-image: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),url({{asset("HomePage/comunidad/imgNav.jpg")}});">   
        <div class="texto">
            <h2 class="titulo-imagen-nav">Bienvenidos al Liceo Gral "Juan Guillermo Iribarren"</h2>
            <p class="texto-imagen-nav">Formando el futuro con valores y excelencia</p>
            
        </div>
    </div>
    
    <div class="sobre-nosotros">
        <h2 class="titulo-sobre-nosotros">Sobre Nosotros</h2>
    </div>
</div>    
    <!------------------- PRIMERA SECION = VALORES -->
        
    <div>
        <div class="caja-valores">
            <h2 class="Valores"> Valores</h2>
            <div class="row row-ambosValores row-valores1">
                <div class="col col-valorup">
                    <div class="iconosValores">
                        <div class="circulo">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                    </div>                  
                    <br></br>
                    <h6 class="subtitulo-valores">Respeto</h6>
                    <p class="texto-valores">El respeto asegura la convivencia pacífica y el trabajo en equipo en una institución.</p>
                </div>
                <div class="col col-valorup">
                    <div class="iconosValores">
                        <div class="circulo">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                    </div>  
                    <br></br>
                    <h6 class="subtitulo-valores">Responsabilidad</h6>
                    <p class="texto-valores">El respeto garantiza la armonía, mientras que la responsabilidad asegura la integridad y el crecimiento institucional.</p>
                </div>
                <div class="col col-valorup">
                    <div class="iconosValores">
                        <div class="circulo">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                    </div>  
                    <br></br>
                    <h6 class="subtitulo-valores">Productividad</h6>
                    <p class="texto-valores">La comunidad institucional actúa con responsabilidad, ejerciendo sus derechos y asumiendo las consecuencias de sus actos, decisiones u omisiones.</p>
                </div>
                
            </div>
            
            <div class="row row-ambosValores row-valores2">
                
                <div class="col col-valordown col-lg-4">
                    <div class="iconosValores">
                        <div class="circulo">
                            <i class="bi bi-feather"></i>
                        </div>
                    </div>  
                    <br></br>
                    <h6 class="subtitulo-valores">Ética</h6>
                    <p class="texto-valores">La institución enfoca su labor educativa en la formación ética de sus miembros.</p>
                </div>
                <div class="col col-valordown col-lg-4">
                    <div class="iconosValores">
                        <div class="circulo">
                            <i class="bi bi-hammer"></i>
                        </div>
                    </div>  
                    <br></br>
                    <h6 class="subtitulo-valores">Democracia</h6>
                    <p class="texto-valores">Se fomenta la participación para decidir, resolver pacíficamente y promover tolerancia y respeto.</p>
                </div>
                
            </div>
        </div>
    </div>
    

        <!------------------- SEGUNDA SECION = RESEÑA -->
        
        <div class="color-reseña">
            <div class=" accordion accordion-flush" id="accordionFlush">

                <div class="accordion-item">
        
                    <div class="accordion-header">
        
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        
                            <h2 class="titulo-reseña" > Reseña Histórica</h2>
        
                        </button>
                    </div>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        
                        <div class="fondo-reseña accordion-body">
                            <p class="textoReseña"> 
                                El General de Brigada Juan Guillermo Iribarren (1797-1827), prócer de la Independencia nacido en Araure, Portuguesa, se unió al llamado patrio a los 17 años. Combatió en varias batallas, destacándose por su valor y tácticas militares, lo que le valió reconocimientos de Páez y Bolívar. Murió a los 30 años como Comandante General del IV Distrito Militar y su nombre figura en el monumento de la Batalla de Carabobo. El texto también menciona el Nivel Básico Especializado desde 1º hasta 5º año.
        
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!------------------- TERCERA SECION = VISION Y MISION -->
        
        <div class="mision-vision">
            <div class="card">
                <div class="card-front">
                    <div class="card-data">
                        <h2 class="titulo-vision">Vision</h2>
                    </div>
                    
                </div>
                <div class="card-back ">
                    <span class="subtitulo-vision">Vision</span>
                    <p class="texto-vision fs-6">Formar ciudadanos con valores democráticos, respeto, equidad, solidaridad, participación, amor al trabajo y conciencia ambiental para fortalecer Venezuela.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-front">
                    <div class="card-data">
                        <h2 class="titulo-vision">Mision</h2>
                    </div>
                    
                </div>
                <div class="card-back ">
                    <span class="subtitulo-vision">Mision</span>
                    <p class="texto-vision fs-6 " >Egresar bachilleres aptos para la universidad y el mercado laboral, con aprecio por el trabajo y conciencia ambiental, integrándose eficazmente en la sociedad.</p>
                </div>
            </div>
        </div> 
    @include("HomePage.Footer")
</body>
</html>



