<div class="row">
    @foreach ($admins as $ad)
    <div class="col-12 col-sm-12 col-lg-4">

        <div class="card author-box card-primary">
          <div class="card-body">
            <div class="author-box-left">
              <img alt="image" height="98" width="104" src="{{asset('storage/images/'.$ad->profil)}}" class="rounded-circle author-box-picture">
              <div class="clearfix mb-2"></div>
              <button wire:click.prevent="getAdmin({{$ad->id}})"  class="btn btn-outline-success btn-sm btn-rounded mr-2"><i class="fa fa-eye" aria-hidden="true"></i></button>
              @if (Auth()->user()->entreprise->nom !== "Demo")
                <button type="button" wire:click.prevent="delete({{$ad->id}})" data-confirm-yes="remove()" class="btn btn-outline-danger btn-sm btn-rounded">
                  <i class="fa fa-trash" aria-hidden="true"></i></button>
              @endif
            </div>
            <div class="author-box-details">
              <div class="author-box-name">
                <a href="#">{{Str::substr($ad->prenom.' '.$ad->nom, 0, 10) }}
                  @if (strlen($ad->prenom.$ad->nom)> 8)
                                ...
                            @endif
                </a>
            </div>
            <div class="author-box-job">{{$ad->fonction}}</div>
            <div class="author-box-description">
                <p>
                    <i class="fa fa-phone" aria-hidden="true"></i> {{$ad->tel}} <br>
                    {{-- <span class="badge badge-pill badge-info">{{$ad->role}}</span> --}}
                </p>
              </div>
              <div class="w-100 d-sm-none"></div>
              <div class="float-right mt-sm-0 mt-3">
              </div>
            </div>
          </div>
        </div>
    </div>
    @endforeach
    <div class="container">
        {{ $admins->links() }}
    </div>
</div>
