<div class="card card-primary mt-3">
    <div class="card-header">
        <h4>
            @if ($etat === "info")
                Document(s) personnel(s)
            @endif
        </h4>
        <div class="card-header-action">
            <div class="btn-group">
                <button wire:click.prevent="changeStatut('info')" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retour</button>
                <button wire:click.prevent="changeStatut('add')" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Ajout</button>
            </div>
        </div>
    </div>
    <div class="card-body mt-2 mb-2">
        <div class="row">
            @if (isset($this->contrats) && count($this->contrats) > 0)
                @foreach ($this->contrats as $contrat)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 card-primary">
                        <div class="card-icon ">
                            <img src="storage/images/file.png" alt="" height="80" width="80">
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <span style="display: flex; flex-direction: column; left:3px;">
                                    <a target="_blank" href="storage/contrats/{{$contrat->fichier}}" class="btn mb-1 btn-icon btn-outline-success btn-sm" title="Ouvrir"><i class="fa fa-eye left-eye"></i></a>
                                    @if (Auth()->user()->entreprise->nom !== "Demo")
                                        <button wire:click.prevent="deleteDocument({{$contrat->id}})"
                                        data-confirm-yes="removeDocument()"
                                        class="btn btn-icon btn-outline-danger btn-sm" title="Supprimer"><i class="fa fa-trash left-i"></i></button>
                                    @endif    
                                    <button wire:click.prevent="download({{$contrat->id}})" class="btn btn-icon btn-sm btn-outline-info"><i class="fa fa-download left-i" aria-hidden="true"></i></button>
                                </span>
                            </div>
                            <hr>
                            <div class="card-body pt-2">
                                <h6 class="text-center mt-n3 mb-2">{{Str::substr($contrat->titre, 0, 11) }} @if (strlen($contrat->titre)> 8)
                                    ...
                                @endif</h6>
                            </div>
                        </div>
                        </div>
                    </div>

                @endforeach
            @endif
            @if (count($this->contrats) <= 0)
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <span class="text-center text-danger">Aucune données </span>
                </div>
            @endif

        </div>
    </div>
</div>
