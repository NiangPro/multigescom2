<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="section-title mt-4 ml-4 mb-0">
                    <strong>Comptabilité du mois</strong>
                </div>  
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-cart-arrow-down"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                <h4>Ventes</h4>
                                </div>
                                <div class="card-body">
                                    {{$venteTotal}} CFA
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Dépenses</h4>
                                </div>
                                <div class="card-body">
                                    {{$this->depenseTotal}} CFA
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                <h4>Revenus</h4>
                                </div>
                                <div class="card-body">
                                {{$revenusTotal}} CFA
                                </div>
                            </div>
                            </div>
                        </div>     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="section-title mt-4 ml-4 mb-0">
                            <strong>Recherche du mois</strong>
                            <div class="float-right"> 
                                <button type="reset" wire:click.prevent="refresh" class="btn btn-sm bg-info mr-4 pl-3 pr-3">
                                    <i class="fas fa-arrow-circle-left text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>  
                        <div class="card-body">
                            <form wire:submit.prevent="search">
                                <div class="form-group d-flex justify-content-around">
                                    <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Du<span class="text-danger">*</span></div>
                                    </div>
                                    <input type="date" class="form-control @error('form.date_debut') is-invalid
                                        @enderror" wire:model="form.date_debut">
                                        @error('form.date_debut')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div> 
                                    <div class="input-group mb-2 ml-3">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">Au</div>
                                        </div>
                                        <input type="date" class="form-control @error('form.date_fin') is-invalid
                                        @enderror" wire:model="form.date_fin">
                                        @error('form.date_fin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm ml-3" style="height:41px;" >Valider</button>
                                </div>
                            </form>
                            @if ($search)
                                <div>
                                    <h4 class="mt-3">Résultat de la recherche : Date du  
                                        {{date("d/m/Y", strtotime($form['date_debut']))}} au 
                                        {{date("d/m/Y", strtotime($form['date_fin']))}}
                                    </h4>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="media align-items-stretch mb-n4">
                                            <div class="text-center bg-danger rounded p-2 mb-5 mt-3">
                                                <i class="fas fa-credit-card text-white"></i>
                                            </div>
                                            <div class="p-2 media-body">
                                            <h6>Dépenses</h6>
                                                <h6 class="text-bold-400 mb-0">{{$searchDepense}} FCFA</h6>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="media align-items-stretch mb-n4">
                                            <div class="text-center bg-primary rounded p-2 mb-5 mt-3">
                                                <i class="fas fa-cart-arrow-down text-white"></i>
                                            </div>
                                            <div class="p-2 media-body">
                                                <h6>Ventes</h6>
                                                <h6 class="text-bold-400 mb-0">{{$searchVente}} FCFA</h6>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="media align-items-stretch mb-n4">
                                            <div class="text-center bg-warning rounded p-2 mb-5 mt-3">
                                                <i class="fas fa-wallet text-white"></i>
                                            </div>
                                            <div class="p-2 media-body">
                                                <h6>Revenues</h6>
                                                <h6 class="text-bold-400 mb-0 text-left">{{$searchRevenus}} FCFA</h6>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="section-title mt-4 ml-4 mb-0">
                            <strong>Rapports Annuels des Ventes et Dépenses</strong>
                        </div>
                        <div class="card-body">
                            <canvas id="myChartLine" width="949" height="600"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="section-title mt-4 ml-4 mb-0">
                    <strong>Graphique du mois</strong>
                </div>
                <div class="card-body">
                    <canvas id="myCharBar" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script>
    // var depenses = `<?php echo $depenses; ?>`;
    var depenseMonth = JSON.parse`<?php echo $depenseMonth; ?>`;
    var venteMonth = JSON.parse`<?php echo $venteMonth; ?>`;
    var revenus = venteMonth - depenseMonth;

    var ctx = document.getElementById('myChartLine').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Dépenses',
                data: JSON.parse(`<?php echo $depenses; ?>`),
                backgroundColor:'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            },
            {
                label: 'Ventes',
                data: JSON.parse(`<?php echo $ventes; ?>`),
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

    var ct = document.getElementById('myCharBar').getContext('2d');
    var myChart2 = new Chart(ct, {
        type: 'bar',
        data: {
            labels: ['Ventes', 'Dépenses', 'Revenues'],
            datasets: [{
                label: 'Comptabilité mensuelle',
                data: [venteMonth ,depenseMonth, revenus],
                backgroundColor: ['blue', 'red', 'green'],
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    window.addEventListener('errorDate', event =>{
            toastr.error('La date du debut doit être inférieur à la date de Fin', 'Date', {positionClass: 'toast-top-right'});
        });
    window.addEventListener('refresh', event =>{
            location.reload();
    });
</script>
@endsection