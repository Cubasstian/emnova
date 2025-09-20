<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>
                        REPORTES IDEAS
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
                                            <th>Título Idea</th>
                                            <th>Descripción Idea</th>
                                            <th>Justificación</th>
                                            <th>Objetivo</th>
                                            <th>Beneficios</th>
                                            <th>Tiempo</th>
                                            <th>ID Gestor</th>
                                            <th>Nombre Gestor</th>
                                            <th>Registro Gestor</th>
                                            <th>Fecha Pitch</th>
                                            <th>Lugar Pitch</th>
                                            <th>Estado</th>
                                            <th>ID Creador</th>
                                            <th>Nombre Creador</th>
                                            <th>Registro Creador</th>
                                            <th>Fecha Creación</th>
                                            <th>ID Reto</th>
                                            <th>Título Reto</th>
                                            <th>Descripción Reto</th>
                                            <th>Fecha Inicio Reto</th>
                                            <th>Fecha Fin Reto</th>
                                            <th>Tipo</th>
                                            <th>Descripción Tipo</th>
                                            <th>Observaciones</th>
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
                title: 'Ideas'
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
            { data: 'justificacion' },
            { data: 'objetivo' },
            { data: 'beneficios' },
            { data: 'tiempo' },
            { data: 'idgestor' },
            { data: 'nombregestor' },
            { data: 'registrogestor' },
            { data: 'fecha_pitch' },
            { data: 'lugar_pitch' },
            { data: 'estado' },
            { data: 'creadoid' },
            { data: 'creadnombre' },
            { data: 'creadoregistro' },
            { data: 'fecha_creacion' },
            { data: 'fk_retos' },
            { data: 'restostitulos' },
            { data: 'retosdescp' },
            { data: 'retofecha_inicio' },
            { data: 'retosfecha_fin' },
            { data: 'tiponombre' },
            { data: 'tipodescripcion' },
            { data: 'observaciones' }
        ]
    });

    cargarIdeas(tablaIdeas);
}

function cargarIdeas(tabla) {
    enviarPeticion('ideas', 'getInforme', {}, function(r) {
        if (r.ejecuto && r.data) {
            tabla.clear().rows.add(r.data).draw();
        } else {
            toastr.error('Error al cargar las ideas');
        }
    });
}
   

    function ingresosDia(){
        let datos = [
            {
                name: 'Ingresos',
                data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
            },
            {
                name: 'Ingresos diferentes',
                data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
            }
        ]
        enviarPeticion('logIngresos', 'ingresosDia', {vigencia: vigencia}, function(r1){
            let cantidad1 = 0
            for(let i = 0; i < r1.data.length; i++){
                datos[0].data[r1.data[i].dia - 1] = r1.data[i].cantidad
                cantidad1 += r1.data[i].cantidad
            }
            datos[0].name = `Ingresos ${cantidad1}`

            enviarPeticion('logIngresos', 'ingresosDiferentesDia', {vigencia: vigencia}, function(r2){
                let cantidad2 = 0
                for(let i = 0; i < r2.data.length; i++){
                    datos[1].data[r2.data[i].dia - 1] = r2.data[i].cantidad
                    cantidad2 += r2.data[i].cantidad
                }
                datos[1].name = `Ingresos diferentes ${cantidad2}`
                Highcharts.chart('ingresosDia', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Ingresos por día'
                    },
                    subtitle: {
                        text: 'Detalle de ingresos al sistema por día'
                    },
                    xAxis: {
                        categories: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]
                    },
                    yAxis: {
                        title: {
                            text: 'Cantidad'
                        }               
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        },
                        series: {
                            label: {
                                connectorAllowed: false
                            }
                        }
                    },
                    series: datos
                })
            })
        })
    }
</script>
</body>
</html>