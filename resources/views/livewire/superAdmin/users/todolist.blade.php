
    <div class="card">
      <div class="card-header">
        @if ($todo === 'add')
        <h4>Ajout</h4>

        <button type="button" wire:click.prevent="backTodo" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        @else
        <h4>A Faire</h4>
        <button type="button" wire:click.prevent="backTodo" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button>

        @endif

      </div>
      <div class="card-body">
            @if ($todo === 'add' || $todo === 'edit')
            <form wire:submit.prevent="addTodo">
                <div class="form-group">
                    <label for="">Titre</label>
                    <input type="text" class="form-control @error('todoForm.titre') is-invalid @enderror" wire:model="todoForm.titre" placeholder="Titre">
                    @error('todoForm.titre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Date</label>
                    <input type="datetime-local" class="form-control @error('todoForm.date') is-invalid @enderror" wire:model="todoForm.date">
                    @error('todoForm.date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Statut</label>
                    <select class="form-control @error('todoForm.statut') is-invalid @enderror" wire:model="todoForm.statut" id="exampleFormControlSelect1">
                        <option value="">Selectionner un statut</option>
                        <option value="En attente">En attente</option>
                        <option value="En cours">En cours</option>
                        <option value="Terminé">Terminé</option>
                    </select>
                    @error('todoForm.statut')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-sm btn-icon icon-left btn-success"><i class="far fa-edit"></i>@if ($todo === "add") Ajouter @else Modifier @endif</b>
                <button type="reset" class="btn btn-sm btn-icon icon-left btn-warning"><i class="far fa-edit"></i> Annuler</b>
            </form>
            @else
                <ul class="list-group mb-1 scrollbar-todo">
                        @foreach ($todolists as $list)
                            <li class="list-group-item d-flex justify-content-between align-items-center border-start-0 border-top-0 border-end-0 border-bottom rounded-0 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="text-small font-weight-600
                                        @if ($list->statut==='Terminé')
                                            text-success
                                        @elseif($list->statut==='En cours')
                                            text-info
                                        @else
                                            text-danger
                                        @endif">
                                        <i class="fas fa-circle"></i> {{$list->titre}} 
                                    </div>
                                </div>
                                
                                <span style="display: flex;">
                                    <button wire:click.prevent="getTodo({{$list->id}})" class="btn rounded-circle mb-1 btn-icon btn-outline-success btn-sm btn_widht" title="Ouvrir"><i class="fa fa-eye left-eye" style="left: 0!important"></i></button>
                                    &nbsp;&nbsp;
                                    <button wire:click.prevent="delete({{$list->id}})"
                                    data-confirm-yes="remove()"
                                    class="btn rounded-circle btn-icon btn-outline-danger btn-sm btn_widht" title="Supprimer"><i class="fa fa-trash left-i" style="left: 0!important"></i></button>
                                </span>
                            </li>
                        @endforeach
                </ul>
                <div class="text-center pt-1 pb-1">
                    {{ $todolists->links() }}
                </div>

            @endif
      </div>
    </div>


