<form class="card background_panel">
	<div class="row">                      
		  @csrf
		<div class="row">
			  <div class="margin_left_20px">
				  	<small>DNI</small>      
				   	@if($paciente != null && $paciente->dni != null)
				   		<input type="text" class="form-control input_width_150px" id="dni" name="dni"  value="{{$paciente->dni}}" readonly/>
				   	@else
				   		<input type="text" class="form-control input_width_150px" id="dni" name="dni"  value="" readonly/>
				   	@endif
			  </div>

			  <div class="margin_left_20px">
				  <small>Nombre</small>      
				  @if($paciente != null && $paciente->nombre != null)
				  	<input type="text" class="form-control input_width_250px" id="nombre" name="nombre" value="{{$paciente->nombre}}" readonly/>
				  @else
				  	<input type="text" class="form-control input_width_250px" id="nombre" name="nombre"   value="" readonly />
				  @endif
			  </div>

			  <div class="margin_left_20px">
				  <small>Apellido</small>      
				  @if($paciente != null && $paciente->apellido != null)
				  	<input type="text" class="form-control input_width_250px" id="apellido" name="apellido"  value="{{$paciente->apellido}}" readonly/>
				  @else
				  	<input type="text" class="form-control input_width_250px" id="apellido" name="apellido"  readonly/>
				  @endif
			  </div>

			  <div class="margin_left_20px">
			  	  <small>Fecha Nacimiento</small>
			  	  @if($paciente != null && $paciente->fecha_nacimiento != null)
				  	<input type="text" class="form-control input_width_150px" id="fecha_nacimiento" name="fecha_nacimiento"  value="{{$paciente->fecha_nacimiento}}" readonly />
				  @else      
				  <input type="text" class="form-control input_width_150px" id="fecha_nacimiento" name="fecha_nacimiento"  readonly/>
				  @endif
			 </div>

			 <div class="margin_left_20px">
			  <small>Edad</small>     
			  @if($paciente != null && $paciente->fecha_nacimiento != null)   
			  	<input type="text" class="form-control input_width_150px" id="edad" name="edad"  readonly />
			  @else
			  	<input type="text" class="form-control input_width_150px" id="edad" name="edad"   readonly/>
			  @endif
			</div>

			<div class="margin_left_20px">
			  <small>Localidad</small>     
			  @if($paciente != null && $paciente->localidad != null)   
			  	<input type="text" class="form-control input_width_350px" id="localidad" name="localidad"  value="{{$paciente->localidad}}" readonly />
			  @else
			  	<input type="text" class="form-control input_width_350px" id="localidad" name="localidad"   readonly/>
			  @endif
			</div>

			<div class="margin_left_20px">
			  <small>Domicilio</small>   
			   @if($paciente != null && $paciente->domicilio != null)     
			   	<input type="text" class="form-control input_width_350px" id="domicilio" name="domicilio"  value="{{$paciente->domicilio}}"  readonly/>
			   @else
			  	<input type="text" class="form-control input_width_350px" id="domicilio" name="domicilio" readonly />
			  @endif
			</div>

			<div class="margin_left_20px">
			  <small>Mail</small>      
			  @if($paciente != null && $paciente->mail != null)     
			  	<input type="text" class="form-control input_width_350px" id="mail" name="mail" value="{{$paciente->mail}}" readonly />
			  @else
			  	<input type="text" class="form-control input_width_350px" id="mail" name="mail"  readonly />
			  @endif
			</div>		
			 			 
		</div>						

		<div class="row">

			<div class="margin_left_20px">
			  <small>Telefono</small>      
			  @if($paciente != null && $paciente->telefono != null)     
			  	<input type="text" class="form-control input_width_150px" id="telefono" name="telefono"  value="{{$paciente->telefono}}" readonly />
			  @else
			   <input type="text" class="form-control input_width_150px" id="telefono" name="telefono"   readonly />
			  @endif
			</div>
			
			<div class="margin_left_20px">
			  <small>Obra Social</small>      
			  @if($paciente != null && $paciente->obra_social != null)    
			  	<input type="text" class="form-control" id="obrasocial" name="obra_social" value="{{$paciente->obra_social}}" readonly />
			  @else
			  	<input type="text" class="form-control" id="obrasocial" name="obra_social"  readonly />
			  @endif
			</div>

			<div class="margin_left_20px">
			  <small>N°Afiliado</small>      
			  @if($paciente != null && $paciente->numero_afiliado != null)    
			  	<input type="text" class="form-control" id="numero_afiliado" name="numero_afiliado" value="{{$paciente->numero_afiliado}}" readonly />
			  @else
			  	<input type="text" class="form-control" id="numero_afiliado" name="numero_afiliado" readonly />
			  @endif
			</div>  

			<div class="margin_left_20px">
			  <small>Tipo Plan</small>      
			  @if($paciente != null && $paciente->obra_social_plan != null)    
			  	<input type="text" class="form-control" id="plan_obra_social" name="plan_obra_social" value="{{$paciente->obra_social_plan}}" readonly />
			  @else
			  	<input type="text" class="form-control" id="plan_obra_social" name="plan_obra_social" readonly  />
			  @endif
			</div>
		</div>
		<div class="row">
			<div class="margin_left_20px">
				  <small>Obra Social Opcional</small>      
				  @if($paciente != null && $paciente->obra_social_opcional != null)    
				  	<input type="text" class="form-control" id="obrasocialopcional" name="obra_social_opcional" value="{{$paciente->obra_social_opcional}}" readonly />
				  @else
				  	<input type="text" class="form-control" id="obrasocialopcional" name="obra_social_opcional"  readonly />
				  @endif
				</div>

				<div class="margin_left_20px">
				  <small>N°Afiliado Opcional</small>      
				  @if($paciente != null && $paciente->numero_afiliado_opcional != null)    
				  	<input type="text" class="form-control" id="numero_afiliado_opcional" name="numero_afiliado_opcional" value="{{$paciente->numero_afiliado_opcional}}" readonly />
				  @else
				  	<input type="text" class="form-control" id="numero_afiliado_opcional" name="numero_afiliado_opcional" readonly />
				  @endif
				</div>  

				<div class="margin_left_20px">
				  <small>Tipo Plan Opcional</small>      
				  @if($paciente != null && $paciente->obra_social_plan_opcional != null)    
				  	<input type="text" class="form-control" id="plan_obra_social_opcional" name="plan_obra_social_opcional" value="{{$paciente->obra_social_plan_opcional}}" readonly />
				  @else
				  	<input type="text" class="form-control" id="plan_obra_social_opcional" name="plan_obra_social_opcional" readonly  />
				  @endif
				</div>	

		</div>

		
					
		


	</div>	
