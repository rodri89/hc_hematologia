<style>
    .class_canvas {
        width: 200px;
        height: 400px;
        background-color: #FFF;        
        border-color: #000;
        /*border: 1px black solid;*/
    } 
</style>    
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
        <canvas class="class_canvas" id="pizarra_lnh"></canvas>
        <img id="pizarra_2_lnh" hidden src=""/>
        <br>
                      
        </div>                      
        
    </div>
    @if($nueva_consulta != 0)
      <div class="row contenedor3">
          <div class="contenido3">            
              <button type="button" id="nuevoCuerpoId_lnh" onclick="nuevoCuerpoLnh()" class="rodri_button_aceptar margin_left_20px">NUEVO</button>            
              <button hidden id="guardarCuerpoId_lnh" onclick="guardarCuerpoLnh()" class="rodri_button_aceptar margin_left_20px">GUARDAR</button>
              <button hidden id="borrarCuerpoId_lnh" onclick="borrarDibujoLnh()" type="button" class="rodri_button_cancelar margin_left_20px">BORRAR</button>                          
              
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

    //======================================================================
    // VARIABLES
    //======================================================================
    var miCanvas_lnh = document.querySelector('#pizarra_lnh');
    var strokeColor_lnh = "#D100A4";
    let lineas_lnh = [];
    let correccionX_lnh = 0;
    let correccionY_lnh = 0;
    let pintarLinea_lnh = false;

    let posicion_lnh = miCanvas_lnh.getBoundingClientRect()
    correccionX_lnh = posicion_lnh.x;
    correccionY_lnh = posicion_lnh.y;

    miCanvas_lnh.width = 200;
    miCanvas_lnh.height = 400;

    var img_lnh = new Image();
    if(document.getElementById("img_cargada_lnh") != null){
       // img.src = "storage/app/images_base64/"+document.getElementById("img_cargada").value;
        img_lnh.src = "img/"+document.getElementById("img_cargada_lnh").value;        
    } else {
        img_lnh.src = "img/imagen_modelo/cuerpo.PNG";
    } 
    //var contexto = canvas.getContext("2d");
    
    //======================================================================
    // FUNCIONES
    //======================================================================  

    img_lnh.onload = function(){ 
            
      //var img_cargada = document.getElementById("img_cargada").value;
      //alert("aa "+img_cargada);
      let ctx_lnh = miCanvas_lnh.getContext('2d');
      ctx_lnh.drawImage(img_lnh, 0, 0);            
    }

    /**
     * Funcion que empieza a dibujar la linea
     */
    function empezarDibujoLnh () {      
        pintarLinea_lnh = true;
        lineas_lnh.push([]);
    };

    function borrarDibujoLnh () {
        location.reload();
        /*var canvas = document.getElementById("pizarra");        
        let ctx = miCanvas.getContext('2d')
        clearCanvas(ctx, canvas);        
        ctx.drawImage(img, 0, 0);
        let lineas = [];        */
    };

     function clearCanvasLnh(context, canvas) { 
        //context.clearRect(0, 0, canvas.width, canvas.height); var w = canvas.width; canvas.width = 1; canvas.width = w; 
        //canvas = document.getElementById("pizarra"); ctx = canvas.getContext("2d"); ctx.clearRect(0, 0, canvas.width, canvas.height); 
    } 

    /**
     * Funcion dibuja la linea
     */
    function dibujarLineaLnh (event) {
        event.preventDefault();
        if (pintarLinea_lnh) {
            let ctx_lnh = miCanvas_lnh.getContext('2d')
            // Estilos de linea
            ctx_lnh.lineJoin = ctx_lnh.lineCap = 'round';
            ctx_lnh.lineWidth = 2;
            // Color de la linea
            ctx_lnh.strokeStyle = strokeColor_lnh;
            // Marca el nuevo punto
            let nuevaPosicionX_lnh = 0;
            let nuevaPosicionY_lnh = 0;
            if (event.changedTouches == undefined) {
                // Versión ratón
                nuevaPosicionX_lnh = event.layerX;
                nuevaPosicionY_lnh = event.layerY;
            } else {
                // Versión touch, pantalla tactil
                nuevaPosicionX_lnh = event.changedTouches[0].pageX - correccionX_lnh;
                nuevaPosicionY_lnh = event.changedTouches[0].pageY - correccionY_lnh;
            }
            // Guarda la linea
            lineas_lnh[lineas_lnh.length - 1].push({
                x: nuevaPosicionX_lnh,
                y: nuevaPosicionY_lnh
            });
            // Redibuja todas las lineas guardadas
            ctx_lnh.beginPath();
            lineas_lnh.forEach(function (segmento) {
                ctx_lnh.moveTo(segmento[0].x, segmento[0].y);
                segmento.forEach(function (punto, index) {
                    ctx_lnh.lineTo(punto.x, punto.y);
                });
            });
            ctx_lnh.stroke();
        }
    }

    /**
     * Funcion que deja de dibujar la linea
     */
    function pararDibujarLnh() {
        pintarLinea_lnh = false;
    }

    //======================================================================
    // EVENTOS
    //======================================================================

    // Eventos raton
    miCanvas_lnh.addEventListener('mousedown', empezarDibujoLnh, false);
    miCanvas_lnh.addEventListener('mousemove', dibujarLineaLnh, false);
    miCanvas_lnh.addEventListener('mouseup', pararDibujarLnh, false);

    // Eventos pantallas táctiles
    miCanvas_lnh.addEventListener('touchstart', empezarDibujoLnh, false);
    miCanvas_lnh.addEventListener('touchmove', dibujarLineaLnh, false);
          
    document.getElementById('seccion_cuerpo_lnh').addEventListener("submit",function(e){
      var ctx_lnh = document.getElementById("pizarra_lnh");
        var image_lnh = ctx_lnh.toDataURL(); // data:image/png....
        document.getElementById('base64_lnh').value = image_lnh;
     },false);    
    

</script>