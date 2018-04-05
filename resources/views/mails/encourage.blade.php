@extends('layout.mails')
@section('content')
	<div class="container">
		<div class="mail-container columns is-vcentered">
			<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<div class="mail-content column ">
							<p>Hola <strong>@if(isset($student->first_name)){{$student->first_name}}@else nombre @endif</strong>,</p>
							<p>Esta semana has aprendido <strong>@if(isset($student)){{$student->progressSinceLastWeek()}}@else BLANK @endif</strong> temas nuevos en tu Módulo de Preparación. Estás avanzando, pero tú puedes dar más. Recuerda que el esfuerzo que dediques ahora a ALEKS te ayudará después en tus cursos de matemáticas en la UTP 🤓.</p>
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
