<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{{$guide['guide']->title}}</title>
<link href="{{ asset('pdf/style.css')}}" rel="stylesheet" type="text/css">
</head>

<body id="pdf1">
	@php
		$total_product = count($guide['products']);
		$total_page_product =  intval(ceil($total_product / 6));
		$total_page =2 + $total_page_product;
		$info_array = ['no' => $guide['guide']->number, 'total_page' => $total_page];
	@endphp
	@include('pages.guide.html-component.guide', array_merge($info_array, ['guide' => $guide['guide'], 'creator' => $guide['creator'], 'supplier' => $guide['supplier']]))
	@include('pages.guide.html-component.delivery', array_merge($info_array, ['delivery' => $guide['delivery']]))
	@include('pages.guide.html-component.packaging', array_merge($info_array, ['packaging' => $guide['packaging']]))
	@include('pages.guide.html-component.procedure', array_merge($info_array, ['procedure' => $guide['procedure'], 'products' => $guide['products']]))
	@for($i = 0; $i < $total_page_product ; $i++)
		@include('pages.guide.html-component.products', array_merge($info_array, ['products' => $guide['products'], 'page' => $i, 'from' => $i * 6, 'to' => $i * 6 + 6 > $total_product ? $total_product : $i * 6 + 6 ]))
	@endfor
	@if($price == 'has-price')
		@include('pages.guide.html-component.price', array_merge($info_array, ['price' => $guide['guide']['price']]))
	@endif


</body>
</html>
