<div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-industry" style="font-size: 45px; color:aliceblue"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Fournisseurs</h4>
                </div>
                <div class="card-body">
                    {{$dataCommercial['nbreFournisseur']}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                  <i class="fas fa-search-location" style="font-size: 45px; color:aliceblue" aria-hidden="true"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Prospects</h4>
                </div>
                <div class="card-body">
                    {{$dataCommercial['nbreProspect']}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="fas fa-users" style="font-size: 45px; color:aliceblue"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Clients</h4>
                </div>
                <div class="card-body">
                  {{$dataAdmin['nbreClient']}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fab fa-product-hunt" style="font-size: 45px; color:aliceblue"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Produits</h4>
                </div>
                <div class="card-body">
                  {{$dataAdmin['nbreProduit']}}
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                          <h4>Rapport annuel des clients et fournisseurs</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChartline" width="949" height="600"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Derniere activité --}}
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
        </div> --}}
        
    </div>
    {{-- calendar --}}
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
    var ctv = document.getElementById('myChartline').getContext('2d');
    var myChart = new Chart(ctv, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [
            {
                label: 'Clients',
                data: JSON.parse(`<?php echo $allClients; ?>`),
                backgroundColor:'blue',
                borderColor: 'blue',
                borderWidth: 1,
            },{
                label: 'Fournisseurs',
                data: JSON.parse(`<?php echo $allFournisseurs; ?>`),
                backgroundColor:'lightgreen',
                borderColor: 'green',
                borderWidth: 1,
            }
        ]},
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    });

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
