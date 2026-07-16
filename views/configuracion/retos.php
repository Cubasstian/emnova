<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Retos
                        <button id="botonMostrarModalRetos" type="button" class="btn btn-success">
                            Crear
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Retos</li>
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
                                <table id="tabla" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ID</th>
                                            <th>Titulo</th>
                                            <th>Descripción</th>
                                            <th>Inicio</th>
                                            <th>Fin</th>
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
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalRetos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalRetosTitulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioRetos">
                        <input type="hidden" name="creado_por" id="creado_por">

                        <!-- Panel de información del creador al crear -->
                        <div class="card card-info card-outline" id="panelCreador" style="display: none;">
                            <div class="card-header py-1">
                                <h3 class="card-title font-weight-bold" style="font-size: 0.9rem;">
                                    <i class="fas fa-user mr-1 text-info"></i> Información de quien crea el reto
                                </h3>
                            </div>
                            <div class="card-body p-2" style="font-size: 0.85rem;">
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Nombre:</strong> <span id="creador_nombre">-</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Rol:</strong> <span id="creador_rol">-</span>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-6">
                                        <strong>Registro:</strong> <span id="creador_registro">-</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Correo:</strong> <span id="creador_correo">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel de información del creador al editar (permite cambiar por registro) -->
                        <div class="card card-warning card-outline" id="panelCreadorEdit" style="display: none;">
                            <div class="card-header py-1">
                                <h3 class="card-title font-weight-bold" style="font-size: 0.9rem;">
                                    <i class="fas fa-user-edit mr-1 text-warning"></i> Creador del Reto
                                </h3>
                            </div>
                            <div class="card-body p-2" style="font-size: 0.85rem;">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control form-control-sm" id="inputBuscarRegistro" placeholder="Buscar creador por registro...">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning btn-sm" type="button" onclick="buscarCreadorPorRegistro()">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Nombre:</strong> <span id="creador_nombre_edit">-</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Rol:</strong> <span id="creador_rol_edit">-</span>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-6">
                                        <strong>Registro:</strong> <span id="creador_registro_edit">-</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Correo:</strong> <span id="creador_correo_edit">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code_gerencia">Dependencia (*)</label>
                            <select class="form-control" name="code_gerencia" id="code_gerencia" required="required">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="titulo">Titulo</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" required="required">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" required="required"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha inicio (*)</label>
                                    <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required="required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha fin (*)</label>
                                    <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="panelArchivo">
                            <div id="contenedorAnexos">
                                <!-- Se cargarán los inputs dinámicamente -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select class="form-control" name="estado" id="estado" required="required">
                                <option value="Activo">Activo</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-submit" id="botonGuardarRetos" form="formularioRetos">Guardar</button>
                    <button type="submit" class="btn btn-secondary btn-submit" id="botonActualizarRetos" form="formularioRetos">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalGestionArchivos">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-folder-open mr-2 text-warning"></i> Archivos del Reto</h4>
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

