<div>
    <section class="section">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fa fa-user-secret" style="font-size: 45px; color:aliceblue"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Super Admin</h4>
                </div>
                <div class="card-body">
                  {{$dataSuperAdmin['nbreSuperAdmin']}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-danger">
                  <i class="fa fa-building" style="font-size: 45px; color:aliceblue" aria-hidden="true"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Entreprises</h4>
                </div>
                <div class="card-body">
                  {{$dataSuperAdmin['nbreEntreprise']}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="fas fa-users-cog" style="font-size: 45px; color:aliceblue"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Admins</h4>
                </div>
                <div class="card-body">
                  {{$dataSuperAdmin['nbreAdmin']}}
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div id='calendar'></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-12 col-12 col-sm-12">
            <div class="row">
                {{-- <div class="col-md-12">
                    @include('livewire.superAdmin.users.todolist')
                </div> --}}
                <div class="col-md-12">
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
            </div>
          </div>
        </div>

      </section>
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

    </script>
@endsection
