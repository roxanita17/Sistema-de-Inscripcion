// alert("hola")
import axios from "axios"
import dayjs from "dayjs";

// TODO: eliminar (supender el Calendario Escolar en espera)
// TODO: tarea programada para poder abrir y cerrar Calendarios Escolares



(function(){

    let dataGlobal=null;

    window.modalModoRegistro = () => {
    modificarTituloModal("formularioLabel", "Calendario Escolar Activación");

    let botonContinuiar = document.getElementById("botonContinuiar");
    let botonExtender = document.getElementById("botonExtender");
    botonContinuiar.classList.remove("d-none");
    botonExtender.classList.add("d-none");

    limpiarFormulario();

    let inputInicioAnoEscolar = document.getElementById("inicio_ano_escolar");
    let contenedorInputCerrarAnoEscolar = document.getElementById("contenedorInputCerrarAnoEscolar");
    let contenedorInputExtenderAnoEscolar = document.getElementById("contenedorInputExtenderAnoEscolar");
    inputInicioAnoEscolar.removeAttribute("readonly");
    contenedorInputCerrarAnoEscolar.classList.remove("d-none");
    contenedorInputExtenderAnoEscolar.classList.add("d-none");


    const hoy = dayjs();
    const añoActual = hoy.year();
    let fechaInicioDefault, fechaCierreDefault;

    // Si estamos antes de septiembre, el Calendario Escolar comenzará en septiembre de este año
    if (hoy.month() < 8) { // Antes de septiembre
        fechaInicioDefault = hoy.month(8).date(1); // 1 de septiembre del año actual
        fechaCierreDefault = hoy.add(1, 'year').month(6).date(30); // 30 de julio del año siguiente
    }
    // Si estamos en o después de septiembre, el Calendario Escolar comenzará en septiembre del año actual
    // (no se permiten años futuros)
    else {
        fechaInicioDefault = hoy.month(8).date(1); // 1 de septiembre del año actual
        fechaCierreDefault = hoy.add(1, 'year').month(6).date(30); // 30 de julio del año siguiente
    }

    // Verificar si hay años activos que podrían afectar las fechas por defecto
    const buscarActivoOExtendido = dataGlobal?.find(reg => reg.status === "Activo" || reg.status === "Extendido");
    if (buscarActivoOExtendido) {
        const fechaMinima = buscarActivoOExtendido.extencion_ano_escolar ?
            dayjs(buscarActivoOExtendido.extencion_ano_escolar).add(1, "day") :
            dayjs(buscarActivoOExtendido.cierre_ano_escolar).add(1, "day");

        if (fechaInicioDefault.isBefore(fechaMinima)) {
            // Ajustar al siguiente septiembre disponible
            fechaInicioDefault = fechaMinima.month(8).date(1);
            if (fechaMinima.month() > 8) { // Si ya pasó septiembre, ir al próximo año
                fechaInicioDefault = fechaInicioDefault.add(1, 'year');
            }
            fechaCierreDefault = fechaInicioDefault.add(10, 'months').month(6).date(30);
        }
    }


    inputInicioAnoEscolar.value = fechaInicioDefault.format("YYYY-MM-DD");
    document.getElementById("cierre_ano_escolar").value = fechaCierreDefault.format("YYYY-MM-DD");


    const event = new Event('change');
    inputInicioAnoEscolar.dispatchEvent(event);
    document.getElementById("cierre_ano_escolar").dispatchEvent(event);
};

    // window.modalModoRegistro= () => {
    //     modificarTituloModal("formularioLabel","Calendario Escolar Activación")

    //     let botonContinuiar= document.getElementById("botonContinuiar")
    //     let botonExtender=document.getElementById("botonExtender")
    //     botonContinuiar.classList.remove("d-none")
    //     botonExtender.classList.add("d-none")

    //     limpiarFormulario()

    //     let inputInicioAnoEscolar=document.getElementById("inicio_ano_escolar")
    //     let contenedorInputCerrarAnoEscolar=document.getElementById("contenedorInputCerrarAnoEscolar")
    //     let contenedorInputExtenderAnoEscolar=document.getElementById("contenedorInputExtenderAnoEscolar")
    //     inputInicioAnoEscolar.removeAttribute("readonly")
    //     contenedorInputCerrarAnoEscolar.classList.remove("d-none")
    //     contenedorInputExtenderAnoEscolar.classList.add("d-none")

    //     let buscarActivoOExtendido=dataGlobal.find(reg => reg.status==="Activo" || reg.status==="Extendido")
    //     console.log("find  => ",buscarActivoOExtendido)

    //     // esto se encarga de que si hay un Calendario Escolar activo o extendido
    //     let fecha=null
    //     if(buscarActivoOExtendido){
    //         if(buscarActivoOExtendido.extencion_ano_escolar){
    //             fecha=dayjs(buscarActivoOExtendido.extencion_ano_escolar).add(1,"day").format("YYYY-MM-DD")
    //         }
    //         else{
    //             fecha=dayjs(buscarActivoOExtendido.cierre_ano_escolar).add(1,"day").format("YYYY-MM-DD")
    //         }
    //         document.getElementById("inicio_ano_escolar").setAttribute("min",fecha)
    //         document.getElementById("inicio_ano_escolar").value=fecha
    //         document.getElementById("cierre_ano_escolar").setAttribute("min",fecha)
    //         document.getElementById("cierre_ano_escolar").value=fecha
    //     }


    // }

    window.modalModoExtender= (id) => {
        modificarTituloModal("formularioLabel","Extender Calendario Escolar")

        let botonContinuiar= document.getElementById("botonContinuiar")
        let botonExtender=document.getElementById("botonExtender")
        botonContinuiar.classList.add("d-none")
        botonExtender.classList.remove("d-none")

        limpiarFormulario()

        let inputInicioAnoEscolar=document.getElementById("inicio_ano_escolar")
        let contenedorInputCerrarAnoEscolar=document.getElementById("contenedorInputCerrarAnoEscolar")
        let contenedorInputExtenderAnoEscolar=document.getElementById("contenedorInputExtenderAnoEscolar")
        inputInicioAnoEscolar.setAttribute("readonly","readonly")
        contenedorInputCerrarAnoEscolar.classList.add("d-none")
        contenedorInputExtenderAnoEscolar.classList.remove("d-none")

        let registro=dataGlobal.find(reg => reg.id===id)
        console.log("datos a editar => ",registro)

        // let buscarEnEspera=dataGlobal.find(reg => reg.status==="En Espera")
        let buscarEnEspera=dataGlobal.find(reg => reg.status==="inactivo")
        console.log("find  => ",buscarEnEspera)

        let fecha=null
        if(buscarEnEspera){
            fecha=dayjs(buscarEnEspera.inicio_ano_escolar).subtract("1","day").format("YYYY-MM-DD")
            document.getElementById("extencion_ano_escolar").setAttribute("max",fecha)
            document.getElementById("extencion_ano_escolar").value=fecha
        }

        insertarDatosFormulario(registro)


    }

    function limpiarFormulario(){
        limpiarAlerta("contendorAlertaFormulario")
        document.getElementById("id_ano_escolar").value="null"

        document.getElementById("inicio_ano_escolar").value=""
        document.getElementById("inicio_ano_escolar").removeAttribute("min")
        document.getElementById("inicio_ano_escolar_error").textContent=""

        document.getElementById("cierre_ano_escolar").value=""
        document.getElementById("cierre_ano_escolar_error").removeAttribute("min")
        document.getElementById("cierre_ano_escolar_error").textContent=""

        document.getElementById("extencion_ano_escolar").value=""
        document.getElementById("extencion_ano_escolar_error").removeAttribute("min")
        document.getElementById("extencion_ano_escolar_error").removeAttribute("max")
        document.getElementById("extencion_ano_escolar_error").textContent=""
         document.getElementById("extencion_ano_escolar").removeAttribute("max")
    }

    function insertarDatosFormulario(data){
        document.getElementById("id_ano_escolar").value=data.id

        document.getElementById("inicio_ano_escolar").value=data.inicio_ano_escolar

        document.getElementById("cierre_ano_escolar").value=data.cierre_ano_escolar

        let fechaLimite=dayjs(data.cierre_ano_escolar).add(3,"week")



        if(data.extencion_ano_escolar==null){
            let fecha=dayjs(data.cierre_ano_escolar).add(1,"day").format("YYYY-MM-DD")
            document.getElementById("extencion_ano_escolar").setAttribute("min",fecha)
            document.getElementById("extencion_ano_escolar").value=fecha
        }
        else{
            let fecha=dayjs(data.cierre_ano_escolar).add(1,"day").format("YYYY-MM-DD")
            document.getElementById("extencion_ano_escolar").setAttribute("min",fecha)
            document.getElementById("extencion_ano_escolar").value=data.extencion_ano_escolar
        }
        document.getElementById("extencion_ano_escolar").setAttribute("max",fechaLimite.format("YYYY-MM-DD"))


    }

    function modificarTituloModal(id,titulo="sin titulo"){
        document.getElementById(id).textContent=titulo
    }

    // |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    // window.validarFormularioCrear= () => {
    //      if(!validacionesAlCrear()){
    //         ejecutarModal("#modalConfirmacionCreacion")
    //     }
    // }

    // window.validarFormularioExtender= () => {
    //      if(!validacionesAlCrear()){
    //         ejecutarModal("#modalConfirmacionExtencion")
    //     }
    // }

    // |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    window.crearAnoEscolar= () => {
        let formulario=document.getElementById("form")
        // console.log(formulario)
        const datosFormulario=new FormData(formulario)
        // alert("ok")
        crear(datosFormulario)
        // alert("Crear")
    }

    window.extenderAnoEscolar= () => {
        let formulario=document.getElementById("form")
        // console.log(formulario)
        const datosFormulario=new FormData(formulario)
        // alert("ok extender")
        extender(datosFormulario)
    }

    // function crear(data){
    //     axios.post("/app/anio-escolar/crear",data)
    //     .then(res => {
    //         console.log("respuesta => ",res)
    //         cargarDatos()
    //         ejecutarModal("#modalConfirmacionCreacion")

    //     })
    //     .catch(error => {
    //         console.error("error del servidor => ",error)
    //     })
    // }

    function crear(data) {
    axios.post("/app/anio-escolar/crear", data)
    .then(res => {
            console.log("respuesta => ",res)
            cargarDatos();
            ejecutarModal("#modalConfirmacionCreacion");

    })
    .catch(error => {
        document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
                ejecutarModal("#formulario")
        let mensajeError=error.response.data.message
                mostrarAlertaError(mensajeError,"warning","contendorAlertaFormulario")
        console.error("Error del servidor => ", error);

    });
}


    function mostrarAlertaError(mensaje="sin mensaje",tipoAlerta="primary",idContenedorAlerta=""){
        let alerta=`
        <div class="alert alert-${tipoAlerta} alert-dismissible fade show" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        `;
        let contenedorAlerta=document.getElementById(idContenedorAlerta)
        if(contenedorAlerta){
            contenedorAlerta.innerHTML=alerta;
        }
    }

    function limpiarAlerta(idContenedorAlerta=""){
        let contenedorAlerta=document.getElementById(idContenedorAlerta)
        if(contenedorAlerta){
            contenedorAlerta.innerHTML="";
        }
    }

    function extender(data){
        axios.post(`/app/anio-escolar/extender`,data)
        .then(res => {
            console.log("respuesta => ",res)
            cargarDatos()
            ejecutarModal("#modalConfirmacionExtencion")
        })
        .catch(error => {
            console.error("error del servidor => ",error)
        })
    }

    function cargarDatos(){
        document.getElementById("contenedorLoader").classList.add("mostrar-loader")
        dataGlobal=null
        axios.get("/app/anio-escolar/consultar-todo")
        .then(res => {
            console.log("respuesta => ",res)
            dataGlobal=[...res.data.data]
            cargarDatosEnLaTabla(dataGlobal)
            document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
        })
        .catch(error => {
            document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
            console.error("error del servidor => ",error)
        })
    }

    function cargarDatosEnLaTabla(data){
        let bodyTabla=document.getElementById("registroTabla")
        bodyTabla.innerHTML=`
         <tr>
                <td colspan="4" style="text-align: center;">Sin Registros</td>
        </tr>
        `
        if(data.length>0){
            // let rowHtml=[]
            let regisgistros=data.map(reg => {
                let accionesHtml=``;
                let cierre=dayjs(reg.cierre_ano_escolar).format("DD/MM/YYYY")
                if(reg.extencion_ano_escolar!=null){
                    cierre=dayjs(reg.extencion_ano_escolar).format("DD/MM/YYYY")
                }

                // if(reg.status==="En Espera"){
                //         // <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                //         //     data-bs-target="#modalConfirmacionEliminar" onclick="cargarIdAnoEscolarSuspender(${reg.id})">
                //         //     <i class="bi bi-trash3-fill"></i>
                //         // </button>
                //     accionesHtml=`
                //         <button type="button" class="btn btn-success" data-bs-toggle="modal"
                //             data-bs-target="#modalConfirmacionActivarAnoEscolar" onclick="cargarIdAnoEscolarActivar(${reg.id})">
                //             <i class="bi bi-check-lg">Activar</i>
                //         </button>
                //     `;
                // }
                if(reg.status==="inactivo"){
                        // <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        //     data-bs-target="#modalConfirmacionEliminar" onclick="cargarIdAnoEscolarSuspender(${reg.id})">
                        //     <i class="bi bi-trash3-fill"></i>
                        // </button>
                    accionesHtml=`
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#modalConfirmacionActivarAnoEscolar" onclick="cargarIdAnoEscolarActivar(${reg.id})">
                            <i class="bi bi-check-lg">Activar</i>
                        </button>
                    `;
                }

                if(reg.status==="Activo" || reg.status==="Extendido"){
                    accionesHtml=`
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modalConfirmacionInactivarAnoEscolar" onclick="cargarIdAnoEscolarInactivar(${reg.id})">
                            <i class="bi bi-slash-circle">Inactivar</i>
                        </button>

                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                         data-bs-target="#formulario" onclick="modalModoExtender(${reg.id})">
                            <i class="bi bi-pencil-square"> Editar </i>
                        </button>


                    `;

                }

                // if(reg.status==="Suspendido"){
                //     accionesHtml=``;
                // }

                return `
                <tr>
                    <td>${dayjs(reg.inicio_ano_escolar).format("DD/MM/YYYY")}</td>
                    <td>${cierre}</td>
                    <td>${reg.status}</td>
                    <td>

                        ${accionesHtml}

                    </td>
                </tr>
                `
            }).join("")
            bodyTabla.innerHTML=regisgistros
        }

    }

    cargarDatos()

    // ||||||||||||||||||||||||||||||||||||||||||||||||||||||

// function validacionesAlCrear() {
//     const inputInicio = document.getElementById("inicio_ano_escolar");
//     const inputCierre = document.getElementById("cierre_ano_escolar");
//     const errorInicio = document.getElementById("inicio_ano_escolar_error");
//     const errorCierre = document.getElementById("cierre_ano_escolar_error");

//     let hayErrores = false;


//     if (!inputInicio.value) {
//         errorInicio.textContent = "Este campo es obligatorio";
//         hayErrores = true;
//     } else {
//         const fechaInicio = dayjs(inputInicio.value);
//         const añoActual = dayjs().year();

//         if (fechaInicio.month() !== 8) {
//             errorInicio.textContent = "La fecha de inicio debe ser en septiembre";
//             hayErrores = true;
//         }

//         if (fechaInicio.year() > añoActual) {
//             errorInicio.textContent = `No se puede crear un Calendario Escolar futuro. El año máximo permitido es ${añoActual}`;
//             hayErrores = true;
//         }
//     }


//     if (!inputCierre.value) {
//         errorCierre.textContent = "Este campo es obligatorio";
//         hayErrores = true;
//     } else {
//         const fechaCierre = dayjs(inputCierre.value);

//         if (fechaCierre.month() !== 6) {
//             errorCierre.textContent = "La fecha de cierre debe ser en julio";
//             hayErrores = true;
//         }

//         if (inputInicio.value) {
//             const fechaInicio = dayjs(inputInicio.value);

//             if (fechaCierre.isSame(fechaInicio)) {
//                 errorCierre.textContent = "No pueden tener la misma fecha";
//                 hayErrores = true;
//             }

//             if (fechaCierre.isBefore(fechaInicio)) {
//                 errorCierre.textContent = "La fecha de cierre no puede ser anterior a la de inicio";
//                 hayErrores = true;
//             }

//             const diferenciaMeses = fechaCierre.diff(fechaInicio, 'month');
//             if (diferenciaMeses < 10 || diferenciaMeses > 11) {
//                 errorCierre.textContent = "El Calendario Escolar debe durar aproximadamente 10 meses (septiembre-julio)";
//                 hayErrores = true;
//             }
//         }
//     }

//     return hayErrores;
// }


// document.addEventListener('DOMContentLoaded', function() {
//     const inputInicio = document.getElementById("inicio_ano_escolar");
//     const inputCierre = document.getElementById("cierre_ano_escolar");

//     if (inputInicio && inputCierre) {
//         // Función para sugerir fecha de cierre automática
//         const sugerirFechaCierre = () => {
//             if (!inputInicio.value) return;

//             const fechaInicio = dayjs(inputInicio.value);
//             const fechaCierreSugerida = fechaInicio.add(10, 'months').month(6);

//             if (!inputCierre.value || dayjs(inputCierre.value).month() !== 6) {
//                 inputCierre.value = fechaCierreSugerida.format("YYYY-MM-DD");
//             }
//         };

//         inputInicio.addEventListener('change', function() {
//             validacionesAlCrear(); // Validar al cambiar
//             sugerirFechaCierre();
//         });

//         inputCierre.addEventListener('change', validacionesAlCrear);
//     }
// });


// Funciones auxiliares para manejo de errores
function mostrarError(elemento, mensaje) {
    const errorElement = document.getElementById(`${elemento.id}_error`);
    if (errorElement) {
        errorElement.textContent = mensaje;
        elemento.classList.add('is-invalid');
    }
}

function limpiarError(elemento) {
    const errorElement = document.getElementById(`${elemento.id}_error`);
    if (errorElement) {
        errorElement.textContent = '';
        elemento.classList.remove('is-invalid');
    }
}

function validacionesAlCrear() {
    const inputInicio = document.getElementById("inicio_ano_escolar");
    const inputCierre = document.getElementById("cierre_ano_escolar");
    let hayErrores = false;


    limpiarError(inputInicio);
    limpiarError(inputCierre);

    if (!inputInicio.value) {
        mostrarError(inputInicio, "Este campo es obligatorio");
        hayErrores = true;
    } else {
        const fechaInicio = dayjs(inputInicio.value);
        const añoActual = dayjs().year();

        if (fechaInicio.month() !== 8) { // 8 = septiembre (0-11)
            mostrarError(inputInicio, "La fecha de inicio debe ser en septiembre");
            hayErrores = true;
        }

        if (fechaInicio.year() > añoActual) {
            mostrarError(inputInicio, `No se puede crear un Calendario Escolar futuro. El año máximo permitido es ${añoActual}`);
            hayErrores = true;
        }
    }


    if (!inputCierre.value) {
        mostrarError(inputCierre, "Este campo es obligatorio");
        hayErrores = true;
    } else {
        const fechaCierre = dayjs(inputCierre.value);

        if (fechaCierre.month() !== 6) { // 6 = julio
            mostrarError(inputCierre, "La fecha de cierre debe ser en julio");
            hayErrores = true;
        }

        if (inputInicio.value) {
            const fechaInicio = dayjs(inputInicio.value);

            if (fechaCierre.isSame(fechaInicio)) {
                mostrarError(inputCierre, "No pueden tener la misma fecha");
                hayErrores = true;
            }

            if (fechaCierre.isBefore(fechaInicio)) {
                mostrarError(inputCierre, "La fecha de cierre no puede ser anterior a la de inicio");
                hayErrores = true;
            }

            const diferenciaMeses = fechaCierre.diff(fechaInicio, 'month');
            if (diferenciaMeses < 10 || diferenciaMeses > 11) {
                mostrarError(inputCierre, "El Calendario Escolar debe durar aproximadamente 10 meses (septiembre-julio)");
                hayErrores = true;
            }
        }
    }

    return hayErrores;
}


function sugerirFechaCierre() {
    const inputInicio = document.getElementById("inicio_ano_escolar");
    const inputCierre = document.getElementById("cierre_ano_escolar");

    if (!inputInicio.value) return;

    const fechaInicio = dayjs(inputInicio.value);
    const fechaCierreSugerida = fechaInicio.add(10, 'months').month(6);

    if (!inputCierre.value || dayjs(inputCierre.value).month() !== 6) {
        inputCierre.value = fechaCierreSugerida.format("YYYY-MM-DD");
        limpiarError(inputCierre); // Limpiar error si se autocompleta correctamente
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const inputInicio = document.getElementById("inicio_ano_escolar");
    const inputCierre = document.getElementById("cierre_ano_escolar");

    if (inputInicio && inputCierre) {

        inputInicio.addEventListener('input', function() {
            limpiarError(inputInicio);
            validacionesAlCrear();
            sugerirFechaCierre();
        });

        inputCierre.addEventListener('input', function() {
            limpiarError(inputCierre);
            validacionesAlCrear();
        });


        inputInicio.addEventListener('blur', validacionesAlCrear);
        inputCierre.addEventListener('blur', validacionesAlCrear);
    }
});


window.validarFormularioCrear = () => {
    if (!validacionesAlCrear()) {
        ejecutarModal("#modalConfirmacionCreacion");
    }
};

window.validarFormularioExtender = () => {
    if (!validacionesAlCrear()) {
        //si se esta extendiendo un año activo
        const idAnoExtender = document.getElementById("id_ano_escolar")?.value;
        const anoExtender = dataGlobal?.find(reg => reg.id == idAnoExtender);

        if (!anoExtender || (anoExtender.status !== "Activo" && anoExtender.status !== "Extendido")) {
            console.log("Solo se pueden extender Calendarios Escolares activos");
            return;
        }
        ejecutarModal("#modalConfirmacionExtencion");
    }
};


    // ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    // function validacionesAlCrear(){
    //     let estado=false
    //     let inputInicio=document.getElementById("inicio_ano_escolar")
    //     let inputInicioMensaja=document.getElementById("inicio_ano_escolar_error")
    //     let inputCierre=document.getElementById("cierre_ano_escolar")
    //     let inputCierreMensaja=document.getElementById("cierre_ano_escolar_error")
    //     inputInicioMensaja.textContent=""
    //     inputCierreMensaja.textContent=""

    //     if(inputInicio.value==""){
    //         estado=true
    //         inputInicioMensaja.textContent="Este campo es obligatorio"
    //     }

    //     if(inputCierre.value==""){
    //         estado=true
    //         inputCierreMensaja.textContent="Este campo es obligatorio"
    //     }

    //     if(inputInicio.value!="" && inputCierre.value!=""){
    //         if(dayjs(inputInicio.value).isSame(dayjs(inputCierre.value))){
    //             estado=true
    //             inputInicioMensaja.textContent="No pueden tener la misma fecha"
    //             inputCierreMensaja.textContent="No pueden tener la misma fecha"
    //         }
    //         if(dayjs(inputInicio.value).isAfter(dayjs(inputCierre.value))){
    //             estado=true
    //             inputInicioMensaja.textContent="La fecha de inicio no puede ser despues que la fecha cierre"
    //         }
    //         if(dayjs(inputInicio.value).isSame(dayjs(inputCierre.value),"year")){
    //             estado=true
    //             inputInicioMensaja.textContent="No puede estar en el mismo año"
    //             inputCierreMensaja.textContent="No puede estar en el mismo año"
    //         }

    //     }



    //     return estado
    // }

    // window.cargarIdAnoEscolarSuspender= (id) => {
    //     document.getElementById("id_ano_escolar_suspender").value=id

    // }

    // window.suspender= () => {
    //     let idAnoEscolar=document.getElementById("id_ano_escolar_suspender").value
    //     // alert(idAnoEscolar)
    //     document.getElementById("contenedorLoader").classList.add("mostrar-loader")
    //      axios.delete(`/app/anio-escolar/suspender/${idAnoEscolar}`)
    //     .then(res => {
    //         document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
    //         ejecutarModal("#modalConfirmacionEliminar")
    //         cargarDatos()
    //     })
    //     .catch(error => {
    //         document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
    //         console.error("error del servidor => ",error)
    //     })
    // }


    window.cargarIdAnoEscolarInactivar= (id) => {
        document.getElementById("id_ano_escolar_inactivar").value=id
    }
    window.inactivar = () =>{
        let idAnoEscolar=document.getElementById("id_ano_escolar_inactivar").value

        document.getElementById("contenedorLoader").classList.add("mostrar-loader");
        axios.get(`/app/anio-escolar/inactivar/${idAnoEscolar}`)
        .then( res => {
            document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
            ejecutarModal("#modalConfirmacionInactivarAnoEscolar")
            cargarDatos()
            location.reload()
        })
        .catch(error => {
            document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
            console.error("error del servidor =>",error)
        })
    }

    window.cargarIdAnoEscolarActivar= (id) => {
        document.getElementById("id_ano_escolar_activar").value=id
    }



    window.activar= () => {
        let idAnoEscolar=document.getElementById("id_ano_escolar_activar").value
        // alert(idAnoEscolar)
        document.getElementById("contenedorLoader").classList.add("mostrar-loader")
         axios.get(`/app/anio-escolar/activar/${idAnoEscolar}`)
        .then(res => {
            document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
            ejecutarModal("#modalConfirmacionActivarAnoEscolar")
            cargarDatos()
            location.reload()
        })
        .catch(error => {
            document.getElementById("contenedorLoader").classList.remove("mostrar-loader")
            console.error("error del servidor => ",error)
        })
    }
/*
    //Mostrar resutados a tiempo real
    document.getElementById('buscador').addEventListener('keyup', function() {
            let filtro = this.value.toLowerCase();
            let filas = document.querySelectorAll('#tabla tr');

            filas.forEach(function(fila) {
                let texto = fila.textContent.toLowerCase();
                fila.style.display = texto.includes(filtro) ? '' : 'none';
            });
        });*/
})()
