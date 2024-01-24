<div class="card mt-2 card-primary">
    <div class="card-body">
        <div class="section-title mt-0"><strong>Liste des Produits</strong></div>
            {{-- view product --}}
            <div class="row pt-3" id="ads">
                @foreach ($produits as $produit)
                <div class="col-sm-3 col-md-6 col-lg-3">
                    <article class="article article-style-b">
                      <div class="article-header card-img-overlay">
                        <div class="article-image" data-background="{{asset('storage/images/'.$produit->image_produit)}}">
                        </div>
                        <div class="article-badge">
                          <div class="article-badge-item @if ($produit->type === "Produit")
                              bg-info
                          @else
                              bg-warning
                          @endif"><i class="fas fa-fire"></i> {{$produit->type}}</div>
                        </div>
                      </div>
                      <div class="article-details">
                        <div class="article-title">
                          <h5>{{ucfirst(Str::substr($produit->nom, 0, 14)) }} @if (strlen($produit->nom)> 8)
                            ...
                            @endif</h5>
                        </div>

                        <div class="article-cta">
                            <button class="btn btn-primary"  wire:click.prevent="getProduct({{$produit->id}})">Voir plus</button>

                        </div>
                      </div>
                    </article>
                  </div>

                @endforeach
                <div class="container">
                    {{ $produits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

