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
                            <p>Hemos notado que no has avanzado mucho en los modulos de aprendisaje. Esta herramienta te sera de mucha utilidad en tus proximos cursos en el area de matemática, Aprovechala.</p>
                            @if($student->moduleProgressions()->exists()))
                                <p>Hablando de tu avance, aqui tenemos un par de estadisticas sobre tu progreso.</p>
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
                                        <td>{{$student->moduleProgressions()->latest()->first()->prep_and_learning_module}}</td>
                                        <td>{{$student->moduleProgressions()->latest()->first()->initial_mastery}}</td>
                                        <td>{{$student->moduleProgressions()->latest()->first()->current_mastery}}</td>
                                        <td>{{$student->moduleProgressions()->latest()->first()->current_number_of_topics_learned}}</td>
                                        <td>{{$student->moduleProgressions()->latest()->first()->current_number_of_topics_learned_per_hour}}</td>
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

