<style>
    .class_canvas_gm {
        width: 200px;
        height: 400px;
        background-color: #FFF;        
        border-color: #000;
        /*border: 1px black solid;*/
    } 
</style>    
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
        <canvas class="class_canvas_gm" id="pizarra_gm"></canvas>
        <img id="pizarra_2_gm" hidden src=""/>
        <br>
                      
        </div>                      
        
    </div>
    @if($nueva_consulta != 0)
      <div class="row contenedor3">
          <div class="contenido3">            
              <button type="button" id="nuevoCuerpoId_gm" onclick="nuevoCuerpoGm()" class="rodri_button_aceptar margin_left_20px">NUEVO</button>            
              <button hidden id="guardarCuerpoId_gm" onclick="guardarCuerpoGm()" class="rodri_button_aceptar margin_left_20px">GUARDAR</button>
              <button hidden id="borrarCuerpoId_gm" onclick="borrarDibujoGm()" type="button" class="rodri_button_cancelar margin_left_20px">BORRAR</button>                          
              
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

    //======================================================================
    // VARIABLES
    //======================================================================
    var miCanvas_gm = document.querySelector('#pizarra_gm');
    var strokeColor_gm = "#D100A4";
    let lineas_gm = [];
    let correccionX_gm = 0;
    let correccionY_gm = 0;
    let pintarLinea_gm = false;

    let posicion_gm = miCanvas_gm.getBoundingClientRect()
    correccionX_gm = posicion_gm.x;
    correccionY_gm = posicion_gm.y;

    miCanvas_gm.width = 200;
    miCanvas_gm.height = 400;

    var img_gm = new Image();
    if(document.getElementById("img_cargada_gm") != null){
       // img.src = "storage/app/images_base64/"+document.getElementById("img_cargada").value;
        img_gm.src = "img/"+document.getElementById("img_cargada_gm").value;        
    } else {
        img_gm.src = "img/imagen_modelo/esqueleto.PNG";
    } 
    //var contexto = canvas.getContext("2d");
    
    //======================================================================
    // FUNCIONES
    //======================================================================  

    img_gm.onload = function(){ 
            
      //var img_cargada = document.getElementById("img_cargada").value;
      //alert("aa "+img_cargada);
      let ctx_gm = miCanvas_gm.getContext('2d');
      ctx_gm.drawImage(img_gm, 0, 0);            
    }

    /**
     * Funcion que empieza a dibujar la linea
     */
    function empezarDibujoGm () {      
        pintarLinea_gm = true;
        lineas_gm.push([]);
    };

    function borrarDibujoGm () {
        location.reload();
        /*var canvas = document.getElementById("pizarra");        
        let ctx = miCanvas.getContext('2d')
        clearCanvas(ctx, canvas);        
        ctx.drawImage(img, 0, 0);
        let lineas = [];        */
    };  

    /**
     * Funcion dibuja la linea
     */
    function dibujarLineaGm (event) {
        event.preventDefault();
        if (pintarLinea_gm) {
            let ctx_gm = miCanvas_gm.getContext('2d')
            // Estilos de linea
            ctx_gm.lineJoin = ctx_gm.lineCap = 'round';
            ctx_gm.lineWidth = 2;
            // Color de la linea
            ctx_gm.strokeStyle = strokeColor_gm;
            // Marca el nuevo punto
            let nuevaPosicionX_gm = 0;
            let nuevaPosicionY_gm = 0;
            if (event.changedTouches == undefined) {
                // Versión ratón
                nuevaPosicionX_gm = event.layerX;
                nuevaPosicionY_gm = event.layerY;
            } else {
                // Versión touch, pantalla tactil
                nuevaPosicionX_gm = event.changedTouches[0].pageX - correccionX_gm;
                nuevaPosicionY_gm = event.changedTouches[0].pageY - correccionY_gm;
            }
            // Guarda la linea
            lineas_gm[lineas_gm.length - 1].push({
                x: nuevaPosicionX_gm,
                y: nuevaPosicionY_gm
            });
            // Redibuja todas las lineas guardadas
            ctx_gm.beginPath();
            lineas_gm.forEach(function (segmento) {
                ctx_gm.moveTo(segmento[0].x, segmento[0].y);
                segmento.forEach(function (punto, index) {
                    ctx_gm.lineTo(punto.x, punto.y);
                });
            });
            ctx_gm.stroke();
        }
    }

    /**
     * Funcion que deja de dibujar la linea
     */
    function pararDibujarGm() {
        pintarLinea_gm = false;
    }

    //======================================================================
    // EVENTOS
    //======================================================================

    // Eventos raton
    miCanvas_gm.addEventListener('mousedown', empezarDibujoGm, false);
    miCanvas_gm.addEventListener('mousemove', dibujarLineaGm, false);
    miCanvas_gm.addEventListener('mouseup', pararDibujarGm, false);

    // Eventos pantallas táctiles
    miCanvas_gm.addEventListener('touchstart', empezarDibujoGm, false);
    miCanvas_gm.addEventListener('touchmove', dibujarLineaGm, false);
          
    document.getElementById('seccion_cuerpo_gm').addEventListener("submit",function(e){
      var ctx_gm = document.getElementById("pizarra_gm");
        var image_gm = ctx_gm.toDataURL(); // data:image/png....
        document.getElementById('base64_gm').value = image_gm;
     },false);    
    

</script>