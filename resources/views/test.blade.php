<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach($danhmuc as $key => $item)
    @php
        $videoId = \Illuminate\Support\Str::after($item->link, 'v=');
    @endphp
    <div class="product-card" onclick="openModal(
        '{{ $item->title ?? 'Không có tên' }}',
        '{{ $item->image ? asset('uploads/danhmuc/'.$item->image) : asset('/images/default.png') }}',
        '{{ $item->description ?? 'Đang cập nhật mô tả' }}',
        '{{ isset($item->price) ? number_format($item->price, 0, ',', '.').' ₫' : 'Liên hệ' }}',
        '{{ $item->author ?? 'Chưa rõ' }}',
        '{{ $item->transcribed ?? 'KChipShop' }}',
        <div id="videoContainer"></div>
        <div class="product-image">
            <img src="{{ $item->image ? asset('uploads/danhmuc/'.$item->image) : asset('/images/default.png') }}"
                 alt="{{ $item->title ?? '' }}" />
        </div>
        <h4>{{ $item->title ?? 'Sản phẩm mới' }}</h4>
        <button class="price-btn">Xem sản phẩm</button>
    </div>
@endforeach
<script>
    const test = "https://www.youtube.com/watch?v=XF6Diudg5jA";

    const videoId = new URL(test).searchParams.get("v");

    const embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1`;

    const iframe = `<iframe width="560" height="315"
                      src="${embedUrl}"
                      title="YouTube video player"
                      frameborder="0"
                      allow="autoplay; encrypted-media"
                      allowfullscreen></iframe>`;

    document.getElementById('videoContainer').innerHTML = iframe;
</script>
</body>
</html>
