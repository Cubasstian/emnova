<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Calificar
                        <span>
                            <small class="badge badge-ligth text-xs" id="conteo_total"></small>
                        </span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Calificar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="row">   
                <div class="col">
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-sm">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Código</th>
                                            <th>Fuente</th>
                                            <th>Titulo</th>
                                            <th>Descripción</th>
                                            <th>Días</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenido"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalCalificar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCalificarTitulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioCalificar">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>Descripción</th>
                                    <th>Escala</th>
                                    <th>Calificación</th>
                                </tr>
                            </thead>
                            <tbody id="contenidoCalificar"></tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-lg" form="formularioCalificar" title="Guardar">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('views/footer.php');?>

<script src="dist/js/ideas.js"></script>
<script type="text/javascript">
    var id = 0
    function init(info){
    	//Cargar registros
        cargarRegistros({criterio: 'evaluador', estado: 4}, 'crear', function(){
            console.log('Cargo...')
        })

        //Guardar respuestas
        $('#formularioCalificar').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))
            enviarPeticion('resultados', 'guardarRespuestas', {idea: id, respuestas: datos}, function(r){
                toastr.success('¡Se guardaron correctamente las respuestas!', 'Éxito')
                $('#modalCalificar').modal('hide')
            })
        })
    }

    function cargarRegistros(datos, accion, callback){
        enviarPeticion('ideas', 'getCalificar', datos, function(r){
            let fila = ''
            let fuente = ''
            r.data.map(registro => {
                fuente = 'Ideación abierta'
                if(registro.idReto != 1){
                    fuente = `  <table class="table table-xs text-xs">
                                    <tr>
                                        <th>ID</th><td>${registro.idReto}</td>
                                    </tr>
                                    <tr>
                                        <th>Reto</th><td>${registro.reto}</td>
                                    </tr>
                                </table>`
                }
                fila += `<tr id=${registro.id}>
                            <td>I-${registro.id.toString().padStart(3,'0')}</td>
                            <td>${fuente}</td>
                            <td>${registro.titulo}</td>
                            <td>${registro.descripcion}</td>
                            <td class="text-center">${registro.dias}</td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="mostrarDetalle(${registro.id})" title="Ver detalle">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </td>
                                        <td>
                							<button type="button" class="btn btn-default btn-sm" onClick="calificar(${registro.id})" title="Calificar">
                                                <i class="fas fa-tasks"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="mostrarHistorico(${registro.id})" title="Historico">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>`
            })
            if(accion == 'crear'){
                $('#contenido').append(fila)
            }else{
                $('#'+r.data[0].id).replaceWith(fila)
            }
            callback()
            $('#conteo_total').text(`Total: ${r.data.length || 0}`)
        })
    }

    function calificar(idIdea){
        id = idIdea
        enviarPeticion('resultados', 'getResultados', {criterio: 'evaluador', idea: idIdea}, function(r){
            if(r.data.length == 0){
                enviarPeticion('ideasCriterios', 'getIdeasCriterios', {criterio: 'idea', valor: idIdea}, function(r){
                    let fila = ''
                    r.data.map(registro => {
                        fila += `<tr>
                                    <td>
                                        ${registro.nombre}
                                    </td>
                                    <td>
                                        <p>${registro.descripcion}</p>
                                    </td>
                                    <td>
                                        <p>${registro.escala}</p>
                                    </td>
                                    <td>
                                        <select class="form-control" name="criterio_${registro.idCriterio}" required="required">
                                            <option value="" selected></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                </tr>`
                    })
                    $('#contenidoCalificar').append(fila)
                })
                $('#modalCalificarTitulo').text(`Calificar idea código # I-${idIdea.toString().padStart(3,'0')}`)
                $('#contenidoCalificar').empty()
                $('#modalCalificar').modal('show')
            }else{
                let tabla = `<table class="table table-bordered table-striped table-sm text-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>Criterio</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">`
                r.data.map(registro => {
                    tabla += `<tr>                                
                                <td>${registro.nombre}</td>
                                <td>${registro.valor}</td>
                            </tr>`
                })
                tabla += '</tbody>'
                Swal.fire({
                    title: `Idea código # I-${idIdea.toString().padStart(3,'0')}`,
                    html: tabla
                })
                
            }
        })
        
        
    }
</script>
</body>
</html>