@extends('plantillas/plantilla_medico')

@section('contenedor')

@include('modal.snackbar')

<h3>Configuración de Firma Digital</h3>
<br>

<h5>Firma actual</h5>
@if($firmaActual != null)
  <img id="img_firma_actual" src="/img/{{ $firmaActual->firma }}" style="max-width:300px; max-height:150px; border:1px solid #ccc; display:block;">
@else
  <p id="texto_sin_firma">Todavía no tiene una firma digital configurada.</p>
  <img id="img_firma_actual" src="" style="max-width:300px; max-height:150px; border:1px solid #ccc; display:none;">
@endif

<hr>

<h5>Subir imagen de firma</h5>
<form id="form_subir_firma" action="{{ route('guardarfirma') }}" method="post" enctype="multipart/form-data">
  @csrf
  <input type="file" id="input_firma_imagen" name="firma_imagen" accept=".pdf,.png,.jpg,.jpeg,application/pdf,image/png,image/jpeg" required>
  <br>
  <small>Formatos permitidos: PDF, PNG, JPG, JPEG. Si es PDF se usa la primera página.</small>
  @if($errors->has('firma_imagen'))
    <br><small style="color:#c00;">{{ $errors->first('firma_imagen') }}</small>
  @endif
  <br><br>
  <button type="submit" class="rodri_button_aceptar">Guardar img</button>
</form>

<hr>

