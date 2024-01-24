
<div class="row">

    @foreach ($companies as $company)
    @if ($company->sigle !== "SAM")
      
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 card-primary">
          <div class="card-icon ">
            <img src="{{asset('storage/images/'.$company->profil)}}" alt="" height="80" width="80">
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>{{Str::substr($company->nom, 0, 11) }} @if (strlen($company->nom)> 8)
                  ...
              @endif</h4>
            </div>
            <div class="card-body pt-2">
                <button  class="btn btn-icon btn-outline-success btn-sm" title="Info"  wire:click.prevent="info({{$company->id}})"><i class="far fa-eye"></i></button>
                @if ($company->statut === 1)
                    <button  class="btn btn-icon btn-outline-success btn-sm" title="Fermer"  wire:click.prevent="closeOrOpen({{$company->id}})"><i class="fa fa-lock-open"></i></button>
                @else
                    <button  class="btn btn-icon btn-outline-warning btn-sm" title="Ouvrir"   wire:click.prevent="closeOrOpen({{$company->id}})"><i class="fa fa-lock"></i></button>
                @endif
                <button  class="btn btn-icon btn-outline-danger btn-sm" wire:click.prevent="getId({{$company->id}})"  title="Supprimer"><i class="fa fa-trash"></i></button>

            </div>
          </div>
        </div>
    </div>
    
    @endif
    @endforeach
    <div class="container">
        {{ $companies->links() }}
    </div>
</div>
