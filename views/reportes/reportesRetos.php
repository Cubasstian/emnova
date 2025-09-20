<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>
                        REPORTES RETOS
                    </h1>
                </div>
                <!-- <div class="col-sm-4">
                    <div class="form-group row">
                        <label for="vigencia" class="col-sm-4 col-form-label">Mes</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="vigencia">
                                <option value=202408>2024-08</option>
                                <option value=202409>2024-09</option>
                                <option value=202410>2024-10</option>
                                <option value=202411>2024-11</option>
                                <option value=202412>2024-12</option>
                            </select>
                        </div>
                    </div>
                </div> -->
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="solicitudes/missolicitudes/">Inicio</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

     <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart">
                                <table id="tablaIdeas" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                                <th>Título</th>
                                                <th>Descripción</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin</th>
                                                <th>Estado</th>
                                                <th>Creado Por (ID)</th>
                                                <th>Fecha Creación</th>
                                                <th>Usuario ID</th>
                                                <th>Nombre Usuario</th>
                                                <th>Registro</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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

<!--Higtcharts-->
<script src="node_modules/highcharts/highcharts.js"></script>
<script src="node_modules/highcharts/highcharts-3d.js"></script>
<script src="node_modules/highcharts/modules/exporting.js"></script>
<script src="node_modules/highcharts/highcharts-more.js"></script>
<script src="node_modules/highcharts/modules/solid-gauge.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<script type="text/javascript">
  var vigencia = 0;

function init(info) {
    var tablaIdeas = $('#tablaIdeas').DataTable({
        scrollX: true,
        scrollY: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar a Excel',
                className: 'btn btn-info',
                title: 'Retos'
            }
        ],
        language: {
            decimal: "",
            emptyTable: "Sin datos para mostrar",
            info: "Mostrando _START_ al _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 to 0 of 0 entries",
            infoFiltered: "(Filtrado de _MAX_ total registros)",
            thousands: ".",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "Ningún registro encontrado",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            aria: {
                sortAscending: ": activar para ordenar la columna ascendente",
                sortDescending: ": activar para ordenar la columna descendente"
            }
        },
        columns: [
             { data: 'id' },
            { data: 'titulo' },
            { data: 'descripcion' },
            { data: 'fecha_inicio' },
            { data: 'fecha_fin' },
            { data: 'estado' },
            { data: 'creado_por' },
            { data: 'fecha_creacion' },
            { data: 'usid' },
            { data: 'nombre' },
            { data: 'registro' }    
        ]
    });

    cargarRetos(tablaIdeas);
}

function cargarRetos(tabla) {
    enviarPeticion('retos', 'getRetosTotal', {}, function(r) {
        if (r.ejecuto && r.data) {
            tabla.clear().rows.add(r.data).draw();
        } else {
            toastr.error('Error al cargar las ideas');
        }
    });
}
   

   
</script>
</body>
</html>