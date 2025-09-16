<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Usuarios
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            <form id="formulario">
                                <div class="form-group">
                                    <label>Registro</label>
                                    <input type="text" name="valor" class="form-control" required="required">
                                </div>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8" id="contenido"></div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalUsuarios">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalUsuariosTitulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioUsuarios">
                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select class="form-control" name="rol" id="rol" required="required">
                                <option value="Administrador">Administrador</option>
                                <option value="Gestor">Gestor</option>
                                <option value="Evaluador">Evaluador</option>
                                <option value="Proponente">Proponente</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" form="formularioUsuarios">Actualizar</button>
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
        //Buscar usuario
        $('#formulario').on('submit', function(e){
            e.preventDefault()
            $('#contenido').empty()
            let datos = parsearFormulario($(this))
            cargarRegistros({info: {registro: datos.valor}}, function(){
                console.log('Se cargo...')
            })
        })

        $('#formularioUsuarios').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))            
            enviarPeticion('usuarios', 'update', {info: datos, id: id}, function(r){
                toastr.success('Se actualizó correctamente')
                cargarRegistros({info: {id: id}}, function(){
                    $('#modalUsuarios').modal('hide')
                })
            })
        })
    }

    function cargarRegistros(datos, callback){
        enviarPeticion('usuarios', 'select', datos, function(r){
            let contenido = ''
            r.data.map(registro => {
                contenido = `<div class="card card-outline card-success">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Nombre</th>
                                                <td>${registro.nombre}</td>
                                            </tr>
                                            <tr>
                                                <th>Rol</th>
                                                <td>${registro.rol}</td>
                                            </tr>
                                            <tr>
                                                <th>login</th>
                                                <td>${registro.login}</td>
                                            </tr>
                                            <tr>
                                                <th>Registro</th>
                                                <td>${registro.registro}</td>
                                            </tr>
                                            <tr>
                                                <th>Cédula</th>
                                                <td>${registro.cedula}</td>
                                            </tr>
                                            <tr>
                                                <th>Correo</th>
                                                <td>${registro.correo}</td>
                                            </tr>
                                            <tr>
                                                <th>Telefono</th>
                                                <td>${registro.telefono}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-4">
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-success btn-block" onClick="mostrarModalEditarUsuarios(${registro.id})" title="Editar">
                                                Editar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            })            
            $('#contenido').html(contenido)
            callback()
        })
    }

    function mostrarModalEditarUsuarios(idUsuario){
        id = idUsuario
        llenarFormulario('formularioUsuarios', 'usuarios', 'select', {info:{id: idUsuario}}, function(r){
            $('#modalUsuariosTitulo').text('Editar usuario')
            $('#modalUsuarios').modal('show')
        })
    }
</script>
</body>
</html>