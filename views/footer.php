	<footer class="main-footer bg-light">
        <div class="row">
            <div class="col-md-6">
                <strong>Copyright &copy; 2025 <a href="https://www.emcali.com.co/" target="_blank">EMCALI EICE ESP</a>.</strong> All rights reserved.
            </div>            
            <div class="col-md-6 text-right text-muted">
                 Desarrollado por <a href="https://www.emcali.com.co/" target="_blank"><img src="dist/img/loguito.png" alt="Emcali"></a>
            </div>
        </div>
	</footer>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Custom number -->
<script src="plugins/customd-jquery-number/jquery.number.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<!-- moment -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/moment/locale/es.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/funciones.js"></script>
<script type="text/javascript">
    var estados = ['','Reparto','Refinar','Preparar pitch','Calificar','Prototipo', 'Etapa proyecto','Banco de ideas']
    var colores = ['','secondary','secondary','secondary','secondary','secondary','success','danger']
	$(function(){
        enviarPeticion('helpers', 'getSession', {1:1}, function(r){
            if(r.data.length == 0){
                window.location.href = 'main/login/'
            }else{
                $('#menu_user').text(r.data.usuario.login)
                let menu
                let menuAdmin = `<li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-tools"></i>
                                        <p>
                                            Configuración
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="configuracion/usuarios/" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Usuarios</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="configuracion/criterios/" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Criterios</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="configuracion/retos/" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Retos</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="configuracion/tipos/" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Tipos</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>`
                let menuRetos = `<li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-bullseye"></i>
                                        <p>
                                            Retos
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="retos/listar/" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>`
                let menuIdeas = `<li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-lightbulb"></i>
                                        <p>
                                            Ideas
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="ideas/nueva/" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Nueva</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="ideas/misIdeas/" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Mis ideas</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>`
                let menuProcesoAbre = `<li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="fas fa-project-diagram"></i>
                                                <p>
                                                    Proceso
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">`
                let menuReparto =              `<li class="nav-item">
                                                    <a href="proceso/reparto/" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Reparto</p>
                                                    </a>
                                                </li>`
                let menuRefinar =               `<li class="nav-item">
                                                    <a href="proceso/refinar/" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Refinar</p>
                                                    </a>
                                                </li>`
                let menuPitch =                 `<li class="nav-item">
                                                    <a href="proceso/pitch/" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Preparar Pitch</p>
                                                    </a>
                                                </li>`
                let menuCalifica =              `<li class="nav-item">
                                                    <a href="proceso/calificar/" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Calificar</p>
                                                    </a>
                                                </li>`
                let menuAnteproyecto =          `<li class="nav-item">
                                                    <a href="proceso/anteproyecto/" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Anteproyectos</p>
                                                    </a>
                                                </li>`
                let menuPrototipo =             `<li class="nav-item">
                                                    <a href="proceso/prototipo/" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Prototipo</p>
                                                    </a>
                                                </li>`
                let menuProcesoCierra =    `</ul>
                                        </li>`
                let menuReportes = `<li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-chart-bar"></i>
                                            <p>
                                                Reportes
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="reportes/dashboard/" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Dashboard</p>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="reportes/reportesIdeas/" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Reporte Ideas</p>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="reportes/reportesRetos/" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Reportes de Retos</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>`
                let menuBuscar =``
                if(r.data.usuario.rol == 'Administrador'){
                    menu = menuAdmin + menuRetos + menuIdeas + menuProcesoAbre + menuReparto + menuRefinar + menuPitch + menuCalifica + menuProcesoCierra + menuReportes + menuBuscar
                }else if(r.data.usuario.rol == 'Gestor'){
                    menu = menuIdeas + menuProcesoAbre + menuRefinar + menuPitch + menuCalifica + menuProcesoCierra + menuBuscar
                }else if(r.data.usuario.rol == 'Evaluador'){
                    menu = menuRetos + menuIdeas + menuProcesoAbre + menuCalifica + menuProcesoCierra
                }else{
                    menu = menuRetos + menuIdeas
                }
                $('#menu').html(menu)
                $('#salir').on('click', function(){
                    enviarPeticion('helpers', 'destroySession', {1:1}, function(r){
                        window.location.href = 'main/login/'
                    })
                })
            }
            init(r)
            //$(':input[required]').css('box-shadow','1px 1px red')
        })
    })  

    // <li class="nav-item">
    //                                 <a href="ideass/buscar/" class="nav-link">
    //                                     <i class="fas fa-search"></i>
    //                                     <p>Buscar</p>
    //                                 </a>
    //                             </li>
</script>