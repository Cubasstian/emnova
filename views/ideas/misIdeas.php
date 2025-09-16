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
            </div>
        </div>
    </section>
</div>

<?php require('views/footer.php');?>

<script src="dist/js/ideas.js"></script>
<script type="text/javascript">
	function init(info){
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
                            <td>I-${registro.id.toString().padStart(3,'0')}</td>
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
                                            <button type="button" class="btn btn-default btn-sm" onClick="downloadDocument(${registro.id},'adjuntos')" title="Ver archivo">
                                                <i class="fas fa-file-import"></i>
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
</script>
</body>
</html>