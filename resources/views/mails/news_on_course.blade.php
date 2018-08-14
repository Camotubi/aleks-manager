@extends('layout.mails')
@section('content')
	<div class="container">
		<div class="mail-container columns is-vcentered">
			<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<div class="mail-content column ">
							<p>Hola <strong>@if(isset($student->first_name)){{$student->first_name}}@else nombre @endif</strong>,</p>
							<p>Queríamos darte la noticia de que si te aplicas en la plataforma ALEKS PPL podras entrar a clases en la UTP en marzo y no en enero. De esta manera podrás disfrutar mas tu verano <span style="font-size:20px;">🤓</span>.</p>
                            <img width="100%" src="data:image/png;base64,{{base64_encode(file_get_contents(base_path('public/img/aleks_skip_verano.jpg')))}}" alt="">

							<p>Atentamente,</p>
							<p>Coordinación Proyecto UTP-ALEKS PPL</p>
						</div>
					</td>
				</tr>
			</table> 
		</div>
	</div>
@endsection