<script type="text/javascript">
    var id
    var boton
    var cantidadRetos = 1

    function generarCamposAnexos() {
        let html = '';
        for (let i = 1; i <= cantidadRetos; i++) {
            html += `<div class="mb-2">
                        <label>Anexo ${i} ${i === 1 ? '(*)' : ''}</label>
                        <input type="file" class="form-control-file documento-input" id="documento_${i}" data-index="${i}" accept=".pdf" onChange="comprobarExtensionArchivoPDF(this)">
                     </div>`;
        }
        $('#contenedorAnexos').html(html);
    }

     // --- Consejo extra: Validación en los inputs ---
    $('#fecha_inicio').on('change', function(){
        $('#fecha_fin').attr('min', $(this).val());
    });

    $('#fecha_fin').on('change', function(){
        $('#fecha_inicio').attr('max', $(this).val());
    });

    function init(info){
        // Traer la configuración de documentos para retos
        enviarPeticion('documentos', 'select', {info: {formulario: 'retos'}}, function(r){
            if (r.data && r.data.length > 0) {
                cantidadRetos = parseInt(r.data[0].cantidad);
            }
            generarCamposAnexos();
        });

        llenarSelect('dependencia', 'getDuplicados', {1:1}, 'code_gerencia', 'dependencia', 1, 'Seleccione...', 'code_gerencia');

        // Cargar datos del usuario creador para mostrar al crear reto
        enviarPeticion('usuarios', 'select', {info: {id: info.data.usuario.id}}, function(rUsuario){
            if (rUsuario.data && rUsuario.data.length > 0) {
                let creador = rUsuario.data[0];
                $('#creador_nombre').text(creador.nombre);
                $('#creador_rol').text(creador.rol);
                $('#creador_registro').text(creador.registro);
                $('#creador_correo').text(creador.correo);
            }
        });

        //Cargar registro
        cargarRegistros({info:{1:1}, nodefault:1}, 'crear', function(){
            $("#tabla").DataTable({
                "lengthMenu": [ 50, 100, 200 ],
                "pageLength": 50,
                "language":{
                    "decimal":        "",
                    "emptyTable":     "Sin datos para mostrar",
                    "info":           "Mostrando _START_ al _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando 0 to 0 of 0 entries",
                    "infoFiltered":   "(Filtrado de _MAX_ total registros)",
                    "infoPostFix":    "",
                    "thousands":      ".",
                    "lengthMenu":     "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "Ningún registro encontrado",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Sig",
                        "previous":   "Ant"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
            })
        })  

        $('#botonMostrarModalRetos').on('click', function(){
            $('#formularioRetos')[0].reset()
            $('#modalRetosTitulo').text('Nueva reto')
            $('#panelArchivo').show()
            $('#panelCreador').show()
            $('#panelCreadorEdit').hide()
            $('#creado_por').val(info.data.usuario.id)
            
            generarCamposAnexos();
            $('.documento-input').first().prop('required', true)
            
            $('#botonGuardarRetos').show()
            $('#botonActualizarRetos').hide()
            $('#modalRetos').modal('show')

             // --- Bloque para fecha actual y mínimo ---
            var hoy = new Date();
            var yyyy = hoy.getFullYear();
            var mm = String(hoy.getMonth() + 1).padStart(2, '0'); // Meses desde 0
            var dd = String(hoy.getDate()).padStart(2, '0');
            var fechaActual = yyyy + '-' + mm + '-' + dd;

            $('#fecha_inicio').val(fechaActual);
            $('#fecha_inicio').attr('min', fechaActual);

            $('#fecha_fin').val(fechaActual);
            $('#fecha_fin').attr('min', fechaActual);
        })

        $('.btn-submit').on('click', function(){
            boton = $(this).attr('id')
        })

        $('#formularioRetos').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))

             // Tomar los valores de las fechas
            const fechaInicio = $('#fecha_inicio').val();
            const fechaFin = $('#fecha_fin').val();

            // Validación: fecha inicio no puede ser mayor a fecha fin
            if(fechaInicio > fechaFin){
                toastr.error('La fecha de inicio no puede ser mayor a la fecha fin.');
                return; // No enviar el formulario
            }

            if(boton == 'botonGuardarRetos'){
                let inputs = $('.documento-input').filter(function() {
                    return this.files && this.files.length > 0;
                }).toArray();

                enviarPeticion('retos', 'insert', {info: datos}, async function(r){
                    let idReto = r.insertId;

                    // Función auxiliar para subir un archivo usando Promise
                    const subirArchivo = (input, id, index) => {
                        return new Promise((resolve) => {
                            cargarDocumento(input, id, 'retos', function(uploadRes) {
                                if (uploadRes.ejecuto) {
                                    let filePath = 'retos/' + id + '/' + id + '_' + index + '.pdf';
                                    enviarPeticion('retosArchivos', 'insert', {
                                        info: {
                                            fk_idreto: id,
                                            ruta: filePath,
                                            estado: 1
                                        }
                                    }, function(dbRes) {
                                        resolve(true);
                                    });
                                } else {
                                    resolve(false);
                                }
                            }, index);
                        });
                    };

                    // For loop secuencial con async/await
                    for (let i = 0; i < inputs.length; i++) {
                        let input = inputs[i];
                        let index = input.getAttribute('data-index');
                        await subirArchivo(input, idReto, index);
                    }

                    toastr.success('Se creó correctamente');
                    cargarRegistros({info: {id: idReto}}, 'crear', function(){
                        $('#modalRetos').modal('hide');
                    });
                });
            }else{                
                enviarPeticion('retos', 'update', {info: datos, id: id}, function(r){
                    toastr.success('Se actualizó correctamente')
                    cargarRegistros({info: {id: id}}, 'actualizar', function(){
                        $('#modalRetos').modal('hide')
                    })
                })
            }
        })
    }

    function cargarRegistros(datos, accion, callback){
        enviarPeticion('retos', 'select', datos, function(r){
            let fila = ''
            let colores = {
                'Activo': 'success',
                'Cancelado': 'danger'
            }
            r.data.map(registro => {
                fila += `<tr id=${registro.id}>
                            <td>${"R-" + (registro.fecha_inicio || '').slice(0, 7) + "-" + registro.id.toString().padStart(3,'0')}</td>
                            <td>${registro.titulo}</td>
                            <td>${registro.descripcion}</td>
                            <td>${registro.fecha_inicio}</td>
                            <td>${registro.fecha_fin}</td>
                            <td class="text-center">
                                <span class="badge badge-${colores[registro.estado]}">
                                    ${registro.estado}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default btn-sm" onClick="mostrarModalEditarRetos(${registro.id})" title="Editar Reto">
                                        <i class="fas fa-edit text-primary"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" onClick="abrirModalArchivos(${registro.id})" title="Ver/Editar Archivos">
                                        <i class="fas fa-file-pdf text-danger"></i> Archivos
                                    </button>
                                </div>
                            </td>
                        </tr>`
            })            
            if(accion == 'crear'){
                $('#contenido').append(fila)    
            }else{
                $('#'+r.data[0].id).replaceWith(fila)
            }
            callback()
        })
    }

    function mostrarModalEditarRetos(idRetos){
        id = idRetos
        llenarFormulario('formularioRetos', 'retos', 'select', {info:{id: idRetos}}, function(r){
            $('#modalRetosTitulo').text('Editar reto')
            $('#panelArchivo').hide()
            $('#panelCreador').hide()
            
            $('#inputBuscarRegistro').val('')
            let idCreador = $('#creado_por').val()
            if (idCreador) {
                enviarPeticion('usuarios', 'select', {info: {id: idCreador}}, function(rUsuario){
                    if (rUsuario.data && rUsuario.data.length > 0) {
                        let creador = rUsuario.data[0];
                        $('#creador_nombre_edit').text(creador.nombre);
                        $('#creador_rol_edit').text(creador.rol);
                        $('#creador_registro_edit').text(creador.registro);
                        $('#creador_correo_edit').text(creador.correo);
                    }
                });
            } else {
                $('#creador_nombre_edit').text('-');
                $('#creador_rol_edit').text('-');
                $('#creador_registro_edit').text('-');
                $('#creador_correo_edit').text('-');
            }
            $('#panelCreadorEdit').show()

            $('.documento-input').prop('required', false)
            $('#botonGuardarRetos').hide()
            $('#botonActualizarRetos').show()
            $('#modalRetos').modal('show')
        })
    }

    var idRetoSeleccionado = null;

    function abrirModalArchivos(idReto) {
        idRetoSeleccionado = idReto;
        $('#modalGestionArchivos').modal('show');
        cargarListaArchivos();
    }

    function cargarListaArchivos() {
        let idReto = idRetoSeleccionado;
        enviarPeticion('retosArchivos', 'select', {info: {fk_idreto: idReto}}, function(r) {
            let html = '';
            let archivosExistentes = {};
            if (r.data && r.data.length > 0) {
                r.data.forEach(function(archivo) {
                    let match = archivo.ruta.match(/_(\d+)\.pdf$/);
                    let index = match ? parseInt(match[1]) : 1;
                    archivosExistentes[index] = archivo;
                });
            }

            for (let i = 1; i <= cantidadRetos; i++) {
                let archivo = archivosExistentes[i];
                let estadoBadge = '';
                let accionesHtml = '';

                if (archivo) {
                    estadoBadge = `<span class="badge badge-success"><i class="fas fa-check-circle"></i> Cargado</span><br><small class="text-muted">${archivo.ruta}</small>`;
                    accionesHtml = `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info" onclick="downloadDocument(${idReto}, 'retos', ${i})" title="Visualizar">
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
        let idReto = idRetoSeleccionado;
        comprobarExtensionArchivoPDF(input);
        if (input.files.length === 0) return;

        cargarDocumento(input, idReto, 'retos', function(uploadRes) {
            if (uploadRes.ejecuto) {
                let filePath = 'retos/' + idReto + '/' + idReto + '_' + index + '.pdf';
                enviarPeticion('retosArchivos', 'insert', {
                    info: {
                        fk_idreto: idReto,
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
        let idReto = idRetoSeleccionado;
        comprobarExtensionArchivoPDF(input);
        if (input.files.length === 0) return;

        cargarDocumento(input, idReto, 'retos', function(uploadRes) {
            if (uploadRes.ejecuto) {
                let filePath = 'retos/' + idReto + '/' + idReto + '_' + index + '.pdf';
                enviarPeticion('retosArchivos', 'update', {
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

    function buscarCreadorPorRegistro() {
        let registroVal = $('#inputBuscarRegistro').val().trim();
        if (registroVal === '') {
            toastr.warning('Por favor ingrese un número de registro.');
            return;
        }
        enviarPeticion('usuarios', 'select', {info: {registro: registroVal}}, function(r) {
            if (r.data && r.data.length > 0) {
                let creador = r.data[0];
                $('#creado_por').val(creador.id);
                $('#creador_nombre_edit').text(creador.nombre);
                $('#creador_rol_edit').text(creador.rol);
                $('#creador_registro_edit').text(creador.registro);
                $('#creador_correo_edit').text(creador.correo);
                toastr.success('Creador asignado correctamente');
            } else {
                toastr.error('Usuario no encontrado con ese registro.');
            }
        });
    }
</script>
</body>
</html>