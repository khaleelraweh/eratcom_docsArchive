<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords"
        content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.2/ckeditor5.css">

    @livewireStyles
    @include('partial.backend.head')

    <style>
        .main-container {
            width: 795px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>

</head>

<body class="main-body app sidebar-mini">
    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ URL::asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->
    @include('partial.backend.main-sidebar')
    <!-- main-content -->
    <div class="main-content app-content">
        @include('partial.backend.main-header')
        <!-- container -->
        <div class="container-fluid">
            @yield('page-header')
            @yield('content')
        </div>
        @include('partial.backend.sidebar')
        @include('partial.backend.models')
        @include('partial.backend.footer')
        <script src="//unpkg.com/alpinejs" defer></script>

        <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

        <script>
            let editorInstance;

            ClassicEditor
                .create(document.querySelector('#khaleel2'), {
                    language: 'ar', // Set language to Arabic
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'strikethrough', 'link', '|',
                            'bulletedList', 'numberedList', 'blockQuote', 'insertTable', '|',
                            'alignment', 'outdent', 'indent', '|',
                            'imageUpload', 'mediaEmbed', '|',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                            'codeBlock', 'removeFormat', '|',
                            'undo', 'redo'
                        ]
                    },
                    image: {
                        toolbar: [
                            'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
                        ]
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn', 'tableRow', 'mergeTableCells'
                        ]
                    }
                })
                .then(editor => {
                    editorInstance = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        </script>



        @livewireScripts
        {{-- livewire alert  --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
        {{-- realrished sweat aleart for front side  --}}
        @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

        @include('partial.backend.footer-scripts')
</body>

</html>
