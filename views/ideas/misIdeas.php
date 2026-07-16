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
</script>
</body>
</html>