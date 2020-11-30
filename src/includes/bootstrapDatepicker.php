<?php
echo '
<!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!--  jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>';
echo '<!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
            <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 
            <!--Font Awesome (added because you use icons in your prepend/append)-->
            <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
            <!-- Inline CSS based on choices in "Settings" tab -->
            <style>
                .bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form {
                    font-family: Montserrat, sans-serif;
                    color: black;
                }
                .bootstrap-iso form button, .bootstrap-iso form button:hover {
                    color: white !important;
                } 
                .asteriskField{
                    color: red;
               }
            </style>
            ';
