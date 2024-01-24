<div class="row">
    @foreach ($superAdmins as $sa)
    <div class="col-12 col-sm-12 col-lg-4">

        <div class="card author-box card-primary">
          <div class="card-body">
            <div class="author-box-left">
              <img alt="image" height="98" width="104" src="{{asset('storage/images/'.$sa->profil)}}" class="rounded-circle author-box-picture">
              <div class="clearfix mb-2"></div>
              <button wire:click.prevent="info({{$sa->id}})"  class="btn btn-outline-success btn-sm btn-rounded mr-2"><i class="fa fa-eye" aria-hidden="true"></i></button>
              
              @if (count($superAdmins)>1)
                <button type="button" wire:click.prevent="delete({{$sa->id}})" class="btn btn-outline-danger btn-sm btn-rounded">
                  <i class="fa fa-trash" aria-hidden="true"></i></button>
              @endif
            </div>
            <div class="author-box-details">
              <div class="author-box-name">
                <a href="#">{{$sa->prenom}} {{$sa->nom}}</a>
            </div>
            <div class="author-box-job">{{$sa->role}}</div>
            <div class="author-box-description">
                <p>
                    <i class="fa fa-phone" aria-hidden="true"></i> {{$sa->tel}} <br>
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
        {{ $superAdmins->links() }}
    </div>
</div>
