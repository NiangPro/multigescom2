            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Client</div>
                                </div>
                                <select class="form-control @error('form.client_id') is-invalid
                                    @enderror" wire:model="form.client_id" id="exampleFormControlSelect1">
                                    <option value="">Selectionner client</option>
                                    @foreach ($clients as $item)
                                        <option value="{{$item->id}}">{{$item->nom}}</option>
                                    @endforeach
                                </select>
                                @error('form.client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Asigné à</div>
                                </div>
                                <select class="form-control @error('form.employe_id') is-invalid
                                    @enderror" wire:model="form.employe_id" id="exampleFormControlSelect1">
                                    <option value="Homme">Selectionner Employé</option>
                                    @foreach ($employes as $item)
                                        <option value="{{$item->id}}">{{$item->prenom}} {{$item->nom}}</option>
                                    @endforeach
                                </select>
                                @error('form.employe_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Statut</div>
                                </div>
                                <select class="form-control @error('form.statut') is-invalid
                                    @enderror" wire:model="form.statut" id="exampleFormControlSelect1">
                                    <option value="">Selectionner un statut</option>
                                    @foreach ($staticData as $item)
                                        <option value="{{$item->valeur}}">{{$item->valeur}}</option>
                                    @endforeach
                                </select>
                                @error('form.statut')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Date<span class="text-danger">*</span></div>
                              </div>
                              <input type="date" class="form-control @error('form.date') is-invalid
                                @enderror" wire:model="form.date">
                                @error('form.date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">Description</div>
                              </div>
                              <input type="text" class="form-control @error('form.description') is-invalid
                              @enderror" wire:model="form.description" placeholder="Description">
                                @error('form.description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
            
            </form>