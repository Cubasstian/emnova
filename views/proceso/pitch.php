<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Pitch
                        <span>
                            <small class="badge badge-ligth text-xs" id="conteo_total"></small>
                        </span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Pitch</li>
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
                                            <th>Gestor</th>
                                            <th>Programación</th>
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

    <div class="modal fade" id="modalCriterios">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCriteriosTitulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioCriterios">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fk_criterios">Criterio</label>
                                    <select class="form-control" name="fk_criterios" id="fk_criterios" required="required"></select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="peso">Peso (%)</label>
                                    <input type="number" class="form-control" name="peso" id="peso" min="1" max="100" step="1" required="required">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-block" title="Agregar criterio">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped table-sm text-sm">
                        <thead>
                            <tr class="text-center">
                                <th>Nombre</th>
                                <th>Peso</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="contenidoCriterios"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEvaluadores">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalEvaluadoresTitulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioEvaluadores">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="evaluador">Evaluador</label>
                                    <select class="form-control" name="evaluador" id="evaluador" required="required"></select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-block" title="Agregar evaluador">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped table-sm text-sm">
                        <thead>
                            <tr class="text-center">
                                <th>Nombre</th>
                                <th>Registro</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="contenidoEvaluadores"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFecha">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalFechaTitulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioFecha">
                        <div class="form-group">
                            <label for="fecha_pitch">Fecha</label>
                            <input type="datetime-local" class="form-control" name="fecha_pitch" step="60" required="required">
                        </div>
                        <div class="form-group">
                            <label for="lugar_pitch">Lugar</label>
                            <input type="text" class="form-control" name="lugar_pitch" required="required">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" form="formularioFecha">Guardar</button>
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
        cargarRegistros({criterio: 'gestor', estado: 3}, 'crear', function(){
            console.log('Cargo...')
        })

        //Llenar criterios
        llenarSelect('criterios', 'select', {info:{estado: 'activo'}, orden: 'nombre'}, 'fk_criterios', 'nombre')
        //Guardar criterio
        $('#formularioCriterios').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))
            datos.fk_ideas = id
            enviarPeticion('ideasCriterios', 'guardarCriterio', {info: datos}, function(r){
                cargarRegistrosCriterios({criterio: 'id', valor: r.insertId}, 'crear', function(){
                    toastr.success('Se agrego correctamente')
                })
            })
        })

        //Llenar evlauadores
        llenarSelect('usuarios', 'select', {info:{rol:'evaluador', estado: 'activo'}, orden: 'nombre'}, 'evaluador', 'nombre')
        //Guardar evaluador
        $('#formularioEvaluadores').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))
            datos.fk_ideas = id
            enviarPeticion('ideasEvaluadores', 'insert', {info: datos}, function(r){
                cargarRegistrosEvaluadores({criterio: 'id', valor: r.insertId}, 'crear', function(){
                    toastr.success('Se agrego correctamente')
                })
            })
        })

        //Formulario fecha
        $('#formularioFecha').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))
            enviarPeticion('ideas', 'update', {info: datos, id: id}, function(r){
                cargarRegistros({criterio: 'id', valor: id}, 'actualizar', function(){
                    $('#modalFecha').modal('hide')
                })
            })
        })
    }

    function cargarRegistros(datos, accion, callback){
        enviarPeticion('ideas', 'getIdeas', datos, function(r){
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
                			<td>${registro.gestor}</td>
                            <td>
                                <table class="table table-xs text-xs">
                                    <tr>
                                        <th>Fecha</th><td>${registro.fecha_pitch}</td>
                                    </tr>
                                    <tr>
                                        <th>Lugar</th><td>${registro.lugar_pitch}</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="mostrarDetalle(${registro.id})" title="Ver detalle">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="mostrarModalCriterios(${registro.id})" title="Configurar criterios">
                                                <i class="fas fa-list-ol"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="jurado(${registro.id})" title="Jurado de votación">
                                                <i class="fas fa-user-graduate"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="fecha(${registro.id})" title="Fecha pitch">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        </td>
                                        <td>
                							<button type="button" class="btn btn-default btn-sm" onClick="aprobar(${registro.id})" title="Aprobar">
                                                <i class="fas fa-check text-success"></i>
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

    //Logica de criterios
    function mostrarModalCriterios(idIdea){
        id = idIdea
        $('#modalCriteriosTitulo').text(`Criterios idea código # I-${idIdea.toString().padStart(3,'0')}`)
        $('#contenidoCriterios').empty()
        cargarRegistrosCriterios({criterio: 'idea', valor: idIdea}, 'crear', function(){
            $('#modalCriterios').modal('show')
        })
    }

    function cargarRegistrosCriterios(datos, accion, callback){
        enviarPeticion('ideasCriterios', 'getIdeasCriterios', datos, function(r){
            let fila = ''
            r.data.map(registro => {
                fila += `<tr id="IC_${registro.id}">
                            <td>${registro.nombre}</td>
                            <td class="text-center">${registro.peso}%</td>
                            <td>
                                <button type="button" class="btn btn-default" onClick="eliminarCriterio(${registro.id})" title="Borrar criterio">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                        </tr>`
            })
            if(accion == 'crear'){
                $('#contenidoCriterios').append(fila)
            }
            callback()
        })
    }

    function eliminarCriterio(idIC){
        enviarPeticion('ideasCriterios', 'delete', {id: idIC}, function(r){
            $(`#IC_${idIC}`).hide('slow')
        })
    }


    //Logica de evaluadores
    function jurado(idIdea){
        id = idIdea
        $('#modalEvaluadoresTitulo').text(`Evaluadores idea código # I-${idIdea.toString().padStart(3,'0')}`)
        $('#contenidoEvaluadores').empty()
        cargarRegistrosEvaluadores({criterio: 'idea', valor: idIdea}, 'crear', function(){
            $('#modalEvaluadores').modal('show')
        })
    }

    function cargarRegistrosEvaluadores(datos, accion, callback){
        enviarPeticion('ideasEvaluadores', 'getIdeasEvaluadores', datos, function(r){
            let fila = ''
            r.data.map(registro => {
                fila += `<tr id="IE_${registro.id}"">
                            <td>${registro.nombre}</td>
                            <td>${registro.registro}</td>
                            <td>
                                <button type="button" class="btn btn-default" onClick="eliminarEvaluador(${registro.id})" title="Borrar gestor">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                        </tr>`
            })
            if(accion == 'crear'){
                $('#contenidoEvaluadores').append(fila)
            }
            callback()
        })
    }
    function eliminarEvaluador(idIE){
        enviarPeticion('ideasEvaluadores', 'delete', {id: idIE}, function(r){
            $(`#IE_${idIE}`).hide('slow')
        })
    }

    //Programación fecha y lugar
    function fecha(idIdea){
        id = idIdea
        $('#modalFechaTitulo').text(`Programación idea código # I-${idIdea.toString().padStart(3,'0')}`)
        $("#formularioFecha").trigger("reset");
        $('#modalFecha').modal('show')
    }

    function aprobar(idIdea){
        Swal.fire({
            icon: 'question',
            title: 'Confirmación',
            html: `Esta seguro de pasar a calificación idea con código # I-${idIdea.toString().padStart(3,'0')}`,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value){
                enviarPeticion('ideas', 'updateIdeasVerificar', {info: {estado: 4}, id: idIdea}, function(r){
                    $(`#${idIdea}`).hide('slow')
                })
            }
        })
    }
</script>
</body>
</html>