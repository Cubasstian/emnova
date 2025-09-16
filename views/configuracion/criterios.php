<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Criterios
                        <button id="botonMostrarModalCriterios" type="button" class="btn btn-success">
                            Crear
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Criterios</li>
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
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Escala</th>
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
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required="required">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" required="required"></textarea>
                        </div>
                        <div class="form-group">    
                            <label for="escala">Escala</label>
                            <textarea class="form-control" name="escala" id="escala" required="required"></textarea>
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
                    <button type="submit" class="btn btn-success btn-submit" id="botonGuardarCriterios" form="formularioCriterios">Guardar</button>
                    <button type="submit" class="btn btn-secondary btn-submit" id="botonActualizarCriterios" form="formularioCriterios">Actualizar</button>
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

        $('#botonMostrarModalCriterios').on('click', function(){
            $('#formularioCriterios')[0].reset()
            $('#modalCriteriosTitulo').text('Nueva Criterio')
            $('#botonGuardarCriterios').show()
            $('#botonActualizarCriterios').hide()
            $('#modalCriterios').modal('show')
        })

        $('.btn-submit').on('click', function(){
            boton = $(this).attr('id')
        })

        $('#formularioCriterios').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))
            if(boton == 'botonGuardarCriterios'){
                enviarPeticion('criterios', 'insert', {info: datos}, function(r){
                    toastr.success('Se creo correctamente')
                    cargarRegistros({info: {id: r.insertId}}, 'crear', function(){
                        $('#modalCriterios').modal('hide')
                    })
                })
            }else{                
                enviarPeticion('criterios', 'update', {info: datos, id: id}, function(r){
                    toastr.success('Se actualizó correctamente')
                    cargarRegistros({info: {id: id}}, 'actualizar', function(){
                        $('#modalCriterios').modal('hide')
                    })
                })
            }
        })
    }

    function cargarRegistros(datos, accion, callback){
        enviarPeticion('criterios', 'select', datos, function(r){
            let fila = ''
            let colores = {
                'Activo': 'success',
                'Cancelado': 'danger'
            }
            r.data.map(registro => {
                fila += `<tr id=${registro.id}>
                            <td>${registro.nombre}</td>
                            <td>${registro.descripcion}</td>
                            <td>${registro.escala}</td>
                            <td class="text-center">
                                <span class="badge badge-${colores[registro.estado]}">
                                    ${registro.estado}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-default" onClick="mostrarModalEditarCriterios(${registro.id})" title="Editar">
                                    <i class="fas fa-edit"></i>
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

    function mostrarModalEditarCriterios(idCriterios){
        id = idCriterios
        llenarFormulario('formularioCriterios', 'criterios', 'select', {info:{id: idCriterios}}, function(r){
            $('#modalCriteriosTitulo').text('Editar criterio')
            $('#botonGuardarCriterios').hide()
            $('#botonActualizarCriterios').show()
            $('#modalCriterios').modal('show')
        })
    }
</script>
</body>
</html>