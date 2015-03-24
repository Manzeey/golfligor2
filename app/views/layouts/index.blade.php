
<!DOCTYPE html>
<html lang="en" ng-app>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Golfligor.se</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link href="/golfligor/public/css/stylesheet.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>



<body ng-controller="LigorController">

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="brand">
                <li class="sidebar-brand">
                    <a href="#"><img src="/golfligor/public/img/golfligor.svg" height="200px"></a>
                </li>
            </ul>
            <ul class="sidebar-nav">
                <li>
                    <a href="#">användarnamn</a>
                </li>
                <br>
                <li class="menu">
                    <a href="#">Startsida</a>
                </li>
                <li class="menu">
                    <a href="#">Mina ligor</a>
                </li>
                <li class="menu">
                    <a href="#">Skapa liga</a>
                </li>
                <li class="menu">
                    <a href="#">Vänner</a>
                </li>
            </ul>
 <div class="footer">
    <ul class="link-footer">
                <li>
                    <a href="#">Om oss</a>
                </li>
                <li>
                    <a href="#">FAQ</a>
                </li>
    </ul>
   <p>Copyright (c) Golfligor.se 2015</p>
 </div>

        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="league-tab col-lg-3">
                    <h1>
                        Mina ligor
                        <small ng-if="remaining()">({{ remaining() }} st)</small>
                    </h1>
                     
                        <ul class="sidebar-nav">
                            <li ng-animate="ng-animate="{enter: 'animate-enter', leave: 'animate-leave'}" ng-repeat="liga in ligor | orderBy: 'ligaNamn'">
                                <a href="{{ liga.ligaID }}">{{ liga.ligaNamn }}</a>
                            </li>
                        </ul>
                        <a href="<% URL::route('new-liga') %>"><h4>Lägg till liga</h4></a>
                    </div>
                    <div class="league-tab col-lg-9">
                        @yield('content')
                    </div>
                    <div class="score-tab col-lg-12">
                        <h1>Scorekort</h1>
                        <br><br>
                        <div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">Hål</th>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
                <td>11</td>
                <td>12</td>
                <td>13</td>
                <td>14</td>
                <td>15</td>
                <td>16</td>
                <td>17</td>
                <td>18</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <th scope="row">Par</th>
                <td>4</td>
                <td>4</td>
                <td>4</td>
                <td>3</td>
                <td>5</td>
                <td>4</td>
                <td>5</td>
                <td>4</td>
                <td>5</td>
                <td>3</td>
                <td>4</td>
                <td>4</td>
                <td>5</td>
                <td>4</td>
                <td>3</td>
                <td>4</td>
                <td>4</td>
                <td>4</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <th scope="row">Slag</th>
                <td><div class="btn-group">
                  <button type="button" class="btn btn-default">-</button>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div></td>
                <td>4</td>
                <td>4</td>
                <td>3</td>
                <td>5</td>
                <td>4</td>
                <td>5</td>
                <td>4</td>
                <td>5</td>
                <td>3</td>
                <td>4</td>
                <td>4</td>
                <td>5</td>
                <td>4</td>
                <td>3</td>
                <td>4</td>
                <td>4</td>
                <td>4</td>
            </tr>
        </tbody>
      </table>
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
    <script src="/golfligor/public/js/main.js"></script>

    <script type="text/javascript">

    </script>

</body>

</html>
