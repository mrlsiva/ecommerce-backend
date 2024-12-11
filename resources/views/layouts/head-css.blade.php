@yield('css')
<style>
@font-face {
    font-family: Material Design Icons;
    src: url("{{ URL::asset('/build/icons/materialdesignicons-webfont.eot?v=7.2.96') }}");
    src: url("{{ URL::asset('/build/icons/materialdesignicons-webfont.eot?#iefix&v=7.2.96') }}") format("embedded-opentype"), url("{{ URL::asset('/build/icons/materialdesignicons-webfont.woff2?v=7.2.96') }}") format("woff2"),
        url("{{ URL::asset('/build/icons/materialdesignicons-webfont.woff?v=7.2.96') }}") format("woff"), url("{{ URL::asset('/build/icons/materialdesignicons-webfont.ttf?v=7.2.96') }}") format("truetype");
    font-weight: 400;
    font-style: normal;
}
@font-face {
    font-family: boxicons;
    font-weight: 400;
    font-style: normal;
    src: url("{{ URL::asset('/build/icons/boxicons.eot') }}");
    src: url("{{ URL::asset('/build/icons/boxicons.eot') }}") format("embedded-opentype"), url("{{ URL::asset('/build/icons/boxicons.woff2') }}") format("woff2"), url("{{ URL::asset('/build/icons/boxicons.woff') }}") format("woff"), "{{ URL::asset('/build/icons/boxicons.ttf') }}") format("truetype"),
        url("{{ URL::asset('/build/icons/boxicons.svg?#boxicons') }}") format("svg");
}
@font-face {
    font-family: Line Awesome Brands;
    font-style: normal;
    font-weight: 400;
    font-display: auto;
    src: url("{{ URL::asset('/build/icons/la-brands-400.eot') }}");
    src: url("{{ URL::asset('/build/icons/la-brands-400.eot?#iefix') }}") format("embedded-opentype"), url("{{ URL::asset('/build/icons/la-brands-400.woff2') }}") format("woff2"), url("{{ URL::asset('/build/icons/la-brands-400.woff') }}") format("woff"),
        url("{{ URL::asset('/build/icons/la-brands-400.ttf') }}") format("truetype"), url("{{ URL::asset('/build/icons/la-brands-400.svg#lineawesome') }}") format("svg");
}
@font-face {
    font-family: Line Awesome Free;
    font-style: normal;
    font-weight: 400;
    font-display: auto;
    src: url("{{ URL::asset('/build/icons/la-regular-400.eot') }}");
    src: url("{{ URL::asset('/build/icons/la-regular-400.eot?#iefix') }}") format("embedded-opentype"), url("{{ URL::asset('/build/icons/la-regular-400.woff2') }}") format("woff2"), url("{{ URL::asset('/build/icons/la-regular-400.woff') }}") format("woff"),
        url("{{ URL::asset('/build/icons/la-regular-400.ttf') }}") format("truetype"), url("{{ URL::asset('/build/icons/la-regular-400.svg#lineawesome') }}") format("svg");
}
@font-face {
    font-family: Line Awesome Free;
    font-style: normal;
    font-weight: 900;
    font-display: auto;
    src: url("{{ URL::asset('/build/icons/la-solid-900.eot') }}");
    src: url("{{ URL::asset('/build/icons/la-solid-900.eot?#iefix') }}") format("embedded-opentype"), url("{{ URL::asset('/build/icons/la-solid-900.woff2') }}") format("woff2"), url("{{ URL::asset('/build/icons/la-solid-900.woff') }}") format("woff"), url("{{ URL::asset('/build/icons/la-solid-900.ttf') }}") format("truetype"),
        url("{{ URL::asset('/build/icons/la-solid-900.svg#lineawesome') }}") format("svg");
}
@font-face {
    font-family: remixicon;
    src: url("{{ URL::asset('/build/icons/remixicon.eot?t=1690730386070') }}");
    src: url("{{ URL::asset('/build/icons/remixicon.eot?t=1690730386070#iefix') }}") format("embedded-opentype"), url("{{ URL::asset('/build/icons/remixicon.woff2?t=1690730386070') }}") format("woff2"), url("{{ URL::asset('/build/icons/remixicon.woff?t=1690730386070') }}") format("woff"),
        url("{{ URL::asset('/build/icons/remixicon.ttf?t=1690730386070') }}") format("truetype"), url("{{ URL::asset('/build/icons/remixicon.svg?t=1690730386070#remixicon') }}") format("svg");
    font-display: swap;
}
</style>
<!-- Layout config Js -->
<script src="{{ URL::asset('build/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ URL::asset('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="{{ URL::asset('build/css/custom.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
