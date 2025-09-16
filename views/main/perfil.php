<?php require('views/header.php');?>

<div class="content-wrapper">
	<section class="content-header">
		<div class="container">
			<div class="row mb-2">
				<div class="col-sm-6">
            		<h1>Perfil</h1>
          		</div>
          		<div class="col-sm-6">
            		<ol class="breadcrumb float-sm-right">
              			<li class="breadcrumb-item"><a href="ideas/misIdeas/">Inicio</a></li>
              			<li class="breadcrumb-item active">Perfil</li>
            		</ol>
          		</div>
        	</div>
    	</div>
    </section>

    <section class="content">
    	<div class="container">
    		<div class="row">
    			<div class="col">
    				<div class="card card-outline card-primary">
    					<div class="card-body">
							<div class="table-responsive">
            					<table class="table">
            						<tr>
                						<th style="width:30%">Nombre:</th>
                						<td id="nombre"></td>
              						</tr>
            						<tr>
                						<th>Rol:</th>
                						<td id="rol"></td>
              						</tr>
              						<tr>
                						<th>Login:</th>
                						<td id="login"></td>
              						</tr>
              						<tr>
                						<th>Registro:</th>
                						<td id="registro"></td>
              						</tr>
              						<tr>
                						<th>Cédula:</th>
                						<td id="cedula"></td>
              						</tr>
              						<tr>
                						<th>Correo:</th>
                						<td id="correo"></td>
              						</tr>
            					</table>
			                </div>
							<form id="formularioDatos">
								<div class="row">
									<div class="col">
			            				<div class="form-group">
			        						<label for="celular">Celular(*)</label>
			            					<input type="number" class="form-control" name="celular" id="celular" required="required">
			        					</div>
			        				</div>
			        				<div class="col">
			            				<div class="form-group">
			        						<label for="fijo">Teléfono fijo</label>
			            					<input type="number" class="form-control" name="fijo" id="fijo" required="required">
			        					</div>
			        				</div>
			        			</div>
              					<div class="row">
                        			<div class="col text-right">
                        				(*) Obligatorios
                        			</div>
                        		</div>
                				<div class="form-group text-center">
                    				<button type="submit" class="btn btn-default">
                    					Actualizar
                    				</button>
                				</div>
        					</form>
    					</div>
    				</div>
    			</div>
    		</div>
		</div>
	</section>
</div>

<?php require('views/footer.php');?>

<script type="text/javascript">
	var id
	function init(info){
		id = info.data.usuario.id

		//Cargar información base
		enviarPeticion('usuarios', 'select', {info: {id: id}}, function(r){
			$('#nombre').text(r.data[0].nombre)			
			$('#rol').text(r.data[0].rol)
			$('#login').text(r.data[0].login)
			$('#registro').text(r.data[0].registro)
			$('#cedula').text(r.data[0].cedula)			
			$('#correo').text(r.data[0].correo)
			$('#celular').val(r.data[0].celular)
			$('#fijo').val(r.data[0].fijo)
		})

		//Actualizar datos
        $('#formularioDatos').on('submit', function(e){
            e.preventDefault()
        	let datos = parsearFormulario($(this))            	
        	enviarPeticion('usuarios', 'update', {info: datos, id:id}, function(r){
            	toastr.success('Actualización correcta')
        	})
        })
	}
</script>
</body>
</html>