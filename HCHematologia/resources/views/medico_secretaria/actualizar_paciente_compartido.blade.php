<form> 
  @if($es_secretaria == 1)
    <div class="row">
    <h4>Buscar Paciente:</h4>      
    <input class="margin_left_5px" type="text" id="dni_paciente" name="dni_paciente" value="" placeholder="Ingrese el DNI" onchange="validarPacienteExiste(this.value)" />
    <button class="rodri_button_calendario divMarginCel margin_left_5px" type="button" onclick="mostrarModalBuscar()"><img class="card-img-top" src="img/iconos/buscar.png"/></button>        
  </div>
  <br>
  @endif

  <div class="row">
      <div class="col-md-1 margin_left_30px"></div>
        <div class="col-md-5">
          @csrf    
          <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
          <input type="hidden" id="medico_id" name="medico_id" value="{{$medico_id}} "/>

          <label for="text" class="col-sm-0 control-label">DNI</label>
          @if($paciente == null) 
            @if($es_secretaria == 1)
              <input type="text" class="form-control input_width_150px" id="dni" name="dni" placeholder="DNI" value="" required />
            @else
              <input type="text" class="form-control input_width_150px" id="dni" name="dni" placeholder="DNI" value="" required/>
            @endif
          {!! $errors->first('dni','<small>:message</small><br>') !!}                     
          <input type="hidden" id="paciente_id" name="paciente_id" value=""/>
          @else
          <input type="text" class="form-control input_width_150px" id="dni" name="dni" value="{{$paciente->dni}}"  required/>  
          <input hidden type="text" id="paciente_id" name="paciente_id" value="{{$paciente->id}} " onchange="validarPacienteExisteId()"/>                          
          @endif    

          <label for="text" class="col-sm-0 control-label">Nombre</label>      
          <input type="text" class="form-control input_width_250px" id="nombre" name="nombre"  placeholder="Nombre Paciente" value="" required />

          <label for="text" class="col-sm-0 control-label">Apellido</label>      
          <input type="text" class="form-control input_width_250px" id="apellido" name="apellido"  placeholder="Apellido Paciente" required />

          <div>
            <label for="text" class="col-sm-0 control-label">Fecha Nacimiento</label><br>
            <div class="row">
              <div class="input_width_60px margin_left_20px">
                <input type="text" maxlength="2" class="form-control" id="fecha_nacimiento_dia" name="fecha_nacimiento"   />
              </div>
              <label for="text" class="col-sm-0 control-label margin_left_5px margin_top_5px margin_right_5px">/</label>
              <div class="input_width_60px margin_left_5px">
                <input type="text" maxlength="2" class="form-control" id="fecha_nacimiento_mes" name="fecha_nacimiento"  />
              </div>
              <label for="text" class="col-sm-0 control-label margin_left_5px margin_top_5px margin_right_5px">/</label>
              <div class="input_width_110px">   
                <input type="text" maxlength="4" class="form-control" id="fecha_nacimiento_anio" name="fecha_nacimiento"  />
              </div>
            </div>
          </div>

          
          <label for="text" class="col-sm-0 control-label">Localidad</label>      
          <input type="text" class="form-control input_width_350px" id="localidad" name="localidad"  placeholder="Localidad"  />

          <label for="text" class="col-sm-0 control-label">Domicilio</label>      
          <input type="text" class="form-control input_width_350px" id="domicilio" name="domicilio"  placeholder="Domicilio"  />

          <label for="text" class="col-sm-0 control-label">Telefono</label>      
          <input type="text" class="form-control input_width_250px" id="telefono" name="telefono"  placeholder="Telefono solo numeros (EJ: 2915050050)"  />
          
          <br>                
  </div>

 <div class="col-md-5">

          <label for="text" class="col-sm-0 control-label">Mail</label>      
          <input type="text" class="form-control input_width_350px" id="mail" name="mail" placeholder="Mail"  />

          <label for="text" class="col-sm-0 control-label">Obra Social</label>      
          <input type="text" class="form-control input_width_250px" id="obrasocial" name="obra_social" placeholder="Obra Social"  />

          <label for="text" class="col-sm-0 control-label">N° Afiliado</label>      
          <input type="text" class="form-control input_width_250px" id="numero_afiliado" name="numero_afiliado" placeholder="N° Afiliado"  />
          
          <label for="text" class="col-sm-0 control-label">Plan</label>      
          <input type="text" class="form-control input_width_250px" id="plan_obra_social" name="plan_obra_social" placeholder="Plan Obra Social"  />

          <label for="text" class="col-sm-0 control-label">Obra Social Opcional</label>      
          <input type="text" class="form-control input_width_250px" id="obra_social_opcional" name="obra_social" placeholder="Obra Social"  />

          <label for="text" class="col-sm-0 control-label">N° Afiliado Opcional</label>      
          <input type="text" class="form-control input_width_250px" id="numero_afiliado_opcional" name="numero_afiliado" placeholder="N° Afiliado"  />
          
          <label for="text" class="col-sm-0 control-label">Plan Opcional</label>      
          <input type="text" class="form-control input_width_250px" id="plan_obra_social_opcional" name="plan_obra_social" placeholder="Plan Obra Social"  />
  </div>  
  </div>  

