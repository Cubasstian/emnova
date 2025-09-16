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
                            <label>Anexo</label>
                            <input type="file" class="form-control-file" id="documento" accept=".pdf" onChange="comprobarExtensionArchivoPDF(this)" required="required">
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
</div>

<?php require('views/footer.php');?>

<script type="text/javascript">
    var id
    var boton
    function init(info){
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
            $('#documento').prop('required', true)
            $('#botonGuardarRetos').show()
            $('#botonActualizarRetos').hide()
            $('#modalRetos').modal('show')
        })

        $('.btn-submit').on('click', function(){
            boton = $(this).attr('id')
        })

        $('#formularioRetos').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))
            if(boton == 'botonGuardarRetos'){
                enviarPeticion('retos', 'insert', {info: datos}, function(r){
                    toastr.success('Se creo correctamente')
                    //Cargar documento
                    cargarDocumento(document.getElementById('documento'), r.insertId, 'retos')
                    cargarRegistros({info: {id: r.insertId}}, 'crear', function(){
                        $('#modalRetos').modal('hide')
                    })
                })
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
                            <td>${registro.id}</td>
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
                                <button type="button" class="btn btn-default" onClick="mostrarModalEditarRetos(${registro.id})" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a class="btn btn-default btn-file" title="Cargar archivo">
                                    <i class='fas fa-upload'></i>
                                    <input type='file' onchange="cargarDocumento(this,${registro.id},'retos')" accept=".pdf">
                                </a>
                                <button type="button" class="btn btn-default" onClick="downloadDocument(${registro.id},'retos')" title="Ver archivo">
                                    <i class="fas fa-file-download"></i>
                                </button>
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
            $('#documento').prop('required', false)
            $('#botonGuardarRetos').hide()
            $('#botonActualizarRetos').show()
            $('#modalRetos').modal('show')
        })
    }
</script>
</body>
</html>