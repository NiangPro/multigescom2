<div>
    <div class="row align-items-center justify-content-center" >
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card">
            <div class="card-header mb-2">
                <select class="form-control" wire:model="idUser" wire:change="changeEvent">
                    <option value="0">Recherche personne</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-body scrollbar-content chat-content" >
              <ul class="list-unstyled list-unstyled-border">

                @if ($idUser!==null && $trouve===false)
                    <li class="media ">
                      <a type="button" class="media" wire:click.prevent="selectEvent({{$current_user->id}})">
                        <img alt="image" class="mr-3 rounded-circle" width="52" height="52" src="{{asset('storage/images/'.$current_user->profil)}}">
                        <div class="media-body">
                            <div class="mt-0 mb-1 font-weight-bold">{{ $current_user->prenom }} {{ $current_user->nom }}</div>
                            <div class="text-success text-small font-600-bold">{{$current_user->role}}</div>
                        </div>
                      </a>
                    </li>
                @endif

                @foreach ($recent_message as $item)
                  <li class="media media-btn @if (isset($current_user->id) && ($item->recepteur_id === $current_user->id || $item->emetteur_id === $current_user->id) )
                    active-btn
                  @endif">
                    <a href="#" class="media media-link" wire:click.prevent="selectEvent({{$item->recepteur_id == Auth()->user()->id ? $item->emetteur_id : $item->recepteur_id }})">
                      <img alt="image" class="mr-3 rounded-circle" width="52" height="52"
                        src="@if($item->emetteur_id === Auth()->user()->id)
                              {{asset('storage/images/'.$item->recepteur->profil)}}
                            @else
                              {{asset('storage/images/'.$item->emetteur->profil)}}
                            @endif
                            ">
                      <div class="media-body">
                        <div class="mt-0 mb-1 font-weight-bold">
                          @if ($item->emetteur_id === Auth()->user()->id)
                            {{$item->recepteur->prenom}} {{$item->recepteur->nom}}
                          @else
                            {{$item->emetteur->prenom}} {{$item->emetteur->nom}}
                          @endif
                        </div>
                        <div class="text-small sms font-weight-600 text-muted">
                          {{Str::substr($item->text, 0, 11) }} @if (strlen($item->text)> 16)
                                ...
                            @endif
                        </div>
                        {{-- <i class="fas fa-circle"></i>  --}}
                      </div>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-8 mt-0">
          <div class="card chat-box" id="mychatbox">
            <div class="card-header">
              <h4>Discussion
                @if (isset($current_user) && $current_user !==null)
                  avec 
                  <strong style="color:black;">
                    {{$current_user->prenom}} {{$current_user->nom}}
                  </strong>
                @endif
              </h4>
            </div>
            <div class="card-body scrollbar-auto chat-content" style="background-image:url('../../storage/images/chat-box.png');
            background-repeat: ROUND; height: 300px; width:100%; ">
                @if (isset($current_message) && $current_message!== null)
                    @foreach ($current_message as $item)
                        @if ( isset($item->emetteur_id) && isset($item->recepteur_id))
                        {{-- <img class="mr-3 rounded-circle" width="52" height="52"
                          src="{{asset('storage/images/'.$item->recepteur->profil)}}" alt="">

                          <img class="mr-3 rounded-circle" width="52" height="52"
                          src="{{asset('storage/images/'.$item->emetteur->profil)}}" alt="">

                          <img class="mr-3 rounded-circle" width="52" height="52"
                          src="{{asset('storage/images/'. Auth()->user()->profil)}}" alt=""> --}}



                            @if ($item["emetteur_id"] === Auth()->user()->id)
                              <div class="chat-item chat-right">
                                <img class="mr-3 rounded-circle" width="52" height="52"
                                    src="{{asset('storage/images/'.Auth()->user()->profil)}}">
                                    <div class="chat-details">
                                        <div class="chat-text">
                                            {{$item->text}}
                                        </div>
                                        <div class="chat-time" >
                                          {{ date("d/m/Y à h:i:s", strtotime($item->created_at)) }}
                                        </div>
                                    </div>
                              </div>
                            @elseif($item["recepteur_id"] ===  Auth()->user()->id)
                                <div class="chat-item chat-left">
                                  <img class="mr-3 rounded-circle" width="52" height="52"
                                      src="{{asset('storage/images/'.$item->emetteur->profil)}}">
                                      <div class="chat-details">
                                          <div class="chat-text">
                                              {{$item->text}}
                                          </div>
                                          <div class="chat-time" >
                                              {{ date("d/m/Y à h:i:s", strtotime($item->created_at)) }}
                                          </div>
                                      </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="card-footer chat-form">
              <form wire:submit.prevent="store" id="chat-form">
                <input type="text" wire:model="form.text" class="form-control @error('form.text') is-invalid @enderror" placeholder="Ecrire un message">
                @error('form.text')
                    <span class="invalid-feedback ml-3 mt-n2 mb-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="btn btn-primary">
                  <i class="far fa-paper-plane"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
</div>
