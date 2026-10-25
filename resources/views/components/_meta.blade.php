{{-- <meta name="title" content="{{ $title }}"> --}}
<meta name="description" content="{{ $description }}">
{{-- <meta name="image" content="{{ $image  }}"> --}}

<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $title }}" />
<meta property="og:description" content="{{ $description  }}" />
<meta property="og:image" content="{{ $image }}" />
<!--<meta property="og:image:width" content="1200"> -->
<!--<meta property="og:image:height" content="630">-->

<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title  }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

<meta name="keywords" content="{{ $keywords }}">