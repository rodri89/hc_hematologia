@include('medico.dibujos.dibujos_styles')  
<form class="" id="seccion_cuerpo_gm" action="{{ route('guardarimagencuerpogm') }}" method="post" enctype="multipart/form-data" type="file">
        <div class="row">
        <div class="col-md-3">
        @csrf         
        <br>
              
        @if($img_cuerpo_ultimo_gm != null)
            <input hidden type="text" name="img_cargada_gm" id="img_cargada_gm" value="{{$img_cuerpo_ultimo_gm->foto}}">
        @endif 
        
        <input hidden name="nueva_consulta_gm" id="nueva_consulta_gm" value="{{$nueva_consulta}}">
        <input hidden name="cuerpo_consulta_id_gm" id="cuerpo_consulta_id_gm" value="{{$consulta->id}}">
        <input type="hidden" name="cuerpo_paciente_id_gm" id="cuerpo_paciente_id_gm" value="{{$paciente->id}}">        
        <input hidden name="base64_gm" id="base64_gm">        
        <canvas id="pizarra_gm" width="200" height="400"></canvas>
        <img id="pizarra_2_gm" hidden src=""/>
        <br>
                      
        </div>                      
        
    </div>
    @if($nueva_consulta != 0)
      <div class="row contenedor3">
          <div class="contenido3"> 

              <button type="button" id="nuevoCuerpoId_gm" onclick="nuevoCuerpoGm()" class="rodri_button_aceptar margin_left_20px">NUEVO</button>  
              <button hidden class="rodri_button_aceptar" id="guardarCuerpoId_gm" value="GUARDAR">GUARDAR</button>
              <input hidden type="button" class="rodri_button_cancelar" id="borrarCuerpoId_gm" value="BORRAR"></input>

              <label>Color</label>
              <input type="color" id="color_gm" value="#ff0000">
              <label hidden>Tamaño Puntero</label>
              <input hidden type="range" id="puntero2" min="2" default="2" max="2" width="10%">
              
          </div>
        </div>
    @endif
    </form>
    <br>
<script>

    function cargarImagenGm(consulta, paciente){
        var examen_fisico = 3;
        $.ajax({
               type:'POST',
               dataType:'JSON',
               url:'/cargar_imagen_examen_fisico',
               data:{consulta:consulta, paciente:paciente, examen_fisico:examen_fisico,_token: '{{csrf_token()}}'},
                success:function(data){                 
                  if(data.examen_fisico != null){
                    document.getElementById("pizarra_2_gm").src = "img/"+ data.examen_fisico.foto;
                    document.getElementById("pizarra_2_gm").hidden = false;
                    document.getElementById("pizarra_gm").hidden = true;
                  } else {
                    document.getElementById("pizarra_2_gm").hidden = true;
                    document.getElementById("pizarra_gm").hidden = false;
                  }
                }
            });   
      }
  function nuevoCuerpoGm(){
    guardarGammapatiaMonoclonal(2);
    habilitarBotonesCuerpoGm(true);    
  }

  function habilitarBotonesCuerpoGm(estado){    
    document.getElementById("nuevoCuerpoId_gm").hidden = estado;
    document.getElementById("guardarCuerpoId_gm").hidden = !estado;
    document.getElementById("borrarCuerpoId_gm").hidden = !estado;
  }

  function borrarSeccionGm(seccion){
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
    var canvas = document.getElementById("pizarra_gm");
    var ctx = canvas.getContext("2d");


    var img = new Image();
    if(document.getElementById("img_cargada_gm") != null){
       // img.src = "storage/app/images_base64/"+document.getElementById("img_cargada").value;
        img.src = "img/"+document.getElementById("img_cargada_gm").value;        
    } else {
        img.src = "img/imagen_modelo/esqueleto.PNG";
    } 
    img.onload = function(){ 
      //var img_cargada = document.getElementById("img_cargada").value;
      //alert("aa "+img_cargada);
      let ctx = canvas.getContext('2d');
      ctx.drawImage(img, 0, 0);            
    }


    // Mandamos llamar a los Elemetos interactivos de la Interfaz HTML
    var drawText = document.getElementById("draw-dataUrl");
    var drawImage = document.getElementById("pizarra_2_gm");
    var clearBtn = document.getElementById("borrarCuerpoId_gm");
    var submitBtn = document.getElementById("guardarCuerpoId_gm");
    clearBtn.addEventListener("click", function (e) {
        // Definimos que pasa cuando el boton draw-clearBtn es pulsado
        clearCanvas();
        drawImage.setAttribute("src", "");
        var img = new Image();
        img.src = "img/imagen_modelo/esqueleto.PNG";
        let ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);

    }, false);
        // Definimos que pasa cuando el boton draw-submitBtn es pulsado

    //submitBtn.addEventListener("submit", function (e) {
    document.getElementById('seccion_cuerpo_gm').addEventListener("submit",function(e){
        var ctx = document.getElementById("pizarra_gm");
        var image = ctx.toDataURL(); // data:image/png....
        document.getElementById('base64_gm').value = image;
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
        var tint = document.getElementById("color_gm");
        var punta = document.getElementById("puntero2");
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
      var tint = document.getElementById("color_gm");
      var punta = document.getElementById("puntero2");
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