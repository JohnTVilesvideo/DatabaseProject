<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Rate My Professor</title>

    <?php
    include_once('links.html');
    ?>
</head>
<body>
<?php
include_once('nav.php');
?>
<div class="container">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#prof">Search Professor</a></li>
        <li><a data-toggle="tab" href="#college">Search College</a></li>
        <li><a data-toggle="tab" href="#dept">Search Department</a></li>
        <li><a data-toggle="tab" href="#course">Search Course</a></li>
    </ul>
    <div class="tab-content">
        <div id="prof" class="tab-pane fade in active">
            <form class="navbar-form navbar-left" action="Search.php" method="POST">
                <div class="form-group">
                    <input type="hidden" name="professorOnly" value="true">
                    <input type="text" name="query" class="form-control " placeholder="Professor's Name">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
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
        <div id="dept" class="tab-pane fade">
            <form class="navbar-form navbar-left" action="Search.php" method="POST">
                <div class="form-group">
                    <input type="text" name="College" class="form-control " placeholder="College">
                    <input type="text" name="Department" class="form-control " placeholder="Department">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
        <div id="course" class="tab-pane fade">
            <form class="navbar-form navbar-left" action="Search.php" method="POST">
                <div class="form-group">
                    <input type="text" name="College" class="form-control " placeholder="College">
                    <input type="text" name="Course" class="form-control " placeholder="Course">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>