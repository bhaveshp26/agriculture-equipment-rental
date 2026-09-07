<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$booking_success = false;
if (isset($_SESSION['booking_success'])) {
    $booking_success = $_SESSION['booking_success'];
    unset($_SESSION['booking_success']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Property</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
    <style>
        #mapid { height: 300px; width: 100%; margin-top: 20px; }
        .carousel-inner img { width: 100%; height: 400px; }
        .property-details { margin-top: 20px; }
        .btn-custom { width: 100%; margin-top: 20px; }
    </style>
</head>
<body>

<?php
include('config/config.php');
include('navbar.php');
include('review-engine.php');
include('booking-engine.php');

$property_id = isset($_GET['property_id']) ? $_GET['property_id'] : null;

if ($property_id) {
    $property_id = mysqli_real_escape_string($db, $property_id);
    $sql = "SELECT *, 
                CASE 
                    WHEN EXISTS (SELECT 1 FROM reservations WHERE property_id = add_property.property_id AND (check_out_date >= CURDATE() OR check_in_date >= CURDATE())) 
                    THEN 'Yes' 
                    ELSE 'No' 
                END AS booked 
            FROM add_property 
            WHERE property_id = '$property_id'";
    $query = mysqli_query($db, $sql);

    if (mysqli_num_rows($query) > 0) {
        $rows = mysqli_fetch_assoc($query);
        $sql2 = "SELECT * FROM property_photo WHERE property_id = '$property_id'";
        $query2 = mysqli_query($db, $sql2);
        $rowcount = mysqli_num_rows($query2);
?>

<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    for ($i = 1; $i <= $rowcount; $i++) {
                        $row = mysqli_fetch_array($query2);
                        $photo = $row['p_photo'];
                    ?>
                    <div class="item <?php echo ($i == 1) ? 'active' : ''; ?>">
                        <img src="owner/<?php echo $photo; ?>" alt="Property Photo">
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-sm-4">
            <h2><?php echo htmlspecialchars($rows['property_type']); ?></h2>
            <p><strong>City:</strong> <?php echo htmlspecialchars($rows['city']); ?></p>
            <p><strong>Pets:</strong> <?php echo htmlspecialchars($rows['tole']); ?></p>
            <p><strong>Contact No.:</strong> <?php echo htmlspecialchars($rows['contact_no']); ?></p>
            <p><strong>Estimated Price:</strong> Rs.<?php echo htmlspecialchars($rows['estimated_price']); ?></p>
            <p><strong>Total Rooms:</strong> <?php echo htmlspecialchars($rows['total_rooms']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($rows['description']); ?></p>
            <?php
if (isset($_SESSION["email"]) && !empty($_SESSION['email'])) {
    $tenant_email = $_SESSION['email'];
    $sql_check_tenant = "SELECT tenant_id FROM tenant WHERE email = '$tenant_email'";
    $result = mysqli_query($db, $sql_check_tenant);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tenant_id = $row['tenant_id'];
    } else {
        echo "<p class='text-danger'><strong>Tenant not found.</strong></p>";
        exit();
    }
?>

<form method="POST">
    <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($rows['property_id']);?>">
    <?php if ($rows['booked'] == 'No') {?>
    <div class="form-group">
        <label for="check_in_date">Check-in Date:</label>
        <input type="date" id="check_in_date" name="check_in_date" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="check_out_date">Check-out Date:</label>
        <input type="date" id="check_out_date" name="check_out_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary btn-custom" name="book_property">Book Property</button>
    <?php } else {?>
    <button type="button" class="btn btn-danger btn-custom" disabled>Property Booked</button>
    <?php }?>
</form>
<form method="POST" action="chatpage.php">
    <input type="hidden" name="owner_id" value="<?php echo htmlspecialchars($rows['owner_id']);?>">
    <button type="submit" class="btn btn-success btn-custom" name="send_message">Send Message</button>
</form>

<?php
} else {
    echo "<p><strong>You should login to book or review property.</strong></p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_property'])) {
    $property_id = mysqli_real_escape_string($db, $_POST['property_id']);
    $check_in_date = mysqli_real_escape_string($db, $_POST['check_in_date']);
    $check_out_date = mysqli_real_escape_string($db, $_POST['check_out_date']);

    if (!empty($tenant_id)) {
        $total_nights = abs(strtotime($check_out_date) - strtotime($check_in_date)) / (60 * 60 * 24);
        $total_amount = $rows['estimated_price'] * $total_nights;

        $sql = "INSERT INTO reservations (property_id, tenant_id, check_in_date, check_out_date, total_nights, total_amount) 
                VALUES ('$property_id', '$tenant_id', '$check_in_date', '$check_out_date', '$total_nights', '$total_amount')";
        if (mysqli_query($db, $sql)) {
            $sql_update = "UPDATE add_property SET booked = 'Yes' WHERE property_id = '$property_id'";
            mysqli_query($db, $sql_update);
            $_SESSION['booking_success'] = true;
            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo "<p class='text-danger'><strong>Error: ". mysqli_error($db). "</strong></p>";
        }
    } else {
        echo "<p class='text-danger'><strong>Tenant not found.</strong></p>";
    }
}
?>

        </div>
    </div>
    <div id="mapid"></div>
</div>

<!-- Review Section -->
<div class="container">
    <h2>Review Property:</h2>
    <div class="well">
        <div class="text-right">
            <?php
            if (isset($_SESSION["email"]) && !empty($_SESSION['email'])) {
            ?>
            <a class="btn btn-info" href="#reviews-anchor" id="open-review-box">Leave a Review</a>
        </div>
        <div class="row" id="post-review-box" style="display:none;">
            <div class="col-md-12">
                <form accept-charset="UTF-8" method="POST">
                    <input name="property_id" type="hidden" value="<?php echo htmlspecialchars($property_id); ?>">
                    <input id="ratings-hidden" name="rating" type="hidden">
                    <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Enter your review here..." rows="5"></textarea>
                    <div class="text-right">
                        <div class="stars starrr" data-rating="0"></div>
                        <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                            <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                        <button class="btn btn-success" type="submit" name="review">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        } else {
            echo "<p><strong>You should login to review property.</strong></p>";
        }
        ?>
    </div>
</div>

<div class="container">
    <h3>Reviews:</h3>
    <?php
    $sql1 = "SELECT * FROM review WHERE property_id = '$property_id'";
    $query = mysqli_query($db, $sql1);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
    ?>
    <div class="well">
        <p><?php echo htmlspecialchars($row['comment']); ?> &nbsp;&nbsp;&nbsp;(<span class="glyphicon glyphicon-star-empty"><?php echo htmlspecialchars($row['rating']); ?></span>)</p>
    </div>
    <?php
        }
    }
    ?>
</div>

<script type="text/javascript">
    function initialize() {
        var lat = "<?php echo htmlspecialchars($rows['latitude']); ?>";
        var lon = "<?php echo htmlspecialchars($rows['longitude']); ?>";
        var latlng = new google.maps.LatLng(lat, lon);
        var map = new google.maps.Map(document.getElementById('mapid'), {
            center: latlng,
            zoom: 13
        });
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            draggable: false,
            anchorPoint: new google.maps.Point(0, -29)
        });
        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'click', function() {
            var iwContent = '<div id="iw_container">' +
                '<div class="iw_title"><b>Location</b> : Noida</div></div>';
            infowindow.setContent(iwContent);
            infowindow.open(map, marker);
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<style>
    h3 {
        font-size: 20px;
    }

    h4 {
        font-size: 20px
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        text-align: left;
        padding: 1px;
    }

    .animated {
        -webkit-transition: height 0.2s;
        -moz-transition: height 0.2s;
        transition: height 0.2s;
    }

    .stars {
        margin: 20px 0;
        font-size: 24px;
        color: #d17581;
    }
</style>

<script>
(function(e) {
    var t, o = {
        className: "autosizejs",
        append: "",
        callback: !1,
        resizeDelay: 10
    }, i = '<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',
        n = ["fontFamily", "fontSize", "fontWeight", "fontStyle", "letterSpacing", "textTransform", "wordSpacing", "textIndent"],
        s = e(i).data("autosize", !0)[0];
    s.style.lineHeight = "99px", "99px" === e(s).css("lineHeight") && n.push("lineHeight"), s.style.lineHeight = "", e.fn.autosize = function(i) {
        return this.length ? (i = e.extend({}, o, i || {}), s.parentNode !== document.body && e(document.body).append(s), this.each(function() {
            function o() {
                var t, o;
                "getComputedStyle" in window ? (t = window.getComputedStyle(u, null), o = u.getBoundingClientRect().width, e.each(["paddingLeft", "paddingRight", "borderLeftWidth", "borderRightWidth"], function(e, i) {
                    o -= parseInt(t[i], 10)
                }), s.style.width = o + "px") : s.style.width = Math.max(p.width(), 0) + "px"
            }

            function a() {
                var a = {};
                if (t = u, s.className = i.className, d = parseInt(p.css("maxHeight"), 10), e.each(n, function(e, t) {
                        a[t] = p.css(t)
                    }), e(s).css(a), o(), window.chrome) {
                    var r = u.style.width;
                    u.style.width = "0px", u.offsetWidth, u.style.width = r
                }
            }

            function r() {
                var e, n;
                t !== u ? a() : o(), s.value = u.value + i.append, s.style.overflowY = u.style.overflowY, n = parseInt(u.style.height, 10), s.scrollTop = 0, s.scrollTop = 9e4, e = s.scrollTop, d && e > d ? (u.style.overflowY = "scroll", e = d) : (u.style.overflowY = "hidden", c > e && (e = c)), e += w, n !== e && (u.style.height = e + "px", f && i.callback.call(u, u))
            }

            function l() {
                clearTimeout(h), h = setTimeout(function() {
                    var e = p.width();
                    e !== g && (g = e, r())
                }, parseInt(i.resizeDelay, 10))
            }
            var d, c, h, u = this,
                p = e(u),
                w = 0,
                f = e.isFunction(i.callback),
                z = {
                    height: u.style.height,
                    overflow: u.style.overflow,
                    overflowY: u.style.overflowY,
                    wordWrap: u.style.wordWrap,
                    resize: u.style.resize
                },
                g = p.width();
            p.data("autosize") || (p.data("autosize", !0), ("border-box" === p.css("box-sizing") || "border-box" === p.css("-moz-box-sizing") || "border-box" === p.css("-webkit-box-sizing")) && (w = p.outerHeight() - p.height()), c = Math.max(parseInt(p.css("minHeight"), 10) - w || 0, p.height()), p.css({
                overflow: "hidden",
                overflowY: "hidden",
                wordWrap: "break-word",
                resize: "none" === p.css("resize") || "vertical" === p.css("resize") ? "none" : "horizontal"
            }), "onpropertychange" in u ? "oninput" in u ? p.on("input.autosize keyup.autosize", r) : p.on("propertychange.autosize", function() {
                "value" === event.propertyName && r()
            }) : p.on("input.autosize", r), i.resizeDelay !== !1 && e(window).on("resize.autosize", l), p.on("autosize.resize", r), p.on("autosize.resizeIncludeStyle", function() {
                t = null, r()
            }), p.on("autosize.destroy", function() {
                t = null, clearTimeout(h), e(window).off("resize", l), p.off("autosize").off(".autosize").css(z).removeData("autosize")
            }), r())
        })) : this
    }
})(window.jQuery || window.$);

var __slice = [].slice;
(function(e, t) {
    var n;
    n = function() {
        function t(t, n) {
            var r, i, s, o = this;
            this.options = e.extend({}, this.defaults, n);
            this.$el = t;
            s = this.defaults;
            for (r in s) {
                i = s[r];
                if (this.$el.data(r) != null) {
                    this.options[r] = this.$el.data(r)
                }
            }
            this.createStars();
            this.syncRating();
            this.$el.on("mouseover.starrr", "span", function(e) {
                return o.syncRating(o.$el.find("span").index(e.currentTarget) + 1)
            });
            this.$el.on("mouseout.starrr", function() {
                return o.syncRating()
            });
            this.$el.on("click.starrr", "span", function(e) {
                return o.setRating(o.$el.find("span").index(e.currentTarget) + 1)
            });
            this.$el.on("starrr:change", this.options.change)
        }
        t.prototype.defaults = {
            rating: void 0,
            numStars: 5,
            change: function(e, t) {}
        };
        t.prototype.createStars = function() {
            var e, t, n;
            n = [];
            for (e = 1, t = this.options.numStars; 1 <= t ? e <= t : e >= t; 1 <= t ? e++ : e--) {
                n.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"))
            }
            return n
        };
        t.prototype.setRating = function(e) {
            if (this.options.rating === e) {
                e = void 0
            }
            this.options.rating = e;
            this.syncRating();
            return this.$el.trigger("starrr:change", e)
        };
        
t.prototype.syncRating = function(e) {
            var t, n, r, i;
            e || (e = this.options.rating);
            if (e) {
                for (t = n = 0, i = e - 1; 0 <= i ? n <= i : n >= i; t = 0 <= i ? ++n : --n) {
                    this.$el.find("span").eq(t).removeClass("glyphicon-star-empty").addClass("glyphicon-star")
                }
            }
            if (e && e < 5) {
                for (t = r = e; e <= 4 ? r <= 4 : r >= 4; t = e <= 4 ? ++r : --r) {
                    this.$el.find("span").eq(t).removeClass("glyphicon-star").addClass("glyphicon-star-empty")
                }
            }
            if (!e) {
                return this.$el.find("span").removeClass("glyphicon-star").addClass("glyphicon-star-empty")
            }
        };
        return t
    }();
    return e.fn.extend({
        starrr: function() {
            var t, r;
            r = arguments[0], t = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
            return this.each(function() {
                var i;
                i = e(this).data("star-rating");
                if (!i) {
                    e(this).data("star-rating", i = new n(e(this), r))
                }
                if (typeof r === "string") {
                    return i[r].apply(i, t)
                }
            })
        }
    })
})(window.jQuery, window);
$(function() {
    return $(".starrr").starrr()
})

$(function() {

    $('#new-review').autosize({
        append: "\n"
    });

    var reviewBox = $('#post-review-box');
    var newReview = $('#new-review');
    var openReviewBtn = $('#open-review-box');
    var closeReviewBtn = $('#close-review-box');
    var ratingsField = $('#ratings-hidden');

    openReviewBtn.click(function(e) {
        reviewBox.slideDown(400, function() {
            $('#new-review').trigger('autosize.resize');
            newReview.focus();
        });
        openReviewBtn.fadeOut(100);
        closeReviewBtn.show();
    });

    closeReviewBtn.click(function(e) {
        e.preventDefault();
        reviewBox.slideUp(300, function() {
            newReview.focus();
            openReviewBtn.fadeIn(200);
        });
        closeReviewBtn.hide();
    });

    $('.starrr').on('starrr:change', function(e, value) {
        ratingsField.val(value);
    });
});
</script>
</body>
</html>

<?php
    } else {
        echo "<p class='text-danger'><strong>Property not found.</strong></p>";
    }
} else {
    echo "<p class='text-danger'><strong>No property ID provided.</strong></p>";
}

if ($booking_success) {
    echo "<script>alert('Property booked successfully!');</script>";
}
?>