</form>

<script type="text/javascript">
	
	function calcularEdad(){
		var fechaNacimiento = document.getElementById("fecha_nacimiento").value;

		var fechaActual = new Date(); 
    	var mes = fechaActual.getMonth()+1;
    	var dia = fechaActual.getDate();
    	var anio = fechaActual.getFullYear();
    	var fechaHoy = anio+"-"+mes+"-"+dia;

		var edad_aux_array = calcularEdad4(fechaNacimiento, fechaHoy);
		document.getElementById("edad").value = edad_aux_array;

		var fechaMostrarAux = document.getElementById("fecha_nacimiento").value;
		
		var fechaMostrarArray = fechaNacimiento.split("-");
		if(fechaMostrarArray[1] != null){
			var nuevaFechaMostrar = fechaMostrarArray[2]+"/"+fechaMostrarArray[1]+"/"+fechaMostrarArray[0];	
			document.getElementById("fecha_nacimiento").value = nuevaFechaMostrar;
		}

		/*var fechaMostrarAux = document.getElementById("fecha_nacimiento").value;
		
		var fechaMostrarArray = fechaMostrarAux.split("-");
		if(fechaMostrarArray[1] != null){
			var nuevaFechaMostrar = fechaMostrarArray[2]+"/"+fechaMostrarArray[1]+"/"+fechaMostrarArray[0];	
			document.getElementById("fecha_nacimiento").value = nuevaFechaMostrar;
		
			var edad_aux = edad_aux_array.split("-");
			var edad = '';
			if(edad_aux[0] != 0){
				edad = edad + edad_aux[0];
				if(edad == 1)
					edad +=" año, "
				else
					edad +=" años, "
			}
			if(edad_aux[1] != 0){
				edad = edad + edad_aux[1]+" meses y ";
			}
			edad = edad + edad_aux[2]+" dias ";	
			document.getElementById("edad").value = edad; 
		}
		*/
	}


	function calcularEdad2(fecha) {		
       	
        var values = fecha.split('-');
        var dia = parseInt(values[2]);
        var mes = parseInt(values[1]);
        var ano = parseInt(values[0]);

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth() + 1;
        var ahora_dia = fecha_hoy.getDate();                  	                  

        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;  
        //alert(ahora_ano + 1900 - parseInt(ano));             
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }

        // calculamos los meses
        var meses = 0;

        if (ahora_mes > mes && dia > ahora_dia)
            meses = ahora_mes - mes - 1;
        else if (ahora_mes > mes)
            meses = ahora_mes - mes
        if (ahora_mes < mes && dia < ahora_dia)
            meses = 12 - (mes - ahora_mes);
        else if (ahora_mes < mes)
            meses = 12 - (mes - ahora_mes + 1);
        if (ahora_mes == mes && dia > ahora_dia)
            meses = 11;

        // calculamos los dias
        var dias = 0;
        if (ahora_dia > dia)
            dias = ahora_dia - dia;
        if (ahora_dia < dia) {           
            ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
        }

        return edad + "-" + meses + "-" + dias;
    }

    function esNumero(strNumber) {
	    if (strNumber == null) return false;
	    if (strNumber == undefined) return false;
	    if (typeof strNumber === "number" && !isNaN(strNumber)) return true;
	    if (strNumber == "") return false;
	    if (strNumber === "") return false;
	    var psInt, psFloat;
	    psInt = parseInt(strNumber);
	    psFloat = parseFloat(strNumber);
	    return !isNaN(strNumber) && !isNaN(psFloat);
	}

	function calcularEdad4(fecha_nacimiento, fecha_hoy) {
  	
	var oneday = 1000 * 60 * 60 * 24;
	var oneweek = oneday * 7;

	var fecha_nacimiento_aux = fecha_nacimiento.split("-");
	var fecha_hoy_aux = fecha_hoy.split("-");

	var D1 = parseFloat(fecha_nacimiento_aux[2]);
	var M1 = parseFloat(fecha_nacimiento_aux[1]);
	var Y1 = parseFloat(fecha_nacimiento_aux[0]);
	
	var D2 = parseFloat(fecha_hoy_aux[2]);
	var M2 = parseFloat(fecha_hoy_aux[1]);
	var Y2 = parseFloat(fecha_hoy_aux[0]);

	var Y = "";
	var M = "";
	var D = "";	

	var X1 = new Date (Y1,M1-1,D1);
	var X2 = new Date (Y2,M2-1,D2);
	

	if (Y1 < 100) YY1 = X1.getFullYear() - 1900;
		else YY1 = X1.getFullYear();
	if (Y2 < 100) YY2 = X2.getFullYear() - 1900;
		else YY2 = X2.getFullYear();

	var A = YY2-YY1;
	var B = new Date (Y1+A,M1-1,D1);
	var C = new Date (Y2,X2.getMonth(),0);
	var F = new Date (Y2,M2-1,0);

	if (C.getDate()-X1.getDate() < 0) Z = 0;
	else Z = C.getDate()-X1.getDate();
	
	if (X2.getTime() < X1.getTime()) {	
	}

	else {
	
		if (X2.getTime() < B.getTime()) Y = A-1;
		else Y = A;

	// months,...
	var Mx = X2.getMonth() - X1.getMonth()
    + (12 * A);

	if (X2.getDate() < X1.getDate()){
    Mx--;
	}

	if 	(X2.getMonth() - X1.getMonth() + (12 * A)>11) M = Mx - Y * 12;
	else M = Mx;

// and days.
	if (X2.getDate() >= X1.getDate()) D = X2.getDate() - X1.getDate();	
	else  D = (X2.getTime() - F.getTime()) / (oneday) + Z;

	}
		return Y;
		//return Y+"-"+M+"-"+D;
	}

</script>

