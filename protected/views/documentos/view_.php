<?php
/* @var $this DocumentosController */
/* @var $model Documentos */

$this->breadcrumbs=array(
	'Documentoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Documentos', 'url'=>array('index')),
	array('label'=>'Create Documentos', 'url'=>array('create')),
	array('label'=>'Update Documentos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Documentos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Documentos', 'url'=>array('admin')),
);
?>
<style>

@media screen and (orientation: portrait) {
  #todobien {
	display: none;	
  }
  #alertaposicion{
	  display:block;
  }
}

@media screen and (orientation: landscape) {
  #todobien {
	display: block;
  }
  #alertaposicion{
	  display:none;
  }
}

.fullscreen-modal .modal-dialog {
  margin: 0;
  margin-right: auto;
  margin-left: auto;
  width: 100%;
}
@media (min-width: 150px) {
  .fullscreen-modal .modal-dialog {
    width: 100%;	
  }
  .modal-body{
	 height: 200px; 
  }
}
@media (min-width: 768px) {
  .fullscreen-modal .modal-dialog {
    width: 100%;	
  }
  .modal-body{
	 height: 500px; 
  }
}
@media (min-width: 992px) {
  .fullscreen-modal .modal-dialog {
    width: 70%;	
  }
  .modal-body{
	 height: 300; 
  }
}
@media (min-width: 1200px) {
  .fullscreen-modal .modal-dialog {
    width: 40%;	
  }
  .modal-body{
	 height: 400px; 
  }
}
.modal-header{
	padding: 10px !important;
}
.modal-footer{
	padding: 1px !important;
}
canvas {
	width: 600px;
	height: 150px;
	background-color: #EEEEEE;
} 
</style>



<div id="alertaposicion">
	<div class="col-lg-12">
		<h3>Por favor rote su celular de modo horizontal, y habilite la opcion de rotacion horizontal, para visualizar el contenido</h3>
		<label>Para Android</label>
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/android.jpg" alt="rotacion-android" style="width:100%" />	
		<hr/>
		<label>Para IOS</label>
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ios.jpg" alt="rotacion-ios" style="width:100%" />				
	</div>
</div>
<div id="todobien">
<div class="col-lg-12">
	<div class="form-panel">
	  <h1 class="mb"><?php echo $model->nombre ?></h1>
	  <div class="container">
	  <p>
		<?php echo $model->tetxo ?>
	  </p>
	  </div>
	</div><!-- /form-panel -->
</div>
<div class="col-lg-12">
	<div class="form-panel">
		<label>Foto del documento de identidad</label>
		<input type="file" accept="image/*" capture="camera" id="camera1" onchange="imgchange1(this)" class="form-control">
		<img src="" id="viewcamera1" alt="Documento de identidad" width="100" height="150">
		<hr/>
		<label>Foto del documento de identidad</label>
		<input type="file" accept="image/*" capture="camera" id="camera2" onchange="imgchange2(this)" class="form-control">
		<img src="" id="viewcamera2" alt="Foto personal" width="100" height="150">
		<hr/>
		<label>Firma documento</label><br/>
		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Firma aqui tu documento</button><br/>
		<img src="" id="viewfirma" alt="Firma autorizada" width="600" height="150">
	</div><!-- /form-panel -->
</div>
<div class="col-lg-12">
	<div class="form-panel">
		
		<label>Pincha aqui, para terminar con el procedimiento</label><br/>
		<button type="button" id="btnguardaryenviar" class="btn btn-primary btn-lg btn-block" >Firmar y Guardar Documento</button><br/>		
	</div><!-- /form-panel -->
