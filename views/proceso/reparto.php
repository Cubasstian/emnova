<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Tipificación y reparto
                        <span>
                            <small class="badge badge-ligth text-xs" id="conteo_total"></small>
                        </span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Reparto</li>
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

    <div class="modal fade" id="modalGestionar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalGestionarTitulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioGestionar">
                        <div class="form-group">
                            <label for="fk_tipos">Tipo</label>
                            <select class="form-control" name="fk_tipos" id="fk_tipos" required="required"></select>
                        </div>
                        <div class="form-group">
                            <label for="gestor">Gestor de innovación</label>
                            <select class="form-control" name="gestor" id="gestor" required="required"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" form="formularioGestionar">Guardar</button>
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
        cargarRegistros({criterio: 'todas', estado: 1}, 'crear', function(){
            console.log('Cargo...')
        })

        //LLenar tipos
        llenarSelect('tipos', 'select', {info:{estado: 'activo'}, orden: 'nombre'}, 'fk_tipos', 'nombre', 1)
        //LLenar gestores
        llenarSelect('usuarios', 'select', {info: {rol: 'Gestor', estado: 'Activo'}, orden: 'nombre'}, 'gestor', 'nombre', 1)

        //Fomulario gestionar
        $('#formularioGestionar').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))
            datos.estado = 1
            datos.observaciones = `Tipo:${$('#fk_tipos option:selected').text()},Gestor: ${$('#gestor option:selected').text()}`
            enviarPeticion('ideas', 'updateIdeas', {info: datos, id: id}, function(r){
                cargarRegistros({criterio: 'id', valor: id}, 'actualizar', function(){
                    $('#modalGestionar').modal('hide')
                    toastr.success("Actualización correcta")
                })
            })
        })
    }

    function cargarRegistros(datos, accion, callback){
        enviarPeticion('ideas', 'getIdeas', datos, function(r){
            let fila = ''
            let fuente = ''
            let botonAsignar = ''
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
            	botonAsignar = ''
            	if(registro.idGestor != 1){
            		botonAsignar = `<button type="button" class="btn btn-default" onClick="aprobar(${registro.id})" title="Aprobar">
                                        <i class="fas fa-check text-success"></i>
                                    </button>`
            	}
                fila += `<tr id=${registro.id}>
                            <td>I-${registro.id.toString().padStart(3,'0')}</td>
                            <td>${fuente}</td>
                            <td>${registro.titulo}</td>
                            <td>${registro.descripcion}</td>
                			<td>${registro.gestor}</td>
                            <td class="text-center">${registro.dias}</td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-default" onClick="mostrarDetalle(${registro.id})" title="Ver detalle">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </td>
                						<td>
                                            <button type="button" class="btn btn-default" onClick="gestionar(${registro.id})" title="gestionar">
                                                <i class="fas fa-cogs"></i>
                                            </button>
                                        </td>
                                        <td>
                							${botonAsignar}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default" onClick="mostrarHistorico(${registro.id})" title="Historico">
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

    function gestionar(idIdea){
        id = idIdea
        $('#modalGestionarTitulo').text(`Gestionar idea código # I-${idIdea.toString().padStart(3,'0')}`)
        $('#modalGestionar').modal('show')
    }

    function aprobar(idIdea){
        Swal.fire({
            icon: 'question',
            title: 'Confirmación',
            html: `Esta seguro de aprobar inicio de refinamiento de idea código # I-${idIdea.toString().padStart(3,'0')}`,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value){                
                enviarPeticion('ideas', 'updateIdeas', {info: {estado: 2}, id: idIdea}, function(r){
                    $(`#${idIdea}`).hide('slow')
                })
            }
        })
    }
</script>
</body>
</html>