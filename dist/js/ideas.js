function mostrarDetalle(idIdea){
    enviarPeticion('ideas', 'getIdeasAll', {criterio: 'id', valor: idIdea}, function(r){
        let tabla = ''
        r.data.map(registro => {
            tabla = `   <table class="table table-bordered table-striped table-sm text-sm">
                        <thead>
                            <tr class="text-center">
                                <th>Campo</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            <tr>
                                <th>Tipo</th>
                                <td>${registro.tipo}</td>
                            </tr>
                            <tr>
                                <th>Titulo</th>
                                <td>${registro.titulo}</td>
                            </tr>
                            <tr>
                                <th>Descripción</th>
                                <td>${registro.descripcion}</td>
                            </tr>
                            <tr>
                                <th>Justificación</th>
                                <td>${registro.justificacion}</td>
                            </tr>
                            <tr>
                                <th>Objetivo</th>
                                <td>${registro.objetivo}</td>
                            </tr>
                            <tr>
                                <th>Beneficios</th>
                                <td>${registro.beneficios}</td>
                            </tr>
                            <tr>
                                <th>Tiempo</th>
                                <td>${registro.tiempo}</td>
                            </tr>
                            <tr>
                                <th>Fecha creación</th>
                                <td>${registro.fecha_creacion}</td>
                            </tr>
                            <tr>
                                <th>Proponente</th>
                                <td>${registro.proponente}</td>
                            </tr>
                            <tr>
                                <th>Gestor de innovación</th>
                                <td>${registro.gestor}</td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                                <td>
                                    <span class="badge badge-${colores[registro.estado]}">
                                        ${estados[registro.estado]}
                                    </span>
                                </td>
                            </tr>
                        </tbody>`
        })
        Swal.fire({
            title: `Idea código # I-${idIdea.toString().padStart(3,'0')}`,
            html: tabla
        })
    })
}

function mostrarIntegrantes(idIdea){
    enviarPeticion('integrantes', 'getIntegrantes', {criterio: 'idea', valor: idIdea}, function(r){
        let fila = ''
        r.data.map(registro => {
            fila += `<tr>
                        <td>${registro.nombre}</td>
                        <td>${registro.registro}</td>
                    </tr>`
        })
        Swal.fire({
            title: `Integrantes idea código # I-${idIdea.toString().padStart(3,'0')}`,
            html: ` <table class="table table-bordered table-striped table-sm text-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Registro</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            ${fila}
                        </tbody>
                    </table>`
        })
    })
}

function mostrarIntegrantesElminar(idIdea){
   
     enviarPeticion('integrantes', 'getIntegrantes', {criterio: 'idea', valor: idIdea}, function(r){
        let fila = ''
        
        r.data.map(registro => {
            console.log('registro',registro);
            fila += `<tr>
                        <td>${registro.nombre}</td>
                        <td>${registro.registro}</td>
                        <td>
                                    <button class="btn btn-danger btn-sm" onClick="eliminarIntegranteModalR(${registro.id}, ${idIdea})" title="Eliminar">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                    </tr>`
        })
        Swal.fire({
            title: `Integrantes idea código # I-${idIdea.toString().padStart(3,'0')}`,
            html: ` <table class="table table-bordered table-striped table-sm text-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Registro</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            ${fila}
                        </tbody>
                    </table>`
        })
    })
}



function mostrarHistorico(idIdea){
    enviarPeticion('ideasHistorico', 'getHistorico', {idea: idIdea}, function(r){
        let fila = ''
        let cambio = ''
        let observacion = ''
        r.data.map(registro => {
            cambio = JSON.parse(registro.informacion)
            observacion = ''
            if(cambio.observaciones != undefined){
                observacion = cambio.observaciones
            }
            fila += `<tr>
                        <td>${registro.nombre}</td>
                        <td>${estados[cambio.estado]}</td>
                        <td>${registro.fecha_creacion}</td>
                        <td>${observacion}</td>
                    </tr>`
        })
        Swal.fire({
            title: `Historico para la idea código # I-${idIdea.toString().padStart(3,'0')}`,
            html: ` <table class="table table-bordered table-sm text-left text-xs">
                        <thead>
                            <tr>
                                <th>Quien</th>
                                <th>Lo paso a</th>
                                <th>Cuando</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${fila}
                        </tbody>
                    </table>`
        })
    })
}