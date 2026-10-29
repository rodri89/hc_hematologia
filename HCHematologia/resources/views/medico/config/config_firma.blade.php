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
  <input type="file" name="firma_imagen" accept="image/*" required>
  <br><br>
  <button type="submit" class="rodri_button_aceptar">Guardar img</button>
</form>

<hr>

<h5>Dibujar firma</h5>
<canvas id="canvas_firma" width="400" height="150" style="border:1px solid #333; background:#fff; touch-action:none;"></canvas>
<br><br>
<button type="button" class="rodri_button_volver" onclick="limpiarCanvasFirma()">Limpiar</button>
<button type="button" class="rodri_button_aceptar" onclick="guardarFirmaDibujada()">Guardar firma</button>

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
    var base64 = canvasFirma.toDataURL('image/png');
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
          limpiarCanvasFirma();
          alert('Firma guardada correctamente.');
        }
      }
    });
  }
</script>

@endsection
