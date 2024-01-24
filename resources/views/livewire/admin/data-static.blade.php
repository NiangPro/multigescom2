<div>
    @if ($etat === "list")

    <div id="accordion">
        @foreach ($datas as $index => $value)
        <div class="accordion bg-white card card-primary">
          <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-{{$this->removeSpace($index)}}" >
            <div class="row">
                <div class="col-md-8">
                    <h4>{{$index}} <sup class="text-primary">{{$this->countFonction($index)}}</sup></h4>
                </div>
                <div class="col-md-4 text-md-right">
                <button type="button" wire:click="addNew('{{$index}}')" class="btn btn-outline-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button></th>

                </div>
            </div>
          </div>
          <div class="accordion-body collapse" id="panel-{{$this->removeSpace($index)}}" data-parent="#accordion">

            <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                    <th>Valeur</th>
                    <th>Entreprise</th>
                    <th>Statut</th>
                    @if (Auth()->user()->entreprise->nom !== "Demo") 
                    <th>Action</th>
                    @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($value as $sd)
                        @if (Auth()->user()->entreprise_id === $sd->entreprise_id)
                            <tr>
                                <td>{{$sd->valeur}}</td>
                                <td>{{$sd->entreprise->nom}}</td>
                                <td><label class="custom-switch mt-2">
                                    <input type="checkbox" @if ($sd->statut)
                                    checked
                                    @endif wire:change="changeStatus({{$sd->id}})" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label></td>
                                @if (Auth()->user()->entreprise->nom !== "Demo") 
                                    <td>
                                        <button class="btn btn-warning btn-sm" wire:click.prevent="edit({{$sd->id}})"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                </table>
            </div>
          </div>
        </div>
        @endforeach
    </div>

    @else
        @include('livewire.admin.staticdata.add')
    @endif

</div>


@section('js')
<script>

     window.addEventListener('statutUpdated', event =>{
        iziToast.success({
        title: 'Donnée statique',
        message: 'Mis à jour avec succes',
        position: 'topRight'
        });

        window.addEventListener('addSuccessful', event =>{
        iziToast.success({
        title: 'Donnée statique',
        message: 'Ajout avec succes',
        position: 'topRight'
        });
    });

   </script>

@endsection
