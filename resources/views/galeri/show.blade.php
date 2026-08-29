<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cards Gallery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />
    <link rel="stylesheet" href="{{ asset('css/cards-gallery.css') }}">
</head>
<body>
<section class="gallery-block cards-gallery">
    <div class="container">
        <div class="heading">
            <h2>Cards Gallery</h2>
        </div>
        <div class="row">
            @foreach($galeri as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 transform-on-hover">
                    <a class="lightbox" href="{{ asset('storage/' . $item->gambar) }}">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_foto }}" class="card-img-top">
                    </a>
                    <div class="card-body">
                        <h6><a href="#">{{ $item->judul }}</a></h6>
                        <p class="text-muted card-text">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.cards-gallery', { animation: 'slideIn' });
</script>
</body>
</html>
