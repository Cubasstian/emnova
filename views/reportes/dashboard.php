<?php require('views/header.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>
                        Dashboard
                    </h1>
                </div>
                <div class="col-sm-4">
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
                </div>
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
                                <div id="ingresosDia" style="height: 400px"></div>
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
    var vigencia = 0
    function init(info){
    	//Seleccionar vigencia actual y carga inicial
        vigencia = moment().format('YYYYMM')
        $('#vigencia').val(vigencia)
        ingresosDia()

        $('#vigencia').on('change', function(){
            vigencia = $(this).val()
            ingresosDia()
        })
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