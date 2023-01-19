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
    width: 90%;	
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
	width: 500px;
	height: 150px;
	background-color: #EEEEEE;
}
#sig-canvas {
  cursor:crosshair;
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
		<canvas id="sig-canvas" width="500" height="150">
		Get a better browser, bro.
		</canvas>	
		<hr/>		
	  </div>
	   
	  <div class="modal-footer">
		<button type="button" id="clear" class="btn btn-default" >Limpiar</button>
		<button type="button" id="save" class="btn btn-primary">Guardar</button>
	  </div>
	  <script>			 
		var canvas = document.getElementById("sig-canvas");
		var ctx = canvas.getContext("2d");
		ctx.strokeStyle = "#222222";
		ctx.lineWith = 2;

		// Set up mouse events for drawing
		var drawing = false;
		var mousePos = { x:0, y:0 };
		var lastPos = mousePos;
		canvas.addEventListener("mousedown", function (e) {
				drawing = true;
		  lastPos = getMousePos(canvas, e);
		}, false);
		canvas.addEventListener("mouseup", function (e) {
		  drawing = false;
		}, false);
		canvas.addEventListener("mousemove", function (e) {
		  mousePos = getMousePos(canvas, e);
		}, false);

		// Get the position of the mouse relative to the canvas
		function getMousePos(canvasDom, mouseEvent) {
		  var rect = canvasDom.getBoundingClientRect();
		  return {
			x: mouseEvent.clientX - rect.left,
			y: mouseEvent.clientY - rect.top
		  };
		}

		window.requestAnimFrame = (function (callback) {
				return window.requestAnimationFrame || 
				   window.webkitRequestAnimationFrame ||
				   window.mozRequestAnimationFrame ||
				   window.oRequestAnimationFrame ||
				   window.msRequestAnimaitonFrame ||
				   function (callback) {
				window.setTimeout(callback, 1000/60);
				   };
		})();

		// Draw to the canvas
		function renderCanvas() {
		  if (drawing) {
			ctx.moveTo(lastPos.x, lastPos.y);
			ctx.lineTo(mousePos.x, mousePos.y);
			ctx.lineJoin = ctx.lineCap = 'round';
			ctx.lineWidth = 2;
			ctx.stroke();			
			lastPos = mousePos;
		  }
		}

		// Allow for animation
		(function drawLoop () {
		  requestAnimFrame(drawLoop);
		  renderCanvas();
		})();

		// Set up touch events for mobile, etc
		canvas.addEventListener("touchstart", function (e) {
				mousePos = getTouchPos(canvas, e);
		  var touch = e.touches[0];
		  var mouseEvent = new MouseEvent("mousedown", {
			clientX: touch.clientX,
			clientY: touch.clientY
		  });
		  canvas.dispatchEvent(mouseEvent);
		}, false);
		canvas.addEventListener("touchend", function (e) {
		  var mouseEvent = new MouseEvent("mouseup", {});
		  canvas.dispatchEvent(mouseEvent);
		}, false);
		canvas.addEventListener("touchmove", function (e) {
		  var touch = e.touches[0];
		  var mouseEvent = new MouseEvent("mousemove", {
			clientX: touch.clientX,
			clientY: touch.clientY
		  });
		  canvas.dispatchEvent(mouseEvent);
		}, false);

		// Get the position of a touch relative to the canvas
		function getTouchPos(canvasDom, touchEvent) {
		  var rect = canvasDom.getBoundingClientRect();
		  return {
			x: touchEvent.touches[0].clientX - rect.left,
			y: touchEvent.touches[0].clientY - rect.top
		  };
		}

		// Prevent scrolling when touching the canvas
		document.body.addEventListener("touchstart", function (e) {
		  if (e.target == canvas) {
			e.preventDefault();
		  }
		}, false);
		document.body.addEventListener("touchend", function (e) {
		  if (e.target == canvas) {
			e.preventDefault();
		  }
		}, false);
		document.body.addEventListener("touchmove", function (e) {
		  if (e.target == canvas) {
			e.preventDefault();
		  }
		}, false);
		
		var limpiar = document.getElementById("clear"); 
		limpiar.addEventListener("click", function(e){
			e.preventDefault();
			canvas.width = canvas.width;
		}, false); 
		
		var guardar = document.getElementById("save"); 
		guardar.addEventListener("click", function(e){
			e.preventDefault();
			var dataUrl = canvas.toDataURL();
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