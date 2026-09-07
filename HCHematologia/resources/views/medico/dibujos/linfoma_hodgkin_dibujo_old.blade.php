<style>
    canvas {
        width: 200px;
        height: 400px;
        background-color: #FFF;        
        border-color: #000;
        /*border: 1px black solid;*/
    } 
</style>    
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
        <canvas id="pizarra"></canvas>        
        <img id="pizarra_2_lh" hidden src=""/>
        <br>
                      
        </div>                      
        
    </div>
      @if($nueva_consulta != 0)
      <div class="row contenedor3">
          <div class="contenido3">            
              <button type="button" id="nuevoCuerpoId" onclick="nuevoCuerpo()" class="rodri_button_aceptar margin_left_20px">NUEVO</button>            
              <button hidden id="guardarCuerpoId" onclick="guardarCuerpo()" class="rodri_button_aceptar margin_left_20px">GUARDAR</button>
              <button hidden id="borrarCuerpoId" onclick="borrarDibujo()" type="button" class="rodri_button_cancelar margin_left_20px">BORRAR</button>                          

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

    //======================================================================
    // VARIABLES
    //======================================================================
    let miCanvas = document.querySelector('#pizarra');
    var strokeColor = "#D100A4";
    let lineas = [];
    let correccionX = 0;
    let correccionY = 0;
    let pintarLinea = false;
     // Marca el nuevo punto
    let nuevaPosicionX = 0;
    let nuevaPosicionY = 0;

    let posicion = miCanvas.getBoundingClientRect()
    correccionX = posicion.x;
    correccionY = posicion.y;

    miCanvas.width = 200;
    miCanvas.height = 400;

    var img = new Image();
    if(document.getElementById("img_cargada") != null){
       // img.src = "storage/app/images_base64/"+document.getElementById("img_cargada").value;
        img.src = "img/"+document.getElementById("img_cargada").value;        
    } else {
        img.src = "img/imagen_modelo/cuerpo.PNG";
    } 
    //var contexto = canvas.getContext("2d");
    
    //======================================================================
    // FUNCIONES
    //======================================================================  

    img.onload = function(){ 
            
      //var img_cargada = document.getElementById("img_cargada").value;
      //alert("aa "+img_cargada);
      let ctx = miCanvas.getContext('2d');
      ctx.drawImage(img, 0, 0);            
    }

    /**
     * Funcion que empieza a dibujar la linea
     */
    function empezarDibujo () {
        pintarLinea = true;
        lineas.push([]);
    };

    function borrarDibujo () {
        location.reload();
        /*var canvas = document.getElementById("pizarra");        
        let ctx = miCanvas.getContext('2d')
        clearCanvas(ctx, canvas);        
        ctx.drawImage(img, 0, 0);
        let lineas = [];        */
    };

     function clearCanvas(context, canvas) { 
        //context.clearRect(0, 0, canvas.width, canvas.height); var w = canvas.width; canvas.width = 1; canvas.width = w; 
        //canvas = document.getElementById("pizarra"); ctx = canvas.getContext("2d"); ctx.clearRect(0, 0, canvas.width, canvas.height); 
    } 

    function guardarLinea() {
      lineas[lineas.length - 1].push({
          x: nuevaPosicionX,
          y: nuevaPosicionY
      });
    }

    /**
     * Funcion dibuja la linea
     */
    function dibujarLinea (event) {
        event.preventDefault();
        if (pintarLinea) {
            let ctx = miCanvas.getContext('2d')
            // Estilos de linea
            ctx.lineJoin = ctx.lineCap = 'round';
            ctx.lineWidth = 2;
            // Color de la linea
            ctx.strokeStyle = strokeColor;
           
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
            guardarLinea();
   
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
        guardarLinea();
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
          
    document.getElementById('seccion_cuerpo').addEventListener("submit",function(e){
      var ctx = document.getElementById("pizarra");
        var image = ctx.toDataURL(); // data:image/png....
        document.getElementById('base64').value = image;
     },false);    
    

</script>