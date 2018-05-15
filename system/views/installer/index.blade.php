<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Zeapps</title>
    <base href="/">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ************************************************************* -->
    <!-- **************************** CSS **************************** -->
    <!-- ************************************************************* -->
    <!-- Bootstrap -->
    <link rel="stylesheet" media="print,screen" href="/assets/bootstrap-3.3.7/css/bootstrap.min.css">

    <!-- jQuery UI -->
    <link rel="stylesheet" media="print,screen" href="/assets/js/jquery-ui-1.11.4/jquery-ui.min.css">
    <link rel="stylesheet" media="print,screen" href="/assets/js/jquery-ui-1.11.4/jquery-ui.structure.min.css">
    <link rel="stylesheet" media="print,screen" href="/assets/js/jquery-ui-1.11.4/jquery-ui.theme.min.css">

    <!-- Font-Awesome -->
    <link rel="stylesheet" media="print,screen" href="/assets/css/font-awesome.min.css">

    <link rel="stylesheet" media="print,screen" href="/assets/css/app.css">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <img src="/assets/images/logo.png" alt="ze-apps" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('zeapps-installer') }}" method="post">
                <div class="form-group">
                    <label for="hostname">Database Hostname</label>
                    <input type="text" class="form-control" id="hostname" name="hostname" value="127.0.0.1">
                </div>

                <div class="form-group">
                    <label for="username">Database Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="">
                </div>

                <div class="form-group">
                    <label for="password">Database Password</label>
                    <input type="text" class="form-control" id="password" name="password" value="">
                </div>

                <div class="form-group">
                    <label for="database">Database Name</label>
                    <input type="text" class="form-control" id="database" name="database" value="">
                </div>


                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>




<!-- ************************************************************* -->
<!-- ***************************** JS **************************** -->
<!-- ************************************************************* -->
<!-- jQuery -->
<script src="/assets/js/jquery-3.2.1.min.js"></script>

<!-- Bootstrap -->
<script src="/assets/bootstrap-3.3.7/js/bootstrap.min.js" defer></script>

<!-- jQuery UI -->
<script src="/assets/js/jquery-ui-1.11.4/jquery-ui.min.js" defer></script>

</body>
</html>