@extends('layout.mails')
@section('content')
    <div class="container">
        <div class="mail-container columns is-vcentered">
            <table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center">
                        <div class="mail-content column " style="
                            color:rgb(84, 165, 218);
                            ">
                            <p>Hola 
                                @if(isset($student))
                                    {{$student->name}}
                                @else
                                    nombre
                                @endif
                                ,</p>
                            <p>Hemos notado que llevas un rato sin utilizar la plataforma de Aleks. La constancia es la llave hacia el progreso.</p>
                            @if($student->moduleProgressions()->exists()))
                                <p>Hablando de progreso, aqui tenemos un par de estadisticas sobre tu progreso.</p>
                                <br>
                                <br>
                                <table class="table">
                                    <tr>
                                        <th>Modulo</th>
                                        <th>Dominio Inicial</th>
                                        <th>Dominio Actual</th>
                                        <th>Total de Topicos Aprendidos</th>
                                        <th>Total de Topicos Aprendidos por hora</th>
                                    </tr>
                                    <tr>
                                        <td>{{$student->moduleProgressions()->first()->prep_and_learning_module}}</td>
                                        <td>{{$student->moduleProgressions()->first()->initial_mastery}}</td>
                                        <td>{{$student->moduleProgressions()->first()->current_mastery}}</td>
                                        <td>{{$student->moduleProgressions()->first()->current_number_of_topics_learned}}</td>
                                        <td>{{$student->moduleProgressions()->first()->current_number_of_topics_learned_per_hour}}</td>
                                    </tr>
                                </table>
                            @endif
                <br>
            <p>¡Esperamos verte de vuelta!</p>
            </div>
        </div>
        </td>
    </tr>
</table> 
    </div>
@endsection

