@include('medico.dibujos.dibujos_styles')  
      <form class="" id="seccion_cuerpo_lnh" action="{{ route('guardarimagencuerpolnh') }}" method="post" enctype="multipart/form-data" type="file">
        <div class="row">
        <div class="col-md-3">
        @csrf         
        <br>
              
        @if($img_cuerpo_ultimo_lnh != null)
            <input hidden type="text" name="img_cargada_lnh" id="img_cargada_lnh" value="{{$img_cuerpo_ultimo_lnh->foto}}">
        @endif 
        
        <input hidden name="nueva_consulta_lnh" id="nueva_consulta_lnh" value="{{$nueva_consulta}}">
        <input hidden name="cuerpo_consulta_id_lnh" id="cuerpo_consulta_id_lnh" value="{{$consulta->id}}">
        <input type="hidden" name="cuerpo_paciente_id_lnh" id="cuerpo_paciente_id_lnh" value="{{$paciente->id}}">        
        <input hidden name="base64_lnh" id="base64_lnh">
        <!-- <canvas class="class_canvas" id="pizarra_lnh"></canvas>-->
        <canvas id="pizarra_lnh" width="200" height="400"></canvas> 
        <img id="pizarra_2_lnh" hidden src=""/>
        <br>
                      
        </div>                      
        
    </div>
    @if($nueva_consulta != 0)
      <div class="row contenedor3">
          <div class="contenido3"> 

              <button type="button" id="nuevoCuerpoId_lnh" onclick="nuevoCuerpoLnh()" class="rodri_button_aceptar margin_left_20px">NUEVO</button>  
              <button hidden class="rodri_button_aceptar" id="guardarCuerpoId_lnh" value="GUARDAR">GUARDAR</button>
              <input hidden type="button" class="rodri_button_cancelar" id="borrarCuerpoId_lnh" value="BORRAR"></input>

              <label>Color</label>
              <input type="color" id="color_lnh" value="#ff0000">
              <label hidden>Tamaño Puntero</label>
              <input hidden type="range" id="puntero1" min="2" default="2" max="2" width="10%">                                                
          </div>
        </div>
    @endif
    </form>
    <br>
