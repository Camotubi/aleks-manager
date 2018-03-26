@extends('layout.mails')
@section('content')
    <div class="container">
        <div class="mail-container columns is-vcentered">
            <table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <div class="mail-content column " style="
                            color:rgb(84, 165, 218);
                            ">
                            <p>Hola 
                                @if(isset($student))
                                    {{$student->name}}
                                @else
                                    nombre
                                @endif
                                ;</p>
                            <p>Queriamos felicitarte ya que has avanzado a buen paso en los temas de aprendisaje, sigue asi.</p>
                            @if($student->moduleProgressions()->exists())
                                <p>Hablando de tu avance, aqui tenemos un par de estadisticas sobre tu progreso.</p>
                                <br>
                                <br>
                                <table style=" border-collapse: collapse;">
                                    <tr>
                                        <th style="background-color:#4B0082;color:white;text-align: left;padding: 8px;">Modulo</th>
                                        <th style="background-color:#4B0082;color:white;text-align: left;padding: 8px;">Dominio Inicial</th>
                                        <th style="background-color:#4B0082;color:white;text-align: left;padding: 8px;">Dominio Actual</th>
                                        <th style="background-color:#4B0082;color:white;text-align: left;padding: 8px;">Total de Topicos Aprendidos</th>
                                        <th style="background-color:#4B0082;color:white;text-align: left;padding: 8px;">Total de Topicos Aprendidos por hora</th>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f2f2f2;text-align: left;padding: 8px;">{{$student->moduleProgressions()->latest()->first()->prep_and_learning_module}}</td>
                                        <td style="background-color: #f2f2f2;text-align: left;padding: 8px;">{{round($student->moduleProgressions()->latest()->first()->initial_mastery,2)}}</td>
                                        <td style="background-color: #f2f2f2;text-align: left;padding: 8px;">{{round($student->moduleProgressions()->latest()->first()->current_mastery,2)}}</td>
                                        <td style="background-color: #f2f2f2;text-align: left;padding: 8px;">{{round($student->moduleProgressions()->latest()->first()->current_number_of_topics_learned,2)}}</td>
                                        <td style="background-color: #f2f2f2;text-align: left;padding: 8px;">{{round($student->moduleProgressions()->latest()->first()->current_number_of_topics_learned_per_hour,2)}}</td>
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

