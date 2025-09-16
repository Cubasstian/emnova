<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Registro de idea</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="card card-outline card-success" id="reto" style="display: none;">
                <div class="card-header">
                    <h3 class="card-title">Información del reto</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Titulo:</th>
                                <td id="retoTitulo"></td>
                            </tr>
                            <tr>
                                <th>Descripción:</th>
                                <td id="retoDescripcion"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <form id="formularioIdea">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Información de la idea</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="titulo">
                                        Título
                                        <br> 
                                        <small class="text-muted">Escribe una breve descripción que capture la esencia de la idea</small>
                                    </label>
                                    <input type="text" class="form-control" name="titulo" id="titulo" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="descripcion">
                                        Describe el problema u oportunidad que resuelve tu idea
                                        <br>
                                        <small class="text-muted">Explicación clara de la idea, incluyendo el problema que resuelve o la oportunidad que aprovecha</small>
                                    </label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="justificacion">
                                        Justifica tu idea
                                        <br>
                                        <small class="text-muted">Describe brevemente las razones por las cuales es importante la ejecución de la idea</small>
                                    </label>
                                    <textarea class="form-control" name="justificacion" id="justificacion" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="objetivo">
                                        ¿En qué consiste tu idea?
                                        <br>
                                        <small class="text-muted">Describe el objetivo  de la idea innovadora  que permite dar solución a la necesidad  u oportunidad planteada</small>
                                    </label>
                                    <textarea class="form-control" name="objetivo" id="objetivo" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="beneficios">
                                        ¿Qué Beneficios Potenciales, resultados o impactos se esperan de tu idea?
                                        <br>
                                        <small class="text-muted">Menciona los posibles resultados e impactos destacando los beneficios que se esperan obtener al ejecutar la idea o solucionar el problema planteado</small>
                                    </label>
                                    <textarea class="form-control" name="beneficios" id="beneficios" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="tiempo">
                                        ¿Cuál es el tiempo probable de maduración de la idea?
                                        <br>
                                        <small class="text-muted">Especifica el tiempo necesario y aproximado para llevar a cabo la maduración de su idea.</small>
                                    </label>
                                    <textarea class="form-control" name="tiempo" id="tiempo" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title">Integrantes</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" id="botonAbrirModalNuevoIntegrante">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">                                
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Registro</th>
                                            <th>Opción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listadoIntegrantes"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title">Adjuntos</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Anexo</label>
                                    <input type="file" class="form-control-file" id="documento" accept=".pdf" onChange="comprobarExtensionArchivoPDF(this)" required="required">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col text-right">
                    (*) Obligatorios
                </div>
            </div>
            <div class="row">
                <div class="col-4"></div>                
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block btn-lg mb-5" form="formularioIdea" id="botonGuardarSolicitud">Guardar</button>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalIntegrante">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo integrante</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioIntegrante">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="integrante">Registro</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="integrante">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="botonBuscarIntegrante">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <label>Nombre</label>
                                <input type="text" class="form-control" id="nombreIntegrante" readonly>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="botonIntegrante" form="formularioIntegrante" disabled="disabled">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('views/footer.php');?>

<script type="text/javascript">
    var idReto = <?=($parametros[0] == '') ? 1 : $parametros[0]; ?>;
    var integrante = {}
    var integrantes = []
    function init(info){
        //Mostrar reto en caso de que exista
        if(idReto != 1){
            enviarPeticion('retos', 'select', {info:{id: idReto}}, function(r){
                $('#retoTitulo').text(r.data[0].titulo)
                $('#retoDescripcion').text(r.data[0].descripcion)
                $('#reto').show()
            })
        }
        integrantes.push(info.data.usuario.id)
        //Agregar integrante
        $('#botonAbrirModalNuevoIntegrante').on('click', function(){
            $('#formularioIntegrante')[0].reset()
            $('#botonIntegrante').prop('disabled', true);
            $('#nombreIntegrante').val('')
            $('#modalIntegrante').modal('show')
        })

        //Buscar integrante
        $('#botonBuscarIntegrante').on('click', function(){
            enviarPeticion('usuarios', 'select', {info: {registro: $('#integrante').val()}}, function(r){
                if(r.data.length == 0){
                    toastr.error("El registro no existe en la base de datos")
                    integrante = {}
                    $('#botonIntegrante').prop('disabled', true);
                    $('#nombreIntegrante').val('')
                }else{
                    integrante = {
                        id: r.data[0].id,
                        nombre: r.data[0].nombre,
                        registro: r.data[0].registro
                    }
                    $('#botonIntegrante').prop('disabled', false);
                    $('#nombreIntegrante').val(r.data[0].nombre)
                }
            })
        })

        //Agregar integrante
        $('#formularioIntegrante').on('submit', function(e){
            e.preventDefault()
            if(!integrantes.includes(integrante.id)) {
                integrantes.push(integrante.id)
                let fila = `<tr id=${integrante.id}>
                                <td>${integrante.nombre}</td>
                                <td>${integrante.registro}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onClick="eliminarIntegrante(${integrante.id})" title="Eliminar">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>`
                $('#listadoIntegrantes').append(fila)
                $('#modalIntegrante').modal('hide')
            }else{
                toastr.error("Ya esta agregado")
            }
        })

        //Guardar idea
        $('#formularioIdea').on('submit', function(e){
            e.preventDefault()
            let datos = parsearFormulario($(this))
            datos.fk_retos = idReto
            //console.log(datos)
            enviarPeticion('ideas', 'crear', {info:datos, integrantes: integrantes}, function(r){
                //Cargar documento
                cargarDocumento(document.getElementById('documento'), r.insertId, 'adjuntos')
                //Enviar correo
                /*enviarPeticion('correo', 'sendMail', {idea: r.insertId}, function(r){
                    toastr.success(r.mensaje)
                })*/
                //Enviar confirmación
                Swal.fire({
                    icon: 'success',
                    title: 'Confimación',
                    text: `Se creo correctamente, código de la idea: I-${r.insertId.toString().padStart(3,'0')}`
                }).then((result) =>{
                    window.location.href = 'ideas/misIdeas/'
                })
            })
        })
    }

    function eliminarIntegrante(idIntegrante){
        integrantes.splice(integrantes.indexOf(idIntegrante), 1);
        $('#'+idIntegrante).hide()
    }
</script>
</body>
</html>