<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Mis ideas
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Mis ideas</li>
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
                                            <th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenido"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal para gestionar archivos de la idea -->
    <div class="modal fade" id="modalGestionArchivos">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-folder-open mr-2 text-warning"></i> Archivos de la Idea</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Anexo</th>
                                    <th>Estado / Ruta</th>
                                    <th class="text-center" style="width: 250px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listaArchivosCuerpo">
                                <!-- Se cargará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para gestionar integrantes de la idea -->
    <div class="modal fade" id="modalGestionIntegrantes">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-users mr-2 text-primary"></i> Gestionar Integrantes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Buscador e Inline Form para agregar nuevos integrantes -->
                    <div class="card card-outline card-primary mb-3">
                        <div class="card-header py-1">
                            <h3 class="card-title font-weight-bold" style="font-size: 0.9rem;">Agregar Integrante</h3>
                        </div>
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-0">
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control" id="buscarRegistroIntegrante" placeholder="Registro...">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" onclick="buscarIntegrantePorRegistro()">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control form-control-sm" id="nombreNuevoIntegrante" readonly placeholder="Nombre del integrante...">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success btn-sm btn-block" id="botonAgregarIntegrante" onclick="agregarIntegranteAIdea()" disabled>
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de integrantes actuales -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Registro</th>
                                    <th class="text-center" style="width: 100px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listaIntegrantesCuerpo">
                                <!-- Se cargará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('views/footer.php');?>

