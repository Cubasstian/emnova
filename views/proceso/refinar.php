<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Refinar
                        <span>
                            <small class="badge badge-ligth text-xs" id="conteo_total"></small>
                        </span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
                        <li class="breadcrumb-item active">Refinar</li>
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
</div>

<?php require('views/footer.php');?>

<script src="dist/js/ideas.js"></script>
<script type="text/javascript">
    function init(info){
    	//Cargar registros
        cargarRegistros({criterio: 'gestor', estado: 2}, 'crear', function(){
            console.log('Cargo...')
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
                                            <button type="button" class="btn btn-default btn-sm" onClick="mostrarIntegrantesElminar(${registro.id})" title="ver integrantes">
                                                <i class="fas fa-users"></i>
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

    function aprobar(idIdea){
        Swal.fire({
            icon: 'question',
            title: 'Confirmación',
            html: `Esta seguro de tener lista para presentar la idea con código # I-${idIdea.toString().padStart(3,'0')}`,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value){                
                enviarPeticion('ideas', 'updateIdeas', {info: {estado: 3}, id: idIdea}, function(r){
                    $(`#${idIdea}`).hide('slow')
                })
            }
        })
    }


    function eliminarIntegranteModalR(idIntegrante, idea) {
    console.log('idIntegrante', idIntegrante);
    console.log('idea', idea);

    Swal.fire({
        icon: 'warning',
        title: 'Eliminar integrante',
        text: '¿Está seguro que desea eliminar este integrante?',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if(result.value){
            // Llama al controlador para eliminar
            enviarPeticion('integrantes', 'eliminarIntegrante', { fk_ideas: idea, integrante: idIntegrante }, function(r){
                if(r.ejecuto){
                    toastr.success('Integrante eliminado correctamente');
                    Swal.close();
                } else {
                    toastr.error('No se pudo eliminar el integrante');
                }
            });
        }
    });
}
</script>
</body>
</html>