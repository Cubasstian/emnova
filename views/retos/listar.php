<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Retos activos
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
            <div class="row" id="contenido"></div>
        </div>
    </section>

    <!-- Modal para visualizar archivos del reto -->
    <div class="modal fade" id="modalArchivosReto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-folder-open mr-2 text-warning"></i> Documentos del Reto</h4>
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
                                    <th>Archivo / Ruta</th>
                                    <th class="text-center" style="width: 150px;">Acción</th>
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
    function init(info){
        //Cargar registro
        cargarRegistros({criterio: 'activos'}, function(){
            console.log('Cargo...')
        })
    }

    function cargarRegistros(datos, callback){
        enviarPeticion('retos', 'getRetos', datos, function(r){
            console.log(r)
            let fila = ''
            r.data.map(registro => {
                fila += `<div class="col-md-4">
                            <div class="card">
                                <img src="dist/img/reto.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="mb-3">${registro.id}. ${registro.titulo}</h5>
                                    <p class="card-text text-sm">
                                        ${registro.descripcion}
                                    </p>
                                    <p class="text-muted text-sm">
                                        <i class="fas fa-calendar-day"></i> Fecha inicio: ${registro.fecha_inicio}
                                    </p>
                                    <p class="text-muted text-sm">
                                        <i class="fas fa-calendar-day"></i> Fecha fin: ${registro.fecha_fin}
                                    </p>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="button" class="btn btn-default" onClick="verDetalleReto(${registro.id})" title="Ver archivo">
                                        <i class="fas fa-file-download"></i> Detalle
                                    </button>
                                    <a class="btn btn-success" href="ideas/nueva/${registro.id}">Participar</a>
                                </div>
                            </div>
                        </div>`
            })            
            $('#contenido').append(fila)
            callback()
        })
    }

    function verDetalleReto(idReto) {
        enviarPeticion('retosArchivos', 'select', {info: {fk_idreto: idReto}}, function(r) {
            let html = '';
            if (r.data && r.data.length > 0) {
                r.data.forEach(function(archivo, i) {
                    let match = archivo.ruta.match(/_(\d+)\.pdf$/);
                    let index = match ? match[1] : (i + 1);
                    html += `
                        <tr>
                            <td class="align-middle"><strong>Anexo ${index}</strong></td>
                            <td class="align-middle text-muted">${archivo.ruta}</td>
                            <td class="text-center align-middle">
                                <button type="button" class="btn btn-sm btn-info" onclick="downloadDocument(${idReto}, 'retos', ${index})">
                                    <i class="fas fa-file-download"></i> Descargar
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html += `
                    <tr>
                        <td class="align-middle"><strong>Documento General</strong></td>
                        <td class="align-middle text-muted">Archivo adjunto del reto</td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-sm btn-info" onclick="descargarAnexosFallback(${idReto})">
                                <i class="fas fa-file-download"></i> Descargar
                            </button>
                        </td>
                    </tr>
                `;
            }
            $('#listaArchivosCuerpo').html(html);
            $('#modalArchivosReto').modal('show');
        });
    }

    function descargarAnexosFallback(idReto) {
        enviarPeticionPura('archivos', 'existDocumento', {id: idReto, ruta: 'retos', indice: 1}, function(res) {
            if (res.ejecuto && res.mensaje === true) {
                downloadDocument(idReto, 'retos', 1);
            } else {
                enviarPeticionPura('archivos', 'existDocumento', {id: idReto, ruta: 'retos'}, function(resSinIndice) {
                    if (resSinIndice.ejecuto && resSinIndice.mensaje === true) {
                        downloadDocument(idReto, 'retos');
                    } else {
                        toastr.error('No se encontraron documentos asociados a este reto.');
                    }
                });
            }
        });
    }
</script>
</body>
</html>