<script src="dist/js/ideas.js"></script>
<script type="text/javascript">
    var cantidadIdeasDoc = 1;

	function init(info){
        enviarPeticion('documentos', 'select', {info: {formulario: 'ideas'}}, function(r){
            if (r.data && r.data.length > 0) {
                cantidadIdeasDoc = parseInt(r.data[0].cantidad);
            }
        });

		cargarRegistros({criterio: 'proponente'}, function(){

        })
	}

    function cargarRegistros(datos, callback){
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
                            <td>I-${(registro.fecha_creacion || '').slice(0, 7)}-${registro.id.toString().padStart(3,'0')}</td>
                            <td>${fuente}</td>
                            <td>${registro.titulo}</td>
                            <td>${registro.descripcion}</td>
                            <td class="text-center">
                                <span class="badge badge-${colores[registro.estado]}">
                                    ${estados[registro.estado]}
                                </span>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="mostrarDetalle(${registro.id})" title="ver detalle">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="mostrarIntegrantes(${registro.id})" title="ver integrantes">
                                                <i class="fas fa-users"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" onClick="abrirModalArchivos(${registro.id})" title="Ver/Editar Archivos">
                                                <i class="fas fa-file-pdf text-danger"></i>
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
            $('#contenido').html(fila)
            callback()
        })
    }

    var idIdeaSeleccionada = null;

    function abrirModalArchivos(idIdea) {
        idIdeaSeleccionada = idIdea;
        $('#modalGestionArchivos').modal('show');
        cargarListaArchivos();
    }

    function cargarListaArchivos() {
        let idIdea = idIdeaSeleccionada;
        enviarPeticion('ideasArchivos', 'select', {info: {fk_idideas: idIdea}}, function(r) {
            let html = '';
            let archivosExistentes = {};
            if (r.data && r.data.length > 0) {
                r.data.forEach(function(archivo) {
                    let match = archivo.ruta.match(/_(\d+)\.pdf$/);
                    let index = match ? parseInt(match[1]) : 1;
                    archivosExistentes[index] = archivo;
                });
            }

            for (let i = 1; i <= cantidadIdeasDoc; i++) {
                let archivo = archivosExistentes[i];
                let estadoBadge = '';
                let accionesHtml = '';

                if (archivo) {
                    estadoBadge = `<span class="badge badge-success"><i class="fas fa-check-circle"></i> Cargado</span><br><small class="text-muted">${archivo.ruta}</small>`;
                    accionesHtml = `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info" onclick="downloadDocument(${idIdea}, 'ideas', ${i})" title="Visualizar">
                                <i class="fas fa-eye"></i> Ver
                            </button>
                            <label class="btn btn-sm btn-warning mb-0" style="cursor:pointer;" title="Reemplazar archivo">
                                <i class="fas fa-sync-alt"></i> Reemplazar
                                <input type="file" style="display:none;" accept=".pdf" onchange="subirReemplazarArchivo(this, ${i}, ${archivo.id})">
                            </label>
                        </div>
                    `;
                } else {
                    estadoBadge = `<span class="badge badge-secondary"><i class="fas fa-times-circle"></i> No cargado</span>`;
                    accionesHtml = `
                        <label class="btn btn-sm btn-success mb-0" style="cursor:pointer;" title="Cargar archivo">
                            <i class="fas fa-upload"></i> Cargar
                            <input type="file" style="display:none;" accept=".pdf" onchange="subirNuevoArchivo(this, ${i})">
                        </label>
                    `;
                }

                html += `
                    <tr>
                        <td class="align-middle"><strong>Anexo ${i}</strong></td>
                        <td class="align-middle">${estadoBadge}</td>
                        <td class="text-center align-middle">${accionesHtml}</td>
                    </tr>
                `;
            }
            $('#listaArchivosCuerpo').html(html);
        });
    }

    function subirNuevoArchivo(input, index) {
        let idIdea = idIdeaSeleccionada;
        comprobarExtensionArchivoPDF(input);
        if (input.files.length === 0) return;

        cargarDocumento(input, idIdea, 'ideas', function(uploadRes) {
            if (uploadRes.ejecuto) {
                let filePath = 'ideas/' + idIdea + '/' + idIdea + '_' + index + '.pdf';
                enviarPeticion('ideasArchivos', 'insert', {
                    info: {
                        fk_idideas: idIdea,
                        ruta: filePath,
                        estado: 1
                    }
                }, function(dbRes) {
                    toastr.success('Archivo subido y registrado correctamente');
                    cargarListaArchivos();
                });
            } else {
                toastr.error('Error al subir archivo');
            }
        }, index);
    }

    function subirReemplazarArchivo(input, index, idArchivo) {
        let idIdea = idIdeaSeleccionada;
        comprobarExtensionArchivoPDF(input);
        if (input.files.length === 0) return;

        cargarDocumento(input, idIdea, 'ideas', function(uploadRes) {
            if (uploadRes.ejecuto) {
                let filePath = 'ideas/' + idIdea + '/' + idIdea + '_' + index + '.pdf';
                enviarPeticion('ideasArchivos', 'update', {
                    info: {
                        ruta: filePath,
                        estado: 1
                    },
                    id: idArchivo
                }, function(dbRes) {
                    toastr.success('Archivo reemplazado correctamente');
                    cargarListaArchivos();
                });
            } else {
                toastr.error('Error al reemplazar el archivo');
            }
        }, index);
    }

    var idIdeaSeleccionadaIntegrantes = null;
    var integranteEncontrado = null;

    function mostrarIntegrantes(idIdea) {
        idIdeaSeleccionadaIntegrantes = idIdea;
        integranteEncontrado = null;
        $('#buscarRegistroIntegrante').val('');
        $('#nombreNuevoIntegrante').val('');
        $('#botonAgregarIntegrante').prop('disabled', true);
        
        $('#modalGestionIntegrantes').modal('show');
        cargarListaIntegrantes();
    }

    function cargarListaIntegrantes() {
        let idIdea = idIdeaSeleccionadaIntegrantes;
        enviarPeticion('integrantes', 'getIntegrantes', {criterio: 'idea', valor: idIdea}, function(r) {
            let html = '';
            if (r.data && r.data.length > 0) {
                let totalIntegrantes = r.data.length;

                r.data.forEach(function(registro) {
                    let botonEliminar = '';
                    if (totalIntegrantes > 1) {
                        botonEliminar = `
                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarIntegranteDeIdea(${registro.id})" title="Eliminar Integrante">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                    } else {
                        botonEliminar = `
                            <button type="button" class="btn btn-danger btn-sm" disabled title="Debe quedar al menos un integrante">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                    }

                    html += `
                        <tr>
                            <td class="align-middle">${registro.nombre}</td>
                            <td class="align-middle">${registro.registro}</td>
                            <td class="text-center align-middle">${botonEliminar}</td>
                        </tr>
                    `;
                });
            } else {
                html = `<tr><td colspan="3" class="text-center">Sin integrantes asignados</td></tr>`;
            }
            $('#listaIntegrantesCuerpo').html(html);
        });
    }

    function buscarIntegrantePorRegistro() {
        let registroVal = $('#buscarRegistroIntegrante').val().trim();
        if (registroVal === '') {
            toastr.warning('Por favor ingrese un número de registro.');
            return;
        }
        enviarPeticion('usuarios', 'select', {info: {registro: registroVal}}, function(r) {
            if (r.data && r.data.length > 0) {
                integranteEncontrado = r.data[0];
                $('#nombreNuevoIntegrante').val(integranteEncontrado.nombre);
                $('#botonAgregarIntegrante').prop('disabled', false);
                toastr.success('Integrante encontrado.');
            } else {
                integranteEncontrado = null;
                $('#nombreNuevoIntegrante').val('');
                $('#botonAgregarIntegrante').prop('disabled', true);
                toastr.error('Registro de integrante no encontrado.');
            }
        });
    }

    function agregarIntegranteAIdea() {
        if (!integranteEncontrado) return;
        let idIdea = idIdeaSeleccionadaIntegrantes;
        
        enviarPeticion('integrantes', 'getIntegrantes', {criterio: 'idea', valor: idIdea}, function(r) {
            let yaExiste = false;
            if (r.data && r.data.length > 0) {
                yaExiste = r.data.some(function(item) {
                    return item.registro == integranteEncontrado.registro;
                });
            }

            if (yaExiste) {
                toastr.error('El integrante ya se encuentra agregado a esta idea.');
                return;
            }

            enviarPeticion('integrantes', 'insert', {
                info: {
                    fk_ideas: idIdea,
                    integrante: integranteEncontrado.id
                }
            }, function(dbRes) {
                toastr.success('Integrante agregado correctamente.');
                $('#buscarRegistroIntegrante').val('');
                $('#nombreNuevoIntegrante').val('');
                $('#botonAgregarIntegrante').prop('disabled', true);
                integranteEncontrado = null;
                cargarListaIntegrantes();
            });
        });
    }

    function eliminarIntegranteDeIdea(idIntegranteRecord) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Se eliminará el integrante de la idea.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                enviarPeticion('integrantes', 'delete', {id: idIntegranteRecord}, function(r) {
                    toastr.success('Integrante eliminado.');
                    cargarListaIntegrantes();
                });
            }
        });
    }
</script>
</body>
</html>