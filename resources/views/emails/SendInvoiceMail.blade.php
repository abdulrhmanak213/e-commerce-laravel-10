<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Send mail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container m-1">
    <h1 class="lead mt-3">Thank You To Ordering From Our Store!</h1>
    <div class="row">
        <div class="md-12">
            <div class="card">
                <div class="class-body">
                    @if(\Session::has('success'))
                        <div class="alert alert-success m-3">{{ \Session::get('success') }}</div>
                        {{ \Session::forget('success') }}
                    @endif
                    @if(\Session::has('error'))
                        <div class="alert alert-danger m-3">{{ \Session::get('error') }}</div>
                        {{ \Session::forget('error') }}
                    @endif
{{--                 
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
