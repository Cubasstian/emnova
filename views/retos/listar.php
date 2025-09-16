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
                                    <button type="button" class="btn btn-default" onClick="downloadDocument(${registro.id},'retos')" title="Ver archivo">
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
</script>
</body>
</html>