<?php

class archivos{
	public function cargarDocumento($datos){
		$dir = $datos['ruta'].'/'.$datos['id'];
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		$suffix = (isset($datos['indice']) && $datos['indice'] !== '') ? '_' . $datos['indice'] : '';
		$filePath = $dir.'/'.$datos['id'].$suffix.'.pdf';
		if(move_uploaded_file($_FILES['file']['tmp_name'], $filePath)){
			return [
				'ejecuto' => true,
				'msg' => 'Carga correcta'
			];
		}else{
			return [
				'ejecuto' => false,
				'msg' => 'Error al cargar el archivo'
			];
		}		
	}

	public function getDocumento($datos){
		$suffix = (isset($datos['indice']) && $datos['indice'] !== '') ? '_' . $datos['indice'] : '';
		$file = $datos['ruta'].'/'.$datos['id'].'/'.$datos['id'].$suffix.'.pdf';
		// Verificar si el archivo existe
		if(file_exists($file)) {
			// Lee el archivo en formato binario
    		$fileContent = file_get_contents($file);    
    		// Codifica el contenido en base64 para enviarlo en formato JSON
    		$base64File = base64_encode($fileContent);    
    		// Enviar la respuesta JSON con el archivo codificado
    		header('Content-Type: application/json');
    		return [
    			'ejecuto' => true,
    			'file' => $base64File
    		];
		}else{
    		return [
				'ejecuto' => false,
				'mensajeError' => 'El archivo no existe'
			];
		}
	}

	public function existDocumento($datos){
		$suffix = (isset($datos['indice']) && $datos['indice'] !== '') ? '_' . $datos['indice'] : '';
		$file = $datos['ruta'].'/'.$datos['id'].'/'.$datos['id'].$suffix.'.pdf';
		if(file_exists($file)) {
			return [
				'ejecuto' => true,
				'mensaje' => true
			];
		}else{
			return [
				'ejecuto' => false,
				'mensajeError' => 'El archivo no existe'
			];
		}
	}
}