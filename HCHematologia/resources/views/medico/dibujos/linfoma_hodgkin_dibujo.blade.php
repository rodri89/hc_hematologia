@include('medico.dibujos.dibujos_styles')  
      <form class="" id="seccion_cuerpo" action="{{ route('guardarimagencuerpo') }}" method="post" enctype="multipart/form-data" type="file">
        <div class="row">
        <div class="col-md-3">
        @csrf 
        <h4><b><a onclick="clickDibujarCuerpo()" type="button"></a></b></h4>        
        <br>
              
        @if($img_cuerpo_ultimo != null)
            <input hidden type="text" name="img_cargada" id="img_cargada" value="{{$img_cuerpo_ultimo->foto}}">
        @endif 
        
        <input hidden name="nueva_consulta" id="nueva_consulta" value="{{$nueva_consulta}}">
        <input hidden name="cuerpo_consulta_id" id="cuerpo_consulta_id" value="{{$consulta->id}}">
        <input type="hidden" name="cuerpo_paciente_id" id="cuerpo_paciente_id" value="{{$paciente->id}}">        
        <input hidden name="base64" id="base64">
        <!-- <canvas id="pizarra"></canvas>   -->
        <canvas id="pizarra" width="200" height="400"></canvas>     
        <img id="pizarra_2_lh" hidden src=""/>
        <br>
                      
        </div>                      
        
    </div>
      @if($nueva_consulta != 0)
      <div class="row contenedor3">
          <div class="contenido3">    

            <button type="button" id="nuevoCuerpoId" onclick="nuevoCuerpo()" class="rodri_button_aceptar margin_left_20px">NUEVO</button>  
            <button hidden class="rodri_button_aceptar" id="guardarCuerpoId" value="GUARDAR">GUARDAR</button>
            <input hidden type="button" class="rodri_button_cancelar" id="borrarCuerpoId" value="BORRAR"></input>

            <label>Color</label>
            <input type="color" id="color" value="#ff0000">
            <label hidden>Tamaño Puntero</label>
            <input hidden type="range" id="puntero" min="2" default="2" max="2" width="10%">

              <!--<button type="button" id="nuevoCuerpoId" onclick="nuevoCuerpo()" class="rodri_button_aceptar margin_left_20px">NUEVO</button>            
              <button hidden id="guardarCuerpoId" onclick="guardarCuerpo()" class="rodri_button_aceptar margin_left_20px">GUARDAR</button>
              <button hidden id="borrarCuerpoId" onclick="borrarDibujo()" type="button" class="rodri_button_cancelar margin_left_20px">BORRAR</button>                          -->

          </div>
        </div>
      @endif
    </form>

    <form hidden class="card background_panel_consulta_actual" id="seccion_cuerpo_2">  
      <div class="row margin_left_5px">
            <h4><b><a onclick="clickDibujarCuerpo2()" type="button">Dibujar Cuerpo</a></b></h4>
      </div>
    </form>      
<script>

  function cargarImagenLh(consulta, paciente){
    var examen_fisico = 1;
    
    $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_imagen_examen_fisico',
           data:{consulta:consulta, paciente:paciente, examen_fisico:examen_fisico,_token: '{{csrf_token()}}'},
            success:function(data){                 
              if(data.examen_fisico != null){
                document.getElementById("pizarra_2_lh").src = "img/"+ data.examen_fisico.foto;
                document.getElementById("pizarra_2_lh").hidden = false;
                document.getElementById("pizarra").hidden = true;
              } else {
                document.getElementById("pizarra_2_lh").hidden = true;
                document.getElementById("pizarra").hidden = false;
              }

            }
        });   
  }

  function nuevoCuerpo(){
    guardarDatosLinfomaHodgkin(2);
    habilitarBotonesCuerpo(true);    
  }

  function habilitarBotonesCuerpo(estado){    
    document.getElementById("nuevoCuerpoId").hidden = estado;
    document.getElementById("guardarCuerpoId").hidden = !estado;
    document.getElementById("borrarCuerpoId").hidden = !estado;
  }

  function borrarSeccion(seccion){
    var myNode = document.getElementById(seccion);
            while (myNode.firstChild) {
                   myNode.removeChild(myNode.firstChild);
            }
  }

  function clickDibujarCuerpo(){
      seccionPrincipal = document.getElementById("seccion_pap");          
      if(seccionPrincipal.hidden == true){
            seccionPrincipal.hidden = false;                
            document.getElementById("seccion_cuerpo_2").hidden = true;
      }
      else {
            seccionPrincipal.hidden = true;
            document.getElementById("seccion_cuerpo_2").hidden = false;

      }
  }

  function clickDibujarCuerpo2(){
      seccionPrincipal = document.getElementById("seccion_cuerpo_2");          
      if(seccionPrincipal.hidden == true){
            seccionPrincipal.hidden = false;                
            document.getElementById("seccion_pap").hidden = true;
      }
      else {
            seccionPrincipal.hidden = true;
            document.getElementById("seccion_pap").hidden = false;

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
    var canvas = document.getElementById("pizarra");
    var ctx = canvas.getContext("2d");


    var img = new Image();
    if(document.getElementById("img_cargada") != null){
       // img.src = "storage/app/images_base64/"+document.getElementById("img_cargada").value;
        img.src = "img/"+document.getElementById("img_cargada").value;        
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
    var drawImage = document.getElementById("pizarra_2_lh");
    var clearBtn = document.getElementById("borrarCuerpoId");
    var submitBtn = document.getElementById("guardarCuerpoId");
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
    document.getElementById('seccion_cuerpo').addEventListener("submit",function(e){
        var ctx = document.getElementById("pizarra");
        var image = ctx.toDataURL(); // data:image/png....
        document.getElementById('base64').value = image;
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
        var tint = document.getElementById("color");
        var punta = document.getElementById("puntero");
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
      var tint = document.getElementById("color");
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


 
          
 /*   document.getElementById('seccion_cuerpo').addEventListener("submit",function(e){
      var ctx = document.getElementById("pizarra");
        var image = ctx.toDataURL(); // data:image/png....
        document.getElementById('base64').value = image;
     },false);    
   */ 

</script>