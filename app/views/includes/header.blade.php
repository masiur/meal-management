    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="General Meal System by CSE 12 & CSE 11 Batch SUST">
        <meta name="author" content="Masiur Rahman Siddiki">
        <meta name="keyword" content="">
        <link rel="shortcut icon" href="https://img.icons8.com/clouds/2x/apple-calculator.png">

    <!--
            Masiur Rahman Siddiki

          C1 - The Royal Apartment
           Meal System

           Gratitude to Nayeem Iqubal Joy Vai
           -->



        <title>{{ isset($title) ? $title. " - "  : ''; }} {{ Config::get('customConfig.names.siteName')}}</title>

        <!-- Bootstrap core CSS -->


        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/bootstrap-reset.css') }}
        {{ HTML::style('fonts/font-awesome/css/font-awesome.css') }}

        <!--right slidebar-->
        {{ HTML::style('css/slidebars.css') }}

        <!-- Custom styles for this template -->
        {{ HTML::style('css/style.css') }}
        {{ HTML::style('css/style-responsive.css') }}

        @yield('style')
        {{ HTML::style('css/custom.css') }}

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            #posts{
                margin-top: 10px;
                height: 500px;
                overflow-y: scroll;
            }
            .post{
                border: 1px solid rgb(204, 236, 232);
                margin-bottom: 10px;
            }
            .post p{
                color: rgb(234, 85, 187);
                font-size: 1.5em;
                padding: 5%;
            }
            .post h2{
                color: rgb(33, 14, 89);
            }
            @media print
            {    
                .no-print, .no-print *
                {
                    display: none !important;
                }
            }
        </style>
    </head>
