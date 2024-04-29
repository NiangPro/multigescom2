<div>
    <div class="card card-primary">
        <form wire:submit.prevent="editParam"  class="needs-validation" novalidate="">
          <div class="card-header">
            <h4>Parametres de l'abonnement</h4>
          </div>
          <div class="card-body">
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label for="">Abonnement Mensuel (F CFA)</label>
                        <input min="0" type="number" wire:model="form.mensuel" class="form-control">
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="">Abonnement Annuel (F CFA)</label>
                        <input min="0" type="number" wire:model="form.annuel" class="form-control">
                    </div>
                    
                    <div class="col-md-2 mt-4 pt-1">
                        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i>
                        Modifier</button>
                    </div>
                </div>
          </div>
        </form>
    </div>
</div>


@section('js')
<script>

    window.addEventListener('editSuccessful', event =>{
        iziToast.success({
        title: 'Abonnement',
        message: 'Mis a jour avec succes',
        position: 'topRight'
        });
    });

</script>

@endsection