</div>
<div class="modal fullscreen-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Firma sobre la linea</h4>
	  </div>
	  <div class="modal-body">	
		<canvas id="pizarra"></canvas>	
		<hr/>		
	  </div>
	   
	  <div class="modal-footer">
		<button type="button" id="clear" class="btn btn-default" >Limpiar</button>
		<button type="button" id="save" class="btn btn-primary">Guardar</button>
	  </div>
	  <script>			 
		//======================================================================
		// VARIABLES
		//======================================================================
		let miCanvas = document.querySelector('#pizarra');
		let lineas = [];
		let correccionX = 0;
		let correccionY = 0;
		let pintarLinea = false;

		let posicion = miCanvas.getBoundingClientRect()
		correccionX = posicion.x;
		correccionY = posicion.y;

		miCanvas.width = 600;
		miCanvas.height = 150;
		
		//======================================================================
		// FUNCIONES
		//======================================================================

		/**
		 * Funcion que empieza a dibujar la linea
		 */
		function empezarDibujo () {
			pintarLinea = true;
			lineas.push([]);
		};

		/**
		 * Funcion dibuja la linea
		 */
		function dibujarLinea (event) {
			event.preventDefault();
			if (pintarLinea) {
				let ctx = miCanvas.getContext('2d')
				// Estilos de linea
				ctx.lineJoin = ctx.lineCap = 'round';
				ctx.lineWidth = 5;
				// Color de la linea
				ctx.strokeStyle = '#000';
				// Marca el nuevo punto
				let nuevaPosicionX = 0;
				let nuevaPosicionY = 0;
				if (event.changedTouches == undefined) {
					// Versión ratón
					nuevaPosicionX = event.layerX;
					nuevaPosicionY = event.layerY;
				} else {
					// Versión touch, pantalla tactil
					nuevaPosicionX = event.changedTouches[0].pageX - correccionX;
					nuevaPosicionY = event.changedTouches[0].pageY - correccionY;
				}
				// Guarda la linea
				lineas[lineas.length - 1].push({
					x: nuevaPosicionX,
					y: nuevaPosicionY
				});
				// Redibuja todas las lineas guardadas
				ctx.beginPath();
				lineas.forEach(function (segmento) {
					ctx.moveTo(segmento[0].x, segmento[0].y);
					segmento.forEach(function (punto, index) {
						ctx.lineTo(punto.x, punto.y);
					});
				});
				ctx.stroke();
			}
		}

		/**
		 * Funcion que deja de dibujar la linea
		 */
		function pararDibujar () {
			pintarLinea = false;
		}

		//======================================================================
		// EVENTOS
		//======================================================================

		// Eventos raton
		miCanvas.addEventListener('mousedown', empezarDibujo, false);
		miCanvas.addEventListener('mousemove', dibujarLinea, false);
		miCanvas.addEventListener('mouseup', pararDibujar, false);

		// Eventos pantallas táctiles
		miCanvas.addEventListener('touchstart', empezarDibujo, false);
		miCanvas.addEventListener('touchmove', dibujarLinea, false);
		
		var limpiar = document.getElementById("clear"); 
		limpiar.addEventListener("click", function(e){
			e.preventDefault();
			miCanvas.width = miCanvas.width;
		}, false); 
		
		var guardar = document.getElementById("save"); 
		guardar.addEventListener("click", function(e){
			e.preventDefault();
			var dataUrl = miCanvas.toDataURL();
			console.log(dataUrl)
			document.getElementById("viewfirma").src = dataUrl;
		}, false);				
					
		function imgchange1(f) {
           var filePath = document.getElementById("camera1").value;
           var reader = new FileReader();
           reader.onload = function (e) {			   
               document.getElementById("viewcamera1").src = e.target.result;
           };
           reader.readAsDataURL(f.files[0]);           
        }
		
		function imgchange2(f) {
           var filePath = document.getElementById("camera2").value;
           var reader = new FileReader();
           reader.onload = function (e) {			   			  
				document.getElementById("viewcamera2").src = e.target.result;			   			                 
           };
           reader.readAsDataURL(f.files[0]);           
        }
		
		var enviartodo = document.getElementById("btnguardaryenviar"); 
		enviartodo.addEventListener("click", function(e){
			e.preventDefault();
			var imagen1 = document.getElementById("viewcamera1").src			
			var imagen2 = document.getElementById("viewcamera2").src
			var imagen3 = document.getElementById("viewfirma").src
			var xhttp = new XMLHttpRequest();			
			xhttp.onreadystatechange = function() {
			  if (this.readyState == 4 && this.status == 200) {								
				alert(this.responseText)
				window.location.replace("<?php echo Yii::app()->createUrl('/documentos/index') ?>");
			  }
			};
			xhttp.open("POST", "<?php echo Yii::app()->createUrl('/documentos/firmar') ?>", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("image1=" + imagen1 + "&image2=" + imagen2 + "&image3=" + imagen3 + "&documento=<?php echo $model->id ?>&cliente=<?php echo Yii::app()->user->id ?>");			
		}, false);
		</script>
	</div>
  </div>
</div>
</div>