<h5>Dibujar firma</h5>
<canvas id="canvas_firma" width="400" height="150" style="border:1px solid #333; background:#fff; touch-action:none;"></canvas>
<br><br>
<button type="button" class="rodri_button_volver" onclick="limpiarCanvasFirma()">Limpiar</button>
<button type="button" class="rodri_button_aceptar" onclick="guardarFirmaDibujada()">Guardar firma</button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script type="text/javascript">
  var canvasFirma = document.getElementById('canvas_firma');
  var ctxFirma = canvasFirma.getContext('2d');
  var dibujandoFirma = false;

  function obtenerPosicionFirma(evento){
    var rect = canvasFirma.getBoundingClientRect();
    var clientX = evento.touches ? evento.touches[0].clientX : evento.clientX;
    var clientY = evento.touches ? evento.touches[0].clientY : evento.clientY;
    return { x: clientX - rect.left, y: clientY - rect.top };
  }

  function empezarDibujoFirma(evento){
    dibujandoFirma = true;
    var pos = obtenerPosicionFirma(evento);
    ctxFirma.beginPath();
    ctxFirma.moveTo(pos.x, pos.y);
    evento.preventDefault();
  }

  function dibujarFirma(evento){
    if(!dibujandoFirma) return;
    var pos = obtenerPosicionFirma(evento);
    ctxFirma.lineTo(pos.x, pos.y);
    ctxFirma.lineWidth = 2;
    ctxFirma.lineCap = 'round';
    ctxFirma.strokeStyle = '#000';
    ctxFirma.stroke();
    evento.preventDefault();
  }

  function terminarDibujoFirma(){
    dibujandoFirma = false;
  }

  canvasFirma.addEventListener('mousedown', empezarDibujoFirma);
  canvasFirma.addEventListener('mousemove', dibujarFirma);
  canvasFirma.addEventListener('mouseup', terminarDibujoFirma);
  canvasFirma.addEventListener('mouseleave', terminarDibujoFirma);
  canvasFirma.addEventListener('touchstart', empezarDibujoFirma);
  canvasFirma.addEventListener('touchmove', dibujarFirma);
  canvasFirma.addEventListener('touchend', terminarDibujoFirma);

  function limpiarCanvasFirma(){
    ctxFirma.clearRect(0, 0, canvasFirma.width, canvasFirma.height);
  }

  function guardarFirmaDibujada(){
    enviarFirmaBase64(canvasFirma.toDataURL('image/png'), limpiarCanvasFirma);
  }

  function enviarFirmaBase64(base64, alGuardar){
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '{{ route("guardarfirmadibujada") }}',
      data: { base64: base64, _token: '{{ csrf_token() }}' },
      success: function(data){
        if(data.response == 1){
          var img = document.getElementById('img_firma_actual');
          img.src = '/img/'+data.firma+'?t='+new Date().getTime();
          img.style.display = 'block';
          var textoSinFirma = document.getElementById('texto_sin_firma');
          if(textoSinFirma != null) textoSinFirma.style.display = 'none';
          if(alGuardar) alGuardar();
          alert('Firma guardada correctamente.');
        } else {
          alert('No se pudo guardar la firma.');
        }
      },
      error: function(){
        alert('No se pudo guardar la firma.');
      }
    });
  }

  // El PDF no se puede mostrar en un <img> al imprimir, así que se convierte
  // la primera página a PNG en el navegador (el servidor no tiene Imagick).
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

  document.getElementById('form_subir_firma').addEventListener('submit', function(evento){
    var archivo = document.getElementById('input_firma_imagen').files[0];
    if(archivo == null) return;

    var nombre = archivo.name.toLowerCase();
    var esPdf = archivo.type == 'application/pdf' || /\.pdf$/.test(nombre);
    if(!esPdf){
      if(!/\.(png|jpe?g)$/.test(nombre)){
        evento.preventDefault();
        alert('Formato no permitido. Use PDF, PNG, JPG o JPEG.');
      }
      return;
    }

    evento.preventDefault();
    var lector = new FileReader();
    lector.onload = function(){
      pdfjsLib.getDocument({ data: new Uint8Array(lector.result) }).promise
        .then(function(pdf){ return pdf.getPage(1); })
        .then(function(pagina){
          var viewport = pagina.getViewport({ scale: 3 });
          var canvas = document.createElement('canvas');
          canvas.width = viewport.width;
          canvas.height = viewport.height;
          var ctx = canvas.getContext('2d');
          ctx.fillStyle = '#fff';
          ctx.fillRect(0, 0, canvas.width, canvas.height);
          return pagina.render({ canvasContext: ctx, viewport: viewport }).promise.then(function(){
            return recortarBordesBlancos(canvas);
          });
        })
        .then(function(canvasFinal){
          enviarFirmaBase64(canvasFinal.toDataURL('image/png'), function(){
            document.getElementById('form_subir_firma').reset();
          });
        })
        .catch(function(){
          alert('No se pudo leer el PDF.');
        });
    };
    lector.readAsArrayBuffer(archivo);
  });

  // Recorta el margen blanco de la página para que quede solo la firma
  function recortarBordesBlancos(canvas){
    var ctx = canvas.getContext('2d');
    var datos = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
    var minX = canvas.width, minY = canvas.height, maxX = -1, maxY = -1;
    for(var y = 0; y < canvas.height; y++){
      for(var x = 0; x < canvas.width; x++){
        var i = (y * canvas.width + x) * 4;
        if(datos[i] < 240 || datos[i+1] < 240 || datos[i+2] < 240){
          if(x < minX) minX = x;
          if(x > maxX) maxX = x;
          if(y < minY) minY = y;
          if(y > maxY) maxY = y;
        }
      }
    }
    if(maxX < 0) return canvas;

    var margen = 10;
    minX = Math.max(0, minX - margen);
    minY = Math.max(0, minY - margen);
    maxX = Math.min(canvas.width - 1, maxX + margen);
    maxY = Math.min(canvas.height - 1, maxY + margen);

    var recortado = document.createElement('canvas');
    recortado.width = maxX - minX + 1;
    recortado.height = maxY - minY + 1;
    recortado.getContext('2d').drawImage(canvas, minX, minY, recortado.width, recortado.height, 0, 0, recortado.width, recortado.height);
    return recortado;
  }
</script>

@endsection
