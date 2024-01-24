<div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-edit" style="font-size: 45px; color:aliceblue"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Tâches</h4>
                </div>
                <div class="card-body">
                    {{$dataEmploye['nbreTache']}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="fa fa-handshake" style="font-size: 45px; color:aliceblue"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Réunions</h4>
                </div>
                <div class="card-body">
                  {{$dataEmploye['nbreReunion']}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fa fa-history" style="font-size: 45px; color:aliceblue"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Historiques</h4>
                </div>
                <div class="card-body">
                  {{$dataEmploye['nbreHistorique']}}
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    {{-- calendar --}}
    <div class="row">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                          <h4>Jour du mois</h4>
                        </div>
                        <div class="card-body">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="row">
              <div class="col-sm py-2">
                  <div class="card">
                      <div class="card-header">
                          <h4>Dernières activitées</h4>
                      </div>
                    <div class="card-body">
                          <ul class="timeline scrollbar-todo">
                              @foreach ($historiques as $item)
                                  <li>
                                      <a href="#">{{$item->description}}</a>
                                      <p>Le {{date("d/m/Y à H:i", strtotime($item->date))}}</p>
                                  </li>
                              @endforeach
                          </ul>
                    </div>
                  </div>
              </div>
          </div>
        </div>
        {{-- <div class="col-lg-4 col-md-12 col-12 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    @include('livewire.superAdmin.users.todolist')
                </div>
            </div>
        </div> --}}
        
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-body">
              <div id='calendar'></div>
            </div>
        </div>
      </div>
    </div>
</div>
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
            const Calendar = FullCalendar.Calendar;
            const calendarEl = document.getElementById('calendar');
            const calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev next today',
                    center: 'title',
                    right: 'dayGridMonth timeGridWeek'
                },
                locale: 'fr',
            });
            calendar.render();
        });

    window.addEventListener('errorDate', event =>{
            toastr.error('La date du debut doit être inférieur à la date de Fin', 'Date', {positionClass: 'toast-top-right'});
        });
    window.addEventListener('refresh', event =>{
            location.reload();
    });

    window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'A faire',
        message: 'Ajout avec succes',
        position: 'topRight'
        });
    });

    window.addEventListener('updateSuccessful', event =>{
        iziToast.success({
        title: 'A faire',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });
    });
</script>
@endsection