<div class="contenedor3">            
  <button onclick="actualizarPaciente()" type="button" id="btnContinuar" class="rodri_button contenido3">Actualizar</button>
</div>
<br>
</form>



@include('modal.snackbar')

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function validarPacienteExisteId(){
    var paciente_id = document.getElementById("paciente_id").value;     
    var user_id = document.getElementById("user_id").value;     
    var medico_id = document.getElementById("medico_id").value;  

    $.ajax({
       type:'POST',
       dataType:'JSON',
       url:'/consultar_paciente_id',
       data:{paciente_id :paciente_id, user_id:user_id, medico_id:medico_id, _token: '{{csrf_token()}}'},
       success:function(data){                
          var nombre = document.getElementById("nombre");
          var apellido = document.getElementById("apellido");
          var dni = document.getElementById("dni");
          var telefono = document.getElementById("telefono");
          var domicilio = document.getElementById("domicilio");
          var localidad = document.getElementById("localidad");
          var mail = document.getElementById("mail");
          var obrasocial = document.getElementById("obrasocial");          
          var fecha_nacimiento_dia = document.getElementById("fecha_nacimiento_dia");
          var fecha_nacimiento_mes = document.getElementById("fecha_nacimiento_mes");
          var fecha_nacimiento_anio = document.getElementById("fecha_nacimiento_anio");          

          var obrasocial = document.getElementById("obrasocial");          
          var plan_obra_social = document.getElementById("plan_obra_social");
          var numero_afiliado = document.getElementById("numero_afiliado");                    

          var obra_social_opcional = document.getElementById("obra_social_opcional");          
          var plan_obra_social_opcional = document.getElementById("plan_obra_social_opcional");
          var numero_afiliado_opcional = document.getElementById("numero_afiliado_opcional");                    

           if(data.paciente != null) {                            
              nombre.value = data.paciente.nombre;
              apellido.value = data.paciente.apellido;
              dni.value = data.paciente.dni;
              telefono.value = data.paciente.telefono;
              domicilio.value = data.paciente.domicilio;
              localidad.value = data.paciente.localidad;
              mail.value = data.paciente.mail;
              obrasocial.value = data.paciente.obra_social;              
              numero_afiliado.value = data.paciente.numero_afiliado;              
              plan_obra_social.value = data.paciente.obra_social_plan;

              obra_social_opcional.value = data.paciente.obra_social_opcional;              
              numero_afiliado_opcional.value = data.paciente.numero_afiliado_opcional;              
              plan_obra_social_opcional.value = data.paciente.obra_social_plan_opcional;

              if(data.paciente.fecha_nacimiento.localeCompare('')!=0){
                var arrayFechaNacimiento = data.paciente.fecha_nacimiento.split('-');
                 if(arrayFechaNacimiento[0].localeCompare("1000")==0){
                  fecha_nacimiento_anio.value = "";
                  fecha_nacimiento_mes.value = "";
                  fecha_nacimiento_dia.value = "";
                 } else {
                  fecha_nacimiento_anio.value = arrayFechaNacimiento[0];
                  fecha_nacimiento_mes.value = arrayFechaNacimiento[1];
                  fecha_nacimiento_dia.value = arrayFechaNacimiento[2];
                }
              } 
            } else{ 
              nombre.value = '';
              apellido.value = '';              
              telefono.value = '';
              domicilio.value = '';
              localidad.value = '';
              mail.value = '';
              obrasocial.value = '';
              numero_afiliado.value = '';              
              plan_obra_social.value = '';              
              obra_social_opcional.value = '';
              numero_afiliado_opcional.value = '';              
              plan_obra_social_opcional.value = '';              
              fecha_nacimiento_dia.value = '';  
              fecha_nacimiento_mes.value = '';             
              fecha_nacimiento_anio.value = '';               
            }                        
         }
    });     
  }

  function validarPacienteExiste(dni){
    if(dni == null){
      dni = document.getElementById("dni").value;         
    }
    var user_id = document.getElementById("user_id").value;     
    var medico_id = document.getElementById("medico_id").value;  
    
    $.ajax({
       type:'POST',
       dataType:'JSON',
       url:'/consultar_paciente',
       data:{dni_paciente :dni, user_id:user_id, medico_id:medico_id, _token: '{{csrf_token()}}'},
       success:function(data){                
          var paciente_id = document.getElementById("paciente_id");
          var nombre = document.getElementById("nombre");
          var apellido = document.getElementById("apellido");
          var dni = document.getElementById("dni");
          var telefono = document.getElementById("telefono");
          var domicilio = document.getElementById("domicilio");
          var localidad = document.getElementById("localidad");
          var mail = document.getElementById("mail");
          var obrasocial = document.getElementById("obrasocial");          
          var fecha_nacimiento_dia = document.getElementById("fecha_nacimiento_dia");
          var fecha_nacimiento_mes = document.getElementById("fecha_nacimiento_mes");
          var fecha_nacimiento_anio = document.getElementById("fecha_nacimiento_anio");          

          var obrasocial = document.getElementById("obrasocial");          
          var plan_obra_social = document.getElementById("plan_obra_social");
          var numero_afiliado = document.getElementById("numero_afiliado");                    

          var obra_social_opcional = document.getElementById("obra_social_opcional");          
          var plan_obra_social_opcional = document.getElementById("plan_obra_social_opcional");
          var numero_afiliado_opcional = document.getElementById("numero_afiliado_opcional");                    

           if(data.paciente != null) {  
              paciente_id.value = data.paciente.id;                          
              nombre.value = data.paciente.nombre;
              apellido.value = data.paciente.apellido;
              dni.value = data.paciente.dni;
              telefono.value = data.paciente.telefono;
              domicilio.value = data.paciente.domicilio;
              localidad.value = data.paciente.localidad;
              mail.value = data.paciente.mail;
              obrasocial.value = data.paciente.obra_social;              
              numero_afiliado.value = data.paciente.numero_afiliado;              
              plan_obra_social.value = data.paciente.obra_social_plan;

              obra_social_opcional.value = data.paciente.obra_social_opcional;              
              numero_afiliado_opcional.value = data.paciente.numero_afiliado_opcional;              
              plan_obra_social_opcional.value = data.paciente.obra_social_plan_opcional;

              if(data.paciente.fecha_nacimiento.localeCompare('')!=0){
                var arrayFechaNacimiento = data.paciente.fecha_nacimiento.split('-');
                 if(arrayFechaNacimiento[0].localeCompare("1000")==0){
                  fecha_nacimiento_anio.value = "";
                  fecha_nacimiento_mes.value = "";
                  fecha_nacimiento_dia.value = "";
                 } else {
                  fecha_nacimiento_anio.value = arrayFechaNacimiento[0];
                  fecha_nacimiento_mes.value = arrayFechaNacimiento[1];
                  fecha_nacimiento_dia.value = arrayFechaNacimiento[2];
                }
              } 
            } else{ 
              nombre.value = '';
              apellido.value = '';              
              telefono.value = '';
              domicilio.value = '';
              localidad.value = '';
              mail.value = '';
              obrasocial.value = '';
              numero_afiliado.value = '';              
              plan_obra_social.value = '';              
              obra_social_opcional.value = '';
              numero_afiliado_opcional.value = '';              
              plan_obra_social_opcional.value = '';              
              fecha_nacimiento_dia.value = '';  
              fecha_nacimiento_mes.value = '';             
              fecha_nacimiento_anio.value = '';               
            }                        
         }
    });     
  }

  function actualizarPaciente(){     
    var paciente_id = document.getElementById("paciente_id").value;  
    var medico_id = document.getElementById("medico_id").value;  
    var user_id = document.getElementById("user_id").value;
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var dni = document.getElementById("dni").value;
    
    var telefono = document.getElementById("telefono").value;
    var domicilio = document.getElementById("domicilio").value;
    var localidad = document.getElementById("localidad").value;
    var mail = document.getElementById("mail").value;
    var obrasocial = document.getElementById("obrasocial").value; 
    var numero_afiliado = document.getElementById("numero_afiliado").value; 
    var plan = document.getElementById("plan_obra_social").value;         

    var obra_social_opcional = document.getElementById("obra_social_opcional").value; 
    var numero_afiliado_opcional = document.getElementById("numero_afiliado_opcional").value; 
    var plan_opcional = document.getElementById("plan_obra_social_opcional").value;         
    
    var fecha_nacimiento_dia = document.getElementById("fecha_nacimiento_dia").value;     
    var fecha_nacimiento_mes = document.getElementById("fecha_nacimiento_mes").value;     
    var fecha_nacimiento_anio = document.getElementById("fecha_nacimiento_anio").value;
    
    if((fecha_nacimiento_dia == null)||(fecha_nacimiento_dia.localeCompare('')==0)
      ||(fecha_nacimiento_mes == null)||(fecha_nacimiento_mes.localeCompare('')==0)
      ||(fecha_nacimiento_anio == null)||(fecha_nacimiento_anio.localeCompare('')==0)){
      var fecha_nacimiento = null;
    } else {
      var fecha_nacimiento = fecha_nacimiento_anio+"/"+fecha_nacimiento_mes+"/"+fecha_nacimiento_dia;  
    }
  
     $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/actualizar_datos_paciente',
           data:{paciente_id:paciente_id, medico_id:medico_id, user_id:user_id, dni :dni,nombre:nombre,apellido:apellido,fecha_nacimiento:fecha_nacimiento,telefono:telefono,mail:mail,obra_social:obrasocial,numero_afiliado:numero_afiliado,obra_social_plan:plan, localidad:localidad, domicilio:domicilio, obra_social_opcional:obra_social_opcional, numero_afiliado_opcional:numero_afiliado_opcional, plan_opcional:plan_opcional, _token: '{{csrf_token()}}'},
           success:function(data){              
                       
            if(data.paciente!=null){
              if(data.huboUnCambio == 1){
                mostrarSnackbar("Los datos han sido actualizados");
                location.reload();
              }
              document.getElementById("nombre").value = data.paciente.nombre;     
              document.getElementById("apellido").value = data.paciente.apellido;
              document.getElementById("dni").value = data.paciente.dni; 
              document.getElementById("telefono").value = data.paciente.telefono;
              document.getElementById("domicilio").value = data.paciente.domicilio;
              document.getElementById("localidad").value = data.paciente.localidad;
              document.getElementById("mail").value = data.paciente.mail;
              document.getElementById("obrasocial").value = data.paciente.obra_social;
              document.getElementById("numero_afiliado").value = data.paciente.numero_afiliado;
              document.getElementById("plan_obra_social").value = data.paciente.obra_social_plan;
              document.getElementById("obra_social_opcional").value = data.paciente.obra_social_opcional;
              document.getElementById("numero_afiliado_opcional").value = data.paciente.numero_afiliado_opcional;
              document.getElementById("plan_obra_social_opcional").value = data.paciente.obra_social_plan_opcional;
              var arrayFechaNacimiento = data.paciente.fecha_nacimiento.split('-');
             if(arrayFechaNacimiento[0].localeCompare("1000")==0){
                fecha_nacimiento_anio.value = "";
                fecha_nacimiento_mes.value = "";
                fecha_nacimiento_dia.value = "";
              } else {
                fecha_nacimiento_anio.value = arrayFechaNacimiento[0];
                fecha_nacimiento_mes.value = arrayFechaNacimiento[1];
                fecha_nacimiento_dia.value = arrayFechaNacimiento[2];
              }
            } else {
              document.getElementById("nombre").value = "";     
              document.getElementById("apellido").value = "";
              document.getElementById("dni").value = "";
              document.getElementById("fecha_nacimiento_dia").value = "";
              document.getElementById("fecha_nacimiento_mes").value = "";
              document.getElementById("fecha_nacimiento_anio").value = ""; 
              document.getElementById("telefono").value = "";
              document.getElementById("domicilio").value = "";
              document.getElementById("localidad").value = "";
              document.getElementById("mail").value = "";
              document.getElementById("obrasocial").value = "";
              document.getElementById("numero_afiliado").value = "";
              document.getElementById("plan_obra_social").value = "";
              document.getElementById("obra_social_opcional").value = "";
              document.getElementById("numero_afiliado_opcional").value = "";
              document.getElementById("plan_obra_social_opcional").value = "";
            }
           }
        });
  }

  function mostrarModalBuscar(){        
    $("#modalBuscarPacienteSecretaria").modal();  
  }

  function seleccionarPaciente(dni){
    document.getElementById("dni_paciente").value = dni;    
    document.getElementById("dni").value = dni;    
    $("#modalBuscarPacienteSecretaria").modal('hide');                
    validarPacienteExiste(dni);
  }

  window.onload=function() {  
    /*var dni_existe = document.getElementById("dni").value;
    if(dni_existe.localeCompare("")!=0)      
      validarPacienteExiste(); */

    var dni_existe = document.getElementById("dni").value;
    var _id_existe = document.getElementById("paciente_id");
    mostrarPanelPaciente(true);
    mostrarPanelHistoriaClinica(false);
    if(_id_existe != null){
      var id_existe = document.getElementById("paciente_id").value;
      if(dni_existe.localeCompare("")!=0)      
        validarPacienteExiste();
      //if(id_existe != null)
        //validarPacienteExisteId();
    }
  }

 </script>