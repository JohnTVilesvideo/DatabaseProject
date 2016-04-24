<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Rate My Professor</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">


    <script src="js/jquery.min.js"></script>

    <!-- bootstrap Javascript flie -->
    <script src="js/bootstrap.min.js"></script>
    <?php
    include_once('links.html');
    ?>
</head>
<body>
<?php
    include_once('nav.php');
?>
<div class="jumbotron" style="background: url('img/background2.jpg')">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8"><b><h1 style="text-align: center; color: dodgerblue; text-shadow: 4px 4px 6px #cbb;">Read Reviews and Tell Your Experiences</h1></b></div>
        <div class="col-md-2"></div>
    </div>
    <div class="container" style="padding-top: 20px">

        <ul class="nav nav-tabs nav-justified" style="font-size: 14pt">
            <li class="active"><a data-toggle="tab" href="#prof">Search Professor</a></li>
            <li><a data-toggle="tab" href="#college">Search College</a></li>
            <li><a data-toggle="tab" href="#dept">Search Department</a></li>
            <li><a data-toggle="tab" href="#course">Search Course</a></li>
        </ul>
        <div class="tab-content" align='center' style="text-align: center">
            <div id="prof" class="tab-pane fade in active" >
                <form class="navbar-form" action="Search.php" method="POST">
                    <div class="form-group" style="padding-top: 30px">
                        <div class="input-group input-group-lg">
                            <input type="hidden" name="professorOnly" value="true">
                            <input type="text" name="query" class="form-control" style="height: 60px; width: 100%; border-radius:25px; font-size: x-large" placeholder="Professor's Name"></td>
                            <hr style="height:30pt; visibility:hidden;" />
                            <button type="submit" class="btn btn-default" >Search</button>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div id="college" class="tab-pane fade">
                <h4>Search by Name</h4>
                <form class="form-group" method="POST" action="Search.php">
                    <div class="form-group">
                        <input type="hidden" name="collegeOnly" value="true">
                        <input type="text" name="query" class="form-control " placeholder="College Name">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>

                </form>
                <h4>Search by State</h4>
                <form class="form-group" method="POST" action="Search.php">
                    <input type="hidden" name="collegeOnly" value="true">
                    <select class="form-control" name="state">
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
                    <input type="submit" class="btn btn-default" value="Search">
                </form>
            </div>
            <div id="dept" class="tab-pane fade" align='center' style="text-align: center">
                <form class="navbar-form" action="Search.php" method="POST">
                    <div class="form-group" style="padding-top: 30px">
                        <div class="input-group input-group-lg">
                            <input type="text" name="College" class="form-control" style="height: 50px; width: 100%; border-radius:25px; font-size: larger" placeholder="College">
                            <input type="text" name="Department" class="form-control" style="height: 50px; width: 100%; border-radius:25px; font-size: larger" placeholder="Department">
                            <hr style="height:60pt; visibility:hidden;"/>
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="course" class="tab-pane fade" align='center'>
                <form class="navbar-form" action="Search.php" method="POST">
                    <div class="form-group" style="padding-top: 30px">
                        <div class="input-group input-group-lg">
                            <input type="text" name="College" class="form-control" style="height: 50px; width: 100%; border-radius:25px; font-size: larger" placeholder="College">
                            <input type="text" name="Course" class="form-control" style="height: 50px; width: 100%; border-radius:25px; font-size: larger" placeholder="Course">
                            <hr style="height:60pt; visibility:hidden;"/>
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="jumbotron" style="background: url('img/background3.jpg')">
    <h1 align="center" style="font-family: SansSerif; color: dodgerblue">How it works</h1>
    <h2 align="center" style="font-family: SansSerif; color: dodgerblue">Read Reviews</h2>
    <div class="jumbotron" style="background: url('img/instruct.gif') no-repeat ; background-size: 100% 600px;">
        <div style="height: 600px"></div>
    </div>
    <h2 align="center" style="font-family: SansSerif; color: dodgerblue">Rate professor/course</h2>
    <div class="jumbotron" style="background: url('img/write.gif') no-repeat ; background-size: 100% 700px;">
        <div style="height: 700px"></div>
    </div>


</div>
<div class="footer col-md-12">
    <hr class="carved">
    <div class="container-fluid">

        <p>Rate My Professor &copy; 2016

        </p>
    </div>
</div>
</body>
</html>