<script>

  function cargarImagenLnh(consulta, paciente){
    var examen_fisico = 2;
    $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_imagen_examen_fisico',
           data:{consulta:consulta, paciente:paciente, examen_fisico:examen_fisico,_token: '{{csrf_token()}}'},
            success:function(data){                 
              if(data.examen_fisico != null){
                document.getElementById("pizarra_2_lnh").src = "img/"+ data.examen_fisico.foto;
                document.getElementById("pizarra_2_lnh").hidden = false;
                document.getElementById("pizarra_lnh").hidden = true;
              } else {
                document.getElementById("pizarra_2_lnh").hidden = true;
                document.getElementById("pizarra_lnh").hidden = false;
              }
            }
        });   
  }

  function nuevoCuerpoLnh(){
    guardarDatosLinfomaNoHodgkin(2);
    habilitarBotonesCuerpoLnh(true);    
  }

  function habilitarBotonesCuerpoLnh(estado){    
    document.getElementById("nuevoCuerpoId_lnh").hidden = estado;
    document.getElementById("guardarCuerpoId_lnh").hidden = !estado;
    document.getElementById("borrarCuerpoId_lnh").hidden = !estado;
  }

  function borrarSeccionLnh(seccion){
    var myNode = document.getElementById(seccion);
            while (myNode.firstChild) {
                   myNode.removeChild(myNode.firstChild);
            }
  }  

  
  (function() { // Comenzamos una funcion auto-ejecutable

    // Obtenenemos un intervalo regular(Tiempo) en la pamtalla
    window.requestAnimFrame = (function (callback) {
        return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function (callback) {
                        window.setTimeout(callback, 1000/60);
            // Retrasa la ejecucion de la funcion para mejorar la experiencia
                    };
    })();

    // Traemos el canvas mediante el id del elemento html
    var canvas = document.getElementById("pizarra_lnh");
    var ctx = canvas.getContext("2d");


    var img = new Image();
    if(document.getElementById("img_cargada_lnh") != null){
       // img.src = "storage/app/images_base64/"+document.getElementById("img_cargada").value;
        img.src = "img/"+document.getElementById("img_cargada_lnh").value;        
    } else {
        img.src = "img/imagen_modelo/cuerpo.PNG";
    } 
    img.onload = function(){ 
      //var img_cargada = document.getElementById("img_cargada").value;
      //alert("aa "+img_cargada);
      let ctx = canvas.getContext('2d');
      ctx.drawImage(img, 0, 0);            
    }


    // Mandamos llamar a los Elemetos interactivos de la Interfaz HTML
    var drawText = document.getElementById("draw-dataUrl");
    var drawImage = document.getElementById("pizarra_2_lnh");
    var clearBtn = document.getElementById("borrarCuerpoId_lnh");
    var submitBtn = document.getElementById("guardarCuerpoId_lnh");
    clearBtn.addEventListener("click", function (e) {
        // Definimos que pasa cuando el boton draw-clearBtn es pulsado
        clearCanvas();
        drawImage.setAttribute("src", "");
        var img = new Image();
        img.src = "img/imagen_modelo/cuerpo.PNG";
        let ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);

    }, false);
        // Definimos que pasa cuando el boton draw-submitBtn es pulsado

    //submitBtn.addEventListener("submit", function (e) {
    document.getElementById('seccion_cuerpo_lnh').addEventListener("submit",function(e){
        var ctx = document.getElementById("pizarra_lnh");
        var image = ctx.toDataURL(); // data:image/png....
        document.getElementById('base64_lnh').value = image;
        //var dataUrl = canvas.toDataURL();
        //drawText.innerHTML = dataUrl;
        //drawImage.setAttribute("src", dataUrl);
     }, false);

    // Activamos MouseEvent para nuestra pagina
    var drawing = false;
    var mousePos = { x:0, y:0 };
    var lastPos = mousePos;
    canvas.addEventListener("mousedown", function (e)
  {
    /*
      Mas alla de solo llamar a una funcion, usamos function (e){...}
      para mas versatilidad cuando ocurre un evento
    */
        var tint = document.getElementById("color_lnh");
        var punta = document.getElementById("puntero1");
        console.log(e);
        drawing = true;
        lastPos = getMousePos(canvas, e);
    }, false);
    canvas.addEventListener("mouseup", function (e)
  {
        drawing = false;
    }, false);
    canvas.addEventListener("mousemove", function (e)
  {
        mousePos = getMousePos(canvas, e);
    }, false);

    // Activamos touchEvent para nuestra pagina
    canvas.addEventListener("touchstart", function (e) {
        mousePos = getTouchPos(canvas, e);
    console.log(mousePos);
    e.preventDefault(); // Prevent scrolling when touching the canvas
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousedown", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }, false);
    canvas.addEventListener("touchend", function (e) {
    e.preventDefault(); // Prevent scrolling when touching the canvas
        var mouseEvent = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(mouseEvent);
    }, false);
  canvas.addEventListener("touchleave", function (e) {
    // Realiza el mismo proceso que touchend en caso de que el dedo se deslice fuera del canvas
    e.preventDefault(); // Prevent scrolling when touching the canvas
    var mouseEvent = new MouseEvent("mouseup", {});
    canvas.dispatchEvent(mouseEvent);
  }, false);
    canvas.addEventListener("touchmove", function (e) {
    e.preventDefault(); // Prevent scrolling when touching the canvas
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousemove", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }, false);

    // Get the position of the mouse relative to the canvas
    function getMousePos(canvasDom, mouseEvent) {
        var rect = canvasDom.getBoundingClientRect();
    /*
      Devuelve el tamaño de un elemento y su posición relativa respecto
      a la ventana de visualización (viewport).
    */
        return {
            x: mouseEvent.clientX - rect.left,
            y: mouseEvent.clientY - rect.top
        };
    }

    // Get the position of a touch relative to the canvas
    function getTouchPos(canvasDom, touchEvent) {
        var rect = canvasDom.getBoundingClientRect();
    console.log(touchEvent);
    /*
      Devuelve el tamaño de un elemento y su posición relativa respecto
      a la ventana de visualización (viewport).
    */
        return {
            x: touchEvent.touches[0].clientX - rect.left, // Popiedad de todo evento Touch
            y: touchEvent.touches[0].clientY - rect.top
        };
    }

    // Draw to the canvas
    function renderCanvas() {
        if (drawing) {
      var tint = document.getElementById("color_lnh");
      var punta = document.getElementById("puntero");
      ctx.strokeStyle = tint.value;
      ctx.beginPath();
            ctx.moveTo(lastPos.x, lastPos.y);
            ctx.lineTo(mousePos.x, mousePos.y);
      console.log(punta.value);
        ctx.lineWidth = punta.value;
            ctx.stroke();
      ctx.closePath();
            lastPos = mousePos;
        }
    }

    function clearCanvas() {
        canvas.width = canvas.width;
    }

    // Allow for animation
    (function drawLoop () {
        requestAnimFrame(drawLoop);
        renderCanvas();
    })();

})();
    

</script>