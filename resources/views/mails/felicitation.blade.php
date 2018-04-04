@extends('layout.mails')
@section('content')
	<div class="container">
		<div class="mail-container columns is-vcentered">
			<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<div class="mail-content column ">
							<p>Hola <strong>@if(isset($student->name)){{$student->name}}@else nombre @endif</strong>,</p>
							<p>Esta semana has aprendido <strong>@if(isset($student)){{$student->progressionsSinceLastWeek()}}@else BLANK @endif</strong> temas nuevos en tu Módulo de Preparación. ¡Felicidades! Estás avanzando a buen paso, sigue así 😊.</p>
							<p>La constancia es la llave hacia el progreso.</p>
							<p>Atentamente,</p>
							<p>Coordinación Proyecto UTP-ALEKS PPL</p>
						</div>
					</td>
				</tr>
			</table> 
		</div>
	</div>
@endsection
